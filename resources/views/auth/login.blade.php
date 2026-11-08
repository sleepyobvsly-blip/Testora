
<x-guest-layout>

    <div class="w-full max-w-md mx-auto">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="w-10 h-10 rounded-xl bg-[#7965e8] flex items-center justify-center text-white font-bold text-xl">
                    S
                </div>

                <span class="text-2xl font-extrabold text-slate-800">
                    Testora
                </span>
            </div>

            <h1 class="text-2xl font-bold text-slate-800">
                Welcome Back
            </h1>

            <p class="text-sm text-slate-500 mt-2">
                Sign in to continue to your Testora workspace.
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">

            <!-- Session Status -->
            <x-auth-session-status
                class="mb-4"
                :status="session('status')"
            />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label
                        for="email"
                        value="Email Address"
                        class="text-slate-700 font-medium"
                    />

                    <x-text-input
                        id="email"
                        class="block mt-2 w-full rounded-lg border-slate-200 focus:border-[#7965e8] focus:ring-[#7965e8]"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Enter your email address"
                    />

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2"
                    />
                </div>

                
                <!-- Password -->
                <div class="mt-5">

                    <x-input-label
                        for="password"
                        value="Password"
                        class="text-slate-700 font-medium"
                    />

                    <div class="relative mt-2">

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            class="block w-full rounded-lg border border-slate-200 pr-12 focus:border-[#7965e8] focus:ring-[#7965e8]"
                        />

                        <!-- Show/Hide Password Button -->
                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute right-0 top-0 h-full flex items-center justify-center px-3 translate-y-[1px] text-slate-400 hover:text-[#7965e8] focus:outline-none"
                            aria-label="Show password"
                            aria-pressed="false"
                        >

                            <!-- Eye Icon -->
                            <svg
                                id="eyeIcon"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7z"
                                />
                                <circle cx="12" cy="12" r="3" />
                            </svg>

                            <!-- Eye Off Icon -->
                            <svg
                                id="eyeOffIcon"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 hidden"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 3l18 18M10.6 10.6a2 2 0 002.8 2.8"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9.9 5.2A10.8 10.8 0 0112 5c6.25 0 9.75 7 9.75 7a16.5 16.5 0 01-3.1 3.9M6.2 6.2C3.6 8 2.25 12 2.25 12s3.5 7 9.75 7c1.2 0 2.3-.25 3.3-.65"
                                />
                            </svg>

                        </button>

                    </div>

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"
                    />

                </div>


                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-5">

                    <label
                        for="remember_me"
                        class="inline-flex items-center"
                    >
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded border-slate-300 text-[#7965e8] shadow-sm focus:ring-[#7965e8]"
                        >

                        <span class="ms-2 text-sm text-slate-600">
                            Remember me
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm text-[#7965e8] hover:text-[#6651d5] font-medium"
                        >
                            Forgot password?
                        </a>
                    @endif

                </div>

                <!-- Login Button -->
                <div class="mt-7">

                    <x-primary-button class="w-full justify-center py-3 bg-[#7965e8] hover:bg-[#6651d5] focus:bg-[#6651d5] active:bg-[#5541c5]">
                        Sign In
                    </x-primary-button>

                </div>

            </form>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-400 mt-7">
            © {{ date('Y') }} Testora. All rights reserved.
        </p>

    </div>

    <!-- Show/Hide Password Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');

            toggleButton.addEventListener('click', function () {

                const isPasswordHidden = passwordInput.type === 'password';

                passwordInput.type = isPasswordHidden ? 'text' : 'password';

                eyeIcon.classList.toggle('hidden', isPasswordHidden);
                eyeOffIcon.classList.toggle('hidden', !isPasswordHidden);

                toggleButton.setAttribute(
                    'aria-label',
                    isPasswordHidden ? 'Hide password' : 'Show password'
                );

                toggleButton.setAttribute(
                    'aria-pressed',
                    isPasswordHidden ? 'true' : 'false'
                );

            });

        });
    </script>

</x-guest-layout>
