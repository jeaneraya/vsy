@extends('layout.account')

@section('title', 'Login')

@section('contents')
    <main class="page-center">
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

                <button class="form-btn primary-default-btn transparent-btn">Sign in</button>
                <button type="submit" class="class="form-btn primary-default-btn transparent-btn">
                    Sign in
                </button>

            </form>

        </article>
    </main>
@endsection
