<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(string $email, string $password, string $deviceName = 'api'): array
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($deviceName)->plainTextToken;

        return compact('user', 'token');
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
