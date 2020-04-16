<?php

namespace App\Http\Controllers;

use App\User;
use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VotesController extends Controller
{
    public function index(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $vote = new Vote();

        $request->validate([
            'vote' => 'required',
            'post_id' => Rule::unique('votes')->where(function ($query) use ( $user) {
                return $query->where('user_id', $user->id);
                }),
        ]);

        $vote->user_id = $user->id;
        $vote->post_id = $request->post_id;

        if($request->vote == "upvote"){
            $vote->vote = 1;
        }else if($request->vote == "downvote"){
            $vote->vote = -1;
        }


        $vote->save();

        return redirect('posts/'.$request->post_id);
    }
}
