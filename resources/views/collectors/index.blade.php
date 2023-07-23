@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title">Collectors</h2></div>
            <div class="col-2">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcollector">
                Add Collector
              </button>
            </div>
            <div class="col-3">
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Select Items to Display
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('collectors') }}">Show Active</a></li>
                  <li><a class="dropdown-item" href="{{ route('collectors-inactive') }}">Show In-active</a></li>
                  <li><a class="dropdown-item" href="{{ route('collectors-all') }}">Show All</a></li>
                </ul>
              </div>
            </div>
        </div>

        @php
        $statusBadgeLib = [
            0 => '<span class="badge-pending">Inactive</span>',
            1 => '<span class="badge-success">Active</span>'
        ];

        $role = [
            3 => "Collector",
            4 => "Manager"
          ];
        @endphp

        <div class="row container">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="table table-striped posts-table" id="collectors-table">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Code</th>
                    <th>Role</th>
                    <th>Collector's Name</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($collectors as $key => $collector)
                      <tr class="align-middle">
                          <td>{{ $key + 1 }}</td>
                          <td class="collector_code">{{ $collector->code }}</td>
                          <td>{{ ($collector->role == 4) ? "Area Manager" : "Collector" }}</td>
                          <td class="collector_name">{{ $collector->name }}</td>
                          <td class="collector_contact">{{ $collector->contact }}</td>
                          <td class="collector_address">{{ $collector->address }}</td>
                          <td>{!! $statusBadgeLib[$collector->status] !!}</td>
                          <td class="text-center">
                              <span class="p-relative">
                                  <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                                  <ul class="dropdown-menu">
                                      <li><a class="dropdown-item fs-6" href="{{ route('collectors.show', ['id' => $collector->user_id, 'name' => $collector->name]) }}">View Batch</a></li>
                                      <li>{!! ($collector->role == 4) ? '<a class="dropdown-item fs-6" href="' . route('stock-delivery', ['user_id' => $collector->user_id, 'name' => $collector->name]) . '">View SD & PS</a>' : '' !!}</li>
                                      <li><a class="dropdown-item fs-6 edit-collector" data-bs-toggle="modal" data-bs-target="#editcollector" data-id="{{ $collector->id }}" data-role="{{ $collector->role }}" data-birthday="{{ $collector->birthday }}" data-status="{{ $collector->status }}" data-cashbond="{{ $collector->cashbond }}" data-ctc-no="{{ $collector->ctc_no }}">Edit</a></li>
                                      <li><a class="dropdown-item fs-6" href="{{ route('delete-collector', ['id' => $collector->id]) }}" onclick ="return confirm('Are you sure you want to delete this collector?')">Trash</a></li>
                                  </ul>
                              </span>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
              </table>
              <script>
                $(document).ready(function() {
                  $('#collectors-table').DataTable();
                });
              </script>
            </div>
          </div>
        </div>
      </div>

      <!-- ADD COLLECTOR MODAL -->
      <div class="modal fade" id="addcollector" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Collector</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-collector') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-2 mb-3">
                      <label for="code" class="form-label">Code:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="code" name="code" required>
                    </div>
                    <div class="col-4 mb-3">
                      <label for="code" class="form-label">Role:</label>
                      <select class="form-select" name="role" id="" required>
                        <option value="3">Collector</option>
                        <option value="4">Area Manager</option>
                      </select>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Fullname:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="name" name="fullname" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Mobile #:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="mobile" name="mobile">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Birthdate:</label>
                      <input type="date" class="form-control border border-secondary-subtle" id="mobile" name="bday">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Cashbond:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="cashbond" name="cashbond">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">CTC No:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="ctcnum" name="ctcnum">
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Address:</label>
                      <textarea class="form-control" name="address" id="address" cols="30" rows="3" required></textarea>
                    </div>
                  </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Add Collector" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD COLLECTOR MODAL -->

      <!-- EDIT COLLECTOR MODAL -->
      <div class="modal fade" id="editcollector" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Collector</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('edit-collector') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-2 mb-3">
                      <label for="code" class="form-label">Code:</label>
                      <input type="hidden" id="e_id" name="e_id">
                      <input type="text" class="form-control border border-secondary-subtle" id="e_code" name="e_code" required>
                    </div>
                    <div class="col-5 mb-3">
                      <label for="code" class="form-label">Role:</label>
                      <select class="form-select" name="e_role" id="e_role" required>
                        <option value="3">Collector</option>
                        <option value="4">Area Manager</option>
                      </select>
                    </div>
                    <div class="col-5 mb-3">
                      <label for="code" class="form-label">Status:</label>
                      <select class="form-select" name="e_status" id="e_status" required>
                        <option value="1">Active</option>
                        <option value="0">In-active</option>
                      </select>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Fullname:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="e_name" name="e_name" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Mobile #:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="e_mobile" name="e_mobile">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Birthdate:</label>
                      <input type="date" class="form-control border border-secondary-subtle" id="e_bday" name="e_bday">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Cashbond:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="e_cashbond" name="e_cashbond">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">CTC No:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="e_ctcnum" name="e_ctcnum">
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Address:</label>
                      <textarea class="form-control" name="e_address" id="e_address" cols="30" rows="3" required></textarea>
                    </div>
                  </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Update Collector" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF EDIT COLLECTOR MODAL -->

      <script>
        $(document).on('click','.edit-collector', function() {
          var _this = $(this).parents('tr');
          var collector_id = $(this).data('id');
          var role = $(this).data('role');
          var birthday = $(this).data('birthday');
          var status = $(this).data('status');
          var cashbond = $(this).data('cashbond');
          var ctc_no = $(this).data('ctc-no');

          $('#e_id').val(collector_id);
          $('#e_code').val(_this.find('.collector_code').text());
          $('#e_role').val(role.toString());
          $('#e_name').val(_this.find('.collector_name').text());
          $('#e_mobile').val(_this.find('.collector_contact').text());
          $('#e_address').val(_this.find('.collector_address').text());
          $('#e_bday').val(birthday);
          $('#e_status').val(status.toString());
          $('#e_cashbond').val(cashbond);
          $('#e_ctcnum').val(ctc_no);
        });
      </script>

@endsection
