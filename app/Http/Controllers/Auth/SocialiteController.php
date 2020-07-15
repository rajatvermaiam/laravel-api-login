<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect()->route('login')->with('message', 'You must Give permission to login. Try again!');
        }
        $ifUser = User::where(['email' => $user->getEmail()])->first();
        if ($ifUser) {
            Auth::login($ifUser);
            return redirect()->route('home');
        } else {
            $newUser = new User();
            $newUser->profile_pic = $user->getAvatar();
            $newUser->provider_id = $user->getId();
            $newUser->provider = $provider;
            $newUser->email_verified_at = Carbon::now();
            $newUser->name = $user->getName();
            $newUser->email = $user->getEmail();
            $newUser->save();
            Auth::login($newUser);
            return redirect()->route('home');
        }
    }
}
