@extends('layout.design')

@section('contents')
    <div class="container">

        <h2 class="main-title">Payroll</h2>

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
        <div class="container users-page">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <div class="col-lg-3">
                            <button class="btn btn-primary  dropdown-toggle" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Add Schedule
                            </button>
                        </div>

                        <div class="collapse show mt-2" id="collapseExample">
                            <form class="sign-up-form form" method="POST" action="{{ route('store_payroll_schedule') }}">
                                @csrf
                                <h2 class="main-title">Add Payroll Schedule</h2>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label-wrapper">
                                            <p class="form-label">Period Start Date</p>
                                            <input id="" type="date"
                                                class="form-control @error('period_start') is-invalid @enderror  form-input"
                                                value="{{ old('period_start') }}" required name="period_start">
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
                                    <th>From</th>
                                    {{-- <th>Message</th> --}}
                                    <th>To</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payrollSchedule as $result)
                                    <tr>
                                        <td>{{ $result->id }}</td>
                                        <td>{{ $result->name }}</td>
                                        <td>{{ $result->description }}</td>
                                        <td>{{ $result->from }}</td>
                                        <td>{{ $result->to }}</td>
                                        {{-- <td>{{ $result->template_id }}</td> --}}
                                        {{-- <td>{{ App\Models\Constants::getRemindersStatus()[$result->status]}}</td> --}}
                                        <td>{{ $result->status }}</td>
                                        </td>
                                        <td class="text-center">
                                            <span class="p-relative">
                                                <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false">
                                                    <iconify-icon icon="gg:more-r"></iconify-icon>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item fs-6"
                                                            href="{{ route('show_reminder', ['id' => $result->id]) }}">View/Update</a>
                                                    </li>
                                                    <li>
                                                        <form method="POST"
                                                            action="{{ route('put_user_archive', ['userId' => $result->id]) }}">
                                                            @csrf @method('PUT')
                                                            <button type="submit"
                                                                class="dropdown-item fs-6">Cancel</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
