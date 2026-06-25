<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class InertiaAuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    public function showLogin(): Response|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('Auth/Login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $result = $this->authService->login(
                $request->email,
                $request->password,
                'web-session'
            );

            Auth::login($result['user'], remember: true);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        } catch (ValidationException) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
