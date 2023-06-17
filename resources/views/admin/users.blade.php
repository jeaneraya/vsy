@extends('layout.design')

@section('contents')
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
        <h2 class="main-title">Users</h2>
        <div class="row stat-cards">
            <div class="col-md-6 col-xl-3">
                <article class="stat-cards-item">
                    <div class="stat-cards-icon primary">
                        <iconify-icon icon="fluent:money-16-filled"></iconify-icon>
                    </div>
                    <div class="stat-cards-info">
                        <p class="stat-cards-info__num">&#8369; 500,000.00</p>
                        <p class="stat-cards-info__title">Total Collections</p>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-xl-3">
                <article class="stat-cards-item">
                    <div class="stat-cards-icon warning">
                        <iconify-icon icon="fluent-mdl2:product-list"></iconify-icon>
                    </div>
                    <div class="stat-cards-info">
                        <p class="stat-cards-info__num">1200</p>
                        <p class="stat-cards-info__title">Total Products</p>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-xl-3">
                <article class="stat-cards-item">
                    <div class="stat-cards-icon purple">
                        <iconify-icon icon="fa:group"></iconify-icon>
                    </div>
                    <div class="stat-cards-info">
                        <p class="stat-cards-info__num">850</p>
                        <p class="stat-cards-info__title">Total Collectors</p>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-xl-3">
                <article class="stat-cards-item">
                    <div class="stat-cards-icon success">
                        <iconify-icon icon="mingcute:group-fill"></iconify-icon>
                    </div>
                    <div class="stat-cards-info">
                        <p class="stat-cards-info__num">100</p>
                        <p class="stat-cards-info__title">Total Employees</p>
                    </div>
                </article>
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
                    <table class="posts-table">
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
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ App\Models\Constants::getRolevalue()[$user->role] }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><button data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
                                            data-id='{{$user->id}}'
                                            data-role='{{ $user->role }}' data-name='{{ $user->name }}'
                                            data-mobile='{{ $user->contact }}' data-address='{{ $user->address }}'
                                            data-approval-status='{{ $user->approval_status }}'
                                            data-cashbond='{{ $user->cashbond }}'
                                            data-code='{{ $user->code }}'
                                            data-ctc-no='{{ $user->ctc_no }}'
                                            class='approval-btn'>edit</button><span
                                            class="badge-pending">{{ App\Models\Constants::getAccountStatusValue()[$user->approval_status] }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="p-relative">
                                            <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false">
                                                <iconify-icon icon="gg:more-r"></iconify-icon>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item fs-6" href="#">View</a></li>
                                                <li><a class="dropdown-item fs-6" href="#">Edit</a></li>
                                                <li><a class="dropdown-item fs-6" href="#">Trash</a></li>
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{route('put_user', ['id' => Auth::id()])}}">
                        @csrf
                        @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3 mb-3">
                                <label for="code" class="form-label">Code:<span class='span-required'>*<span></label>
                                <input type="text" class="form-control border border-secondary-subtle" id="code"
                                    name="code" required>
                            </div>
                            <div class="col-9 mb-3">
                                <label for="" class="form-label">Fullname:</label>
                                <input type="text" class="form-control border border-secondary-subtle" id="name"
                                    name="fullname" required readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Mobile #:</label>
                                <input type="text" class="form-control border border-secondary-subtle" id="mobile"
                                    name="mobile" readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Cashbond:<span
                                        class='span-required'>*<span></label>
                                <input type="text" class="form-control border border-secondary-subtle" id="cashbond"
                                    name="cashbond" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">CTC No<span
                                        class='span-required'>*<span>:</label>
                                <input type="text" class="form-control border border-secondary-subtle" id="ctcnum"
                                    name="ctcnum" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Address:</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="3" required readonly></textarea>
                            </div>

                            <div class="col-12">

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="approval_status" id="approved_radio" value="1" checked>
                                <label class="form-check-label" for="inlineRadio1">Approved</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="approval_status" id="reject_radio" value="2">
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
    <script>
        $(document).ready(function() {
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
                    $(".span-required").show();
                }
            });
        });
    </script>
@endsection
