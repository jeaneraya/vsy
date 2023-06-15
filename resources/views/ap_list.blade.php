@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title">AP List</h2></div>
            <div class="col-2"><button class="btn btn-primary">Add AP List</button></div>
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

@endsection
