@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title">Stocks</h2></div>
            <div class="col-2"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproduct">Add Stocks</button></div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="posts-table">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($products as $key => $product)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->unit }}</td>
                    <td>&#8369; {{ $product->price }}</td>
                    <td>{{ $product->status }}</td>
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
                      <textarea class="form-control" name="description" id="description" cols="30" rows="3" required></textarea>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Unit:</label>
                      <select name="unit" id="unit" class="form-select" required>
                        <option value="" disabled selected></option>
                        <option value="bottle">Bottle</option>
                        <option value="box">Box</option>
                        <option value="carton/s">Carton/s</option>
                        <option value="grams">Grams</option>
                        <option value="kilos">Kilos</option>
                        <option value="meter/s">meter/s</option>
                        <option value="piece">Piece</option>
                        <option value="sachet">Sachet</option>
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

@endsection
