@extends('layout.account')

@section('title', 'Register')

@section('contents')
    <main class="page-center registration-form">
        <article class="sign-up">
            <img src="{{ asset('assets/images/logo/logo.png') }}" class="img" style="width:10%">
            <p class="sign-up__subtitle" style="margin:auto">VSY Collection | Create New Administrator's Account</p>

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
                    @error('role')
                        {{-- <span class="invalid-feedback" role="alert"> --}}
                        <strong>{{ $message }}</strong>
                        {{-- </span> --}}
                    @enderror

                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Name</p>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror form-input"
                            name="name" value="{{ old('name') }}" placeholder="Enter your name" required
                            autocomplete="name" autofocus>
                    </label>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Birthday</p>
                        <input id="birthday" type="date"
                            class="form-control @error('birthday') is-invalid @enderror  form-input" name="birthday"
                            value="{{ old('birthday') }}" required autocomplete="birthday">
                    </label>
                    @error('birthday')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Address</p>
                        <input id="address" type="address"
                            class="form-control @error('address') is-invalid @enderror  form-input" name="address"
                            value="{{ old('address') }}" required autocomplete="address">
                    </label>
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Contact Number</p>
                        <input id="contact" type="contact"
                            class="form-control @error('contact') is-invalid @enderror  form-input" name="contact"
                            value="{{ old('contact') }}" required autocomplete="contact">
                    </label>
                    @error('contact')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror



                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Email</p>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror  form-input" name="email"
                            value="{{ old('email') }}" required autocomplete="email">
                    </label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Password</p>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror form-input"
                            placeholder="Enter your password" name="password" required autocomplete="new-password">
                    </label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label class="form-label-wrapper col-6">
                        <p class="form-label">Confirm Password</p>
                        <input id="password-confirm" type="password" class="form-control form-input"
                            name="password_confirmation" required autocomplete="new-password">
                    </label>


                </div>
                <button type="submit" class="form-btn primary-default-btn transparent-btn">
                    Create Account
                </button>

            </form>

        </article>
    </main>

@endsection
