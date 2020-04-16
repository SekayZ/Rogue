@extends('layouts.app')

@section('content')

    <div id="post_box" >
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Post New Picture</div>

                    <div class="card-body">
                        <form method="post" action="/posts" enctype="multipart/form-data">
                            @csrf

                            <div id="post_picture_text" class="form-group row">
                                <label id="choose_file_button" for="image" class="col-md-4 col-form-label text-md-right">Post a Picture</label>

                                <div class="col-md-6">
                                    <input id="image_upload_post" type="file" 
                                    class="form-control @error('image') is-invalid @enderror" name="image"  >

                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div id="pic_caption_div" class="form-group row">
                                <label for="caption" class="col-md-4 col-form-label text-md-right">Picture Caption</label>

                                <div class="col-md-6">
                                    <input id="caption" type="text" class="form-control @error('caption') is-invalid @enderror" name="caption" value="{{ old('caption') }}" required autocomplete="caption" autofocus>

                                    @error('caption')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div id="post_button_div"  class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Post
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
