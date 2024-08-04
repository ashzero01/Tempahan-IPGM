<!-- resources/views/auth/user-login.blade.php -->
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('user.login') }}">
            @csrf

            <div>
                <x-label for="ICnumber" value="{{ __('IC Number') }}" />
                <x-input id="ICnumber" class="block mt-1 w-full" type="text" name="ICnumber" :value="old('ICnumber')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
