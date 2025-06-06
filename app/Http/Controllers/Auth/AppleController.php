<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class AppleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('apple')->redirect();
    }

    public function callback()
    {
        try {
            $appleUser = Socialite::driver('apple')->user();

            $user = User::where('email', $appleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $appleUser->name ?? $appleUser->email,
                    'email' => $appleUser->email,
                    'apple_id' => $appleUser->id,
                    'password' => encrypt('apple_password_123') // بهتر است از روش بهتری برای رمز استفاده کنید
                ]);
            }

            Auth::login($user);

            return redirect()->route('user.dashboard');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'خطا در ورود از طریق اپل');
        }
    }
}
