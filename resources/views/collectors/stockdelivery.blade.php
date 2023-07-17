@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
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
        <div class="row">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="posts-table">
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
                          <td>{{ ($stock_delivery->covered_date == null) ? '' : $stock_delivery->covered_date}}</td>
                          <td>{{ $stock_delivery->description }}</td>
                          <td>{{ ($stock_delivery->dr_num == null) ? '' : $stock_delivery->dr_num }}</td>
                          <td>{!! ($stock_delivery->total_delivery == null) ? '' : '&#8369;' . number_format($stock_delivery->total_delivery, 2) !!}</td>
                          <td>{{ ($stock_delivery->amount_paid == null) ? '0' : $stock_delivery->amount_paid }}</td>
                          <td>&#8369; {{ number_format($stock_delivery->balance,2)  }}</td>
                          <td class="text-center">
                              <span class="p-relative">
                                  <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                                  <ul class="dropdown-menu">
                                      <li><a class="dropdown-item fs-6" href="#">Edit</a></li>
                                      <li><a class="dropdown-item fs-6" href="#">Trash</a></li>
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

@endsection
