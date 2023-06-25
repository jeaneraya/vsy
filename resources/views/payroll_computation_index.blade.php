@extends('layout.design')

@section('contents')
    <div class="container">

        <h2 class="main-title">Payroll Computations</h2>

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



        <div class="container users-page">
            <div class="col-lg-12">
                <form class="sign-up-form form">
                    <div class="row">
                        <label class="form-label-wrapper col-12">
                            <p class="form-label">Payroll Schedule</p>
                            <select name="id" id="id" type="text"
                                class="form-control @error('id') is-invalid @enderror form-input autofocus">

                                @foreach ($results['payroll_schedules'] as $schedule)
                                    <option value="{{ $schedule->id }}"
                                        {{ $schedule->id == request()->get('id') ? 'selected' : '' }}>
                                        {{ $schedule->name }} [{{ $schedule->from }} to {{ $schedule->to }}] :
                                        {{ $schedule->description }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="form-label-wrapper col-12">
                            <div class="">
                                <button type="submit" class="btn btn-primary mb-3">See Computations</button>
                            </div>
                        </label>
                    </div>
                </form>

                <form class="sign-up-form form mt-2" method="GET" action="{{ route('view_add_payroll_computations',[
                    'schedule_id' => request()->get('id')
                ]) }}">
                    <div class="sign-up-form form mt-2">
                        <div class="row">
                            <label class="form-label-wrapper col-12">
                                <p class="form-label">Employee</p>
                                <select id="id" type="text"
                                    class="form-control @error('id') is-invalid @enderror form-input autofocus" name="employee_id">
                                    <option disabled selected>Select Employee</option>
                                    @foreach ($results['withOutComputations'] as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == '' ? 'selected' : '' }}>
                                            {{ $user->fullname }} - {{ $user->position }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="form-label-wrapper col-12">
                                <div class="">
                                    <button type="submit" class="btn btn-primary mb-3">Add Computations</button>
                                </div>
                            </label>
                        </div>
                    </div>
                </form>




                <div class="users-table table-wrapper">
                    <table class="posts-table" id="example">
                        <thead style="padding-left:1em">
                            <tr class="users-table-info">
                                <th>ID</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Gross Pay</th>
                                <th>Deductions</th>
                                <th>Net Pay</th>
                                <th>Claimed</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results['withComputations'] as $withComputations)
                                <td>{{ $withComputations->employee_id }}</td>
                                <td>{{ $withComputations->employee_code }}</td>
                                <td>{{ $withComputations->employee_full_name }}</td>
                                <td>{{ $withComputations->computations_gross }}</td>
                                <td>{{ $withComputations->computations_total_deductions }}</td>
                                <td>{{ $withComputations->computations_net_pay }}</td>
                                <td>{{ $withComputations->computations_is_claimed }}</td>
                                <td class="text-center">
                                    <span class="p-relative">
                                        <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false">
                                            <iconify-icon icon="gg:more-r"></iconify-icon>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item fs-6">View/Update</a>
                                            </li>
                                            <li>
                                                <form method="POST">
                                                    {{-- action="{{ route('put_user_archive', ['userId' => $withComputations->id]) }}">
                                                    @csrf @method('PUT') --}}
                                                    <button type="submit" class="dropdown-item fs-6">Mark as
                                                        Claimed</button>
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
        });
    </script>
@endsection
