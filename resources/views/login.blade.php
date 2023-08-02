@extends("layout.account")

@section("title", "Login")

@section("contents")
<main class="page-center">
  <article class="sign-up">
  <img src="{{ asset('assets/images/logo/logo.png') }}" class="img" style="width:35%">
    <!-- <p class="sign-up__subtitle">VSY Collection | Signin To Your Account</p> -->
    <p class="sign-up__subtitle">VSY Enterprise</p>
    <div class="btn-group">
      <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        Select Website to Visit
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="https://vsyresidential.com/">VSY Apartment</a></li>
        <li><a class="dropdown-item" href="#">VSY Lending</a></li>
        <li><a class="dropdown-item" data-bs-toggle="collapse" href="#sign-up-form" role="button" aria-expanded="false" aria-controls="collapseExample">
      VSY Collection
    </a></li>
      </ul>
    </div>

    <form class="sign-up-form form" id="sign-up-form" action="" method="">
      <label class="form-label-wrapper">
        <p class="form-label">Email</p>
        <input class="form-input" type="email" placeholder="Enter your email" required>
      </label>
      <label class="form-label-wrapper">
        <p class="form-label">Password</p>
        <input class="form-input" type="password" placeholder="Enter your password" required>
      </label>
      <a class="link-info forget-link" href="##">Forgot your password?</a>
      <label class="form-checkbox-wrapper">
        <input class="form-checkbox" type="checkbox" required>
        <span class="form-checkbox-label">Remember me next time</span>
      </label>
      <button class="form-btn primary-default-btn transparent-btn">Sign in</button>
    </form>
  </article>
</main>
@endsection
