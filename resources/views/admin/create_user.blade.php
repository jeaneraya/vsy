@extends('layout.design')

@section('contents')
    <style>
        input:enabled:read-write:-webkit-any(:focus, :hover)::-webkit-calendar-picker-indicator {
            display: block !important;
        }
    </style>
    <div class="container">
        <h2 class="main-title">Create Users</h2>
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

        <div class="row stat-cards">
            <form class="sign-up-form form" method="POST" action="{{ route('post_user_create') }}">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Role</p>
                            <select name="role" id="role" type="text"
                                class="form-control @error('role') is-invalid @enderror form-input autofocus">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $role->id == old('role') ? 'selected' : '' }}>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Name</p>
                            <input id="name" type="text"
                                class="form-control @error('name') is-invalid @enderror form-input" name="name"
                                value="{{ old('name') }}" placeholder="Enter your name" required autocomplete="name">
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Birthday</p>
                            <input id="birthday" type="date"
                                class="form-control @error('birthday') is-invalid @enderror  form-input" name="birthday"
                                value="{{ old('birthday') }}" required autocomplete="birthday">
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Address</p>
                            <input id="address" type="address"
                                class="form-control @error('address') is-invalid @enderror  form-input" name="address"
                                value="{{ old('address') }}" required autocomplete="address">
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Contact Number</p>
                            <input id="contact" type="contact"
                                class="form-control input-numbers @error('contact') is-invalid @enderror  form-input"
                                name="contact" value="{{ old('contact') }}" required autocomplete="contact" maxlength="11"
                                minlength="11">
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Email</p>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror  form-input" name="email"
                                value="{{ old('email') }}" required autocomplete="email">
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Password</p>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror form-input"
                                placeholder="Enter your password" name="password" required autocomplete="new-password">
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Confirm Password</p>
                            <input id="password-confirm" type="password" class="form-control form-input"
                                name="password_confirmation" required autocomplete="new-password">
                        </label>
                    </div>

                </div>
                <div class="collector-div row">
                    <h2 class="main-title">Collector Details</h2>

                    <div class="col-6">
                        <label for="validationCustom01">Collector Code</label>
                        <input type="text"
                            class="form-control input-numbers  @error('code') is-invalid @enderror  form-input"
                            id="code" name="code" placeholder="" value="{{ old('code') }}">
                    </div>
                    <div class="col-6">
                        <label for="validationCustom01">Cashbond</label>
                        <input type="text"
                            class="form-control input-numbers  @error('cashbond') is-invalid @enderror form-input"
                            id="cashbond" name="cashbond" placeholder="" value="{{ old('cashbond') }}">
                    </div>

                    <div class="col-6">
                        <label for="validationCustom01">CTC no.</label>
                        <input type="text"
                            class="form-control input-numbers  @error('ctcnum') is-invalid @enderror  form-input"
                            id="ctcnum" name="ctcnum" placeholder="" value="{{ old('ctcnum') }}">
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Collector Status</label>
                            <select class="form-control  @error('collector_status') is-invalid @enderror  form-input"
                                id="collector_status" name="collector_status">
                                <option value="1" {{ old('ctcnum') == 1 ? 'selected' : '' }}>Pending
                                </option>
                                <option value="2" {{ old('ctcnum') == 2 ? 'selected' : '' }}>Approved
                                </option>
                                <option value="3" {{ old('ctcnum') == 3 ? 'selected' : '' }}>Rejected
                                </option>
                                <option value="4" {{ old('ctcnum') == 4 ? 'selected' : '' }}>Archived
                                </option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="form-btn primary-default-btn transparent-btn">
                    Create Account
                </button>

            </form>
        </div>
    </div>
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

            // initialize
            $('.collector-div').hide();

            // end initialize

            $('#role').change(function() {
                $("#code").prop('required', false);
                $("#ctcnum").prop('required', false);
                $("#code").prop('required', false);

                $("#code").prop('disabled', true);
                $("#cashbond").prop('disabled', true);
                $("#ctcnum").prop('disabled', true);

                $('.collector-div').hide();

                let val = $(this).val();

                if (val == 4) { // area manager
                    $('.collector-div').show()

                    // $("#code").prop('required', true);
                    // $("#ctcnum").prop('required', true);
                    // $("#cashbond").prop('required', true);

                    $("#code").prop('disabled', false);
                    // $("#cashbond").prop('disabled', false);
                    // $("#ctcnum").prop('disabled', false);

                    $(".span-required").show();
                }
            })
        });
    </script>
@endsection
