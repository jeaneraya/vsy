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
                <h2 class="main-title">Notifications</h2>
            </div>
            <div class="col-2"> <a type="button" class="btn btn-primary" href="{{ route('view_add_reminder') }}">Add Reminder</a></div>
            <div class="col-2"> <a type="button" class="btn btn-primary" href="{{ route('view_reminders_log') }}">Automated Logs</a></div>
            <div class="col-2"> <form action={{route("update_all_read_status")}} method="POST">
                @csrf @method('PUT')
                <input name='is_read' value="1" hidden>
                <button type="submit" class="btn btn-primary" href="{{ route('view_reminders_log') }}">Mark All as Read </button>
            </form>
            </div>
        </div>

        @php
            $isActiveBadge = [
                1 => 'Active',
                2 => 'Inactive'
            ];
            $counter = $results->count();
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
                                <th>Sent on</th>
                                <th>Message</th>
                                <th>Read</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)

                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>{{ $result->description }}</td>
                                    <td>{{ $result->sent_datetime }}</td>
                                    <td>{{ $result->message }}</td>
                                    <td>{{ $result->is_read == 1 ? 'YES' : 'NO' }}</td>
                                    <td><form method="POST" action={{route('update_is_read')}}>
                                        @csrf @method('PUT')
                                            <input hidden value="{{$result->is_read == 1 ? 0 : 1}}" name="is_read">
                                            <input hidden value="{{$result->id}}" name="log_id">
                                            <button type="submit" class='btn btn-primary'> {{ $result->is_read == 1 ? 'Unread' : 'Mark as Read' }} </button>
                                        </form>
                                       </td>
                                </tr>
                                @php
                            $counter--;
                            @endphp
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
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>
@endsection
