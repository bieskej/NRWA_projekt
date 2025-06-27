<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // ✅ Registracija korisnika
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registracija uspješna',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // ✅ Login korisnika (email + password)
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Neispravni podaci.'],
            ]);
        }

        $user->tokens()->delete(); // očisti stare tokene

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login uspješan',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // ✅ GitHub OAuth Redirect
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->stateless()->redirect();
    }

    // ✅ GitHub OAuth Callback
    public function handleGitHubCallback()
    {
        $githubUser = Socialite::driver('github')->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $githubUser->getEmail()],
            ['name' => $githubUser->getName() ?? $githubUser->getNickname()]
        );

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'OAuth login uspješan',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    // ✅ Dohvati ulogovanog korisnika
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    // ✅ Logout korisnika
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Odjavljen']);
    }
}
