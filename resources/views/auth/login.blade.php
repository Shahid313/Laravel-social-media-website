<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                                <img id="Eye" onclick="toggle()" style="position:absolute; right: 500px; transform: translate(0,-50%); top:50.5%; cursor:pointer;" src="{{ asset('icons/show.png') }}" width="20px" height="20px" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
            @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>

                
                <x-primary-button class="ml-3">
                    {{ __('Log in') }}
                </x-primary-button>

                

            </div>
        </form>
        <a href="/login_with_google">
                <x-primary-button class="ml-3">
                    {{ __('Login with google') }}
                </x-primary-button>
                </a>
    </x-auth-card>
    <script>
            var state = false;
            function toggle(){
                if(state == true){
                    document.getElementById("password").setAttribute("type", "password");
                    state = false;
                    document.getElementById("Eye").setAttribute("src", "{{ asset('icons/show.png') }}");
                }else{
                    document.getElementById("password").setAttribute("type", "text");
                    state = true;
                    document.getElementById("Eye").setAttribute("src", "{{ asset('icons/hide.png') }}");
                }
            }
        </script>
</x-guest-layout>
