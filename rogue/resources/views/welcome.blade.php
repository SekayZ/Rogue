@extends('layouts.app')

@section('content')
<body id="body_welcome_page">
<div class="container" id="welcome" >
    <div class="row justify-content-center">
        <div class="jumbotron">
            <div align="center" class="display-4">Welcome to Rogue!</div>
            <p class="lead">

                </br>This is a project for SOEN341 made by Killian, James, Daniel, Ashraf and Kaysse
                </br>This a list of our functionalities so far:
                <ul>
                    <li>Registration/Connection</li>
                    <li>Profile</li>
                    <li>Adding pictures</li>
                    <li>Commenting pictures</li>
                    <li>Editing the profile</li>
                </ul>
                Go ahead! Start using our website by creating your profile and posting some amazing pictures!
            </p>
        </div>
    </div>

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
 <div id="text_container_welcome">
    <img id="welcome_logo" src="images/Allblack1.png" alt="Logo"/>
 </div>
</body>
@endsection
