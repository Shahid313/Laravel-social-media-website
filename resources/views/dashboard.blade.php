<x-app-layout>
@include('layouts.navigation')

<br>
    <br>
    <br>
    
  
    
<div class="flex flex-row">


    <!-- my posts -->
    <main class="flex flex-row justify-items-start">
    <div class='h-screen w-6/12 flex flex-col items-center'>
    
    @foreach ($posts as $post)
      @if($post->id == Auth::user()->id)

      <div class='bg-white w-10/12 p-4 mb-2 mt-8 shadow-md rounded-md'>
        <div class='flex flex-row place-items-start'>
        <div class='w-10 h-10 rounded-full'>
        
        @if($post->profileImage != "nullImage")

                        
                        <div class="h-10 w-10 rounded-full">
                        @if(substr($post->profileImage,0,5) == "https")
                        <img class="h-10 w-10 rounded-full" src="{{$post->profileImage}}" alt=""/>
                        @else
                        <img class="h-10 w-10 rounded-full" src="{{ asset( 'profileImages/'.$post->profileImage ) }}" alt=""/>
                        @endif
                        </div>
                        @else
                        <img class="h-10 w-10 rounded-full" src="{{ asset( 'profileImages/profile.png' ) }}" alt=""/>
                        
                        @endif
        
        
        </div>
        <h3 class='ml-2 text-black text-bold'>{{ $post->name }}</h3>
        </div>

        <!-- The person whose post is shared details -->
        @if($post->personWhosePostIsSharedImage != "null")

        <div class='flex flex-row place-items-start mt-2'>
        <div class='w-10 h-10 rounded-full'>
        
        @if($post->personWhosePostIsSharedImage != "nullImage")

                        
                        <div class="h-8 w-8 rounded-full">
                        @if(substr($post->personWhosePostIsSharedImage,0,5) == "https")
                        <img class="h-8 w-8 rounded-full" src="{{$post->personWhosePostIsSharedImage}}" alt=""/>
                        @else
                        <img class="h-8 w-8 rounded-full" src="{{ asset( 'profileImages/'.$post->personWhosePostIsSharedImage ) }}" alt=""/>
                        @endif
                        </div>
                        @else
                        <img class="h-8 w-8 rounded-full" src="{{ asset( 'profileImages/profile.png' ) }}" alt=""/>
                        
                        @endif
        
        
        </div>
        <h3 class='ml-2 text-black text-bold'>{{ $post->personWhosePostIsSharedName }}</h3>
        </div>

        <!-- The person whose post is shared details end -->
        @endif
        
        <div class='pt-4 pb-4'>
        {!! $post->content !!}
        </div>
        
        @if($post->postImage != "nullImage")

        <div class="mb-4">
        <img src="{{ asset( 'postImages/'.$post->postImage ) }}" alt=""/>
        </div>
        @endif

        <div class="mb-4 flex flex-row">

        <a href="/like-unlike-post/{{$post->postId}}/{{Auth::user()->id}}">
          <?php
          $isLiked = false;
          $currentPostd = 0;
          $likesCounter = 0;
          foreach($likes as $like){
            if($like->userId == Auth::user()->id){
              $isLiked = true;
              $currentPostd = $like->postId;
            }

            if($post->postId == $like->postId){
              $likesCounter++;
            }
          }

          if($isLiked == true && $currentPostd == $post->postId){
            ?>
            <div class="flex">
            <p>{{$likesCounter}}</p>
            <img class="ml-2" src="{{ asset( 'icons/heart.png') }}" width="25px" height="25px" alt=""/>
          </div>
          <?php
          }else{
            ?>
            <div class="flex">
            <p>{{$likesCounter}}</p>
            <img class="ml-2" src="{{ asset( 'icons/like.png') }}" width="25px" height="25px" alt=""/>
          </div>
          <?php
          }
          ?>
        
        </a>

        <form method="POST" action="/share-post/{{$post->id}}/{{$post->postId}}">
          @csrf
        <button>
        <img class="ml-4" src="{{ asset( 'icons/share.png') }}" width="25px" height="25px" alt=""/>
        </button>
        </div>
        </form>

        <div class="flex justify-end">
        <p class="text-xs">{{$post->created_at}}</p>
        </div>

        @foreach ($replies as $reply)
        @if($reply->replyAtPostId == $post->postId)
        <div class='bg-white border-red-400 w-10/12 p-4 mt-4 mb-4 shadow-md rounded-md'>
        <div class='flex flex-row place-items-start mb-4'>
        <div class='rounded-full w-8 h-8'>
        @if($reply->profileImage != "nullImage")

                        
        <div class="h-8 w-8 rounded-full">
        @if(substr($reply->profileImage,0,5) == "https")
        <img class="h-8 w-8 rounded-full" src="{{$reply->profileImage}}" alt=""/>
        @else
        <img class="h-8 w-8 rounded-full" src="{{ asset( 'profileImages/'.$reply->profileImage ) }}" alt=""/>
        @endif
        </div>
        @else
        <img class="h-8 w-8 rounded-full" src="{{ asset( 'profileImages/profile.png' ) }}" alt=""/>

        @endif
        </div>

        <h3 class='ml-2 text-black text-md'>{{ $reply->name }}</h3>
        </div>
          <p class="text-xs">{{$reply->replyContent}}</p>
        </div>
        @endif
        @endforeach

        <!-- make reply starts -->
        <form method="POST" action="/make-reply/{{$post->postId}}/{{Auth::user()->id}}">
            @csrf

            <div>
                <x-input-label for="content" :value="__('Reply')" />

                <textarea class="block mt-1 w-full" id="content" :value="old('content')" name="content" autofocus rows="3" cols="10"></textarea>


                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-primary-button class="ml-4">
                    {{ __('Reply') }}
                </x-primary-button>
            </div>
        </form>

        <!-- make reply ends -->

      </div>
      @endif
      @endforeach

    </div>
    

    <!-- others posts -->

    <div class='h-screen w-6/12 flex flex-col items-center'>
      
    @foreach($posts as $post)
    @if($post->userId != Auth::user()->id)
      @foreach($requests as $request)
      @if($request->requestStatus == 'accepted')
      @if($request->madeFriendId == Auth::user()->id || $request->madeByFriendId == Auth::user()->id)
      <div class='bg-white w-10/12 p-4 mb-2 mt-8 shadow-md rounded-md'>
        <div class='flex flex-row place-items-start'>
        <div class='w-10 h-10 rounded-full'>
        
        @if($post->profileImage != "nullImage")

                        
                        <div class="h-10 w-10 rounded-full">
                        @if(substr($post->profileImage,0,5) == "https")
                        <img class="h-10 w-10 rounded-full" src="{{$post->profileImage}}" alt=""/>
                        @else
                        <img class="h-10 w-10 rounded-full" src="{{ asset( 'profileImages/'.$post->profileImage ) }}" alt=""/>
                        @endif
                        </div>
                        @else
                        <img class="h-10 w-10 rounded-full" src="{{ asset( 'profileImages/profile.png' ) }}" alt=""/>
                        
                        @endif
        
        
        </div>
        <h3 class='ml-2 text-black text-bold'>{{ $post->name }}</h3>
        </div>

  
        <div class='pt-4 pb-4'>
        {!! $post->content !!}
        </div>
        
        @if($post->postImage != "nullImage")
        <div class="mb-4">
        <img src="{{ asset( 'postImages/'.$post->postImage ) }}" alt=""/>
        </div>
        @endif

        <div class="mb-4 flex flex-row">

        <a href="/like-unlike-post/{{$post->postId}}/{{Auth::user()->id}}">
          <?php
          $isLiked = false;
          $currentPostd = 0;
          $likesCounter = 0;
          foreach($likes as $like){
            if($like->userId == Auth::user()->id){
              $isLiked = true;
              $currentPostd = $like->postId;
            }

            if($post->postId == $like->postId){
              $likesCounter++;
            }
          }

          if($isLiked == true && $currentPostd == $post->postId){
            ?>
            <div class="flex">
            <p>{{$likesCounter}}</p>
            <img class="ml-2" src="{{ asset( 'icons/heart.png') }}" width="25px" height="25px" alt=""/>
          </div>
          <?php
          }else{
            ?>
            <div class="flex">
            <p>{{$likesCounter}}</p>
            <img class="ml-2" src="{{ asset( 'icons/like.png') }}" width="25px" height="25px" alt=""/>
          </div>
          <?php
          }
          ?>
        
        </a>

        <form method="POST" action="/share-post/{{$post->id}}/{{$post->postId}}">
          @csrf
        <img class="ml-4" src="{{ asset( 'icons/share.png') }}" width="25px" height="25px" alt=""/>
        </div>
        </form>

        <div class="flex justify-end">
        <p class="text-xs">{{$post->created_at}}</p>
        </div>

        @foreach ($replies as $reply)
        @if($reply->replyAtPostId == $post->postId)
        <div class='bg-white border-red-400 w-10/12 p-4 mt-4 mb-4 shadow-md rounded-md'>
        <div class='flex flex-row place-items-start mb-4'>
        <div class='rounded-full w-8 h-8'>
        @if($reply->profileImage != "nullImage")

                        
        <div class="h-8 w-8 rounded-full">
        @if(substr($reply->profileImage,0,5) == "https")
        <img class="h-8 w-8 rounded-full" src="{{$reply->profileImage}}" alt=""/>
        @else
        <img class="h-8 w-8 rounded-full" src="{{ asset( 'profileImages/'.$reply->profileImage ) }}" alt=""/>
        @endif
        </div>
        @else
        <img class="h-8 w-8 rounded-full" src="{{ asset( 'profileImages/profile.png' ) }}" alt=""/>

        @endif
        </div>

        <h3 class='ml-2 text-black text-md'>{{ $reply->name }}</h3>
        </div>
          <p class="text-xs">{{$reply->replyContent}}</p>
        </div>
        @endif
        @endforeach

        <!-- make reply starts -->
        <form method="POST" action="/make-reply/{{$post->postId}}/{{Auth::user()->id}}">
            @csrf

            <div>
                <x-input-label for="content" :value="__('Reply')" />

                <textarea class="block mt-1 w-full" id="content" :value="old('content')" name="content" autofocus rows="3" cols="10"></textarea>


                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-primary-button class="ml-4">
                    {{ __('Reply') }}
                </x-primary-button>
            </div>
        </form>

        <!-- make reply ends -->
        
      </div>
      @endif
      @endif
      @endforeach
      @endif
      @endforeach
    </div> 
        </main>

        <!-- sidebar -->
        <div class="fixed right-0 h-screen w-3/12 z-0 flex flex-row">
        <div>
              <h1 class="text-gray-800">Friend Requests</h1>
              @foreach($requests as $request)
              @if($request->requestStatus == "middle" && $request->madeFriendId == Auth::user()->id)
              <div class='bg-white w-10/12 p-2 mt-4 mb-4 shadow-md rounded-md'>
              <div class='flex flex-row place-items-start mb-4'>
                <div class='rounded-full w-8 h-8'>
                @if($request->profileImage != "nullImage")
                <div class="h-8 w-8 rounded-full">
                @if(substr($request->profileImage,0,5) == "https")
                <img class="h-8 w-8 rounded-full" src="{{$request->profileImage}}" alt=""/>
                @else
                <img class="h-8 w-8 rounded-full" src="{{ asset( 'profileImages/'.$request->profileImage ) }}" alt=""/>
                @endif
                </div>
                @else
                <img class="h-8 w-8 rounded-full" src="{{ asset( 'profileImages/profile.png' ) }}" alt=""/>
                @endif
                </div>
              <h3 class='ml-2 text-black text-sm'>{{$request->name}}</h3>
              </div>
              <div class="flex justify-between">

              <form action="/accept-friend-request/{{$request->friendId}}" method="POST">
                @csrf
              <button type="submit" name="" class="underline text-xs">
                {{ __('Accept') }}
              </button>
              </form>

              <form action="/refuse-friend-request/{{$request->friendId}}" method="POST">
                @csrf
              <button type="submit" name="" class="underline text-xs">
                {{ __('Refuse') }}
              </button>
              </form>
              </div>
              </div>
              @endif
              @endforeach

        </div>

        <div class="w-8 h-full"></div>

            <div class="mr-2">
            <h1 class="text-gray-800">Add Friend</h1>
              @foreach($users as $user)
              @if($user->id != Auth::user()->id)
              @if($user->madeFriendId != Auth::user()->id && $user->madeByFriendId != Auth::user()->id)

              <div class='bg-white w-10/12 p-2 mt-4 mb-4 shadow-md rounded-md'>
              <div class='flex flex-row place-items-start mb-4'>
                <div class='rounded-full w-8 h-8'>
                @if($user->profileImage != "nullImage")
                <div class="h-8 w-8 rounded-full">
                @if(substr($user->profileImage,0,5) == "https")
                <img class="h-8 w-8 rounded-full" src="{{$user->profileImage}}" alt=""/>
                @else
                <img class="h-8 w-8 rounded-full" src="{{ asset( 'profileImages/'.$user->profileImage ) }}" alt=""/>
                @endif
                </div>
                @else
                <img class="h-8 w-8 rounded-full" src="{{ asset( 'profileImages/profile.png' ) }}" alt=""/>
                @endif
              
              </div>
              
              <h3 class='ml-2 text-black text-sm'>{{$user->name}}</h3>
              
              </div>
              <div class="flex justify-center">
                <form method="POST"  action="/add-friend/{{$user->id}}/{{Auth::user()->id}}">
                  @csrf
              <button name="" type="submit" class="underline text-xs">
                {{ __('Add Friend') }}
              </button>
              </form>
              </div>
              </div>
              @endif
              @endif
            @endforeach



            </div>


        </div>
</div>
</x-app-layout>