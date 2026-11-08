
<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-bold text-gray-800">
            Change Your Password
        </h2>

        <p class="mt-2 text-sm text-gray-600">
            You're using a temporary password.
            Please create a new password before continuing to Testora.
        </p>
    </div>

    <form method="POST" action="{{ route('password.force-update') }}">
        @csrf

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
                New Password
            </label>

            <input
                id="password"
                type="password"
                name="password"
                required
                autofocus
                autocomplete="new-password"
                class="mt-1 block w-full rounded-md border-gray-300"
            >

            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                Confirm New Password
            </label>

            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="mt-1 block w-full rounded-md border-gray-300"
            >
        </div>

        <div class="mt-6">
            <button
                type="submit"
                class="w-full rounded-md bg-violet-600 px-4 py-3 text-sm font-semibold text-white hover:bg-violet-700"
            >
                Update Password
            </button>
        </div>
    </form>
</x-guest-layout>
