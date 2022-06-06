<x-guest-layout>
    <section class="grid grid-rows-1 grid-cols-2 content-center bg-primary-blue">
        <div class="text-center bg-white">
            <img src="{{asset('images/logo2ColorCompletePink-02.png')}}" class="w-1/4 mt-5 ml-5" alt="logo educo">
            <img src="{{asset('images/login_image.png')}}" alt="login_graphic" class="inline mt-15 ml-5">
            <h1 class="font-bold text-primary-blue text-5xl mt-6">Redefining <span class="text-secondary">Education</span> for Businesses</h1>
        </div>

        <div>
            <x-auth-card>
                <x-slot name="logo">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </x-slot>

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')" />

                        <x-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-button class="ml-3 hover:bg-secondary bg-primary-blue font-bold">
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </form>
            </x-auth-card>
        </div>
    </section>
</x-guest-layout>
