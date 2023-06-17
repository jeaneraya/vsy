@extends('layout.account')

@section('title', 'Login')

@section('contents')
    <main class="page-center">

        <div>
            @if (Session::has('info'))
                <div class="alert alert-primary" role="alert">
                    {{ session('info') }}
                </div>
            @endif

            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (Session::has('danger'))
                <div class="alert alert-danger" role="alert">
                    {{ session('danger') }}
                </div>
            @endif
            @if (Session::has('warning'))
                <div class="alert alert-warning" role="alert">
                    {{ session('warning') }}
                </div>
            @endif
        </div>

        <article class="sign-up">
            <img src="{{ asset('assets/images/logo/logo.png') }}" class="img" style="width:35%">
            <p class="sign-up__subtitle">VSY Collection | Signin To Your Account</p>
            <form class="sign-up-form form"method="POST" action="{{ route('login') }}">
                @csrf

                <label class="form-label-wrapper">
                    <p class="form-label">Email</p>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror form-input" placeholder="Enter your email"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror


                <label class="form-label-wrapper">
                    <p class="form-label">Password</p>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror form-input"
                        placeholder="Enter your password" name="password" required autocomplete="current-password">
                </label> @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror


                @if (Route::has('password.request'))
                    <a class="link-info forget-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif


                <label class="form-checkbox-wrapper">
                    <input class="form-check-input form-checkbox" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <span class="form-checkbox-label">Remember me next time</span>
                </label>

                <button type="submit" class="form-btn primary-default-btn transparent-btn">
                    Sign in
                </button>

            </form>

        </article>
    </main>
@endsection
