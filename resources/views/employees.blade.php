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
                <h2 class="main-title">Employees</h2>
            </div>
            <div class="col-2"><a href={{ route('create_post_employees') }} class="btn btn-primary">Add Employee</a></div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="users-table table-wrapper">
                    <table class="posts-table" id="employees-table">
                        <thead style="padding-left:1em">
                            <tr class="users-table-info">
                                <th>Employee ID</th>
                                <th>Code</th>
                                <th>Employee's Name</th>
                                <th>Address</th>
                                <th>Position</th>
                                <th>Rate</th>
                                <th>Active</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $key => $employee)
                                <tr>
                                    <td>{{ $employee->id }}</td>
                                    <td>{{ $employee->employee_code }}</td>
                                    <td>{{ $employee->fullname }}</td>
                                    <td>{{ $employee->address }}</td>
                                    <td>{{ $employee->position }}</td>
                                    <td>{{ $employee->rate_per_day }}</td>
                                    <td>{{ App\Models\Constants::getHiringStatus()[$employee->hiring_status] }}</td>
                                    <td class="text-center">
                                        <span class="p-relative">
                                            <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false">
                                                <iconify-icon icon="gg:more-r"></iconify-icon>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item fs-6"
                                                        href="{{ route('show_employee', ['id' => $employee->id]) }}">View/Update</a>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('resign_employee') }}">
                                                        @csrf @method('PUT')
                                                        <input hidden name="id" value="{{ $employee->id }}">
                                                        <button class="dropdown-item fs-6" type="submit">Resign</button>
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
    <script src="{{ asset('assets/tools/DataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/tools/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            // DataTable
            var table = $('#employees-table').DataTable({
                // dom: 'lfrtip',
                initComplete: function() {
                    // Apply the search
                    this.api()
                        .columns()
                        .every(function() {
                            var that = this;

                            $('input', this.footer()).on('keyup change clear', function() {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });
                },
                dom: 'lBfrtip',
                responsive: true,
                scrollX: true,
                // dom: 'B',
                // dom: 'Pfrtip',
                // colReorder: true,
                // buttons: [
                //     'excel',
                //     'print',
                // ],
                // select: true,
                // "ordering": false,
                // paging: true,
                // lengthMenu: [
                //     [10, 25, 50, -1],
                //     [10, 25, 50, 'All'],
                // ],
                lengthChange: false,

            });
        });
    </script>
@endsection
