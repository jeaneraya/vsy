@extends('layout.design')

@section('contents')


    <div class="container">

        <h2 class="main-title">Users</h2>

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
        <h2 class="main-title">Users</h2>

        <div class="row stat-cards">

            <div class="col-md-6 col-xl-3">
                <a href={{ route('get_user_index', ['status' => '0']) }}>
                    <article class="stat-cards-item">
                        <div class="stat-cards-icon purple">
                            <iconify-icon icon="fa:group"></iconify-icon>
                        </div>
                        <div class="stat-cards-info">
                            <p class="stat-cards-info__num">{{ $allUsers->where('approval_status', '0')->count() }}</p>
                            <p class="stat-cards-info__title">Pending For Approval</p>
                        </div>
                    </article>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a href={{ route('get_user_index', ['status' => '1']) }}>
                    <article class="stat-cards-item">
                        <div class="stat-cards-icon purple">
                            <iconify-icon icon="fa:group"></iconify-icon>
                        </div>
                        <div class="stat-cards-info">
                            <p class="stat-cards-info__num">{{ $allUsers->where('approval_status', '1')->count() }}</p>
                            <p class="stat-cards-info__title">Approved</p>
                        </div>
                    </article>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a href={{ route('get_user_index', ['status' => '2']) }}>
                    <article class="stat-cards-item">
                        <div class="stat-cards-icon purple">
                            <iconify-icon icon="fa:group"></iconify-icon>
                        </div>
                        <div class="stat-cards-info">
                            <p class="stat-cards-info__num">{{ $allUsers->where('approval_status', '2')->count() }}</p>
                            <p class="stat-cards-info__title">Rejected</p>
                        </div>
                    </article>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a href={{ route('get_user_index', ['status' => '3']) }}>
                    <article class="stat-cards-item">
                        <div class="stat-cards-icon purple">
                            <iconify-icon icon="fa:group"></iconify-icon>
                        </div>
                        <div class="stat-cards-info">
                            <p class="stat-cards-info__num">{{ $allUsers->where('approval_status', '3')->count() }}</p>
                            <p class="stat-cards-info__title">Archived</p>
                        </div>
                    </article>
                </a>
            </div>

            <div class="col-md-6 col-xl-3">
                <a href={{ route('get_user_index') }}>
                    <article class="stat-cards-item">
                        <div class="stat-cards-icon success">
                            <iconify-icon icon="mingcute:group-fill"></iconify-icon>
                        </div>
                        <div class="stat-cards-info">
                            <p class="stat-cards-info__num">{{ $allUsers->count() }}</p>
                            <p class="stat-cards-info__title">Total Users</p>
                        </div>
                    </article>
                </a>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-3">
                        <a type="button" class="btn btn-primary" href="{{ route('get_user_create') }}">Add</a>
                    </div>
                </div>
                <div class="users-table table-wrapper">
                    <table class="posts-table" id="example">
                        <thead style="padding-left:1em">
                            <tr class="users-table-info">
                                <th>ID</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                        </thead>

                        @php
                            $statusBadgeLib = [
                                0 => '<span class="badge-pending">Pending</span>',
                                1 => '<span class="badge-success">Approved</span>',
                                2 => '<span class="badge-trashed">Rejected</span>',
                                3 => '<span class="badge-active">Archived</span>',
                            ];
                        @endphp
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ App\Models\Constants::getRolevalue()[$user->role] }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{!! $statusBadgeLib[$user->approval_status] !!}
                                    </td>
                                    <td class="text-center">
                                        <span class="p-relative">
                                            <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false">
                                                <iconify-icon icon="gg:more-r"></iconify-icon>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item fs-6"
                                                        href="{{ route('get_user', ['userId' => $user->id]) }}">Edit
                                                        Profile</a>
                                                </li>
                                                <li>
                                                    <form method="POST"
                                                        action="{{ route('put_user_archive', ['userId' => $user->id]) }}">
                                                        @csrf @method('PUT')
                                                        <button type="submit" class="dropdown-item fs-6">Trash</button>
                                                    </form>
                                                </li>
                                                <li>

                                                    <a role="button" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter" data-id='{{ $user->id }}'
                                                        data-role='{{ $user->role }}' data-name='{{ $user->name }}'
                                                        data-mobile='{{ $user->contact }}'
                                                        data-address='{{ $user->address }}'
                                                        data-approval-status='{{ $user->approval_status }}'
                                                        data-cashbond='{{ $user->cashbond }}'
                                                        data-code='{{ $user->code }}' data-ctc-no='{{ $user->ctc_no }}'
                                                        class='approval-btn dropdown-item fs-6'>Approval</a>
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

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Approval</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('put_user', ['id' => Auth::id()]) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-3 mb-3">
                                    <label for="code" class="form-label">Code:<span
                                            class='span-required'>*<span></label>
                                    <input type="text" class="form-control border border-secondary-subtle"
                                        id="code" name="code" required>
                                </div>
                                <div class="col-9 mb-3">
                                    <label for="" class="form-label">Fullname:</label>
                                    <input type="text" class="form-control border border-secondary-subtle"
                                        id="name" name="fullname" required readonly>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="" class="form-label">Mobile #:</label>
                                    <input type="text" class="form-control border border-secondary-subtle"
                                        id="mobile" name="mobile" readonly>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="" class="form-label">Cashbond:<span
                                            class='span-required'>*<span></label>
                                    <input type="text" class="form-control border border-secondary-subtle"
                                        id="cashbond" name="cashbond" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="" class="form-label">CTC No<span
                                            class='span-required'>*<span>:</label>
                                    <input type="text" class="form-control border border-secondary-subtle"
                                        id="ctcnum" name="ctcnum" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="" class="form-label">Address:</label>
                                    <textarea class="form-control" name="address" id="address" cols="30" rows="3" required readonly></textarea>
                                </div>

                                <div class="col-12">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="approval_status"
                                            id="approved_radio" value="1" checked>
                                        <label class="form-check-label" for="inlineRadio1">Approved</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="approval_status"
                                            id="reject_radio" value="2">
                                        <label class="form-check-label" for="inlineRadio2">Reject</label>
                                    </div>
                                </div>
                                <input type="hidden" id="user_id" name="id">
                                <input type="hidden" id="role" name="role">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
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
            var table = $('#example').DataTable({
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

            $(".approval-btn").click(function() {

                // reset modal
                $("#code").val('');
                $("#cashbond").val('');
                $("#ctcnum").val('');
                $("#name").val('');
                $("#mobile").val('');
                $("#address").val('');
                $("#approved_radio").prop('checked', true);
                $(".span-required").hide();

                $("#code").prop('required', false);
                $("#cashbond").prop('required', false);
                $("#ctcnum").prop('required', false);

                $("#code").prop('disabled', true);
                $("#cashbond").prop('disabled', true);
                $("#ctcnum").prop('disabled', true);
                // end reset modal

                $("#user_id").val($(this).attr('data-id'));
                $("#name").val($(this).attr('data-name'));
                $("#mobile").val($(this).attr('data-mobile'));
                $("#address").val($(this).attr('data-address'));
                $("#role").val($(this).attr('data-role'));
                $("#code").val($(this).attr('data-code'));
                $("#cashbond").val($(this).attr('data-cashbond'));
                $("#ctcnum").val($(this).attr('data-ctc-no'));

                // collector
                if ($(this).attr('data-role') == 3) {
                    $("#code").prop('required', true);
                    $("#ctcnum").prop('required', true);
                    $("#code").prop('required', true);

                    $("#code").prop('disabled', false);
                    $("#cashbond").prop('disabled', false);
                    $("#ctcnum").prop('disabled', false);

                    $(".span-required").show();
                }
            });
        });
    </script>
@endsection
