<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\AdminRegisterRequest;
use App\Models\Admin;
use App\Services\Admin\AdminLoginService;
use App\Services\Admin\AdminRegisterService;
use App\Services\EmailVerificationService;
use App\Traits\ResetPasswordTrait;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminAuthController extends Controller
{
    use ResetPasswordTrait;

    public function register(AdminRegisterRequest $request)
    {
        $result = (new AdminRegisterService())->register($request);

        return $this->response($result->data, $result->message, $result->status);
    }

    public function login(AdminLoginRequest $request)
    {
        $result = (new AdminLoginService())->login($request);

        return $this->response($result->data, $result->message, $result->status);
    }

    public function logout()
    {
        if (auth('admin')->user()) {
            auth()->guard('admin')->logout();

            return $this->response(response(), 'Logged out successfully', 401);

        }
        return $this->response(response(), 'Unauthorized', 401);

    }

    public function verify(Request $request)
    {
        return (new EmailVerificationService())->verify($request);
    }

    public function redirectToAuth()
    {
        return response()->json([
            'url' => Socialite::driver('google')
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }

    public function handleAuthCallback()
    {
        try {
            /** @var SocialiteUser $socialiteUser */
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $e) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        /** @var Admin $user */
        $user = Admin::query()
            ->firstOrCreate(
                [
                    'email' => $socialiteUser->getEmail(),
                ],
                [
                    'email_verified_at' => now(),
                    'name' => $socialiteUser->getName(),
                    'google_id' => $socialiteUser->getId(),
                    'avatar' => $socialiteUser->getAvatar(),
                    'password' => bcrypt($socialiteUser->getName().$socialiteUser->getId())
                ]
            );

        $token = Auth::guard('admin')->attempt([
            'email' => $user->email,
            'password'=> $socialiteUser->getName().$socialiteUser->getId(),
        ]);

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
