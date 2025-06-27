<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            $user = User::updateOrCreate(
                [
                    'github_id' => $githubUser->getId(),
                ],
                [
                    'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                    'username' => $githubUser->getNickname(),
                    'email' => $githubUser->getEmail(),
                    'password' => Hash::make(Str::random(24))
                ]
            );

            Auth::login($user);

            $request->session()->regenerate();

            return redirect('/');

        } catch (\Exception $e) {
            Log::error('GitHub Login Error: ' . $e->getMessage());
            
            return redirect('/login')->with('error', 'Došlo je do greške prilikom prijave putem GitHuba.');
        }
    }
}