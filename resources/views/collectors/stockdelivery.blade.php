@extends("layout.design")

@section ("contents")

<div class="container" style="overflow-x: hidden;">
  <div class="info-and-trans-details">
    <div class="row pb-2">
      <div class="col-3" style="font-size:14px">
          <h5 class="pb-2" style="border-bottom: 1px solid #cbcbcb"><strong>Personal Information</strong></h5>
          @foreach($am_infos as $am_info)
          <div class="row">
              <div class="col-3">Fullname:</div>
              <div class="col-8"><strong>{{ $am_info->name }}</strong></div>
          </div>
          <div class="row">
              <div class="col-3">Mobile:</div>
              <div class="col-9"><strong>{{ $am_info->contact }}</strong></div>
          </div>
          <div class="row">
              <div class="col-3">Address:</div>
              <div class="col-9"><strong class="text-capitalize">{{ $am_info->address }}</strong></div>
          </div>
          <div class="row">
              <div class="col-3">Birthdate:</div>
              <div class="col-9"><strong>{{ date('m-d-Y', strtotime($am_info->birthday)) }}</strong></div>
          </div>
      </div>
      <div class="col-3" style="font-size:14px">
          @php
          $total_payments = 0;
          $prev_bal = 0;
          $total_bal = 0;
          $latest_del = 0;
          $total_del = 0;
          $available_credit = 0;
          @endphp
          @foreach($stock_deliveries as $stock_delivery)
          @php
          $total_payments += $stock_delivery->amount_paid;
          $total_bal = $stock_delivery->balance;
          $total_del += $stock_delivery->total_delivery;
          $available_credit = $creditLimit - $total_bal;
          @endphp
          @endforeach
          <h5 class="pb-2" style="border-bottom: 1px solid #cbcbcb"><strong>General Transaction</strong></h5>
          <div class="row mt-1">
              <div class="col-6">Credit Limit:</div>
              <div class="col-6" style="color: {{ $total_bal > $creditLimit ? 'red' : 'black' }}">&#8369; {{ number_format($creditLimit, 2) }}
              </div>
          </div>
          <div class="row">
              <div class="col-6">Total Delivery:</div>
              <div class="col-6">&#8369; {{ number_format($total_del,2) }}
              </div>
          </div>
          <div class="row">
              <div class="col-6">Total Payments:</div>
              <div class="col-6">&#8369; {{ number_format($total_payments,2) }}</div>
          </div>
          <div class="row">
              <div class="col-6">Prev. Balance:</div>
              <div class="col-6">&#8369; {{ number_format(@$previousDelivery->balance,2) }}</div>
          </div>
      </div>
      <div class="col-3" style="font-size:14px">
          <h5 class="pb-2" style="border-bottom: 1px solid #cbcbcb"><strong>Latest Transaction</strong></h5>
          <div class="row mt-1">
              <div class="col-6">Avail. Credit Amount:</div>
              <div class="col-6" style="color: {{ $total_bal > $creditLimit ? 'red' : 'black' }}">&#8369; {{ number_format($available_credit,2) }}</div>
          </div>
          <div class="row">
              <div class="col-6">Latest Payments:</div>
              <div class="col-6">&#8369; {{ number_format(@$latestPayments,2) }}</div>
          </div>
          <div class="row">
              <div class="col-6">Latest Delivery:</div>
              <div class="col-6">&#8369; {{ number_format(@$latestDelivery->total_delivery,2) }}</div>
          </div>
          <div class="row">
              <div class="col-6">Total Balance:</div>
              <div class="col-6" style="color: {{ $total_bal > $creditLimit ? 'red' : 'black' }}">&#8369; {{ number_format($total_bal,2) }}</div>
          </div>
      </div>
      @endforeach
      <div class="col-3">
        <form class="row g-3" action="{{ route('filter-stock-delivery', ['user_id' => $collector_id, 'name' => $collector_name]) }}" id="covered-date" method="POST">
        @csrf
          <div class="col-auto">
            <label for="" class="form-label">From</label>
            <input type="date" name="covered-from" class="form-control form-control-sm covered-from">
          </div>
          <div class="col-auto">
            <label for="" class="form-label">To</label>
                <input type="date" name="covered-to" class="form-control form-control-sm covered-to">
          </div>
          <div class="col-auto">
            <button type="submit" name="covered-date-button" id="covered-date-button" class="btn btn-primary btn-sm mb-3">Submit</button>
          </div>
        </form>
      </div>
  </div>
  <div class="row">
      <div class="input-group">
        <div class="mb-2 mx-2">
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addtransaction">
            Add Transaction
          </button>
        </div>
        <div class="mb-2 mx-2">
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addtransactionpayment">
            Add Payment
          </button>
        </div>
        <div class="mb-2">
          <button class="btn btn-primary btn-sm" onclick="window.open('{{ route('print-stock-delivery', ['user_id' => $collector_id, 'name' => $collector_name, 'start-date' => $startDate, 'end-date' => $endDate ]) }}', '_blank')">Print File</button>
        </div>
      </div>
  </div>
  </div>
  <div class="row container trans-table-container">
    <div class="col-lg-12">
      <div class="users-table table-wrapper">
        <table class="table table-striped posts-table align-middle" id="stockdelivery-table">
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
                      <label for="" class="form-label">Date</label>
                      <input type="date" class="form-control" name="payment_date">
                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    var containerHeight = $('.info-table-container').height(); // Get the height of the container
    var contentHeight = $('.info-table-container')[0].scrollHeight; // Get the total scrollable content height

    $('.info-table-container').scrollTop(contentHeight - containerHeight); // Scroll to the last record
  });
</script>

<!-- <script>
$(document).ready(function() {
    var dataTable = $('#stockdelivery-table').DataTable({
        paging: false,
        lengthChange: false,
        ordering: false,
    });

    $('#covered-date-button').on('click', function() {
        var fromDate = $('.covered-from').val();
        var toDate = $('.covered-to').val();

        $.ajax({
            url: "{{ route('date-covered-sdps') }}",
            type: "POST", // Change the request method to POST
            data: {
                "_token": "{{ csrf_token() }}",
                "fromDate": fromDate,
                "toDate": toDate
            },
            success: function(response) {
                console.log(fromDate, toDate);
                console.log(response); // Check the response data in the browser console
                dataTable.clear().rows.add(response.data).draw();
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    });
});
</script> -->
@endsection


