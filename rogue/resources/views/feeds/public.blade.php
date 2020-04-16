@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($posts as $post)
            <div class="row py-5">
                <div class="col-lg-8 col-sm-12">
                    <a href="/posts/{{ $post->id }}">
                        <img src="/storage/{{ $post->image }}" class="w-100">
                    </a>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="row py-2">
                        <div class="pl-3 my-auto">
                            <a href="/profile/{{ $post->user->id }}">
                                <img src="/storage/{{ $post->user->profile->photo }}" class="rounded-circle w-100" style="max-width: 40px;">
                            </a>
                        </div>
                        <div class="pl-2 my-auto">
                            <a href="/profile/{{ $post->user->id }}">
                                <span class="text-dark">{{ $post->user->username }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {{ $post->caption }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-black-50">
                            {{ $post->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
