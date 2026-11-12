<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Validate registration and prepare simulated payment.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],
        ]);

        // Store registration details temporarily.
        // The password is hashed before session storage.
        $request->session()->put('pending_registration', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('registration.payment');
    }

    /**
     * Display the simulated payment page.
     */
    public function showPayment(): View|RedirectResponse
    {
        if (!session()->has('pending_registration')) {
            return redirect()->route('register');
        }

        return view('auth.registration-payment', [
            'fee' => config('app.registration_fee'),
        ]);
    }

    /**
     * Confirm simulated payment and create the seller account.
     */
    public function confirmPayment(Request $request): RedirectResponse
    {
        $registration = $request->session()->get('pending_registration');

        if (
            !is_array($registration) ||
            empty($registration['name']) ||
            empty($registration['email']) ||
            empty($registration['password'])
        ) {
            $request->session()->forget('pending_registration');

            return redirect()->route('register')
                ->withErrors([
                    'registration' => 'Your registration session is invalid or expired. Please register again.'
                ]);
        }

        // Check if the email was registered by someone else
        // while this registration was pending.
        if (User::where('email', $registration['email'])->exists()) {
            $request->session()->forget('pending_registration');

            return redirect()->route('register')
                ->withErrors(['email' => 'This email address is already registered.']);
        }

        $user = User::create([
            'name' => $registration['name'],
            'email' => $registration['email'],
            'password' => $registration['password'],
            'is_active' => true,
            'must_change_password' => false,
            'registration_payment_status' => 'paid_simulated',
            'registration_paid_at' => now(),
        ]);

        // Assign the Business Owner role.
        $user->assignRole('admin');

        event(new Registered($user));

        // Clear temporary registration information.
        $request->session()->forget('pending_registration');

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Simulated registration payment confirmed. Welcome to Testora!');
    }
}
