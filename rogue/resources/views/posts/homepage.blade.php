@extends('layouts.app')

@section('content')

    <div class="container">

    @if($posts->count() == 0)
        <br>
            <div>
                <div class="row">
                    <img src="images/Allblack1.png" alt="Logo" width="250" height="250"/>
                    <img src="images/Allblack1.png" alt="Logo" width="250" height="250"/>
                    <img src="images/Allblack1.png" alt="Logo" width="250" height="250"/>
                    <img src="images/Allblack1.png" alt="Logo" width="250" height="250"/>
                </div>
            </div>
        <br>
        <h1>You are currently not following anyone</h1>
        <hr>
        <h3> Follow other users to view your custom feed.</h3>
        <br>
            <div class="row">
                <img src="images/Allblack1.png" alt="Logo" width="250" height="250"/>
                <img src="images/Allblack1.png" alt="Logo" width="250" height="250"/>
                <img src="images/Allblack1.png" alt="Logo" width="250" height="250"/>
                <img src="images/Allblack1.png" alt="Logo" width="250" height="250"/>
            </div>
        @endif

      @foreach($posts as $post)
          <div class="row">
              <div class="col-8">
                  <img src="/storage/{{ $post->image }}" class="w-100">
              </div>
              <div class="col-4">
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
                      </div>

                      <hr size="20">

                      <p>

                <span>
                    {{ $post->caption }}
                </span>
                      </p>


                  </div>
              </div>
          </div>

          <br><br>


      @endforeach
</div>
@endsection
