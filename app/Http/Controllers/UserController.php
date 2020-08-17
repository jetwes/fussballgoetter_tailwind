<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function changeAvatar(Request $request)
    {
        if (!$request->hasFile('avatar'))
            return redirect(route('home'));
        $user = User::find(Auth::user()->id);
        if ($request->file('avatar')->getMimeType() != 'image/jpeg' && $request->file('avatar')->getMimeType() != 'image/png')
            return Redirect::route('change-avatar')
                ->with('error-message', 'Bitte nur .jpg oder .png Bilddateien hochladen!');
        $user->avatar = $request->file('avatar');

        if ($user->save()) {
            return Redirect::route('home')
                ->with('success-message', 'Ihr Konto wurde erfolgreich geändert.');
        } else {
            return Redirect::route('home')
                ->with('error-message', 'Beim speichern des Benutzers ist ein Fehler aufgetreten.');
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password'  => 'same:password_again|min:6'
        ],[
            'password.same' => 'Die Passwörter müssen übereinstimmen',
            'password.min' => 'Das Passwort muss mindestens 6 Zeichen lang sein.'
        ]);

        $user = User::where('id',\auth()->id())->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return \redirect(route('home'))->with('success-message','Das Passwort wurde erfolgreich geändert!');
    }
}
