<x-app-layout>
@if(Auth::user()->profileImage != "nullImage")

                        @if(substr(Auth::user()->profileImage,0,5) == "https")
                        <img class="w-screen h-full" src="{{Auth::user()->profileImage}}" alt=""/>
                        @else
                        <img class="w-screen h-full" src="{{ asset( 'profileImages/'.Auth::user()->profileImage ) }}" alt=""/>
                        @endif
                        @else
                        <div></div>
                        
                        @endif


</x-app-layout>