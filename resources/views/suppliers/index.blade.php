@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title">Suppliers</h2></div>
            <div class="col-2"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addsupplier">Add Suppliers</button></div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="posts-table">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Supplier's Name</th>
                    <th>Supplier's Address</th>
                    <th>Contact Person</th>
                    <th>Contact No/s.</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($suppliers as $key => $supplier)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $supplier->supplier_name }}</td>
                    <td>{{ $supplier->supplier_address }}</td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td>{{ $supplier->contact_num }}</td>
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

      <!-- ADD SUPPLIER MODAL -->
      <div class="modal fade" id="addsupplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Supplier</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-supplier') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="code" class="form-label">Supplier's Name:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="supplier_name" name="supplier_name" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Supplier's Address:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="supplier_address" name="supplier_address" required>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Contact Person:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="contact_person" name="contact_person" required>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Contact Nos.:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="contact_num" name="contact_num" required>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Add Supplier" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD SUPPLIER MODAL -->

@endsection
