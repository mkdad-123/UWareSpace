<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SuperAdmin;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'broker' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker($request->input('broker'))->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {

                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                //->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

}
