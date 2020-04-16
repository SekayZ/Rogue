<?php

namespace App\Http\Controllers;

use App\Follows;
use App\Post;
use App\User;
use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;

class PostsController extends Controller
{
    public function index(){
        $users = auth()->user()->follows()->pluck('followed');
        $posts = Post::whereIn('user_id', $users)->latest()->get();
        return view('posts.homepage', compact('posts'));
    }

    public function store(Request $request){

        $user = User::findOrFail(Auth::id());

        $post = new Post();
        $post->user_id = $user->id;

        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'caption' => 'required',
        ]);

        if(null != $request->image) {
            $path = $request->file('image')->store('images/posts','public');
            $img = Image::make(Storage::disk('public')->get($path))->fit(700)->encode();
            Storage::disk('public')->put($path, $img);
            $post->image = $path;
        }

        $post->caption = $request->caption;
        $post->save();

        return redirect('posts/'.$post->id);
    }

    public function create(){

        return view('posts.create', [
            'user' => User::findOrFail(Auth::id()),
        ]);
    }

    public function show($id){

        $post = Post::findOrFail($id);

        $followed = Follows::where('user_id', '=' , Auth::id())
            ->where('followed' , '=' , $post->user->id)->exists();

        $voted = Vote::where('user_id', '=', Auth::id())->where('post_id', '=', $post->id)->exists();

        $score = $post->score();

        return view('posts.index', [
            'post' => $post,
            'followed' => $followed,
            'voted' => $voted,
            'score' => $score,
        ]);
    }

}
