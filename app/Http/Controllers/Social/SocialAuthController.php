<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;

class SocialAuthController extends Controller
{
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
        // $user = SocialAccountService::createOrGetUser(Socialite::driver($social)->user(), $social);
        // auth()->login($user);

        // return redirect()->to('/home');
    }
}
