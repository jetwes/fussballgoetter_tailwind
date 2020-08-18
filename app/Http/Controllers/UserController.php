<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
            'password'  => 'same:password_again|min:6|nullable',
            'name'      => 'required',
            'birthday'  =>  'nullable|size:10|regex:/^(\d{2})\.(\d{2})\.(\d{4})$/'
        ],[
            'password.same' => 'Die Passwörter müssen übereinstimmen',
            'password.min' => 'Das Passwort muss mindestens 6 Zeichen lang sein.',
            'birthday.size' => 'Das Geburtsdatum muss im Format TT.MM.JJJJ eingegeben werden',
            'birthday.regex' => 'Das Geburtsdatum muss im Format TT.MM.JJJJ eingegeben werden'
        ]);

        $user = User::where('id',\auth()->id())->first();
        if ($request->input('password') != '')
            $user->password = Hash::make($request->input('password'));
        if ($request->input('birthday') != '')
            $user->birthday = Carbon::createFromFormat('d.m.Y',$request->input('birthday'));
        else $user->birthday = null;
        $user->name = $request->input('name');

        $user->save();
        return \redirect(route('home'))->with('success-message','Das Profil wurde gespeichert!');
    }
}
