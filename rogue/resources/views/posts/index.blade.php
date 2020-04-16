@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <img src="/storage/{{ $post->image }}" class="w-100">
            </div>
            <div class="row py-4">
                <div class="col-6">
                    @if (Auth::check() && $post->user->id != Auth::id() && !$voted)
                        <form method="post" action="/vote" >
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <button type="submit" class="btn btn-primary btn-sm" name="vote" value="upvote">upvote</button>
                            <button type="submit" class="btn btn-primary btn-sm" name="vote" value="downvote">downvote</button>
                        </form>
                    @endif
                </div>
                <div class="col-6 text-right">
                        <strong>Votes: {{ $score }}</strong>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div>
                <div class="d-flex align-items-center">
                    <div class="pr-3">
                        <a href="/profile/{{ $post->user->id }}">
                        <img src="/storage/{{ $post->user->profile->photo }}" class="rounded-circle w-100" style="max-width: 40px;">
                        </a>
                    </div>
                    <div class="pr-3">
                        <a href="/profile/{{ $post->user->id }}">
                            <span class="text-dark">{{ '@'.$post->user->username }}</span>
                        </a>
                    </div>
                    <div class="ml-auto">
                        @if (Auth::check() && $post->user->id != Auth::id() && $followed==false)
                            <form method="post" action="/follow" >
                                @csrf
                                <input type="hidden" name="follow" value="{{ $post->user->id }}">
                                <button type="submit" class="btn btn-primary pr-5 pl-5">Follow</button>
                            </form>
                        @endif
                    </div>
                </div>

                <br>

                <p>

                <span>
                    {{ $post->caption }}
                </span>
                </p>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        Comment
                    </div>
                    <div class="panel-body">
                        @if (Auth::check())

                        <form method="post" action="/comments" enctype="multipart/form-data">
                        @csrf
                        <textarea class="form-control @error('comment') is-invalid @enderror" placeholder="write a comment..." rows="2" name="comment" value="{{ old('comment') }}" required></textarea>
                        @error('comment')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                        <input type="hidden" name="post_id" value="{{ $post->id }}" />
                        <br>
                        <button type="submit" class="btn btn-primary pr-5 pl-5">Post</button>
                        <div class="clearfix"></div>
                        </form>
                        @else
                            Login or Register to post a comment!
                        @endif
                        <hr>
                        <ul class="media-list">
                            @if ($post->comments->count()>0)

                            @foreach($post->comments->sortByDesc('created_at') as $comment)
                            <li class="media">
                                <div class="pr-3">
                                <a href="/profile/{{ $comment->user->profile->id }}" class="pull-left">
                                    <img src="/storage/{{ $comment->user->profile->photo }}" class="rounded-circle w-100" style="max-width: 40px;">
                                </a>
                                </div>
                                <div class="media-body">
                                <a href="/profile/{{ $comment->user->profile->id }}">
                                    <strong class="text-dark">{{ '@'.$comment->user->username }}</strong>
                                </a>
                                    <span class="text-muted pull-right">
                                    <small class="text-muted">{{ $comment->created_at }}</small>
                                </span>
                                <p>
                                    {{ $comment->comment }}
                                </p>
                                </div>
                            </li>
                            @endforeach
                            @else
                            <li class="media">
                                No comments yet!
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
