@extends("layout.design")

@section ("contents")

<div class="container view-batch">
        <div class="row">
            <div class="col-6"><h2 class="main-title">Batch # @foreach($transactions as $transaction){{ $transaction->num }}@endforeach of {{ $collector_name }}</h2></div>
            <div class="col-2"> 
              <button class="btn btn-primary" onclick="openLedgerModal()">Payment</button>
            </div>
            <div class="col-2">
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
            <div class="col-2">
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Print Files
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
              </div>
            </div>
        </div>
        <div class="collapse" id="addproductstobatch">
          <div class="card card-body d-flex justify-content-center p-5">
            <h5 class="mb-3"><strong>Add Product</strong></h5>
            <form action="{{ route('add-batch-product') }}" method="POST">
            @csrf
              <div class="row">
                <div class="col-2">
                  <label for="" class="form-label">Product Code</label>
                  <input type="hidden" name="batch" value="{{ $batch_id }}">
                  <input type="hidden" name="collector" value="{{ $collector_id }}">
                  <input type="hidden" name="collector_name" value="{{ $collector_name }}">
                  <input type="number" name="product_id" id="product_id" hidden>
                  <input type="text" class="form-control" name="product_code" id="product_code" autocomplete="off">
                  <div id="product-list"></div>
                </div>
                <div class="col-3">
                  <label for="" class="form-label">Description</label>
                  <input type="text" class="form-control" name="description" id="description" readonly>
                </div>
                <div class="col-2">
                  <label for="" class="form-label">Unit</label>
                  <select class="form-select" name="unit" id="unit">
                    <option value="" disabled selected></option>
                    <option value="box">Box</option>
                    <option value="pc">Pc</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
                <div class="col-1">
                  <label for="" class="form-label">Price</label>
                  <input type="number" class="form-control" name="price" id="price" readonly>
                </div>
                <div class="col-1">
                  <label for="" class="form-label">Qty</label>
                  <input type="number" min="0" class="form-control" name="qty" id="qty">
                </div>
                <div class="col-2">
                  <label for="" class="form-label">Total</label>
                  <input type="number" class="form-control" name="total" id="total" readonly>
                </div>
                <div class="col-1 d-flex align-items-end">
                  <input type="submit" name="add_product" class="btn btn-primary" value="Add Product">
                </div>
            </div>
            </form>
            </div>
        </div>
        <div class="collapse" id="addexpensestobatch">
          <div class="card card-body d-flex justify-content-center p-5">
            <h5 class="mb-3"><strong>Add Expenses</strong></h5>
            <form action="{{ route('add-batch-expenses') }}" method="POST">
            @csrf
              <div class="row">
                <div class="col-2">
                  <label for="" class="form-label">Expenses Code</label>
                  <input type="hidden" name="batch" value="{{ $batch_id }}">
                  <input type="hidden" name="collector" value="{{ $collector_id }}">
                  <input type="hidden" name="collector_name" value="{{ $collector_name }}">
                  <input type="hidden" name="code" id="code">
                  <input type="text" class="form-control" name="expenses_code" id="expenses_code">
                  <div id="expenses-list"></div>
                </div>
                <div class="col-4">
                  <label for="" class="form-label">Description</label>
                  <input type="text" class="form-control" name="description" id="expenses_description" readonly>
                </div>
                <div class="col-2">
                  <label for="" class="form-label">Amount</label>
                  <input type="number" class="form-control" name="amount" min="0">
                </div>
                <div class="col-2 d-flex align-items-end">
                  <input type="submit" name="add_expenses" class="btn btn-primary" value="Save New Data">
                </div>
            </div>
            </form>
            </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-lg-12">
            <h5><strong>Products</strong></h5>
            </div>
            <div class="users-table table-wrapper">
              <table class="posts-table">
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
                @foreach($batch_withdrawals as $key => $withdrawal)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $withdrawal->product_code }}</td>
                        <td>{{ $withdrawal->description }}</td>
                        <td>{{ $withdrawal->qty }}</td>
                        <td>{{ $withdrawal->unit }}</td>
                        <td>{{ $withdrawal->price }}</td>
                        <td>{{ $withdrawal->total_amount }}</td>
                        <td class="text-center">
                          <span class="p-relative">
                              <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                              <ul class="dropdown-menu">
                                  <li><a class="dropdown-item fs-6" href="#">Edit</a></li>
                                  <li><a class="dropdown-item fs-6" href="#">Delete</a></li>
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
                  <td colspan="7" align="right"><strong>Total: </strong>&#8369; {{ number_format($total,2) }}</td>
                  <td></td>
                </tr>
              </tfoot>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <h5><strong>Expenses</strong></h5>
              </div>
              <div class="users-table table-wrapper">
                <table class="posts-table">
                  <thead style="padding-left:1em">
                    <tr class="users-table-info">
                      <th>#</th>
                      <th>Code</th>
                      <th>Description</th>
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
                          <td>{{ $expenses_trans->code }}</td>
                          <td>{{ $expenses_trans->description }}</td>
                          <td>{{ $expenses_trans->amount }}</td>
                          <td class="text-center">
                            <span class="p-relative">
                                <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item fs-6" href="#">Edit</a></li>
                                    <li><a class="dropdown-item fs-6" href="#">Delete</a></li>
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
                    <td colspan="3" align="right"><strong>Total: </strong>&#8369; {{ number_format($totalExpenses,2) }}</td>
                    <td colspan="2"></td>
                  </tr>
                </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- PAYMENT LEDGER -->
      <div class="modal fade" id="payment_ledger" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content payment_ledger_content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Payment of: {{$collector_name}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  @foreach($transactions as $transaction)
                  <div class="col-7">
                    <div class="row">
                      <div class="col-4"><strong>Period Covered:</strong></div>
                      <div class="col-8">{{ $transaction->period_from }} to {{ $transaction->period_to }}</div>
                    </div>
                    <div class="row">
                      <div class="col-4"><strong>1st Collection:</strong></div>
                      <div class="col-8">{{ $transaction->first_collection }}</div>
                    </div>
                    <div class="row">
                      <div class="col-6"><strong>Addt'l Expenses:</strong></div>
                      <div class="col6"></div>
                    </div>
                    <div class="row">
                      <div class="col-6"><strong>Downpayment:</strong></div>
                      <div class="col6"></div>
                    </div>
                    <div class="row">
                      <div class="col-6"><strong>Arears:</strong></div>
                      <div class="col6"></div>
                    </div>
                  </div>
                  <div class="col-5">
                    <div class="row">
                      <div class="col-5"><strong>Batch Status:</strong></div>
                      <div class="col-7">{{ $transaction->status }}</div>
                    </div>
                    <div class="row">
                      <div class="col-5"><strong>Total as Capital:</strong></div>
                      <div class="col-7">&#8369;{{ number_format($total + $totalExpenses,2) }}</div>
                    </div>
                    <div class="row">
                      @php
                      $total_payment = 0; // Declare the variable outside the loop
                      $balance = 0;
                      @endphp

                      @foreach($payments as $payment)
                          @php
                          $total_payment += $payment->paid_amount; // Increment the variable inside the loop
                          $balance = $payment->balance;
                          @endphp
                      @endforeach
                      <div class="col-5"><strong>Total Payment:</strong></div>
                      <div class="col-7">&#8369; {{ number_format($total_payment,2) }}</div>
                    </div>
                    <div class="row">
                      <div class="col-7"><strong>Remaining Balance:</strong></div>
                      <div class="col-5">&#8369; {{ ($balance == 0) ? number_format($total + $totalExpenses,2) : number_format($balance,2) }}</div>
                    </div>
                  </div>
                  @endforeach
                </div>
                <hr/>
                <table class="table-striped w-100">
                  <thead>
                    <th><input type="checkbox" class="form-check-input" id="select_all_ids"></th>
                    <th>#</th>
                    <th>Payment Date</th>
                    <th>Days</th>
                    <th>Amount</th>
                    <th>Balance</th>
                    <th>MOP</th>
                    <th>MOP Detail</th>
                  </thead>
                  <tbody>
                    @foreach($payments as $key => $payment)
                    <tr id="id_of_payment">
                        <td>  
                          <input class="form-check-input payment_ids" type="checkbox" name="payment_id" value="{{ $payment->id }}" id="payment_id_{{ $payment->id }}">
                        </td>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $payment->payment_date }}</td>
                        <td>{{ $payment->days }}</td>
                        <td>{{ $payment->paid_amount }}</td>
                        <td>{{ $payment->balance }}</td>
                        <td>{{ $payment->mop }}</td>
                        <td>{{ $payment->mop_details }}</td>
                    </tr>
                @endforeach
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary" onclick="openMakePaymentModal()">Make Payment</button>
                <button class="btn btn-primary" onclick="openEditPaymentModal(event)" data-route="{{ route('payment-data', ['id' => '__paymentId__']) }}">Edit Payment</button>
                <button class="btn btn-danger" id="deleted-selected-rows">Delete Payment</button>
              </div>
            </div>
        </div>
      </div>
      <!-- END OF PAYMENT LEDGER -->

      <!-- ADD PAYMENT MODAL -->
      <div class="modal fade" id="addpayment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Payment of: {{$collector_name}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('add-payment') }}" method="GET" class="d-flex align-items-end">
                      <div class="row">
                      <input type="hidden" name="batch" value="{{ $batch_id }}">
                      <input type="hidden" name="collector" value="{{ $collector_id }}">
                      <input type="hidden" name="collector_name" value="{{ $collector_name }}">
                      <input type="number" name="total_credit" value="{{ ($balance == 0) ? $total + $totalExpenses : $balance }}" hidden>
                      <input type="text" name="id" value="" hidden class="form-control">
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Amount</label>
                      <input type="number" name="amount" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Date of Payment</label>
                      <input type="date" name="payment_date" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Mode of Payment</label>
                      <input type="text" name="mop" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">OR Number</label>
                      <input type="text" name="mop_details" class="form-control">
                    </div>
                     <div class="col-6 mb-4">
                     <button class="btn btn-primary" name="payment_submit" type="submit">Submit</button>
                    </div>
                  </div>
                  </form>
              </div>
            </div>
        </div>
      </div>
      <!-- END OF ADD PAYMENT MODAL -->

      <!-- EDIT PAYMENT MODAL -->
      <div class="modal fade" id="editpayment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Payment of: {{$collector_name}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('edit-payment') }}" method="GET" class="d-flex align-items-end">
                      <div class="row">
                      <input type="hidden" name="batch" value="{{ $batch_id }}">
                      <input type="hidden" name="collector" value="{{ $collector_id }}">
                      <input type="hidden" name="collector_name" value="{{ $collector_name }}">
                      <input type="hidden" name="current-balance" id="current-balance">
                      <input type="hidden" name="current-amount" id="current-amount">
                      <input type="hidden" name="payid" id="rowId">
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Amount</label>
                      <input type="number" name="edit-amount" id="edit-amount" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Date of Payment</label>
                      <input type="date" name="edit-payment-date" id="edit-payment-date" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Mode of Payment</label>
                      <input type="text" name="edit-mop" id="edit-mop" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">OR Number</label>
                      <input type="text" name="edit-mop-details" id="edit-mop-details" class="form-control">
                    </div>
                     <div class="col-6 mb-4">
                     <button class="btn btn-primary" name="edit_payment_submit" type="submit">Update Payment</button>
                    </div>
                  </div>
                  </form>
              </div>
            </div>
        </div>
      </div>
      <!-- END OF EDIT PAYMENT MODAL -->

      <script>
        function openLedgerModal() {
          $('#payment_ledger').modal('show');
        }

        function openMakePaymentModal() {
          $('#payment_ledger').addClass('modal-dimmed');
          $('#addpayment').modal('show');
        }

        $('#addpayment').on('hidden.bs.modal', function () {
        $('#payment_ledger').removeClass('modal-dimmed'); });

        function openEditPaymentModal(event) {
          var selectedPaymentId = document.querySelector('input[name="payment_id"]:checked').value;
          var route = event.target.dataset.route.replace('__paymentId__', selectedPaymentId);
          console.log('Route:', route);
                $.ajax({
              url: route,
              method: "GET",
              success: function(data) {
                  // Handle the response data
                  console.log(data);

                  // Populate the form fields with the data
                  $('#rowId').val(selectedPaymentId);
                  $('#edit-amount').val(data.payment_datas[0].paid_amount);
                  $('#current-balance').val(data.payment_datas[0].balance);
                  $('#current-amount').val(data.payment_datas[0].paid_amount);
                  $('#edit-payment-date').val(data.payment_datas[0].payment_date);
                  $('#edit-mop').val(data.payment_datas[0].mop);
                  $('#edit-mop-details').val(data.payment_datas[0].mop_details);
                  $('#payment_ledger').addClass('modal-dimmed');
                  $('#editpayment').modal('show');
              },
              error: function(xhr, status, error) {
                  // Handle the error if any
                  console.log(error);
              }
          });
          $('#rowId').val(selectedPaymentId);
          $('#payment_ledger').addClass('modal-dimmed');
          $('#editpayment').modal('show');
        }

        $('#editpayment').on('hidden.bs.modal', function () {
        $('#payment_ledger').removeClass('modal-dimmed'); });
      </script>

      <script>
        $(function(e) {
          $("#select_all_ids").click(function() {
            $(".payment_ids").prop('checked', $(this).prop('checked'));
          });

          $('#deleted-selected-rows').click(function(e) {
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=payment_id]:checked').each(function() {
              all_ids.push($(this).val());
            });

            $.ajax({
              url: "{{ route('delete-payment') }}",
              type: "DELETE",
              data: {
                ids: all_ids,
                _token: "{{ csrf_token() }}"
              },
              success: function(response) {
                $.each(all_ids, function(key, val) {
                  $("#id_of_payment" + val).remove();
                });
              },
              error: function(xhr, status, error) {
                console.log(xhr.responseText);
              }
            });

          });
        });
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

        $('#code').val(selectedExpensetId);
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

@endsection
