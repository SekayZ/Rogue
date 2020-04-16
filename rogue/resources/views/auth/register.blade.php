@extends('layouts.app')

@section('content')
<div class="reg_html">    
    <div class="reg_body">
        <div class="reg_container">
            <form method="POST" action="{{ route('register') }}">
                <div class="reg_field_container">
                        @csrf
                            <h1 class="reg_h1">Registration</h1>
                            <div class="reg_input_style">
                                <input id="name" placeholder="Name" type="text" class="reg_input_field @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="reg_input_style">
                                <input id="email" placeholder="Email" type="email" class="reg_input_field @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="reg_input_style">
                                <input id="username" placeholder="Username" type="text" class="reg_input_field @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="reg_input_style">
                                <input id="password" placeholder="Password" type="password" class="reg_input_field @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                 
                            <div class="reg_input_style">
                                <input id="password-confirm" placeholder="Confirm Password" type="password" class="reg_input_field" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <button type="submit" class="reg_input_submit">
                                {{ __('Register') }}
                            </button>
                </div>
            </form> 
        </div>
    </div>           
</div>    
@endsection
