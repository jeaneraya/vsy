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
  </article>
</main>
@endsection