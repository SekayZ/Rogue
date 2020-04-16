<?php

namespace App\Http\Controllers;

use App\Post;
use App\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index(){
        if(Auth::check()) {
            $users = auth()->user()->follows()->pluck('followed');
            $posts = Post::whereIn('user_id', $users)->latest()->get();
            return view('feeds.private', compact('posts'));
        }else{
            return $this->explore();
        }
    }

    public function explore(){
        $posts = Post::all()->whereNotIn('user_id', Auth::id());
        $posts->each(function ($item) {
            $comment_score = $item->comments->count() == null ? 0 : $item->comments->count() ;
            $time_created = new Carbon($item->created_at);
            $time_score = Carbon::now()->diffInMinutes($time_created);
            $vote_score = $item->score();
            $item['score'] = ( (0.75 + ($comment_score * 0.5) + ($vote_score) ) / (1 + ( $time_score / 60 ) )) ;
        });
        $posts = $posts->sortByDesc('score');

        return view('feeds.public', ['posts' => $posts]);
    }
}
