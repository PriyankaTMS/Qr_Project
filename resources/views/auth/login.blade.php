{{--  @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  --}}


@extends('layouts.app')

@section('content')
    <style>
        body {
            /*  background: linear-gradient(135deg, #6c307f, #d9a7c7);*/
            background-size: cover;
            font-family: 'Poppins', sans-serif;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            margin-top: 10%;
        }

        .card-header {
            background: #ffffff;
            border: none;
            padding: 20px;
            border-bottom: 2px solid #eee;
        }

        .header-logo {
            max-height: 60px;
        }

        .login-title {
            text-align: center;
            font-size: 22px;
            font-weight: 600;
            color: #4C4C4C;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 10px;
            height: 45px;
        }

        .btn-login {
            background: #6c307f;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            width: 120px;
        }

        .btn-login:hover {
            background: #5a2970;
            color: #fff;
        }

        .bottom-link a {
            color: #6c307f;
            font-weight: 500;
            text-decoration: none;
        }

        .bottom-link a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card login-card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <img src="{{ asset('stallmaillogo.png') }}" class="header-logo" alt="Left Logo">
                        <!--<img src="{{ asset('sublogo.png') }}" class="header-logo" alt="Right Logo">-->
                    </div>

                    <div class="card-body">

                        <h4 class="login-title">Welcome Back</h4>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autofocus>

                                @error('email')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required>

                                @error('password')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-login">
                                    {{ __('Login') }}
                                </button>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-center mt-3 bottom-link">
                                    <a href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
