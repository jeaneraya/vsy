@extends("layout.design")

@section ("contents")

<div class="container-fluid view-batch">
        <div class="sticky-container">
        <div class="row">
            <div class="col-6"><h2 class="main-title">Withdrawals of {{ $collector_name }}</h2></div>
            <div class="col-6">
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Add Items
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" role="button" data-bs-toggle="collapse" href="#addproductstobatch">Add Products</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" role="button" data-bs-toggle="collapse" href="#addexpensestobatch">Add Expenses</a></li>
                </ul>
              </div>
            </div>
        </div>
        <div class="collapse" id="addproductstobatch">
          <div class="card card-body d-flex justify-content-center p-3">
            <h5 class="mb-3"><strong id="title-product-container">Add Product</strong></h5>
            <form action="{{ route('add-batch-product') }}" method="POST" id="form-product">
            @csrf
              <div class="row">
                <div class="col-3">
                  <label for="" class="form-label">Ref. Number</label>
                  <input type="text" class="form-control" name="ref_no" id="ref_no" autocomplete="off">
                  <input type="hidden" class="form-control" name="bdid" id="bdid" autocomplete="off">
                </div>
                <div class="col-3 product-code-container">
                  <label for="" class="form-label">Product Code</label>
                  <input type="hidden" name="delivery_id" value="{{ $batch_delivery_id }}">
                  <input type="hidden" name="batch_id" value="{{ $batch_id }}">
                  <input type="hidden" name="collector_name" value="{{ $collector_name }}">
                  <input type="number" name="product_id" id="product_id" hidden>
                  <input type="text" class="form-control" name="product_code" id="product_code" autocomplete="off">
                  <div id="product-list"></div>
                </div>
                <div class="col-4">
                  <label for="" class="form-label">Description</label>
                  <input type="text" class="form-control" name="description" id="description" readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  <label for="" class="form-label">Unit</label>
                  <select class="form-select" name="unit" id="unit">
                    <option value="" disabled selected></option>
                    <option value="box">Box</option>
                    <option value="pc">Pc</option>
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
                  <input type="submit" name="add_product" class="btn btn-primary" value="Add Product" id="product-button">
                  <button type="button" class="btn btn-secondary" id="close-products-button" style="margin-left:1em">Close</button>
                </div>
            </div>
            </form>
            </div>
        </div>
        <div class="collapse" id="addexpensestobatch">
          <div class="card card-body d-flex justify-content-center p-5">
            <h5 class="mb-3"><strong id="expenses-title-container">Add Expenses</strong></h5>
            <form action="{{ route('add-batch-expenses') }}" method="POST" id="expenses_form">
            @csrf
              <div class="row">
                <div class="col-2">
                  <label for="" class="form-label">Expenses Code</label>
                  <input type="hidden" name="delivery_id" value="{{ $batch_delivery_id }}">
                  <input type="hidden" name="batch_id" value="{{ $batch_id }}">
                  <input type="hidden" name="collector_name" value="{{ $collector_name }}">
                  <input type="hidden" name="e_code" id="e_code">
                  <input type="text" class="form-control" name="expenses_code" id="expenses_code" autocomplete="off">
                  <div id="expenses-list"></div>
                </div>
                <div class="col-3">
                  <label for="" class="form-label">Description</label>
                  <input type="hidden" id="et_id" name="et_id">
                  <input type="text" class="form-control" name="description" id="expenses_description" readonly>
                </div>
                <div class="col-3">
                  <label for="" class="form-label">Remarks</label>
                  <input type="text" class="form-control" name="remarks" id="remarks">
                </div>
                <div class="col-2">
                  <label for="" class="form-label">Amount</label>
                  <input type="number" class="form-control" name="amount" id="e_amount" min="0">
                </div>
                <div class="col-1 d-flex align-items-end">
                  <input type="submit" name="add_expenses" class="btn btn-primary" value="Save Data" id="expenses_button">
                  <button type="button" class="btn btn-secondary" id="close-expenses-button" style="margin-left:1em">Close</button>
                </div>
            </div>
            </form>
            </div>
        </div>
        <hr>
        </div>
    </div>
    <div class="container view-batch">
      <div class="row container">
        <div class="col-lg-12">
          <h5 class="text-center"><strong>Products</strong></h5>
          </div>
          <div class="users-table table-wrapper products">
            <table id="products-table" class="table table-striped posts-table align-middle" style="width:100%">
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
                $interest_rate = 0;
              @endphp
              @foreach($batch_withdrawals as $key => $withdrawal)
                  <tr>
                      <td>{{ $key + 1 }}</td>
                      <td class="t_product_code">{{ $withdrawal->product_code }}</td>
                      <td class="t_description">{{ $withdrawal->description }}</td>
                      <td class="t_qty">{{ $withdrawal->qty }}</td>
                      <td class="t_unit">{{ $withdrawal->unit }}</td>
                      <td class="t_price">{{ $withdrawal->price }}</td>
                      <td class="t_total_amount">{{ $withdrawal->total_amount }}</td>
                      <td class="text-center">
                        <span class="p-relative">
                            <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item fs-6 return-batch-product" data-bid="{{ $withdrawal->bid }}" data-batch-id="{{ $withdrawal->delivery_id }}" data-bs-toggle="modal" data-bs-target="#returnitems">Return</a></li>
                                <li><a class="dropdown-item fs-6 edit-batch-product" data-id="{{ $withdrawal->bid }}" data-ref-no="{{ $withdrawal->ref_no }}" data-product-id="{{ $withdrawal->product_id }}" data-batch-id="{{ $withdrawal->delivery_id }}">Edit</a></li>
                                <li><a class="dropdown-item fs-6" href="{{ route('delete-batch-product', ['batch_id' => $batch_id, 'name' => $collector_name,'batch_delivery_id' => $batch_delivery_id,  'bd_id' => $withdrawal->bid] ) }}" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a></li>
                            </ul>
                        </span>
                    </td>
                  </tr>
                  @php
                    $total += $withdrawal->total_amount;
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
            $('#products-table').DataTable();
          });
        </script>
        <div class="row container">
          <div class="col-lg-12">
            <h5 class="text-center"><strong>Expenses</strong></h5>
            </div>
            <div class="users-table table-wrapper expenses">
              <table id="expenses-table" class="table table-striped posts-table align-middle" style="width:100%">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Remarks</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @php
                  $totalExpenses = 0;
                @endphp
                @foreach($expenses_transactions as $key => $expenses_trans)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="t_code">{{ $expenses_trans->code }}</td>
                        <td class="t_e_description">{{ $expenses_trans->description }}</td>
                        <td class="t_remarks">{{ $expenses_trans->remarks }}</td>
                        <td class="t_amount">{{ $expenses_trans->amount }}</td>
                        <td class="text-center">
                          <span class="p-relative">
                              <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                              <ul class="dropdown-menu">
                                  <li><a class="dropdown-item fs-6 edit-batch-expenses" data-id="{{ $expenses_trans->eid }}" data-expenses-id="{{ $expenses_trans->expenses_id }}">Edit</a></li>
                                  <li><a class="dropdown-item fs-6" href="{{ route('delete-batch-expenses', ['batch_id' => $batch_id, 'name' => $collector_name,'batch_delivery_id' => $batch_delivery_id, 'et_id' => $expenses_trans->eid] ) }}" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a></li>
                              </ul>
                          </span>
                      </td>
                    </tr>
                    @php
                      $totalExpenses += $expenses_trans->amount;
                    @endphp
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4"></td>
                  <td colspan="2" align="right"><strong>Total: </strong>&#8369; {{ number_format($totalExpenses,2) }}</td>
                </tr>
              </tfoot>
              </table>
              <script>
              $(document).ready(function() {
                $('#expenses-table').DataTable();
              });
            </script>
            </div>
          </div>
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
          $('#addproductstobatch').collapse('hide');
          var currentUrl = window.location.href;

        if (currentUrl.includes('?openCollapseProducts=true')) {
          var updatedUrl = currentUrl.replace('?openCollapseProducts=true', '');

          window.history.replaceState({}, document.title, updatedUrl);
        }
        })

        $(document).on('click', '#close-expenses-button', function() {
          $('#addexpensestobatch').collapse('hide');

          var currentUrl2 = window.location.href;

          if (currentUrl2.includes('?openCollapseExpenses=true')) {
            var updatedUrl2 = currentUrl2.replace('?openCollapseExpenses=true', '');

            window.history.replaceState({}, document.title, updatedUrl2);
          }
        })
      </script>
      <script>
        $(document).ready(function() {
          $('#product_code').keyup(function() {
              var query = $(this).val();
              if (query != '') {
                  $.ajax({
                      url: "{{ route('productcode-autocomplete') }}", 
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

          $(document).on('click', '#product-list-ul li', function() {
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
  $(document).ready(function() {
    $('#expenses_code').keyup(function() {
        var query = $(this).val();
        if (query != '') {
            $.ajax({
                url: "{{ route('expenses-autocomplete') }}", 
                method: "GET",
                data: { query: query },
                success: function(data) {
                    $("#expenses-list").fadeIn();
                    $("#expenses-list").html(data);
                }
            });
        } else {
            $('#expenses-list').fadeOut();
            $('#expenses-list').html("");
        }
    });

    $(document).on('click', '#expenses-list-ul li', function() {
        var selectedExpense = $(this).text();
        var selectedExpensetId = $(this).data('expensesid');
        var selectedExpenseCode = $(this).data('expensescode');

        $('#e_code').val(selectedExpensetId);
        $('#expenses_code').val(selectedExpenseCode);
        $('#expenses_description').val(selectedExpense);
        $('#expenses-list').fadeOut();
    });
});

</script>

<script>

  const productInput = document.getElementById('product_code');
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

      xhr.open('GET', '/get-product?product=' + encodeURIComponent(product) + '&unit=' + encodeURIComponent(unit));
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
        const openCollapseProducts = urlParams.get('openCollapseProducts');

        if (openCollapseProducts === 'true') {
            $('#addproductstobatch').collapse('show');
        } 
    });
</script>

<script>
    $(document).ready(function() {
        
        const urlParams = new URLSearchParams(window.location.search);
        const openCollapseExpenses = urlParams.get('openCollapseExpenses');

        if (openCollapseExpenses === 'true') {
            $('#addexpensestobatch').collapse('show');
        } 
    });
</script>

<script>
  $(document).on('click', '.edit-batch-product', function() {
    $('#form-product').attr('action', "{{ route('edit-batch-product') }}");
    $('#addproductstobatch').collapse('show');

    var _this = $(this).parents('tr');
    var bdid = $(this).data('id');
    var ref_no = $(this).data('ref-no');
    var product_id = $(this).data('product-id');

    $('#bdid').val(bdid);
    $('#ref_no').val(ref_no);
    $('#product_id').val(product_id);
    $('#product_code').val(_this.find('.t_product_code').text());
    $('#description').val(_this.find('.t_description').text());
    $('#unit').val(_this.find('.t_unit').text());
    $('#price').val(_this.find('.t_price').text());
    $('#qty').val(_this.find('.t_qty').text());
    $('#total').val(_this.find('.t_total_amount').text());

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
</script>


@endsection
