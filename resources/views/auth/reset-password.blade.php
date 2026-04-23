<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="mt-1 flex gap-2">
                <x-text-input id="password" class="block flex-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <button class="inline-flex items-center rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 toggle-password" type="button" data-target="password" aria-label="Show password">
                    <i class="bx bx-hide"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <div class="mt-1 flex gap-2">
                <x-text-input id="password_confirmation" class="block flex-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                <button class="inline-flex items-center rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 toggle-password" type="button" data-target="password_confirmation" aria-label="Show password">
                    <i class="bx bx-hide"></i>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
