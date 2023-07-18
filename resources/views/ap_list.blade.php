@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title">AP List</h2></div>
            <div class="col-2"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addaplist">Add AP List</button></div>
            <div class="col-3">
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Select Items to Display
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('ap_list') }}">Show Active</a></li>
                  <li><a class="dropdown-item" href="{{ route('aplist-inactive') }}">Show In-active</a></li>
                  <li><a class="dropdown-item" href="{{ route('aplist-all') }}">Show All</a></li>
                </ul>
              </div>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="posts-table">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Name</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                      $status = [
                          0 => '<span class="badge-trashed">Inactive</span>',
                          1 => '<span class="badge-success">Active</span>',
                      ];
                  @endphp
                  @foreach ($aplists as $key => $aplist)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="ap_id" hidden>{{ $aplist->id }}</td>
                    <td class="ap_name">{{ $aplist->name }}</td>
                    <td class="ap_remarks">{{ $aplist->remarks }}</td>
                    <td class="ap_status" hidden>{{$aplist->status}}</td>
                    <td>{!! $status[$aplist->status] !!}</td>
                    <td class="text-center">
                        <span class="p-relative">
                        <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fs-6 edit-aplist" data-bs-toggle="modal" data-bs-target="#editAPList" data-id="'.$aplist->id.'">Edit</a></li>
                            <li><a class="dropdown-item fs-6" href="{{ route('delete-aplist', ['id' => $aplist->id]) }}" onclick ="return confirm('Are you sure you want to delete this AP List?')">Trash</a></li>
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

      <!-- ADD AP_LIST MODAL -->
      <div class="modal fade" id="addaplist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add AP List</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-aplist') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-12 mb-3">
                      <label for="name" class="form-label">Name:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="name" name="name" required>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Remarks:</label>
                      <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="3" required></textarea>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Add AP List" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD AP_LIST MODAL -->

      <!-- EDIT AP_LIST MODAL -->
      <div class="modal fade" id="editAPList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit AP List</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('edit-aplist') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-7 mb-3">
                      <label for="name" class="form-label">Name:</label>
                      <input type="hidden" id="e_id" name="e_id">
                      <input type="text" class="form-control border border-secondary-subtle" id="e_name" name="e_name" required>
                    </div>
                    <div class="col-5 mb-3">
                      <label for="name" class="form-label">Status:</label>
                      <select name="e_status" id="e_status" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">In-active</option>
                      </select>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Remarks:</label>
                      <textarea class="form-control" name="e_remarks" id="e_remarks" cols="30" rows="3" required></textarea>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Update AP List" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF EDIT AP_LIST MODAL -->
                    

      <script>
        $(document).on('click','.edit-aplist', function() {
          var _this = $(this).parents('tr');
          $('#e_id').val(_this.find('.ap_id').text());
          $('#e_name').val(_this.find('.ap_name').text());
          $('#e_remarks').val(_this.find('.ap_remarks').text());
          var status = parseInt(_this.find('.ap_status').text());
        $('#e_status').val(status);
        })
      </script>
      

      <!-- EDIT AP_LIST MODAL -->
      <div class="modal fade" id="editAPList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit AP List</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('edit-aplist') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-7 mb-3">
                      <label for="name" class="form-label">Name:</label>
                      <input type="hidden" id="e_id" name="e_id">
                      <input type="text" class="form-control border border-secondary-subtle" id="e_name" name="e_name" required>
                    </div>
                    <div class="col-5 mb-3">
                      <label for="name" class="form-label">Status:</label>
                      <select name="e_status" id="e_status" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">In-active</option>
                      </select>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Remarks:</label>
                      <textarea class="form-control" name="e_remarks" id="e_remarks" cols="30" rows="3" required></textarea>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Update AP List" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF EDIT AP_LIST MODAL -->
                    

      <script>
        $(document).on('click','.edit-aplist', function() {
          var _this = $(this).parents('tr');
          $('#e_id').val(_this.find('.ap_id').text());
          $('#e_name').val(_this.find('.ap_name').text());
          $('#e_remarks').val(_this.find('.ap_remarks').text());
          var status = parseInt(_this.find('.ap_status').text());
        $('#e_status').val(status);
        })
      </script>

@endsection
