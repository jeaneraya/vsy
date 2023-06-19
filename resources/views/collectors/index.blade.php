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
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="posts-table">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Code</th>
                    <th>Collector's Name</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($collectors as $key => $collector)
                      <tr>
                          <td>{{ $key + 1 }}</td>
                          <td>{{ $collector->code }}</td>
                          <td>{{ $collector->fullname }}</td>
                          <td>{{ $collector->mobile }}</td>
                          <td>{{ $collector->address }}</td>
                          <td>{{ $collector->status }}</td>
                          <td class="text-center">
                              <span class="p-relative">
                                  <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                                  <ul class="dropdown-menu">
                                      <li><a class="dropdown-item fs-6" href="{{ route('collectors.show', ['id' => $collector->id, 'name' => $collector->fullname]) }}">View</a></li>
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
                    <div class="col-3 mb-3">
                      <label for="code" class="form-label">Code:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="code" name="code" required>
                    </div>
                    <div class="col-9 mb-3">
                      <label for="" class="form-label">Fullname:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="name" name="fullname" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Mobile #:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="mobile" name="mobile">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Cashbond:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="cashbond" name="cashbond">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">CTC No:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="ctcnum" name="ctcnum">
                    </div>
                    <div class="col-6 mb-3">
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

@endsection
