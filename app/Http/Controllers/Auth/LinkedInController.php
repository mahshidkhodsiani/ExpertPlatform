<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class LinkedInController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function callback()
    {
        try {
            $linkedinUser = Socialite::driver('linkedin')->user();

            $user = User::where('email', $linkedinUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $linkedinUser->name,
                    'email' => $linkedinUser->email,
                    'linkedin_id' => $linkedinUser->id,
                    'password' => encrypt('linkedin_password_123') // بهتر است از روش بهتری برای رمز استفاده کنید
                ]);
            }

            Auth::login($user);

            return redirect()->route('user.dashboard');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'خطا در ورود از طریق لینکدین');
        }
    }
}
