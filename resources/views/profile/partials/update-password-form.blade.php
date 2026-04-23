<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="mt-1 flex gap-2">
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="block flex-1 w-full" autocomplete="current-password" />
                <button class="inline-flex items-center rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 toggle-password" type="button" data-target="update_password_current_password" aria-label="Show password">
                    <i class="bx bx-hide"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="mt-1 flex gap-2">
                <x-text-input id="update_password_password" name="password" type="password" class="block flex-1 w-full" autocomplete="new-password" />
                <button class="inline-flex items-center rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 toggle-password" type="button" data-target="update_password_password" aria-label="Show password">
                    <i class="bx bx-hide"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="mt-1 flex gap-2">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block flex-1 w-full" autocomplete="new-password" />
                <button class="inline-flex items-center rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 toggle-password" type="button" data-target="update_password_password_confirmation" aria-label="Show password">
                    <i class="bx bx-hide"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
