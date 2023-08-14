@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-3"><h2 class="main-title text-capitalize">AP LISTS</h2></div>
            <div class="col-6">
                <form class="row g-3" action="{{ route('account-payables')}}" id="covered-date" method="POST">
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
                        <a href="{{route('print-account-payables', ['startDate' => $startDate, 'endDate' => $endDate])}}" target="_blank" class="btn btn-success">Print Report</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row container">
          <div class="col-12">
            <div class="users-table table-wrapper">
              <table class="table table-striped posts-table align-middle" id="reports-transaction-table" style="width:100%">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>Date</th>
                    <th>Pay To</th>
                    <th>Remarks</th>
                    <th>Payment Info</th>
                    <th>Amount</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                @php
                $post_status = [
                          0 => '<span class="badge-trashed">Unposted</span>',
                          1 => '<span class="badge-success">Posted</span>',
                      ];
                @endphp
                @foreach ($accounts_payable as $ap)
                <tr>
                    <td>{{ $ap->schedule_date }}</td>
                    <td>{{ $ap->name }}</td>
                    <td>{{ $ap->remarks }}</td>
                    <td>{{ $ap->bank }} {{ $ap->check_num }}</td>
                    <td>&#8369; {{ number_format($ap->amount_paid,2) }}</td>
                    <td>{!! $post_status[$ap->post_status] !!}</td>
                </tr>
                @endforeach
                </tbody>
              </table>
              <script>
                $(document).ready(function() {
                  $('#reports-transaction-table').DataTable();
                });
              </script>
            </div>
          </div>
        </div>
      </div>

      <!-- ADD TRANSACTION MODAL -->
      <div class="modal fade" id="addtransaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Transaction</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-aplist-transaction') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="code" class="form-label">Schedule Date:</label>
                      <input type="hidden" name="ap_id" value="">
                      <input type="date" class="form-control border border-secondary-subtle" id="schedule_date" name="schedule_date" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Amount:</label>
                      <input type="number" class="form-control border border-secondary-subtle" id="amount_payable" name="amount_payable">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Remarks:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="remarks" name="remarks" value="">
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
      <!-- END OF ADD TRANSACTION MODAL -->

      <!-- EDIT SUPPLIER MODAL -->
      <div class="modal fade" id="editsupplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Supplier</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-supplier-form" action="{{ route('edit-supplier') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="code" class="form-label">Supplier's Name:</label>
                      <input type="hidden" id="supplier_id" name="supplier_id">
                      <input type="text" class="form-control border border-secondary-subtle" id="e-supplier_name" name="e_supplier_name" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Supplier's Address:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="e-supplier_address" name="e_supplier_address" required>
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
      <!-- END OF EDIT SUPPLIER MODAL -->

      <!-- ADD PAYMENT MODAL -->
      <div class="modal fade" id="addpayment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Payment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('add-aplist-payment') }}" method="POST" class="d-flex align-items-end">
                    @csrf
                  <div class="row">
                      <input type="hidden" name="p_apid" value="">
                    <div class="col-6 mb-4">
                        <label for="" class="form-label">Schedule Date</label>
                        <input type="date" name="p_schedule_date" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Amount</label>
                      <input type="number" name="p_amount" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Remarks</label>
                      <input type="text" name="p_remarks" value="" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                        <label for="" class="form-label">Payment Type</label>
                        <select name="p_type" class="form-select">
                            <option value="cash">Cash</option>
                            <option value="check">Check</option>
                        </select>
                    </div>
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Bank Name</label>
                      <input type="text" name="p_bank" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                      <label for="" class="form-label">Check #</label>
                      <input type="text" name="p_check_num" class="form-control">
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
        $(document).on('click', '.edit-supplier-data', function(){
            var _this = $(this).parents('tr');
            var supplier_id = $(this).data('id');
            $('#supplier_id').val(supplier_id);
            $('#e-supplier_name').val(_this.find('.supplier_name').text());
            $('#e-supplier_address').val(_this.find('.supplier_address').text());
            $('#e-contact_person').val(_this.find('.contact_person').text());
            $('#e-contact_num').val(_this.find('.contact_num').text());
        });

        $(document).on('click', '.supplier-payment', function() {
          var stid = $(this).data('stid');
          var balance = $(this).data('balance');

          $('#p_stid').val(stid);
          $('#p_balance').val(balance);

          $('#addpayment').modal('show');
        })
      </script>

@endsection
