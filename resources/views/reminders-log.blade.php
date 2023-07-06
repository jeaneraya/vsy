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
                <h2 class="main-title">Reminders Log</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="users-table table-wrapper">
                    <table class="posts-table" id="employees-table">
                        <thead style="padding-left:1em">
                            <tr class="users-table-info">
                                <th>ID</th>
                                <th>Sent on</th>
                                <th>Sent to</th>
                                <th>Description</th>
                                <th>Sent via</th>
                                <th>Schedule</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $key => $result)
                                <tr>
                                    <td>{{ $result->id }}</td>
                                    <td>{{ $result->sent_datetime }}</td>
                                    <td>{{ $result->sent_to == 0 ? 'System' : $result->sent_to_name }}</td>
                                    <td>{{ $result->description }}</td>
                                    <td>{{ $result->sent_via == 1 ? 'SMS' : 'Notification' }}</td>
                                    <td>{{ $result->schedule }}</td>
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
                initComplete: function() {},
                dom: 'lBfrtip',
                responsive: true,
                scrollX: true,
                lengthChange: false,
                order: [['0', 'desc']],
                pageLength: 20
            });
        });
    </script>
@endsection
