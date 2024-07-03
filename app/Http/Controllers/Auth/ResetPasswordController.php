<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\SuperAdmin;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{

    public function reset(ResetPasswordRequest $request)
    {

        $status = Password::broker($request->input('broker'))->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {

                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('success')->with('status', __($status))
            : redirect()->route('fail')->with('status', __($status));
    }

}
