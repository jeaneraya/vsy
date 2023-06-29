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
                <h2 class="main-title">Reminders</h2>
            </div>
            <div class="col-2"> <a type="button" class="btn btn-primary" href="{{ route('view_add_reminder') }}">Add Reminder</a></div>
        </div>

        @php
            $isActiveBadge = [
                1 => 'Active',
                2 => 'Inactive'
            ];
        @endphp
    <div class="container users-page">
        <div class="col-lg-12">
            <div class="row">
                <div class="users-table table-wrapper">
                    <table class="posts-table" id="example">
                        <thead style="padding-left:1em">
                            <tr class="users-table-info">
                                <th>ID</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Schedule</th>
                                <th>Status</th>
                                <th>Active</th>
                                <th>Frequency</th>
                                <th>Created by</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reminders as $reminder)
                                <tr>
                                    <td>{{ $reminder->id }}</td>
                                    <td>{{ App\Models\Constants::getRemindersTypes()[$reminder->type] }}</td>
                                    <td>{{ $reminder->description }}</td>
                                    <td>{{ $reminder->schedule }}</td>
                                    <td>{{ App\Models\Constants::getRemindersStatus()[$reminder->status]}}</td>
                                    <td>{{ App\Models\Constants::reminderIsActiveStatus()[$reminder->is_active] }}</td>
                                    <td>{{ App\Models\Constants::getReminderFrequencies()[$reminder->frequency] }}</td>
                                    <td>{{ $reminder->created_by }}</td>

                                    </td>
                                    <td class="text-center">
                                        <span class="p-relative">
                                            <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false">
                                                <iconify-icon icon="gg:more-r"></iconify-icon>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item fs-6"
                                                        href="{{ route('show_reminder', ['id' => $reminder->id]) }}">View/Update</a>
                                                </li>
                                                <li>
                                                    <form method="POST"
                                                        action="{{ route('put_user_archive', ['userId' => $reminder->id]) }}">
                                                        @csrf @method('PUT')
                                                        <button type="submit" class="dropdown-item fs-6">Cancel</button>
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
                order: [[0, 'desc']],
            });
        });
    </script>
@endsection
