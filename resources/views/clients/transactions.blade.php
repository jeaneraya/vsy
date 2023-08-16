@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title text-capitalize">{{$client_name}}'s Transactions</h2></div>
            <div class="col-2"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addtransaction">Add Transaction</button></div>
            <div class="col-6">
            <form class="row g-3" action="{{ route('filter-client-transactions', ['client_id' => $client_id])}}" id="covered-date" method="POST">
                @csrf
                    <div class="col-auto">
                        <div class="input-group">
                          <span class="input-group-text" id="basic-addon3">From</span>
                          <input type="date" name="covered-from" class="form-control form-control-sm covered-from">
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="input-group">
                          <span class="input-group-text" id="basic-addon3">To</span>
                          <input type="date" name="covered-to" class="form-control form-control-sm covered-to">
                        </div>
                    </div>
                    <div class="col-auto">
                    <button type="submit" name="covered-date-button" id="covered-date-button" class="btn btn-primary btn-sm mb-3 p-2">Submit</button>
                    </div>
                    <div class="col-auto">
                        <a href="{{route('print-client-transactions', ['client_id' => $client_id, 'startDate' => $startDate, 'endDate' => $endDate])}}" target="_blank" class="btn btn-success">Print Report</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row container">
          <div class="col-12">
            <div class="users-table table-wrapper">
              <table class="table table-striped posts-table align-middle" id="clients-transaction-table" style="width:100%">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>Date</th>
                    <th>Ref No.</th>
                    <th>Description</th>
                    <th>Payments</th>
                    <th>Charges</th>
                    <th>Balance</th>
                    <th>Remarks</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($client_trans as $ct)
                  <tr>
                    <td>{{ $ct->trans_date }}</td>
                    <td class="supplier_name">{{ $ct->ref_no }}</td>
                    <td class="supplier_address">{{ $ct->trans_description }}</td>
                    <td class="contact_person">&#8369; {{ number_format($ct->payments,2) }}</td>
                    <td class="contact_num">&#8369; {{ number_format($ct->charges,2) }}</td>
                    <td>&#8369; {{ number_format($ct->balance,2) }}</td>
                    <td>{{ $ct->remarks }}</td>
                    <td class="text-center">
                        <span class="p-relative">
                        <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fs-6 edit-client-trans" data-bs-toggle="modal" data-bs-target="#editclienttrans" data-id = "{{ $ct->id }}">Edit</a></li>
                            <li><a href="{{ route('client-trans-details', ['client_id' => $client_id, 'trans_id' => $ct->id ]) }}" class="dropdown-item">Details</a></li>
                            <li><a class="dropdown-item add-client-payment" onclick="openPaymentModal()" data-tid="{{$ct->id}}" data-balance="{{$ct->balance}}">Payment</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item fs-6 text-danger" href="{{route('delete-client-transaction',['client_id'=>$client_id, 'trans_id' => $ct->id])}}" onclick="return confirm('Are you sure you want to delete this Transaction?')">Trash</a></li>
                        </ul>
                        </span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <script>
                $(document).ready(function() {
                  $('#clients-transaction-table').DataTable();
                });
              </script>
            </div>
          </div>
        </div>
      </div>

      <!-- ADD CLIENTS MODAL -->
      <div class="modal fade" id="addtransaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Transaction</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-client-transaction') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="code" class="form-label">Date:</label>
                      <input type="hidden" name="cid" value={{$client_id}}>
                      <input type="date" class="form-control border border-secondary-subtle" id="trans_date" name="trans_date" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Ref No:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="ref_no" name="ref_no">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Charges:</label>
                      <input type="number" class="form-control border border-secondary-subtle" id="charges" name="charges">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Remarks:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="remarks" name="remarks">
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Description:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="description" name="description" required>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Add Transaction" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD CLIENT MODAL -->

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
                      <input type="text" class="form-control border border-secondary-subtle" id="e-client_name" name="e_client_name" required>
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
              <input type="submit" value="Update Supplier" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF EDIT CLIENT MODAL -->

      <!-- ADD PAYMENT MODAL -->
      <div class="modal fade" id="addpayment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Payment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('add-client-payment') }}" method="GET" class="d-flex align-items-end">
                    @csrf
                    <div class="row">
                      <input type="hidden" name="p_client_id" value={{$client_id}}>
                      <input type="hidden" name="p_tid" id="p_tid">
                      <input type="hidden" name="balance" id="p_balance">
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Amount</label>
                      <input type="number" name="amount" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Date of Payment</label>
                      <input type="date" name="payment_date" class="form-control">
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

      <script>
        $(document).on('click', '.edit-client-data', function(){
            var _this = $(this).parents('tr');
            var client_id = $(this).data('id');
            $('#client_id').val(client_id);
            $('#e-client_name').val(_this.find('.client_name').text());
            $('#e-client_address').val(_this.find('.client_address').text());
            $('#e-contact_person').val(_this.find('.contact_person').text());
            $('#e-contact_num').val(_this.find('.contact_num').text());
        });

        $(document).on('click', '.add-client-payment', function() {
          var tid = $(this).data('tid');
          var balance = $(this).data('balance');

          $('#p_tid').val(tid);
          $('#p_balance').val(balance);

          $('#addpayment').modal('show');
        })
      </script>

@endsection
