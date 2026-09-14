<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date_format:d.m.Y'],
            'password' => ['nullable', 'string', 'min:6', 'same:password_again'],
        ], [
            'password.same' => 'Die Passwörter müssen übereinstimmen.',
            'password.min' => 'Das Passwort muss mindestens 6 Zeichen lang sein.',
            'birthday.date_format' => 'Das Geburtsdatum muss im Format TT.MM.JJJJ eingegeben werden.',
        ]);

        $user = $request->user();
        $user->name = $validated['name'];
        $user->birthday = filled($validated['birthday'] ?? null)
            ? Carbon::createFromFormat('d.m.Y', $validated['birthday'])->startOfDay()
            : null;

        if (filled($validated['password'] ?? null)) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('home')->with('success-message', 'Das Profil wurde gespeichert!');
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ], [
            'avatar.required' => 'Bitte eine Bilddatei auswählen.',
            'avatar.image' => 'Bitte nur .jpg, .png oder .webp Bilddateien hochladen!',
            'avatar.mimes' => 'Bitte nur .jpg, .png oder .webp Bilddateien hochladen!',
            'avatar.max' => 'Das Bild darf maximal 8 MB groß sein.',
        ]);

        $user = $request->user();
        $filename = Str::uuid().'.jpg';

        $encoded = Image::decodePath($request->file('avatar')->getRealPath())
            ->cover(240, 240)
            ->encode(new JpegEncoder(quality: 90));

        Storage::disk('avatars')->put($filename, (string) $encoded);

        $old = $user->avatar;
        $user->avatar = '/user/avatars/'.$filename;
        $user->save();

        if ($old && Str::startsWith($old, '/user/avatars/')) {
            Storage::disk('avatars')->delete(basename($old));
        }

        return redirect()->route('home')->with('success-message', 'Dein Profilbild wurde geändert.');
    }
}
