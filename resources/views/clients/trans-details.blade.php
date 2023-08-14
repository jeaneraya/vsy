@extends("layout.design")

@section ("contents")

<div class="container-fluid view-batch">
        <div class="sticky-container">
        <div class="row">
            <div class="col-6"><h2 class="main-title text-capitalize">{{$client_name}}'s Trans. Details</h2></div>
            <div class="col-6">
                <button type="button" class="btn btn-primary" data-bs-toggle="collapse" href="#additems">Add Items</button>
            </div>
        </div>
        <div class="collapse" id="additems">
          <div class="card card-body d-flex justify-content-center p-3">
            <h5 class="mb-3"><strong id="title-product-container">Add Items</strong></h5>
            <form action="{{ route('add-client-items') }}" method="POST" id="form-product">
            @csrf
              <div class="row">
                <div class="col-3">
                  <label for="" class="form-label">Product Code</label>
                  <input type="hidden" name="client_id" value="{{ $client_id }}">
                  <input type="hidden" name="trans_id" value="{{ $trans_id }}">
                  <input type="hidden" name="product_id" id="product_id" hidden>
                  <input type="text" class="form-control" name="product_code" id="product_code" autocomplete="off" readonly>
                </div>
                <div class="col-4 product-code-container">
                  <label for="" class="form-label">Description</label>
                  <input type="hidden" name="tdid" id="tdid">
                  <input type="text" class="form-control" name="description" id="description" autocomplete="off">
                  <div id="product-list"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  <label for="" class="form-label">Unit</label>
                  <select class="form-select" name="unit" id="unit">
                    <option value="" disabled selected></option>
                    <option value="pc">Pc</option>
                    <option value="box">Box</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
                <div class="col-2">
                  <label for="" class="form-label">Price</label>
                  <input type="number" class="form-control" name="price" id="price" readonly>
                </div>
                <div class="col-2">
                  <label for="" class="form-label">Qty</label>
                  <input type="number" min="0" class="form-control" name="qty" id="qty">
                </div>
                <div class="col-2">
                  <label for="" class="form-label">Total</label>
                  <input type="number" class="form-control" name="total" id="total" readonly>
                </div>
                <div class="col-1 d-flex align-items-end">
                  <input type="submit" name="add_product" class="btn btn-primary" value="Add Item" id="product-button">
                  <button type="button" class="btn btn-secondary" id="close-products-button" style="margin-left:1em">Close</button>
                </div>
            </div>
            </form>
            </div>
        </div>
        <hr>
        </div>
    </div>
        <div class="container view-supplier-details">
        <div class="row container">
          <div class="col-lg-12">
            <h5 class="text-center"><strong>Items</strong></h5>
            </div>
            <div class="trans-details table-wrapper products">
              <table id="trans-details-table" class="table table-striped posts-table align-middle" style="width:100%">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @php
                  $total = 0;
                @endphp
                @foreach($trans_details as $key => $td)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="t_product_code">{{ $td->product_code }}</td>
                        <td class="t_description">{{ $td->description }}</td>
                        <td class="t_qty">{{ $td->qty }}</td>
                        <td class="t_unit">{{ $td->unit }}</td>
                        <td class="t_price">{{ $td->price }}</td>
                        <td class="t_total">{{ $td->total }}</td>
                        <td class="text-center">
                          <span class="p-relative">
                              <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                              <ul class="dropdown-menu">
                                  <li><a class="dropdown-item fs-6 edit-trans-detail" data-id="{{ $td->id }}" data-product-id="{{ $td->product_id }}">Edit</a></li>
                                  <li><a class="dropdown-item fs-6" href="{{ route('delete-supplier-trans-detail', ['trans_id' => $td->id] ) }}" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a></li>
                              </ul>
                          </span>
                      </td>
                    </tr>
                    @php
                      $total += $td->total;
                    @endphp
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6"></td>
                  <td colspan="2" align="right"><strong>Total: </strong>&#8369; {{ number_format($total,2) }}</td>
                </tr>
              </tfoot>
              </table>
            </div>
          </div>
          <script>
            $(document).ready(function() {
              $('#trans-details-table').DataTable();
            });
          </script>
          </div>
        </div>
      </div>

      <div class="scroll-to-bottom-container">
        <button class="scroll-to-bottom" style="background:none"><iconify-icon icon="formkit:arrowdown"></iconify-icon></button>
      </div>


      <script>
        $(document).on('click', '.scroll-to-bottom', function() {
          window.scrollTo(0, document.body.scrollHeight);
        });
      </script>

      <script>
        $(document).on('click','#close-products-button', function() {
          $('#additems').collapse('hide');
        })
      </script>

      <script>
        $(document).ready(function() {
          $('#description').keyup(function() {
              var query = $(this).val();
              if (query != '') {
                  $.ajax({
                      url: "{{ route('client-productcode-autocomplete') }}", 
                      method: "GET",
                      data: { query: query },
                      success: function(data) {
                          $("#product-list").fadeIn();
                          $("#product-list").html(data);
                      }
                  });
              } else {
                  $('#product-list').fadeOut();
                  $('#product-list').html("");
              }
          });

          $(document).on('click', '#client-products-list-ul li', function() {
              var selectedProduct = $(this).text();
              var selectedProductId = $(this).data('productid');
              var selectedProductCode = $(this).data('productcode');

              $('#product_id').val(selectedProductId);
              $('#product_code').val(selectedProductCode);
              $('#description').val(selectedProduct);
              $('#product-list').fadeOut();
          });
      });

    </script>

