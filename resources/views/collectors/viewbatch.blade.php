@extends("layout.design")

@section ("contents")

<div class="container-fluid view-batch">
        <div class="sticky-container">
        <div class="row">
            <div class="col-6"><h2 class="main-title">Batch # @foreach($transactions as $transaction){{ $transaction->num }}@endforeach of {{ $collector_name }}</h2></div>
            <div class="col-6">
              <div class="btn-group">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDeliveryYarn">Add Delivery</button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" role="button" data-bs-toggle="collapse" href="#addproductstobatch">Add Products</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" role="button" data-bs-toggle="collapse" href="#addexpensestobatch">Add Expenses</a></li>
                </ul>
              </div>
              <button class="btn btn-primary" onclick="openLedgerModal()">Payment</button>
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Print Files
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" onclick="window.open('{{ route('credit-computation', ['collector_id' => $collector_id,'batch_id' => $batch_id ,'name' => $collector_name]) }}', '_blank')">Credit Computation</a></li>
                  <li><a class="dropdown-item" onclick="window.open('{{ route('trust-receipt', ['collector_id' => $collector_id,'batch_id' => $batch_id ,'name' => $collector_name]) }}', '_blank')">Trust Receipt Aggreement</a></li>
                  <li><a class="dropdown-item" onclick="window.open('{{ route('print-expenses-summary', ['collector_id' => $collector_id,'batch_id' => $batch_id ,'name' => $collector_name]) }}', '_blank')">Expenses Summary</a></li>
                  <li><a class="dropdown-item" onclick="window.open('{{ route('print-withdrawals-returns', ['collector_id' => $collector_id,'batch_id' => $batch_id ,'name' => $collector_name]) }}', '_blank')">Withdrawals & Returns</a></li>
                </ul>
              </div>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyoffset">
                Apply Offset Balance
              </button>
            </div>
        </div>
        <hr>
        </div>
    </div>
        <div class="container view-batch">
        <div class="row container">
          <div class="col-lg-12">
            <h5 class="text-center"><strong>Deliveries</strong></h5>
            </div>
            <div class="users-table table-wrapper">
              <table id="deliveries_table" class="table table-striped posts-table align-middle" style="width:100%">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Dr Number</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @php
                  $total = 0;
                @endphp
                @foreach($batch_deliveries as $key => $bd)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $bd->dr_num }}</td>
                        <td>{{ $bd->date_withdrawn }}</td>
                        <td>{{ $bd->remarks }}</td>
                        <td>{{ $bd->amount }}</td>
                        <td class="text-center">
                          <span class="p-relative">
                              <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                              <ul class="dropdown-menu">
                                  <li><a href="{{ route('collectorsWithdrawal', ['name' => $collector_name,'batch_id' => $batch_id, 'batch_delivery_id' => $bd->id]) }}" class="dropdown-item">View Withdrawals</a></li>
                                  <li><a class="dropdown-item edit-batch-delivery" data-id="{{$bd->id}}" data-dr-num="{{$bd->dr_num}}" data-date-withdrawn="{{$bd->date_withdrawn}}" data-remarks="{{$bd->remarks}}" data-amount="{{$bd->amount}}">Edit</a></li>
                                  <li><a href="{{ route('delete-delivery-trans', ['name' => $collector_name,'batch_id' => $batch_id, 'batch_delivery_id' => $bd->id]) }}" class="dropdown-item" onclick="return confirm('Are You Sure You Want to Delete this Transaction?')">Delete</a></li>
                              </ul>
                          </span>
                      </td>
                    </tr>
                    @php
                      $total += $bd->amount;
                    @endphp
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4"></td>
                  <td colspan="2" align="right"><strong>Total: </strong>&#8369; {{ number_format($total,2) }}</td>
                </tr>
              </tfoot>
              </table>
            </div>
          </div>
          <script>
            $(document).ready(function() {
              $('#deliveries_table').DataTable();
            });
          </script>
        </div>
      </div>

      <div class="scroll-to-bottom-container">
        <button class="scroll-to-bottom" style="background:none"><iconify-icon icon="formkit:arrowdown"></iconify-icon></button>
      </div>

      <!-- ADD DELIVERY -->
      <div class="modal fade" id="addDeliveryYarn" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="batchDeliveryTitle">Add New Delivery</h1>
              <button type="button" class="btn-close btn-delivery-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{route('add-delivery-transaction')}}" method="POST" id="delivery_form">
                @csrf
                <div class="row">
                  <div class="col-6">
                    <label for="" class="form-label">DR Number</label>
                    <input type="hidden" name="batch_id" id="bd_batch_id" value="{{$batch_id}}">
                    <input type="hidden" name="collector_id" id="bd_collector_id" value="{{$collector_id}}">
                    <input type="text" class="form-control" name="dr_num" id="dr_num">
                  </div>
                  <div class="col-6">
                    <label for="" class="form-label">Transaction Date</label>
                    <input type="date" class="form-control" name="date_withdrawn" id="date_withdrawn">
                  </div>
                  <div class="col-12">
                    <label for="" class="form-label">Amount</label>
                    <input type="number" class="form-control" name="amount" id="amount">
                  </div>
                  <div class="col-12">
                    <label for="" class="form-label">Remarks</label>
                    <input type="text" class="form-control" name="remarks" id="remarks">
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save Transaction</button>
            </div>
          </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD DELIVERY -->

      <!-- OFFSET BALANCE -->
      <div class="modal fade" id="applyoffset" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Apply Previous Balance</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('apply-offset', ['collector_id' => $collector_id,'batch_id' => $batch_id]) }}" method="POST">
                @csrf
                <div class="row">
                  @foreach($offset_balances as $ob)
                  <div class="col-6">
                    <label for="" class="form-label">Batch #</label>
                    <input type="number" class="form-control" value="{{$ob->num}}" readonly>
                    <input type="hidden" value="{{$ob->id}}">
                  </div>
                  <div class="col-6">
                    <label for="" class="form-label">Previous Balance</label>
                    <input type="number" class="form-control" value="{{$ob->offset_balance}}" readonly>
                  </div>
                  @endforeach
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="apply">Apply Offset Balance</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- END OF OFFSET BALANCE -->
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
                @php
                  $status = [
                      0 => 'In-active',
                      1 => 'Active'
                    ];
                    $interest_rate = 0;
                  @endphp
                  @foreach($transactions as $transaction)
                  @php
                  $interest_rate = $transaction->addon_interest;
                  @endphp
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
                      <div class="col-4"><strong>Batch #:</strong></div>
                      <div class="col-8">{{ $transaction->num }}</div>
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
                      <div class="col-7">{!! $status[$transaction->status] !!}</div>
                    </div>
                    <div class="row">
                      <div class="col-5"><strong>Total as Capital:</strong></div>
                      <div class="col-7">&#8369;{{ number_format($total + $totalExpenses,2) }}</div>
                    </div>
                    <div class="row">
                      <div class="col-5"><strong>Interest:</strong></div>
                      <div class="col-7">&#8369; {{ number_format($totalExpenses * ($interest_rate/100),2) }}</div>
                    <div class="row">
                      @php
                      $total_payment = 0; 
                      @endphp

                      @foreach($payments as $payment)
                          @php
                          $total_payment += $payment->paid_amount;
                          @endphp
                      @endforeach
                      <div class="col-7"><strong>Total Payment:</strong></div>
                      <div class="col-5">&#8369; {{ number_format($total_payment,2) }}</div>
                    </div>
                    <div class="row">
                      <div class="col-7"><strong>Remaining Balance:</strong></div>
                      <div class="col-5">&#8369; {{ ($payment_balance == 0) ? number_format($total + $totalExpenses + ($totalExpenses * ($interest_rate/100)),2) : number_format($payment_balance,2) }}</div>
                    </div>
                  </div>
                  @endforeach
                </div>
                <hr/>
                <table class="table-striped w-100" style="font-size:14px">
                  <thead>
                    <th><input type="checkbox" class="form-check-input" id="select_all_ids"></th>
                    <th>#</th>
                    <th>Payment Sched</th>
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
                        <td>{{ $payment->payment_sched }}</td>
                        <td>{!! ($payment->payment_date == null) ? '00-00-0000' : $payment->payment_date !!}</td>
                        <td>{!! ($payment->days == null) ? 0 : $payment->days !!}</td>
                        <td>&#8369; {{ number_format($payment->paid_amount,2) }}</td>
                        <td>&#8369; {{ number_format($payment->balance,2) }}</td>
                        <td>{{ $payment->mop }}</td>
                        <td>{{ $payment->mop_details }}</td>
                    </tr>
                @endforeach
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <!-- <button class="btn btn-primary" onclick="openMakePaymentModal()">Make Payment</button> -->
                <button class="btn btn-primary" onclick="openEditPaymentModal(event)" data-route="{{ route('payment-data', ['id' => '__paymentId__']) }}">Payment</button>
                <a class="btn btn-secondary" href="{{ route('offset-balance', ['batch-id'=>$batch_id, 'balance' => $payment_balance]) }}">Offset Balance</a>
                <!-- <button class="btn btn-danger" id="deleted-selected-rows">Delete Payment</button> -->
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
                      <input type="number" name="total_credit" value="{{ ($payment_balance == 0) ? $total + $totalExpenses + ($totalExpenses * ($interest_rate/100)) : $payment_balance }}" hidden>
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
                <h1 class="modal-title fs-5">Payment of: {{$collector_name}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('edit-payment') }}" method="GET" class="d-flex align-items-end">
                      <div class="row">
                      <input type="hidden" name="batch" value="{{ $batch_id }}">
                      <input type="hidden" name="collector" value="{{ $collector_id }}">
                      <input type="hidden" name="collector_name" value="{{ $collector_name }}">
                      <input type="hidden" name="current-balance" id="current-balance" value="{{ ($payment_balance == 0) ? $total + $totalExpenses + ($totalExpenses * ($interest_rate/100)) : $payment_balance }}">
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

      <!-- RETURN ITEMS MODAL -->
      <div class="modal fade" id="returnitems" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Return Item</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('return-item') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-6 mb-4">
                  <label for="" class="form-label">Product Code</label>
                  <input type="hidden" name="r_et_id" id="r_et_id">
                  <input type="hidden" name="batch" value="{{ $batch_id }}">
                  <input type="hidden" name="collector" value="{{ $collector_id }}">
                  <input type="hidden" name="collector_name" value="{{ $collector_name }}">
                  <input class="form-control" type="text" name="r_product_code" id="r_product_code">
                </div>
                <div class="col-6 mb-4">
                  <label for="" class="form-label">Description</label>
                  <input type="hidden" id="r_batch_id" name="r_batch_id">
                  <input class="form-control" type="text" name="r_description" id="r_description">
                </div>
                <div class="col-6 mb-4">
                  <label for="" class="form-label">Return Qty</label>
                  <input class="form-control" type="number" min="0" name="return_qty" id="return_qty">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save Data</button>
            </form>
            </div>
          </div>
        </div>
      </div>
      <!-- END OF RETURN ITEMS MODAL -->

      <script>
  $(document).ready(function() {
    $(document).on('click','.edit-batch-delivery', function() {

$('#addDeliveryYarn').modal('show');

var id = $(this).data('id');
var dr_num = $(this).data('dr-num');
var date_withdrawn = $(this).data('date-withdrawn');
var remarks = $(this).data('remarks');
var amount = $(this).data('amount');
var url = "/collectors/" + id + "/edit";

$('#dr_num').val(dr_num);
$('#date_withdrawn').val(date_withdrawn);
$('#remarks').val(remarks);
$('#amount').val(amount);
$('#delivery_form').attr('action', url);
$('#batchDeliveryTitle').text('Edit Delivery');
});
  }) 
