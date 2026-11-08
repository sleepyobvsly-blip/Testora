
<x-guest-layout>

    <div class="w-full max-w-md mx-auto">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="w-10 h-10 rounded-xl bg-[#7965e8] flex items-center justify-center text-white font-bold text-xl">
                    S
                </div>
                <span class="text-2xl font-extrabold text-slate-800">
                    Sentra
                </span>
            </div>

            <h1 class="text-2xl font-bold text-slate-800">
                Create an Account
            </h1>

            <p class="text-sm text-slate-500 mt-2">
                Get started with your Sentra workspace.
            </p>
        </div>

        <!-- Register Card -->
        <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label
                        for="name"
                        value="Full Name"
                        class="text-slate-700 font-medium"
                    />

                    <x-text-input
                        id="name"
                        class="block mt-2 w-full rounded-lg border-slate-200 focus:border-[#7965e8] focus:ring-[#7965e8]"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Enter your full name"
                    />

                    <x-input-error
                        :messages="$errors->get('name')"
                        class="mt-2"
                    />
                </div>

                <!-- Email -->
                <div class="mt-5">
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

                    <x-text-input
                        id="password"
                        class="block mt-2 w-full rounded-lg border-slate-200 focus:border-[#7965e8] focus:ring-[#7965e8]"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Create a password"
                    />

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"
                    />
                </div>

                <!-- Confirm Password -->
                <div class="mt-5">
                    <x-input-label
                        for="password_confirmation"
                        value="Confirm Password"
                        class="text-slate-700 font-medium"
                    />

                    <x-text-input
                        id="password_confirmation"
                        class="block mt-2 w-full rounded-lg border-slate-200 focus:border-[#7965e8] focus:ring-[#7965e8]"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm your password"
                    />

                    <x-input-error
                        :messages="$errors->get('password_confirmation')"
                        class="mt-2"
                    />
                </div>

                <!-- Register Button -->
                <div class="mt-7">
                    <x-primary-button class="w-full justify-center py-3 bg-[#7965e8] hover:bg-[#6651d5] focus:bg-[#6651d5] active:bg-[#5541c5]">
                        Create Account
                    </x-primary-button>
                </div>

            </form>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <span class="text-sm text-slate-500">
                    Already have an account?
                </span>

                <a
                    href="{{ route('login') }}"
                    class="text-sm text-[#7965e8] hover:text-[#6651d5] font-semibold ml-1"
                >
                    Sign In
                </a>
            </div>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-400 mt-7">
            © {{ date('Y') }} Sentra. All rights reserved.
        </p>

    </div>

</x-guest-layout>
