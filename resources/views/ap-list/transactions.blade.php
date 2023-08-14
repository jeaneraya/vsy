@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title text-capitalize">{{$ap_name}}</h2></div>
            <div class="col-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addtransaction">Add Transaction</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addpayment">Add Payment</button>
            </div>
        </div>
        <div class="row container">
          <div class="col-12">
            <div class="users-table table-wrapper">
              <table class="table table-striped posts-table align-middle" id="aplist-transaction-table" style="width:100%">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>Date</th>
                    <th>Amount Owed</th>
                    <th>Payments</th>
                    <th>Remarks</th>
                    <th>Balance</th>
                    <th>Posted</th>
                    <th>Type</th>
                    <th>Bank</th>
                    <th>Check #</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                @php
                $post_status = [
                          0 => '<span class="badge-trashed">Unposted</span>',
                          1 => '<span class="badge-success">Posted</span>',
                      ];
                $Balance = 0;
                $newBalance = 0;
                @endphp
                @foreach ($aplist_trans as $at)
                @if ($at->post_status == 1)
        @php
            if ($at->amount_payable != 0) {
                $newBalance += $at->amount_payable; 
            }
            if ($at->amount_paid != 0) {
                $newBalance -= $at->amount_paid; 
            }
        @endphp
    @endif
                <tr>
                    <td>{{ $at->schedule_date }}</td>
                    <td class="supplier_name">&#8369; {{ number_format($at->amount_payable,2) }}</td>
                    <td class="supplier_address">&#8369; {{ number_format($at->amount_paid,2) }}</td>
                    <td>{{ $at->remarks }}</td>
                    <td class="contact_person">&#8369; {{ ($newBalance == 0) ? '0.00' : number_format($newBalance,2) }}</td>
                    <td class="contact_num">{!! $post_status[$at->post_status] !!}</td>
                    <td class="t_balance">{{ $at->type }}</td>
                    <td>{{ $at->bank }}</td>
                    <td>{{ $at->check_num}}</td>
                    <td class="text-center">
                        <span class="p-relative">
                        <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fs-6 edit-supplier-trans" data-bs-toggle="modal" data-bs-target="#editsuppliertrans" data-id = "{{ $at->id }}">Edit</a></li>
                            <li><a href="{{route('post-ap-trans', ['ap_id' => $ap_id, 'detail_id' => $at->id, 'apy' => $at->amount_payable, 'ap' => $at->amount_paid, 'balance' => $at->balance])}}" class="dropdown-item">Post</a></li>
                            <li><hr class="dropdown-divider"></li>
                            @if ($at->post_status == 0)
                            <li><a class="dropdown-item fs-6 text-danger" href="{{route('delete-supplier',['id'=>$at->id])}}" onclick="return confirm('Are you sure you want to delete this Transaction?')">Trash</a></li>
                            @endif
                        </ul>
                        </span>
                    </td>
                </tr>
                @endforeach
                </tbody>
              </table>
              <script>
                $(document).ready(function() {
                  $('#aplist-transaction-table').DataTable();
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
                      <input type="hidden" name="ap_id" value="{{$ap_id}}">
                      <input type="date" class="form-control border border-secondary-subtle" id="schedule_date" name="schedule_date" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Amount:</label>
                      <input type="number" class="form-control border border-secondary-subtle" id="amount_payable" name="amount_payable">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Remarks:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="remarks" name="remarks" value="{{$ap_remarks}}">
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
                      <input type="hidden" name="p_apid" value="{{$ap_id}}">
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
                      <input type="text" name="p_remarks" value="{{$ap_remarks}}" class="form-control">
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
