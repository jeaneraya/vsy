@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title text-capitalize">Clients</h2></div>
            <div class="col-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addclient">Add Client</button>
                <button class="btn btn-primary" onclick="openProducts()">List of Products</button>
            </div>
        </div>
        <div class="row container">
          <div class="col-12">
            <div class="users-table table-wrapper">
              <table class="table table-striped posts-table align-middle" id="clients-table" style="width:100%">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Clients's Name</th>
                    <th>Clients's Address</th>
                    <th>Contact Person</th>
                    <th>Contact No/s.</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($clients as $key => $client)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="client_name">{{ $client->client_name }}</td>
                    <td class="client_address">{{ $client->client_address }}</td>
                    <td class="contact_person">{{ $client->contact_person }}</td>
                    <td class="contact_num">{{ $client->contact_num }}</td>
                    <td class="text-center">
                        <span class="p-relative">
                        <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fs-6 edit-client-data" data-bs-toggle="modal" data-bs-target="#editclient" data-id = "{{ $client->id }}">Edit</a></li>
                            <li> <a class="dropdown-item fs-6" href="{{ route('client-transactions', ['client_id' => $client->id]) }}">Transactions</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item fs-6 text-danger" href="delete/{{ $client->id }}" onclick="return confirm('Are you sure you want to delete this Client?')">Trash</a></li>
                        </ul>
                        </span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <script>
                $(document).ready(function() {
                  $('#clients-table').DataTable();
                });
              </script>
            </div>
          </div>
        </div>
      </div>

      <!-- ADD CLIENT MODAL -->
      <div class="modal fade" id="addclient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Client</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-client') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="code" class="form-label">Client's Name:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="client_name" name="client_name" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Clients's Address:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="client_address" name="client_address" required>
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
              <input type="submit" value="Add Client" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD CLIENT MODAL -->

      <!-- PRODUCT LIST -->
        <div class="modal fade" id="productList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Product List</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table" id="productsTable">
                        <thead>
                            <th>#</th>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($products as $key => $product)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $product->product_code }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->unit }}</td>
                                <td>{{ $product->price }}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick=openAddProductModal()>Add Product</button>
                </div>
                </div>
            </div>
        </div>
      <!-- END OF PRODUCT LIST -->

      <!-- EDIT CLIENT MODAL -->
      <div class="modal fade" id="editclient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Client</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-client-form" action="{{ route('edit-client') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="code" class="form-label">Client's Name:</label>
                      <input type="hidden" id="client_id" name="client_id">
                      <input type="text" class="form-control border border-secondary-subtle" id="e-client_name" name="client_name" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Client's Address:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="e-client_address" name="e_client_address" required>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Contact Person:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="e-contact_person" name="e_contact_person" required>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Contact Nos.:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="e-contact_num" name="e_contact_num" required>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Update Client" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF EDIT CLIENT MODAL -->

    <!-- ADD PRODUCT MODAL -->
    <div class="modal fade" id="addproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-clients-products') }}" method="POST" id="addProductForm">
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
              <input type="submit" value="Save Product" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD PRODUCT MODAL -->

      @if(request()->query('openProductsModal') === 'true')
    <script>
        $(document).ready(function() {
            $('#productList').modal('show');
        });
    </script>
    @endif

    <script>
    function openProducts() {
        $('#productList').modal('show');
    }

    function openAddProductModal() {
        $('#addproduct').modal('show');
    } 

    $(document).on('click', '.edit-client-data', function(){
        var _this = $(this).parents('tr');
        var client_id = $(this).data('id');
        $('#client_id').val(client_id);
        $('#e-client_name').val(_this.find('.client_name').text());
        $('#e-client_address').val(_this.find('.client_address').text());
        $('#e-contact_person').val(_this.find('.contact_person').text());
        $('#e-contact_num').val(_this.find('.contact_num').text());
    });
      </script>

@endsection
