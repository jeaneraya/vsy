@extends('layout.design')

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



    <div class="container">
        <h2 class="main-title">ID: {{ $user->id }} / {{ $user->name }} / Role: {{ $user->role }}</h2>
        <div class="col-lg-12">
            <div class="row">
                <form class="needs-validation" novalidate>
                    <div class="form-row row">
                        <div class="col-6 mb-3">
                            <label for="validationCustom01">Name</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder=""
                                value={{ $user->name }} required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="validationCustom01">Email</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder=""
                                value={{ $user->email }} required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="validationCustom01">Birthday</label>
                            <input type="date" class="form-control" id="validationCustom01" placeholder="" required
                                value={{ $user->birthday }}>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="validationCustom01">Address</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="" required
                                value={{ $user->address }}>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>


                        <div class="col-6 mb-3">
                            <label for="validationCustom01">Mobile No.</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="" required maxlength="11" minlength="11"
                                value={{ $user->contact }}>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Role</label>
                                <select class="form-control" id="exampleFormControlSelect1" required>
                                    <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>SuperAdmin</option>
                                    <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Admin</option>
                                    <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>Collector</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Account Approval Status</label>
                                <select class="form-control" id="exampleFormControlSelect1" required>
                                    <option value="0" {{ $user->approval_status == 0 ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="1" {{ $user->approval_status == 1 ? 'selected' : '' }}>Approved
                                    </option>
                                    <option value="2" {{ $user->approval_status == 2 ? 'selected' : '' }}>Rejected
                                    </option>
                                    <option value="3" {{ $user->approval_status == 3 ? 'selected' : '' }}>Archived
                                    </option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>

                        @if ($user->isCollector())
                            <h2 class="main-title">Collector</h2>

                            <div class="col-6 mb-3">
                                <label for="validationCustom01">Collector Code</label>
                                <input type="text" class="form-control input-numbers" id="validationCustom01"
                                    placeholder="" required
                                    value={{ is_null($user->collectors) === false ? $user->collectors->code : null }}>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="validationCustom01">Cashbond</label>
                                <input type="text" class="form-control input-numbers" id="validationCustom01"
                                    placeholder=""
                                    value={{ is_null($user->collectors) === false ? $user->collectors->cashbond : null }}
                                    required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="validationCustom01">CTC no.</label>
                                <input type="text" class="form-control input-numbers" id="validationCustom01"
                                    placeholder="" required
                                    value={{ is_null($user->collectors) === false ? $user->collectors->ctc_no : null }}>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Collector Status</label>
                                    <select class="form-control" id="exampleFormControlSelect1" required>
                                        <option value="1" {{ $user->approval_status == 1 ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="2" {{ $user->approval_status == 2 ? 'selected' : '' }}>Approved
                                        </option>
                                        <option value="3" {{ $user->approval_status == 3 ? 'selected' : '' }}>Rejected
                                        </option>
                                        <option value="4" {{ $user->approval_status == 4 ? 'selected' : '' }}>Archived
                                        </option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                    <button class="btn btn-primary" type="submit">Submit form</button>
                </form>
            </div>
        </div>
    </div>




@endsection

@section('scripts')
    <script src="{{ asset('assets/tools/DataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/tools/DataTables/datatables.min.js') }}"></script>

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


        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
@endsection
