@extends("layout.account")

@section("title","Register")

@section("contents")
<main class="page-center">
<article class="sign-up">
    <img src="{{ asset('assets/images/logo/logo.png') }}" class="img" style="width:20%">
    <p class="sign-up__subtitle">VSY Collection | Create New Administrator's Account</p>
    <form class="sign-up-form form" action="" method="">
      <label class="form-label-wrapper">
        <p class="form-label">Name</p>
        <input class="form-input" type="text" placeholder="Enter your name" required>
      </label>
      <label class="form-label-wrapper">
        <p class="form-label">Username</p>
        <input class="form-input" type="text" placeholder="Enter your email" required>
      </label>
      <label class="form-label-wrapper">
        <p class="form-label">Password</p>
        <input class="form-input" type="password" placeholder="Enter your password" required>
      </label>
      <button class="form-btn primary-default-btn transparent-btn">Create Account</button>
    </form>




    <form class="sign-up-form form" method="POST" action="{{ route('register') }}">
        @csrf

        <label class="form-label-wrapper">
            <p class="form-label">Name</p>
            <input id="name" type="text" placeholder="Enter your name" class="form-control @error('name') is-invalid @enderror form-input" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
          </label>
          @error('name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror

        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
        </div>
    </form>
  </article>
</main>
@endsection
