<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="Email" :value="__('Email')" />
            <x-text-input id="Email" class="block mt-1 w-full" type="email" name="Email" :value="old('Email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('Email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="Haslo" :value="__('Password')" />

            <x-text-input id="Haslo" class="block mt-1 w-full"
                            type="password"
                            name="Haslo"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('Haslo')" class="mt-2" />
        </div>

        

        <div class="flex items-center justify-end mt-4">
           

            <x-primary-button class="ms-3">
                {{ __('Zaloguj się') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
