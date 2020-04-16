<?php

namespace App\Http\Controllers;

use App\Follows;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;

class ProfilesController extends Controller
{

    public function edit(){

        return view('profiles.edit', [
            'user' => User::findOrFail(Auth::id()),
        ]);
    }

    public function show($user=null){
        if($user==null || $user == auth()->id()){
            $user = User::findOrFail(Auth::id());
            $notifications = collect();
            foreach ($user->unreadNotifications->where('type', 'App\Notifications\NewComment') as $notification) {
                $insert = ['type' => 'new_comment',
                    'username' => User::find($notification->data['user_commented'])->username,
                    'post_id' => $notification->data['new_comment'],
                    'url' => '/posts/' . $notification->data['new_comment'] ,
                ];
                $notifications->push($insert);
                $notification->markAsRead();
            }
            foreach ($user->unreadNotifications->where('type', 'App\Notifications\NewFollower') as $notification) {
                $insert = ['type' => 'new_follower',
                    'username' => User::find($notification->data['new_follower'])->username ,
                    'url' => '/profile/' . $notification->data['new_follower'],
                    ];
                $notifications->push($insert);
                $notification->markAsRead();
            }

            return view('profiles.index', [
                'user' => $user,
                'notifications' => $notifications,
            ]);
        }else {
            $user = User::findOrFail($user);
            $followed = Follows::where('user_id', '=' , Auth::id())
                ->where('followed' , '=' , $user->id)->exists();
            return view('profiles.index', [
                'user' => $user,
                'followed' => $followed,
            ]);
        }
    }

    public function update(Request $request){
        $user = User::findOrFail(Auth::id());
        $profile = $user->profile;

        $request->validate([
            'username' => 'nullable|alpha_num|max:25|unique:users',
            'title' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if($request->image != null) {
            $path = $request->file('image')->store('images/profile','public');
            $img = Image::make(Storage::disk('public')->get($path))->fit(200)->encode();
            Storage::disk('public')->put($path, $img);
            $profile->photo = $path;
        }

        if($request->title != null) {
            $profile->title = $request->title;
        }

        if($request->username != null) {
            $user->username = $request->username;
            $user->save();
        }

        $profile->save();

        return redirect('profile/'.$user->id);

    }

    public function search(Request $request){
        if(User::where('username', '=', $request->search)->exists()){
            $user = User::where('username', '=', $request->search)->first();
            return redirect('profile/'.$user->id);
        }else{
            return redirect('profile');
        }
    }
}


