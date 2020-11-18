<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="/images/logo.png" />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="mt-4">
                <div class="flex justify-start">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 text-left" href="{{ route('register') }}">
                        Register
                    </a>
                </div>
                @if (Route::has('password.request'))
                <div class="flex justify-end">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>

                    <x-jet-button class="ml-4">
                        {{ __('Login') }}
                    </x-jet-button>
                </div>
                @endif

            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
