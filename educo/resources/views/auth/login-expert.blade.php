<x-guest-layout>
    <section class="grid grid-rows-1 grid-cols-2 content-center bg-primary-blue">
        <div class="text-center bg-white">
            <img src="{{asset('images/logo2ColorCompletePink-02.png')}}" class="w-1/4 mt-5 ml-5" alt="logo educo">
            <img src="{{asset('images/login_image.png')}}" alt="login_graphic" class="inline mt-15 ml-5">
            <h1 class="font-bold text-primary-blue text-5xl mt-6">Redefining <span class="text-secondary">Education</span> for Businesses</h1>
        </div>
        <div>
            <x-auth-card>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login.expert.store') }}">
            @csrf
            <div class="text-center">
                <h2 class="font-bold text-xl text-secondary">expert login</h2>
            </div>

                <!-- Email Address -->
                    <div>
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')" />

                        <x-input id="password" class="block mt-1 w-full"
                                 type="password"
                                 name="password"
                                 required autocomplete="current-password" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-button class="ml-3 hover:bg-secondary bg-primary-blue font-bold">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>
            </x-auth-card>
        </div>
    </section>
</x-guest-layout>
