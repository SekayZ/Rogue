@extends('layouts.app')

@section('content')
<div class="container">

    @if (Auth::check() && $user->id == Auth::id() && $notifications)
        @foreach($notifications as $notification)
        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            @if($notification['type'] == 'new_comment')
                <a href="{{ $notification['url'] }}" class="alert-link">{{ '@' . $notification['username'] }} just commented on your post!</a>

            @elseif($notification['type'] == 'new_follower')
                <a href="{{ $notification['url'] }}" class="alert-link">{{ '@' . $notification['username'] }} is now following you!</a>

            @endif
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endforeach
    @endif

    <div class="row">
        <div class="col-3 pt-5">
            <img src="/storage/{{ $user->profile->photo }}" class="rounded-circle w-100">
        </div>
        <div class="col-6 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                    <div class="h2">{{ $user->username }}</div>
                </div>
            </div>
            <div class="d-flex">
                <div class="pr-5"><strong>{{ $user->numPosts() }} posts</strong></div>
                <div class="pr-5"><a href="#" class="text-dark" role="button" data-toggle="modal" data-target="#followers"><strong>{{ $user->numFollowers() }} followers</strong></a></div>
                <div class="pr-5"><a href="#" class="text-dark" role="button" data-toggle="modal" data-target="#following"><strong>{{ $user->numFollowing() }} following</strong></a></div>
            </div>
            <!-- Modals for following and followers of profile -->
            <!-- Modal for followers -->
            <div class="modal fade" id="followers" tabindex="-1" role="dialog" aria-labelledby="followerLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="followerLabel">{{ '@' . $user->username }} is followed by these users</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if( $user->numFollowers() < 1)
                                No one is following this user at this time. Be the first!
                            @else
                            @foreach( $user->followers as $follower)
                            <div class="row py-2">
                                <div class="pl-3 my-auto">
                                    <a href="/profile/{{ $follower->id }}">
                                        <img src="/storage/{{ $follower->profile->photo }}" class="rounded-circle w-100" style="max-width: 40px;">
                                    </a>
                                </div>
                                <div class="pl-2 my-auto">
                                    <a href="/profile/{{ $follower->id }}">
                                        <span class="text-dark">{{ '@' . $follower->username }}</span>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for following -->
            <div class="modal fade" id="following" tabindex="-1" role="dialog" aria-labelledby="followingLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="followingLabel">{{ '@' . $user->username }} is following these users</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if( $user->numFollowing() < 1)
                                {{ $user->username }} is not following anyone at the moment.
                            @else
                            @foreach( $user->follows as $follow)
                                <div class="row py-2">
                                    <div class="pl-3 my-auto">
                                        <a href="/profile/{{ $follow->id }}">
                                            <img src="/storage/{{ $follow->profile->photo }}" class="rounded-circle w-100" style="max-width: 40px;">
                                        </a>
                                    </div>
                                    <div class="pl-2 my-auto">
                                        <a href="/profile/{{ $follow->id }}">
                                            <span class="text-dark">{{ '@' . $follow->username }}</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of Modals -->
            <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
        </div>
        <div class="col-3 pt-5">
            @if (Auth::check() && $user->id != Auth::id() && $followed==false)
                <form method="post" action="/follow" >
                    @csrf
                    <input type="hidden" name="follow" value="{{ $user->id }}">
                    <button type="submit" class="btn btn-primary btn-block mb-2 ">Follow</button>
                </form>
            @elseif (Auth::check() && $user->id != Auth::id() && $followed)
                <form method="post" action="/unfollow" >
                    @csrf
                    <input type="hidden" name="unfollow" value="{{ $user->id }}">
                    <button type="submit" class="btn btn-primary btn-block mb-2 ">Unfollow</button>
                </form>
            @elseif (Auth::check() && $user->id == Auth::id())
                <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block mb-2 ">Logout</button>
                </form>
                <a href="/profile/edit" class="btn btn-primary btn-block mb-2 ">Edit Profile</a>
            @endif
        </div>
    </div>
    <div class="row pt-5">
        @if($user->numPosts() != 0)
            @foreach($user->posts as $post)
                <div class="col-4 pb-4">
                    <a href="/posts/{{ $post->id }}">
                        <img src="/storage/{{ $post->image }}" class="w-100">
                    </a>
                </div>
            @endforeach
        @else
            <br>
            <h1>No posts yet</h1>
        @endif

    </div>

</div>
@endsection
