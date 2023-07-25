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
            <div class="col-2"> <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Add Schedule
                </button></div>
        </div>

        <div class="container users-page">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <div class="collapse mt-2" id="collapseExample">
                            <form class="sign-up-form form" method="POST" action="{{ route('store_payroll_schedule') }}">
                                @csrf
                                <h2 class="main-title">Add Payroll Schedule</h2>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label-wrapper">
                                            <p class="form-label">Name</p>
                                            <input id="name" type="text"
                                                class="form-control input_name @error('name') is-invalid @enderror form-input"
                                                name="name" value="{{ old('name') }}" placeholder="Enter your name"
                                                required autocomplete="name" maxlength="50" autofocus>
                                        </label>
                                    </div>


                                    <div class="col-6">
                                        <label class="form-label-wrapper">
                                            <p class="form-label">Period Start Date</p>
                                            <input id="" type="date"
                                                class="form-control @error('period_start') is-invalid @enderror  form-input"
                                                value="{{ old('period_start') }}" name="period_start">
                                        </label>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label-wrapper">
                                            <p class="form-label">Period End Date</p>
                                            <input id="" type="date"
                                                class="form-control @error('period_end') is-invalid @enderror  form-input"
                                                name="period_end" value="{{ old('period_end') }}" required>
                                        </label>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-wrapper">
                                            <p class="form-label">Description</p>
                                            <input id="" type="text"
                                                class="form-control @error('description') is-invalid @enderror form-input"
                                                name="description" value="{{ old('description') }}" required
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


                    <div class="users-table table-wrapper">
                        <table class="posts-table" id="example">
                            <thead style="padding-left:1em">
                                <tr class="users-table-info">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>From (m-d-y)</th>
                                    <th>To (m-d-y)</th>
                                    <th>Total Net</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @php
                            $scheduleStatus = [
                                0 => '-',
                                1 => 'Active',
                                2 => 'Archived',
                        ];
                            @endphp
                            <tbody>
                                @foreach ($payrollSchedule as $result)
                                    <tr>
                                        <td>{{ $result->id }}</td>
                                        <td>{{ $result->name }}</td>
                                        <td>{{ $result->description }}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $result->from)->format('m-d-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $result->to)->format('m-d-Y') }}</td>
                                        <td>₱ {{ number_format((float)$result->total_net, 2, '.', '') }} </td>
                                        <td>{{ $scheduleStatus[$result->status] }}</td>
                                        </td>
                                        <td class="text-center">
                                            <span class="p-relative">
                                                <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false">
                                                    <iconify-icon icon="gg:more-r"></iconify-icon>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item fs-6"
                                                            href="{{ route('show_payroll_schedule', ['schedule_id' => $result->id]) }}">View/Update<a>
                                                    </li>
                                                    <li><a class="dropdown-item fs-6"
                                                            href="{{ route('payroll_computations', ['id' => $result->id]) }}">Computations<a>
                                                    </li>
                                                    {{-- <li>
                                                        <form method="POST"
                                                            action="{{ route('put_user_archive', ['userId' => $result->id]) }}">
                                                            @csrf @method('PUT')
                                                            <button type="submit"
                                                                class="dropdown-item fs-6">Cancel</button>
                                                        </form>
                                                    </li> --}}
                                                </ul>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <script>
                            $(document).ready(function() {
                                $('#example').DataTable({
                                    initComplete: function() {},
                                    dom: 'lBfrtip',
                                    order: [[0, 'desc']],
                                });
                                let hasError = {{ json_encode($errors->any()) }}

                                if (hasError) {
                                    $('#collapseExample').collapse(
                                        'show'
                                    )
                                }
                                });
                        </script>
                    </div>
                </div>
            </div>
        </div>


    @endsection
