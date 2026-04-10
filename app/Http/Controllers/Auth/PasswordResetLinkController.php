<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // --- TEMPORARY TESTING OVERRIDE ---
        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user) {
            $token = Password::getRepository()->create($user);
            $link = url(route('password.reset', ['token' => $token, 'email' => $user->email]));
            
            return back()->with('status', 'TESTING MODE ACTIVE: See the link below.')
                         ->with('test_link', $link);
        }
        
        // Final fallback just in case the user doesn't exist
        return back()->withErrors(['email' => 'User not found for testing.']);
    }
}
