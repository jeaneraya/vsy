@extends('layout.design')

@section('contents')
    <div class="container">
        <h2 class="main-title">Users</h2>
        @if (Session::has('success'))
            {{ Session::get('success') }}
        @elseif(Session::has('warning'))
            {{ Session::get('warning') }}
            <!-- here to 'withWarning()' -->
        @endif
        <div class="row stat-cards">
            <form class="sign-up-form form" method="POST" action="{{ route('post_user_create') }}">
                @csrf
                <label class="form-label-wrapper">
                    <p class="form-label">Role</p>
                    {{-- <input id="role" type="text" class="form-control @error('role') is-invalid @enderror form-input"
                        role="role" value="{{ old('role') }}" placeholder="Enter your role" required
                        autocomplete="role" autofocus> --}}

                    <select name="role" id="role" type="text"
                        class="form-control @error('role') is-invalid @enderror form-input autofocus">
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

                <label class="form-label-wrapper">
                    <p class="form-label">Name</p>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror form-input"
                        name="name" value="{{ old('name') }}" placeholder="Enter your name" required
                        autocomplete="name">
                </label>
                @error('name')
                    {{-- <span class="invalid-feedback" role="alert"> --}}
                    <strong>{{ $message }}</strong>
                    {{-- </span> --}}
                @enderror

                <label class="form-label-wrapper">
                    <p class="form-label">Birthday</p>
                    <input id="birthday" type="birthday"
                        class="form-control @error('birthday') is-invalid @enderror  form-input" name="birthday"
                        value="{{ old('birthday') }}" required autocomplete="birthday">
                </label>
                @error('birthday')
                    {{-- <span class="invalid-feedback" role="alert"> --}}
                    <strong>{{ $message }}</strong>
                    {{-- </span> --}}
                @enderror

                <label class="form-label-wrapper">
                    <p class="form-label">Address</p>
                    <input id="address" type="address"
                        class="form-control @error('address') is-invalid @enderror  form-input" name="address"
                        value="{{ old('address') }}" required autocomplete="address">
                </label>
                @error('address')
                    {{-- <span class="invalid-feedback" role="alert"> --}}
                    <strong>{{ $message }}</strong>
                    {{-- </span> --}}
                @enderror

                <label class="form-label-wrapper">
                    <p class="form-label">Contact Number</p>
                    <input id="contact" type="contact"
                        class="form-control @error('contact') is-invalid @enderror  form-input" name="contact"
                        value="{{ old('contact') }}" required autocomplete="contact">
                </label>
                @error('contact')
                    {{-- <span class="invalid-feedback" role="alert"> --}}
                    <strong>{{ $message }}</strong>
                    {{-- </span> --}}
                @enderror



                <label class="form-label-wrapper">
                    <p class="form-label">Email</p>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror  form-input" name="email"
                        value="{{ old('email') }}" required autocomplete="email">
                </label>
                @error('email')
                    {{-- <span class="invalid-feedback" role="alert"> --}}
                    <strong>{{ $message }}</strong>
                    {{-- </span> --}}
                @enderror

                <label class="form-label-wrapper">
                    <p class="form-label">Password</p>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror form-input"
                        placeholder="Enter your password" name="password" required autocomplete="new-password">
                </label>
                @error('password')
                    {{-- <span class="invalid-feedback" role="alert"> --}}
                    <strong>{{ $message }}</strong>
                    {{-- </span> --}}
                @enderror

                <label class="form-label-wrapper">
                    <p class="form-label">Confirm Password</p>
                    <input id="password-confirm" type="password" class="form-control form-input"
                        name="password_confirmation" required autocomplete="new-password">
                </label>


                <button type="submit" class="form-btn primary-default-btn transparent-btn">
                    Create Account
                </button>

            </form>
        </div>
    </div>
@endsection