<script>

  const productInput = document.getElementById('product_id');
  const unitSelect = document.getElementById('unit');
  const priceInput = document.getElementById('price');

  unitSelect.addEventListener('change', updateProduct);

  function updateProduct() {
      const product = productInput.value;
      const unit = unitSelect.value;

      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                  const priceresult = xhr.responseText;
                  if (priceresult !== 'NULL') {
                      priceInput.value = priceresult;
                  } else {
                      priceInput.value = ''; 
                  }
              } else {
                  console.error('Error: ' + xhr.status);
              }
          }
      };

      xhr.open('GET', '/get-client-product-price?product=' + encodeURIComponent(product) + '&unit=' + encodeURIComponent(unit));
      xhr.send();
  }
</script>

<script>
  const productQty = document.getElementById('qty');
  const productTotal = document.getElementById('total');

  productQty.addEventListener('input', updateTotal);

  function updateTotal() {
    var qty = parseFloat(document.getElementById("qty").value);
    var price = parseFloat(document.getElementById("price").value);
    var total = isNaN(qty) || isNaN(price) ? 0 : qty * price;
    document.getElementById("total").value = total;
  }
</script>

<script>

    $(document).ready(function() {
        
        const urlParams = new URLSearchParams(window.location.search);
        const openCollapseProducts = urlParams.get('openCollapseClientItems');

        if (openCollapseProducts === 'true') {
            $('#additems').collapse('show');
        } 
    });
</script>

<script>
  $(document).on('click', '.edit-trans-detail', function() {
    $('#form-product').attr('action', "{{ route('edit-supplier-trans-item') }}");
    $('#additems').collapse('show');

    var _this = $(this).parents('tr');
    var tdid = $(this).data('id');
    var ref_no = $(this).data('ref-no');
    var product_id = $(this).data('product-id');

    $('#tdid').val(tdid);
    $('#ref_no').val(ref_no);
    $('#product_id').val(product_id);
    $('#product_code').val(_this.find('.t_product_code').text());
    $('#description').val(_this.find('.t_description').text());
    $('#unit').val(_this.find('.t_unit').text());
    $('#price').val(_this.find('.t_price').text());
    $('#qty').val(_this.find('.t_qty').text());
    $('#total').val(_this.find('.t_total').text());

    $('#title-product-container').text('Edit Product');
    $('#product-button').val('Update Data');
  })
</script>

<script>
  $(document).on('click','.edit-batch-expenses', function() {
    $('#expenses_form').attr('action', "{{ route('edit-batch-expenses') }}");
    $('#addexpensestobatch').collapse('show');

    var _this = $(this).parents('tr');
    var et_id = $(this).data('id');
    var expenses_id = $(this).data('expenses-id');

    $('#et_id').val(et_id);
    $('#e_code').val(expenses_id);
    $('#expenses_code').val(_this.find('.t_code').text());
    $('#expenses_description').val(_this.find('.t_e_description').text());
    $('#remarks').val(_this.find('.t_remarks').text());
    $('#e_amount').val(_this.find('.t_amount').text());

    $('#expenses_button').val('Update Data');
    $('#expenses-title-container').text('Edit Expenses');
  })
</script>

<script>
  $(document).on('click', '.return-batch-product', function() {
    var _this = $(this).parents('tr');
    var r_et_id = $(this).data('bid');
    var r_batch_id = $(this).data('batch-id');

    $('#r_et_id').val(r_et_id);
    $('#r_batch_id').val(r_batch_id);
    $('#r_product_code').val(_this.find('.t_product_code').text());
    $('#r_description').val(_this.find('.t_description').text());
  })

  $(document).ready(function() {
        
        const urlParams = new URLSearchParams(window.location.search);
        const openCollapseProducts = urlParams.get('openCollapseSupplierItems');

        if (openCollapseProducts === 'true') {
            $('#additems').collapse('show');
        } 
    });
</script>


@endsection
