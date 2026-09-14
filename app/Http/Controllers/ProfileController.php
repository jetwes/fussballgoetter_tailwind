<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
}
