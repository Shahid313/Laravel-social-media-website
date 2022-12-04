<x-app-layout>
@include('layouts.navigation')

<x-auth-card>
    <p>Friends</p>
    @foreach($users as $user)
    @if($user->id != Auth::user()->id)
    @if($user->madeFriendId == Auth::user()->id || $user->madeByFriendId == Auth::user()->id)
    <p>{{$user->name}}</p>
    @endif
    @endif
    @endforeach
    
</x-auth-card>

</x-app-layout>