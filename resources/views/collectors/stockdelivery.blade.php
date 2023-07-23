@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row stock-delivery-header">
            <div class="col-5"><h2 class="main-title">Stock Delivery & Payment Summary of {{ $collector_name }}</h2></div>
            <div class="col-2">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addtransaction">
                Add Transaction
              </button>
            </div>
            <div class="col-3">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addtransactionpayment">
                Add Payment
              </button>
              <button class="btn btn-primary" onclick="window.open('{{ route('print-stock-delivery', ['user_id' => $collector_id, 'name' => $collector_name]) }}', '_blank')">Print</button>
            </div>
        </div>
        <div class="row container">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="table table-striped posts-table" id="stockdelivery-table">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>Date</th>
                    <th>Description</th>
                    <th>DR Number</th>
                    <th>Delivery</th>
                    <th>Payment</th>
                    <th>Balance</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($stock_deliveries as $key => $stock_delivery)
                      <tr>
                          <td class="covered_date">{{ ($stock_delivery->covered_date == null) ? '' : $stock_delivery->covered_date}}</td>
                          <td class="description">{{ $stock_delivery->description }}</td>
                          <td class="dr_num">{{ ($stock_delivery->dr_num == null) ? '' : $stock_delivery->dr_num }}</td>
                          <td>{!! ($stock_delivery->total_delivery == null) ? '' : '&#8369; ' . number_format($stock_delivery->total_delivery, 2) !!}</td>
                          <td class="amount_paid">{!! ($stock_delivery->amount_paid == null) ? '0' : '&#8369; ' . number_format($stock_delivery->amount_paid,2) !!}</td>
                          <td>&#8369; {{ number_format($stock_delivery->balance,2)  }}</td>
                          <td class="text-center">
                              <span class="p-relative">
                                  <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                                  <ul class="dropdown-menu">
                                  {!! ($stock_delivery->dr_num != null) ?
                                      '<li><a class="dropdown-item fs-6 edit-transaction" data-bs-toggle="modal" data-bs-target="#edittransaction" data-tid="' . $stock_delivery->id . '" data-total-delivery="' . $stock_delivery->total_delivery . '" data-credit-limit="' . $stock_delivery->credit_limit . '">Edit Transaction</a></li>' :
                                      '<li><a class="dropdown-item fs-6 edit-payment" data-bs-toggle="modal" data-bs-target="#edittransactionpayment" data-pid="' . $stock_delivery->id . '" data-amount-paid="' . $stock_delivery->amount_paid . '">Edit Payment</a></li>'
                                  !!}
                                      <li><a class="dropdown-item fs-6" href="{{ route('delete-stock-delivery', ['user_id' => $collector_id, 'name' => $collector_name, 't_id' => $stock_delivery->id]) }}" onclick="return confirm('Are you sure you want to delete this row')">Trash</a></li>
                                  </ul>
                              </span>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
              </table>
              <script>
                $(document).ready(function() {
                    $('#stockdelivery-table').DataTable({
                        paging: false,
                        lengthChange: false,
                        ordering: false,
                    });
                });
            </script>
            </div>
          </div>
        </div>
      </div>

      <div class="scroll-to-bottom-container">
        <button class="scroll-to-bottom" style="background:none"><iconify-icon icon="formkit:arrowdown"></iconify-icon></button>
      </div>

      <!-- ADD TRANSACTION MODAL -->
      <div class="modal fade" id="addtransaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Transaction</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-stock-delivery') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Covered Date:</label>
                      <input type="hidden" name="am_id" value="{{ $collector_id }}">
                      <input type="hidden" name="name" value="{{ $collector_name }}">
                      <input type="date" class="form-control border border-secondary-subtle" name="covered_date" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">DR Number:</label>
                      <input type="text" class="form-control border border-secondary-subtle" name="dr_num" required>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Description:</label>
                      <input type="text" class="form-control border border-secondary-subtle" name="description" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Credit Limit:</label>
                      <input type="number" step="any" min="0" class="form-control border border-secondary-subtle" name="credit_limit">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Total Delivery:</label>
                      <input type="number" step="any" min="0" class="form-control border border-secondary-subtle" name="total_delivery" required>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <input type="submit" value="Add Transaction" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD TRANSACTION MODAL -->

      <!-- ADD TRANSACTION PAYMENT MODAL -->
      <div class="modal fade" id="addtransactionpayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Payment</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-stock-payment') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    @php
                      $balance = 0;
                      @endphp
                    @foreach($stock_deliveries as $stock_delivery)
                          @php
                          $balance = $stock_delivery->balance;
                          @endphp
                      @endforeach
                      <input type="hidden" name="am_id" value="{{ $collector_id }}">
                      <input type="hidden" name="name" value="{{ $collector_name }}">
                      <input type="hidden" name="balance" value="{{ $balance }}">
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Amount:</label>
                      <input type="text" class="form-control border border-secondary-subtle" name="amount_paid" required>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Description:</label>
                      <input type="text" class="form-control border border-secondary-subtle" name="description" required>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <input type="submit" value="Add Payment" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD TRANSACTION PAYMENT MODAL -->

      <!-- EDIT TRANSACTION MODAL -->
      <div class="modal fade" id="edittransaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Transaction</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('edit-stock-delivery') }}" method="POST">
                @csrf
              <div class="modal-body">
                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Covered Date:</label>
                      <input type="hidden" name="am_id" value="{{ $collector_id }}">
                      <input type="hidden" name="name" value="{{ $collector_name }}">
                      <input type="hidden" name="e_tid" id="e_tid">
                      <input type="date" class="form-control border border-secondary-subtle" name="e_covered_date" id="e_covered_date">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">DR Number:</label>
                      <input type="text" class="form-control border border-secondary-subtle" name="e_dr_num" id="e_dr_num">
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Description:</label>
                      <input type="text" class="form-control border border-secondary-subtle" name="e_description" id="e_description">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Credit Limit:</label>
                      <input type="number" step="any" min="0" class="form-control border border-secondary-subtle" name="e_credit_limit" id="e_credit_limit">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Total Delivery:</label>
                      <input type="number" step="any" min="0" class="form-control border border-secondary-subtle" name="e_total_delivery" id="e_total_delivery">
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <input type="submit" value="Update Transaction" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF EDIT TRANSACTION MODAL -->

      <!-- EDIT TRANSACTION PAYMENT MODAL -->
      <div class="modal fade" id="edittransactionpayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Payment</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('edit-stock-payment') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                      <input type="hidden" name="am_id" value="{{ $collector_id }}">
                      <input type="hidden" name="name" value="{{ $collector_name }}">
                      <input type="hidden" name="e_pid" id="e_pid">
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Amount:</label>
                      <input type="number" class="form-control border border-secondary-subtle" name="ep_amount_paid"  id="ep_amount_paid">
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Description:</label>
                      <input type="text" class="form-control border border-secondary-subtle" name="ep_description" id="ep_description">
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <input type="submit" value="Edit Payment" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF EDIT TRANSACTION PAYMENT MODAL -->

      <script>
        $(document).on('click', '.edit-transaction', function() {
          var _this = $(this).parents('tr');
          var transaction_id = $(this).data('tid');
          var total_delivery = $(this).data('total-delivery');
          var credit_limit = $(this).data('credit-limit');

          $('#e_tid').val(transaction_id);
          $('#e_covered_date').val(_this.find('.covered_date').text());
          $('#e_dr_num').val(_this.find('.dr_num').text());
          $('#e_description').val(_this.find('.description').text());
          $('#e_credit_limit').val(credit_limit);
          $('#e_total_delivery').val(total_delivery);
        })
      </script>

      <script>
        $(document).on('click', '.scroll-to-bottom', function() {
          window.scrollTo(0, document.body.scrollHeight);
        });
      </script>

      <script>
        $(document).on('click', '.edit-payment', function() {
          var _this = $(this).parents('tr');
          var pid = $(this).data('pid');
          var amount_paid = $(this).data('amount-paid');

          $('#e_pid').val(pid);
          $('#ep_amount_paid').val(amount_paid);
          $('#ep_description').val(_this.find('.description').text());
        })
      </script>

@endsection


