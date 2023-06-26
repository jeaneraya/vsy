@extends('layout.design')

@section('contents')
    <div class="container">
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
            @php
                $show = '';

                if ($errors->any()) {
                    $show = 'show';
                }
            @endphp

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

        <div class="row">
            <div class="col-4">
                <h2 class="main-title">Payroll</h2>
            </div>
        </div>

        <div class="container users-page">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <div class="collapse show mt-2" id="collapseExample">
                            <form class="sign-up-form form" method="POST"
                                action="{{ route('put_payroll_schedule', ['schedule_id' => $results->id]) }}">
                                @csrf @method('PUT')
                                <h2 class="main-title">Update Payroll Schedule</h2>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label-wrapper">
                                            <p class="form-label">Name</p>
                                            <input id="name" type="text"
                                                class="form-control input_name @error('name') is-invalid @enderror form-input"
                                                name="name" value="{{ $results->name }}" placeholder="Enter your name"
                                                required autocomplete="name" maxlength="50" autofocus>
                                        </label>
                                    </div>


                                    <div class="col-6">
                                        <label class="form-label-wrapper">
                                            <p class="form-label">Period Start Date</p>
                                            <input id="" type="date"
                                                class="form-control @error('period_start') is-invalid @enderror  form-input"
                                                value="{{ $results->from }}" name="period_start">
                                        </label>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label-wrapper">
                                            <p class="form-label">Period End Date</p>
                                            <input id="" type="date"
                                                class="form-control @error('period_end') is-invalid @enderror  form-input"
                                                name="period_end" value="{{ $results->to }}" required>
                                        </label>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-wrapper">
                                            <p class="form-label">Description</p>
                                            <input id="" type="text"
                                                class="form-control @error('description') is-invalid @enderror form-input"
                                                name="description" value="{{ $results->description }}" required
                                                placeholder="ex. 2023 March 1-15">
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="form-btn primary-default-btn transparent-btn">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endsection

    @section('scripts')
        <script src="{{ asset('assets/tools/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/tools/DataTables/jquery.dataTables.min.js') }}"></script>

        <script>
            $(document).ready(function() {

                // DataTable
                var table = $('#example').DataTable({
                    initComplete: function() {},
                    dom: 'lBfrtip',
                    responsive: true,
                    scrollX: true,
                    lengthChange: false,
                });

                let hasError = {{ json_encode($errors->any()) }}

                if (hasError) {
                    $('#collapseExample').collapse(
                        'show'
                    )
                }
            });
        </script>
    @endsection
