@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title">Stocks</h2></div>
            <div class="col-2">
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproduct">Add Stocks</button>
            </div>
            <div class="col-3">
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Select Items to Display
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('products') }}">Show Active</a></li>
                  <li><a class="dropdown-item" href="{{ route('show-inactive') }}">Show In-active</a></li>
                  <li><a class="dropdown-item" href="{{ route('show-all') }}">Show All</a></li>
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
                    <th>Product Code</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                @php
                      $status = [
                          0 => '<span class="badge-trashed">Inactive</span>',
                          1 => '<span class="badge-success">Active</span>',
                      ];
                  @endphp
                  @foreach($products as $key => $product)
                    <td>{{ $key + 1 }}</td>
                    <td class="product_id" hidden>{{ $product->id }}</td>
                    <td class="product_code">{{ $product->product_code }}</td>
                    <td class="description">{{ $product->description }}</td>
                    <td class="unit">{{ $product->unit }}</td>
                    <td class="price" hidden>{{ $product->price }}</td>
                    <td class="status" hidden>{{$product->status }}</td>
                    <td>&#8369; {{ number_format($product->price,2) }}</td>
                    <td>{!! $status[$product->status] !!}</td>
                    <td class="text-center">
                        <span class="p-relative">
                        <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fs-6 edit-product-data" data-bs-toggle="modal" data-bs-target="#editProduct" data-id="'.$product->id.'">Edit</a></li>
                            <li><a class="dropdown-item fs-6" href="{{ route('delete-product', ['id' => $product->id]) }}" onclick="return confirm('Are you sure you want to delete this product?')">Trash</a></li>
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


      <!-- ADD PRODUCT MODAL -->
      <div class="modal fade" id="addproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-product') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="code" class="form-label">Product Code:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="product_code" name="product_code" required>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Product Description:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="description" name="description" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Unit:</label>
                      <select name="unit" id="unit" class="form-select" required>
                        <option value="" disabled selected></option>
                        <option value="box">Box</option>
                        <option value="pack">Pack</option>
                        <option value="pc">Piece</option>
                      </select>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Price:</label>
                      <input type="number" class="form-control border border-secondary-subtle" step="any" min="0" id="price" name="price" required>
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
      <!-- END OF ADD PRODUCT MODAL -->

      <!-- EDIT PRODUCT MODAL -->
      <div class="modal fade" id="editProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('edit-product') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="code" class="form-label">Product Code:</label>
                      <input type="hidden" id="e_product_id" name="e_product_id">
                      <input type="text" class="form-control border border-secondary-subtle" id="e_product_code" name="e_product_code">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Unit:</label>
                      <select name="e_unit" id="e_unit" class="form-select">
                        <option value="" disabled selected></option>
                        <option value="box">Box</option>
                        <option value="pack">Pack</option>
                        <option value="pc">Piece</option>
                      </select>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Product Description:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="e_d" name="e_description">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Price:</label>
                      <input type="number" class="form-control border border-secondary-subtle" step="any" min="0" id="e_price" name="e_price">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Status:</label>
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
      <!-- END OF EDIT PRODUCT MODAL -->
      
      <script>
    $(document).on('click','.edit-product-data', function() {
        var _this = $(this).parents('tr');
        $('#e_product_id').val(_this.find('.product_id').text());
        $('#e_product_code').val(_this.find('.product_code').text());
        $('#e_d').val(_this.find('.description').text());
        $('#e_unit').val(_this.find('.unit').text()); 
        var price = parseFloat(_this.find('.price').text());
        $('#e_price').val(price);
        var status = parseInt(_this.find('.status').text());
        $('#e_status').val(status);
    });
</script>


@endsection
