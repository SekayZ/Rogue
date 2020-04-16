<?php

namespace App\Http\Controllers;

use App\Follows;
use App\Notifications\NewFollower;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(Request $request)
    {

        $user = User::findOrFail(Auth::id());
        $follow = new Follows();
        $follow->user_id = $user->id;

        if (null != $request->follow) {
            $follow->followed = $request->follow;
        }

        $follow->save();

        $toNotify = User::findOrFail($request->follow);

        $toNotify->notify(new NewFollower($user));

        return redirect('profile/'.$request->follow);
    }

    public function unfollow(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        if (null != $request->unfollow) {
            $unfollow = $request->unfollow;
        }

        Follows::where('user_id', $user->id)
            ->where('followed', $unfollow)->delete();

        return redirect('profile/'.$request->unfollow);
    }

}
