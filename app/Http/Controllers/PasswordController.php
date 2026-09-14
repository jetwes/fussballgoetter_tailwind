<?php

namespace App\Http\Controllers;

use App\Mail\TemporaryPasswordMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * "Passwort vergessen": Es wird ein temporäres Passwort per E-Mail verschickt,
 * das erst nach Klick auf den Bestätigungslink aktiv wird.
 */
class PasswordController extends Controller
{
    public function forgot(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return redirect()->route('login')->with('error-message', 'Die E-Mail-Adresse konnte nicht gefunden werden.');
        }

        $temporaryPassword = Str::random(10);

        $user->forceFill([
            'code' => Str::random(60),
            'password_temp' => Hash::make($temporaryPassword),
        ])->save();

        Mail::to($user)->send(new TemporaryPasswordMail($user, $temporaryPassword));

        return redirect()->route('login')->with('success-message', 'Wir haben dir eine E-Mail mit deinem neuen Passwort gesendet.');
    }

    public function recover(string $code): RedirectResponse
    {
        $user = User::where('code', $code)->whereNotNull('password_temp')->where('password_temp', '!=', '')->first();

        if (! $user) {
            return redirect()->route('login')->with('error-message', 'Dein Account konnte nicht zurückgesetzt werden.');
        }

        $user->forceFill([
            'password' => $user->password_temp, // bereits gehasht
            'password_temp' => null,
            'code' => null,
        ])->save();

        return redirect()->route('login')->with('success-message', 'Dein Passwort wurde zurückgesetzt. Du kannst dich jetzt mit dem neuen Passwort anmelden.');
    }
}
