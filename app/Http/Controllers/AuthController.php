<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login page.
     */
    public function showLogin()
    {
        return view('auth.login');
    }


    /**
     * Handle login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);


        $remember = $request->boolean('remember');


        if (Auth::attempt($credentials, $remember)) {

            // Regenerate session after successful login
            $request->session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('success', 'Login successful.');
        }


        return back()
            ->withErrors([
                'email' => 'The provided email or password is incorrect.',
            ])
            ->onlyInput('email');
    }


    /**
     * Show registration page.
     */
    public function showRegister()
    {
        return view('auth.register');
    }


    /**
     * Handle registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);


        // Automatically login after registration
        Auth::login($user);

        // Regenerate session
        $request->session()->regenerate();

        $user->sendEmailVerificationNotification();

        return redirect()
            ->route('home')
            ->with('success', 'Registration successful. Please verify your email address.');
    }

    public function verificationNotice()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        /*
         * Make sure the signed URL email matches the user email.
         */
        if (! hash_equals(
            (string) $hash,
            sha1($user->getEmailForVerification())
        )) {
            abort(403);
        }

        if (! $user->hasVerifiedEmail()) {

            $user->markEmailAsVerified();

            event(new Verified($user));
        }

        return redirect()
            ->route('home')
            ->with('success', 'Your email has been verified successfully.');
    }

    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {

            return redirect()
                ->route('home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()
            ->with(
                'success',
                'A new verification link has been sent to your email.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Forgot Password
    |--------------------------------------------------------------------------
    */

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {

            return back()
                ->with(
                    'success',
                    'Password reset link has been sent to your email.'
                );
        }

        return back()
            ->withErrors([
                'email' => __($status),
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    */

    public function showResetPassword($token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => [
                'required',
            ],
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function (User $user, string $password) {

                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {

            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Your password has been reset successfully. Please login.'
                );
        }

        return back()
            ->withErrors([
                'email' => __($status),
            ]);
    }


    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();


        // Invalidate current session
        $request->session()->invalidate();


        // Generate new CSRF token
        $request->session()->regenerateToken();


        return redirect()
            ->route('home')
            ->with('success', 'You have been logged out successfully.');
    }
}