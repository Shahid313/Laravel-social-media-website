<x-app-layout>
@include('layouts.navigation')
    <br>
    <br>
    <br>
    <br>

<form method="POST" class="flex justify-center items-center flex-col" id="get-form-data" action="/store-post/{{Auth::user()->id}}" enctype="multipart/form-data">
            @csrf

            

            <!-- Post Content -->
            <div>
                <x-input-label for="content" :value="__('Whats on your mind')" />

                

                <textarea class="block mt-1 w-full" id="content" :value="old('content')" name="content" autofocus rows="5" cols="40"></textarea>


                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <!-- Post Image -->
            <div class="mt-4">
            <label for="post_image" class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">
                    {{ __('Post Image (optional)') }}
                </label>

                <x-text-input id="post_image" class="hidden" type="file" name="postImage" :value="old('postImage')" autofocus />

                <x-input-error :messages="$errors->get('postImage')" class="mt-2" />
            </div>

            <div class="flex items-center mt-4">

                <x-primary-button class="ml-4">
                    {{ __('Add Post') }}
                </x-primary-button>
            </div>
        </form>

        <script src="{{ asset( 'main.js' ) }}" type="text/javascript"></script>

</x-app-layout>