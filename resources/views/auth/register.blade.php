@extends('layout.account')

@section('title', 'Register')

@section('contents')
<style>

input:enabled:read-write:-webkit-any(:focus, :hover)::-webkit-calendar-picker-indicator {
   display: block !important;
 }


</style>
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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <main class="page-center registration-form">
        <article class="sign-up">
            <img src="{{ asset('assets/images/logo/logo.png') }}" class="img" style="width:20%">
            <p class="sign-up__subtitle">VSY Collection | Create New Administrator's Account</p>

            <form class="sign-up-form form" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row">
                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Role</p>
                        {{-- <input id="role" type="text" class="form-control @error('role') is-invalid @enderror form-input"
                            role="role" value="{{ old('role') }}" placeholder="Enter your role" required
                            autocomplete="role" autofocus> --}}

                        <select name="role" id="role" type="text"
                            class="form-control @error('role') is-invalid @enderror form-input autofocus">
                            @php
                                $roles = App\Models\Role::all();
                            @endphp
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id == old('role') ? 'selected' : '' }}>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Name</p>
                        <input id="name" type="text"
                            class="form-control input_name @error('name') is-invalid @enderror form-input" name="name"
                            value="{{ old('name') }}" placeholder="Enter your name" required autocomplete="name"
                            maxlength="50"
                            autofocus>
                    </label>

                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Birthday</p>
                        <input id="birthday" type="date"
                            class="form-control @error('birthday') is-invalid @enderror  form-input" name="birthday"
                            value="{{ old('birthday') }}" required autocomplete="birthday">
                    </label>


                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Address</p>
                        <input id="address" type="address"
                            class="form-control @error('address') is-invalid @enderror  form-input" name="address"  maxlength="100"
                            value="{{ old('address') }}" required autocomplete="address">
                    </label>

                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Contact Number</p>
                        <input id="contact" type="contact"
                            class="form-control input-numbers @error('contact') is-invalid @enderror  form-input" name="contact" maxlength="11" minlength="11"
                            value="{{ old('contact') }}" required autocomplete="contact">
                    </label>

                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Email</p>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror  form-input" name="email"
                            maxlength="50"
                            value="{{ old('email') }}" required autocomplete="email">
                    </label>
                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Password</p>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror form-input"
                            maxlength="50"
                            placeholder="Enter your password" name="password" required autocomplete="new-password">
                    </label>


                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Confirm Password</p>
                        <input id="password-confirm" type="password" class="form-control form-input"
                            name="password_confirmation" required autocomplete="new-password" maxlength="50">

                    </label>


                </div>
                <button type="submit" class="form-btn primary-default-btn transparent-btn">
                    Create Account
                </button>

            </form>

        </article>
    </main>

@endsection


@section('scripts')
<script>
    $('document').ready(function() {
        // front end input restriction
        $(".input-numbers").keypress(function(event) {
            return /\d/.test(String.fromCharCode(event.keyCode));
        });
        $(".input_name").keypress(function(event) {
            return /^[a-zA-Z.\s]*$/.test(String.fromCharCode(event.keyCode));
        });
    });
    </script>

@endsection

