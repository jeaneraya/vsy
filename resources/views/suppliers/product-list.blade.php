@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title" style="text-transform:capitalize">{{$supplier_name}}'s Products</h2></div>
            <div class="col-4"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addsupplierproduct">Add Products</button></div>
            <div class="col-3">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Items to Display
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('supplier-products', ['supplier_id' => $supplier_id]) }}">Show Active</a></li>
                    <li><a class="dropdown-item" href="{{ route('supplier-products-inactive', ['supplier_id' => $supplier_id]) }}">Show In-active</a></li>
                    <li><a class="dropdown-item" href="{{ route('supplier-products-all', ['supplier_id' => $supplier_id]) }}">Show All</a></li>
                  </ul>
                </div>
              </div>
        </div>
        <div class="row container">
          <div class="col-12">
            <div class="users-table table-wrapper">
              <table class="table table-striped posts-table align-middle" id="suppliers-products-table" style="width:100%">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Price</th>
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
                    @foreach ($suppliers_products as $key => $sp)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="item_code">{{ $sp->item_code }}</td>
                        <td class="item_description">{{ $sp->item_description }}</td>
                        <td class="unit">{{ $sp->unit }}</td>
                        <td class="price">{{ $sp->price }}</td>
                        <td>{!! $status[$sp->status] !!}</td>
                        <td class="text-center">
                        <span class="p-relative">
                        <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fs-6 edit-supplier-product" data-bs-toggle="modal" data-bs-target="#editsupplierproduct" data-id="{{ $sp->id }}" data-status="{{ $sp->status }}">Edit</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item fs-6 text-danger" href="{{route('delete-supplier-product', ['product_id' => $sp->id])}}" onclick="return confirm('Are you sure you want to delete this Item?')">Trash</a></li>
                        </ul>
                        </span>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
              <script>
                $(document).ready(function() {
                  $('#suppliers-products-table').DataTable();
                });
              </script>
            </div>
          </div>
        </div>
      </div>

      <!-- ADD SUPPLIER PRODUCTS MODAL -->
      <div class="modal fade" id="addsupplierproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-supplier-product', ['supplier_id' => $supplier_id]) }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-4 mb-3">
                      <label for="code" class="form-label">Item Code:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="item_code" name="item_code" required>
                    </div>
                    <div class="col-4 mb-3">
                      <label for="" class="form-label">Unit:</label>
                      <select name="unit" id="unit" class="form-select">
                        <option value=""></option>
                        <option value="pc">Piece</option>
                        <option value="pack">Pack</option>
                        <option value="box">Box</option>
                      </select>
                    </div>
                    <div class="col-4 mb-3">
                      <label for="" class="form-label">Price:</label>
                      <input type="number" class="form-control border border-secondary-subtle" id="price" name="price" required>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Description:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="description" name="description" required>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Add Product" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD SUPPLIER PRODUCTS MODAL -->

      <!-- EDIT SUPPLIER PRODUCTS MODAL -->
      <div class="modal fade" id="editsupplierproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('edit-supplier-product') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-4 mb-3">
                      <label for="code" class="form-label">Item Code:</label>
                      <input type="hidden" name="pid" id="pid">
                      <input type="text" class="form-control border border-secondary-subtle" id="e_item_code" name="e_item_code">
                    </div>
                    <div class="col-4 mb-3">
                      <label for="" class="form-label">Unit:</label>
                      <select name="e_unit" id="e_unit" class="form-select">
                        <option value=""></option>
                        <option value="pc">Piece</option>
                        <option value="pack">Pack</option>
                        <option value="box">Box</option>
                      </select>
                    </div>
                    <div class="col-4 mb-3">
                      <label for="" class="form-label">Price:</label>
                      <input type="number" class="form-control border border-secondary-subtle" id="e_price" name="e_price">
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Description:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="e_description" name="e_description">
                    </div>
                    <div class="col-6">
                        <label for="" class="label-form">Status</label>
                        <select name="e_status" id="e_status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">In-active</option>
                        </select>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Add Product" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF EDIT SUPPLIER PRODUCTS MODAL -->

      <script>
        $(document).on('click', '.edit-supplier-product', function(){
            var _this = $(this).parents('tr');
            var pid = $(this).data('id');
            var status = $(this).data('status');

            $('#e_item_code').val(_this.find('.item_code').text());
            $('#e_description').val(_this.find('.item_description').text());
            $('#e_unit').val(_this.find('.unit').text());
            $('#e_price').val(_this.find('.price').text());
            $('#pid').val(pid);
            $('e_status').val(status.toString());
        });
      </script>

@endsection
