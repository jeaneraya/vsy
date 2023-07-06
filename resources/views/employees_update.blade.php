@extends('layout.design')

@section('contents')
    <style>
        input:enabled:read-write:-webkit-any(:focus, :hover)::-webkit-calendar-picker-indicator {
            display: block !important;
        }
    </style>
    <div class="container">
        <h2 class="main-title">View Employee</h2>
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
            <form class="sign-up-form form" method="POST"
                action="{{ route('update_employee', ['id' => $employees->id]) }}">
                @csrf
                @method('PUT')
                <h3>Name: {{ $employees->fullname }} <br>
                ID: {{ $employees->id }}</h3>
                <hr>

                <div class="row">
                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Employee Name</p>
                            <input id="name" type="text"
                                class="form-control @error('name') is-invalid @enderror form-input" name="fullname"
                                value="{{ $employees->fullname }}" placeholder="Enter your name" required>
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Birthday</p>
                            <input id="birthday" type="date"
                                class="form-control @error('birthday') is-invalid @enderror  form-input" name="birthday"
                                value="{{ $employees->birthday }}" required>
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Address</p>
                            <input id="address" type="address"
                                class="form-control @error('address') is-invalid @enderror  form-input" name="address"
                                value="{{ $employees->address }}" required>
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Contact Number</p>
                            <input id="contact" type="contact"
                                class="form-control input-numbers @error('contact') is-invalid @enderror  form-input"
                                name="contact" value="{{ $employees->contact }}" required maxlength="11" minlength="11">
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Employee Code</p>
                            <input id="" type=""
                                class="form-control @error('employee_code') is-invalid @enderror  form-input"
                                name="employee_code" value="{{ $employees->employee_code }}" required>
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Date hired</p>
                            <input id="" type="date"
                                class="form-control @error('date_hired') is-invalid @enderror  form-input" name="date_hired"
                                value="{{ $employees->date_hired }}" required>
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Position</p>
                            <input id="position" type="text"
                                class="form-control @error('position') is-invalid @enderror form-input" name="position"
                                value="{{ $employees->position }}" placeholder="Enter your name" required>
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Rate Per Day</p>
                            <input id="contact" type="contact"
                                class="form-control input-numbers @error('contact') is-invalid @enderror  form-input"
                                name="rate_per_day" value="{{ $employees->rate_per_day }}" required min="0">
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Overtime Pay / hrs</p>
                            <input id="address" type="address"
                                class="form-control @error('overtime_pay') is-invalid @enderror  form-input"
                                name="overtime_pay" value="{{ $employees->overtime_pay }}" required min="0">
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Interest</p>
                            <input id="address" type="address"
                                class="form-control @error('interest') is-invalid @enderror  form-input" name="interest"
                                value="{{ $employees->interest }}" required min="0">
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">CTC Number</p>
                            <input id="ctc_number" type="text"
                                class="form-control @error('address') is-invalid @enderror  form-input" name="ctc_number"
                                value="{{ $employees->ctc_number }}">
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Place Issued</p>
                            <input id="" type="text"
                                class="form-control @error('place_issued') is-invalid @enderror  form-input"
                                name="place_issued" value="{{ $employees->place_issued }}" >
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Date Issued</p>
                            <input id="birthday" type="date"
                                class="form-control @error('birthday') is-invalid @enderror  form-input"
                                name="date_issued" value="{{ $employees->birthday }}" >
                        </label>
                    </div>
                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Status</p>
                            <select name="status" id="status" type="text"
                                class="form-control @error('role') is-invalid @enderror form-input autofocus">
                                <option value="0" disabled {{ $employees->status == 0 ? 'selected' : '' }}>
                                    -</option>
                                @foreach (App\Models\Constants::getEmployeeStatus() as $key => $status)
                                    <option value="{{ $key }}"
                                        {{ $key == $employees->status ? 'selected' : '' }}>
                                        {{ $status }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Hiring Status</p>
                            <select name="hiring_status" id="" type="text"
                                class="form-control @error('role') is-invalid @enderror form-input autofocus">
                                @foreach (App\Models\Constants::getHiringStatus() as $key => $status)
                                    <option value="{{ $key }}"
                                        {{ $key == $employees->hiring_status ? 'selected' : '' }}>
                                        {{ $status }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                </div>
                <button type="submit" class="form-btn primary-default-btn transparent-btn">
                    Update
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

                if (val == 3) { // collector
                    $('.collector-div').show()

                    // $("#code").prop('required', true);
                    // $("#ctcnum").prop('required', true);
                    // $("#cashbond").prop('required', true);

                    $("#code").prop('disabled', false);
                    $("#cashbond").prop('disabled', false);
                    $("#ctcnum").prop('disabled', false);

                    $(".span-required").show();
                }
            })
        });
    </script>
@endsection
