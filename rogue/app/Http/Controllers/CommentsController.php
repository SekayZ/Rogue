<?php

namespace App\Http\Controllers;

use App\Notifications\NewComment;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function store(Request $request){
        $comment = new Comment();
        $user = User::findOrFail(Auth::id());
        $post = Post::findOrFail($request->post_id);

        $comment->user_id = $user->id;
        $comment->post_id = $post->id;

        $request->validate([
            'comment' => 'required',
        ]);

        $comment->comment = $request->comment;
        $comment->save();

        $toNotify = $post->user;

        $toNotify->notify(new NewComment($comment));

        return redirect('posts/'.$post->id);

    }


}
