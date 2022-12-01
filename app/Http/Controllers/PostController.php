<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;
use App\Models\Reply;
use App\Models\Like;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function home(){
        $posts = DB::table('posts')
        ->leftJoin('users', 'posts.userId', '=', 'users.id')
        ->get();

        $replies = DB::table('replies')
        ->leftJoin('users', 'replies.repliedById', '=', 'users.id')
        ->get();

        $likes = DB::select('SELECT * from likes');
        $users = DB::select('SELECT * from users left join friends on users.id = friends.madeFriendId or users.id = friends.madeByFriendId');

        $requests = DB::table('friends')
        ->leftJoin('users', 'friends.madeByFriendId', '=', 'users.id')
        ->get();

        $shareButons=\Share::page(
            url('/dashboard'),
        )->twitter();

        return view('dashboard', ['posts' => $posts, 'replies' => $replies, 'likes' => $likes, 'users' => $users, 'requests' => $requests, 'shareButons' => $shareButons]);
    }

    public function create(){
        $shareButons=\Share::page(
            url('/dashboard'),
        )->facebook();
        return view('post.create', ['shareButons' => $shareButons]);
    }

    public function reply($postId, $userId, Request $request){
        $newReply = new Reply;
        $newReply->replyContent = $request->content;
        $newReply->replyAtPostId = $postId;
        $newReply->repliedById = $userId;
        $newReply->save();
        return redirect('/dashboard');
    }

    public function likeUnlike($postId, $userId){
        $likes = Like::where('postId', '=', $postId)
        ->where('userId', '=', $userId)
        ->first();

        if($likes){
            $likes->delete();
        }else{
            $like = new Like;
            $like->postId = $postId;
            $like->userId = $userId;
            $like->save();
        }
        

        return redirect('/dashboard');

    }

    public function store($id, Request $request){
        if($request->postImage != null){
        $filename = time().'.'.$request->postImage->getClientOriginalExtension();
        $request->postImage->move(public_path('/postImages'), $filename);

        $post = new Post;
        $post->personWhosePostIsSharedImage = "null";
        $post->personWhosePostIsSharedName = "null";
        $post->content = $request->content;
        $post->postImage = $filename;
        $post->userId = $id;
        $post->save();

        return redirect('/dashboard');
        }else{
        $post = new Post;
        $post->personWhosePostIsSharedImage = "null";
        $post->personWhosePostIsSharedName = "null";
        $post->content = $request->content;
        $post->postImage = "nullImage";
        $post->userId = $id;
        $post->save();

        return redirect('/dashboard');
        }
        
    }

    public function sharePost($userId, $postId){
        $user = User::where('id', $userId)->first();
        $mypost = Post::where('postId', $postId)->first();

            $post = new Post;
            $post->personWhosePostIsSharedImage = $user->profileImage;
            $post->personWhosePostIsSharedName = $user->name;
            $post->content = $mypost->content;
            $post->postImage = $mypost->postImage;
            $post->userId = $mypost->userId;
            $post->save();
    
            return redirect('/dashboard');
           
    }
}