</script>

      <script>
        $(document).on('click', '.scroll-to-bottom', function() {
          window.scrollTo(0, document.body.scrollHeight);
        });
      </script>

      <script>
        function openLedgerModal() {
          $('#payment_ledger').modal('show');
        }

        function openMakePaymentModal() {
          // $('#payment_ledger').addClass('modal-dimmed');
          $('#addpayment').modal('show');
        }

        $('#addpayment').on('hidden.bs.modal', function () {
        // $('#payment_ledger').removeClass('modal-dimmed'); 
      });

        function openEditPaymentModal(event) {
          var selectedPaymentId = document.querySelector('input[name="payment_id"]:checked').value;
          var route = event.target.dataset.route.replace('__paymentId__', selectedPaymentId);
          console.log('Route:', route);
                $.ajax({
              url: route,
              method: "GET",
              success: function(data) {

                  //console.log(data);

                  $('#rowId').val(selectedPaymentId);
                  $('#edit-amount').val(data.payment_datas[0].paid_amount);
                  // $('#current-balance').val(data.payment_datas[0].balance);
                  $('#current-amount').val(data.payment_datas[0].paid_amount);
                  $('#edit-payment-date').val(data.payment_datas[0].payment_date);
                  $('#edit-mop').val(data.payment_datas[0].mop);
                  $('#edit-mop-details').val(data.payment_datas[0].mop_details);
                  // $('#payment_ledger').addClass('modal-dimmed');
                  $('#editpayment').modal('show');
              },
              error: function(xhr, status, error) {

                  console.log(error);
              }
          });
          $('#rowId').val(selectedPaymentId);
          // $('#payment_ledger').addClass('modal-dimmed');
          $('#editpayment').modal('show');
        }

        $('#editpayment').on('hidden.bs.modal', function () {
        // $('#payment_ledger').removeClass('modal-dimmed'); 
      });
      </script>

      <script>
        $(function() {
          $("#select_all_ids").click(function() {
            $(".payment_ids").prop('checked', $(this).prop('checked'));
          });

          $('#deleted-selected-rows').click(function() {
            // e.preventDefault();
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
                location.reload();
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

        $(document).on('click', '.btn-delivery-close', function() {
          var origUrl = "{{ route('add-delivery-transaction') }}";

          $('#dr_num').val('');
          $('#date_withdrawn').val('');
          $('#remarks').val('');
          $('#amount').val('');
          $('#delivery_form').attr('action', origUrl);
          $('#batchDeliveryTitle').text('Add New Delivery');
        })
    });
</script>




@endsection
