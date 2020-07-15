@extends('layouts.app')

@section('pagelevelheader')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (Session::has('message'))
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{ Session::get('message') }}</strong>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary mr-1">
                                        {{ __('Login') }}
                                    </button>

                                    or

                                    @if (Route::has('register'))
                                        <a class="btn btn-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </form>

                        <div class="or-seperator"><i>OR</i></div>

                        <div class="text-center social-btn">
                            <a href="{{ url('/login/facebook')}}" class="btn btn-primary btn-lg">
                                <i class="fa fa-facebook"></i>Log in with<b>Facebook</b></a>
                            <a href="{{ url('/login/twitter')}}" class="btn btn-info btn-lg">
                                <i class="fa fa-twitter"></i>Log in with<b>Twitter</b></a><br>
                            <a href="{{ url('/login/linkedin')}}" class="btn btn-primary btn-lg">
                                <i class="fa fa-linkedin"></i>Log in with <b>LinkedIn</b></a>
                            <a href="{{ url('/login/google')}}" class="btn btn-danger btn-lg">
                                <i class="fa fa-google"></i>Log in with<b>Google</b></a>
                            <a href="{{ url('/login/github')}}" class="btn btn-primary btn-lg">
                                <i class="fa fa-github"></i>Log in with<b>Github</b></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

