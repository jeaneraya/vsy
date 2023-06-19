@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title">AP List</h2></div>
            <div class="col-2"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addaplist">Add AP List</button></div>
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
                  @foreach ($aplists as $key => $aplist)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $aplist->name }}</td>
                    <td>{{ $aplist->remarks }}</td>
                    <td>{{ $aplist->status }}</td>
                    <td class="text-center">
                        <span class="p-relative">
                        <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
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

@endsection
