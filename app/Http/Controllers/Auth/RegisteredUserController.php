<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Friend;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Mail\SocialMediaMail;
use Illuminate\Support\Facades\Mail;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
            if($request->profileImage != null){
                $filename = time().'.'.$request->profileImage->getClientOriginalExtension();
                $request->profileImage->move(public_path('/profileImages'), $filename);
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->profileImage = $filename;
                $user->backgroundImage1 = "nullImage";
                $user->backgroundImage2 = "nullImage";
                $user->save();
                Auth::login($user);
                return redirect(RouteServiceProvider::HOME);
            }else{
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->profileImage = "nullImage";
                $user->backgroundImage1 = "nullImage";
                $user->backgroundImage2 = "nullImage";
            
                $user->save();


                Auth::login($user);

                return redirect(RouteServiceProvider::HOME);
            }
            
            
    }

    public function redirectToProvider(){
        return Socialite::driver('google')->redirect();
    }

    public function handlecallback(){
        try{
            $user = Socialite::driver('google')->stateless()->user();
        }catch(Exception $e){
            echo $e;
            return redirect('/');
        }

        $existingUser = User::where('google_id', $user->id)->first();
        if($existingUser){
            Auth::login($existingUser);
            return redirect(RouteServiceProvider::HOME);
        }else{
            $username = $user->name;
            $useremail = $user->email;
            $googleId = $user->id;
            $usernameimage = $user->avatar;
            $user = new User;
            $user->name = $username;
            $user->email = $useremail;
            $user->google_id = $googleId;
            $user->password = "LoggedInWithGoogle";
            $user->profileImage = $usernameimage;
            $user->backgroundImage1 = "nullImage";
            $user->backgroundImage2 = "nullImage";

            $user->save();


        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
        }
    }

    public function makefriend($madeFriendId, $madeByFriendId){
                $friend = new Friend;
                $friend->madeFriendId = $madeFriendId;
                $friend->madeByFriendId = $madeByFriendId;
                $friend->requestStatus = "middle";
                $friend->requestSent = "yes";
                $friend->save();
                return redirect(RouteServiceProvider::HOME);
    }

    public function acceptfriendrequest($friendId){
        DB::table('friends')
        ->where('friendId', $friendId)  // find your user by their email
        ->limit(1)  // optional - to ensure only one record is updated.
        ->update(array('requestStatus' => "accepted"));
        return redirect(RouteServiceProvider::HOME);
    }

    public function refusefriendrequest($friendId){
        DB::table('friends')
        ->where('friendId', $friendId)  // find your user by their email
        ->limit(1)  // optional - to ensure only one record is updated.
        ->update(array('requestStatus' => "refused"));
        return redirect(RouteServiceProvider::HOME);
    }

    public function profileImage(){
        return view('profile.profileImage');
    }

    
}
