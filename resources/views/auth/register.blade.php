<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />

                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                                <img id="Eye" onclick="toggle()" style="position:absolute; right: 500px; transform: translate(0,-50%); top:52%; cursor:pointer;" src="{{ asset('icons/show.png') }}" width="20px" height="20px" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
                                <img id="confirmEye" onclick="confirmtoggle()" style="position:absolute; right: 500px; transform: translate(0,-50%); top:65.5%; cursor:pointer;" src="{{ asset('icons/show.png') }}" width="20px" height="20px" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Profile Image -->
            <div class="mt-4">
                <label for="profile_image" class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">
                    {{ __('Profile Image (optional)') }}
                </label>
                <x-text-input id="profile_image" class="hidden" type="file" name="profileImage" :value="old('profileImage')" autofocus />

                <x-input-error :messages="$errors->get('profileImage')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
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

            var confirmState = false;

            function confirmtoggle(){
                if(confirmState == true){
                    document.getElementById("password_confirmation").setAttribute("type", "password");
                    confirmState = false;
                    document.getElementById("confirmEye").setAttribute("src", "{{ asset('icons/show.png') }}");
                }else{
                    document.getElementById("password_confirmation").setAttribute("type", "text");
                    confirmState = true;
                    document.getElementById("confirmEye").setAttribute("src", "{{ asset('icons/hide.png') }}");
                }
            }
        </script>
    </x-auth-card>
</x-guest-layout>
