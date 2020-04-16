@extends('layouts.app')

@section('content')
<div class="login_html">
        <div class="login_body">
            <div class="login_container">
                <div  class="login_left_container">
                    <img  src="images/Allblack1.png" alt="Logo"/>
                </div>
                
                <form method="POST" action="{{ route('login') }}">
                        @csrf
                    <div  class="login_right_container">
                            <div class="login_input_style">
                                <input placeholder="Email" id="email" type="email" class="login_input_field @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="login_input_style">
                                <input placeholder="Password" id="password" type="password" class="login_input_field @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                </label>
                            </div>
                            <button type="submit" class="login_input_submit">
                                    {{ __('Login') }}
                            </button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif    
                    </div>      
                </form> 
            </div>
        </div>
</div>
   @endsection
