<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class PasswordController extends Controller
{
    public function forgotEmail(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
            ]
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        } else { //change the password
            $user = User::where('email', '=', $request->input('email'))->first();

            if ($user) {

                //generate new code and password
                $code = Str::random(60);
                $temp_password = Str::random(10);

                $user->code = $code;
                $user->password_temp = Hash::make($temp_password);

                if ($user->save()) {
                    Mail::send('emails.reminder',
                        [
                            'link'          => URL::route('user-recover', $code),
                            'username'      => $user->name,
                            'email'         => $user->email,
                            'temp_password' => $temp_password,
                        ],
                        function ($message) use ($user) {
                            $message->to($user->email, $user->username)->subject('Dein neuns Fußballgötter Password');
                        });

                    return Redirect::to('/login')
                        ->with('success-message', 'Wir haben dir eine eMail mit deinem neuen Password gesendet');
                }
            }

            return Redirect::route('user-password-forgot')
                ->with('success-message', 'Die eMail-Adresse konnte nicht gefunden werden.');
        }
    }

    public function getRecover($code)
    {
        $user = User::where('code', '=', $code)
            ->where('password_temp', '!=', '');

        if ($user->count()) {
            $user = $user->first();

            $user->password = $user->password_temp;
            $user->password_temp = '';
            $user->code = '';

            if ($user->save()) {
                return Redirect::to('/auth/login')
                    ->with('success-message', 'Ihr Account wurde zurückgesetzt. Sie können Sie nun mit Ihrem neuen Passwort einloggen.');
            }
        }

        return Redirect::to('/auth/login')
            ->with('error-message', 'Ihr Account konnte nicht zurück gesetzt werden.');
    }

}
