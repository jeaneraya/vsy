<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VSY Collection</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <!-- Material Icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <!-- Jquery -->
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>


</head>
<body onload="window.print();">

<div class="container">
    <div class="row pb-2" style="border-bottom: 1px solid #cbcbcb">
    <h4 style="border-bottom:1px solid #cbcbcb" class="text-center py-2">Credit Computation Report</h4>
        <div class="col-6">
            @foreach($users_infos as $am_info)
            <div class="row mt-1">
                <div class="col-3">Code:</div>
                <div class="col-9">{{ $am_info->code }}</div>
            </div>
            <div class="row">
                <div class="col-3">Name:</div>
                <div class="col-9">{{ $am_info->name }}</div>
            </div>
            <div class="row">
                <div class="col-3">Contact #:</div>
                <div class="col-9">{{ $am_info->contact }}</div>
            </div>
        </div>
        <div class="col-6">
            <div class="row mt-1">
                <div class="col-3">Address:</div>
                <div class="col-9">{{ $am_info->address }}</div>
            </div>
            @endforeach
            @php
            $interest_rate = 0;
            $per_month_interest = 0;
            @endphp
            @foreach($transactions as $transaction)
            @php
            $interest_rate = $transaction->addon_interest;
            @endphp
            <div class="row">
                <div class="col-5">Period Covered:</div>
                <div class="col-7"> {{ date('m-d-Y', strtotime($transaction->period_from)) }} to {{ date('m-d-Y', strtotime($transaction->period_to)) }}</div>
            </div>
            <div class="row">
                <div class="col-5">Batch #:</div>
                <div class="col-7"> {{ $transaction->num }}</div>
            </div>
            @endforeach
            @php
            $per_month_interest = $interest_rate/5;
            @endphp
        </div>
    </div>
    <div class="row">
        <table class="table table-striped" style="font-size: 12px;">
            <thead style="padding-left:1em">
              <tr>
                <th colspan="7">Withdrawals Summary</th>
              </tr>
              <tr class="users-table-info">
                <th>Delivered</th>
                <th>Returned</th>
                <th>Sold</th>
                <th>Unit</th>
                <th>Description</th>
                <th>Price</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
                @php
                $total_out = 0;
                $total_return = 0;
                $total_qty = 0;
                $total_sold = 0;
                $grand_total = 0;
                $total_amount_sold = 0;
                $sold_qty = 0;
                @endphp
              @foreach($batch_withdrawals as $bw)
              @php
                $total_out += $bw->qty;
                $total_return += $bw->return_qty;
                $total_qty += $bw->qty - $bw->return_qty;
                $sold_qty = $bw->qty - $bw->return_qty;
                $total_sold = $sold_qty * $bw->price;
                $total_amount_sold += $total_sold;
              @endphp
                  <tr>
                      <td>{{ $bw->qty }}</td>
                      <td>{{ $bw->return_qty }}</td>
                      <td>{{ $bw->qty - $bw->return_qty }}</td>
                      <td>{{ $bw->unit }}</td>
                      <td>{{ $bw->description }}</td>
                      <td>&#8369; {{ number_format($bw->price,2) }}</td>
                      <td>&#8369; {{ number_format($total_sold,2) }}</td>
                  </tr>
              @endforeach
          </tbody>
          <tfoot>
            <tr>
                <td><strong>{{ $total_out }}</strong></td>
                <td><strong>{{ $total_return }}</strong></td>
                <td><strong>{{ $total_qty }}</strong></td>
                <td colspan="2"></td>
                <td><strong>Total:</strong></td>
                <td><strong>&#8369; {{ number_format($total_amount_sold,2) }}</strong></td>
            </tr>
          </tfoot>
          </table>
    </div>
    <div class="row">
        <table class="table table-striped" style="font-size: 12px;">
            <thead style="padding-left:1em">
              <tr>
                <th colspan="2">Expenses Summary</th>
              </tr>
              <tr class="users-table-info">
                <th>Description</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
                @php
                $total_expenses = 0;
                $expenses_with_interest = 0;
                @endphp
              @foreach($expenses_transactions as $et)
              @php
                $total_expenses += $et->amount;
              @endphp
                  <tr>
                      <td>{{ $et->description }}</td>
                      <td>&#8369; {{ number_format($et->amount,2) }}</td>
                  </tr>
              @endforeach
          </tbody>
          <tfoot>
            <tr>
                <td></td>
                <td><strong>&#8369; {{ number_format($total_expenses,2) }}</strong></td>
            </tr>
          </tfoot>
          </table>
    </div>
    <div class="row p-0">
        <table>
            <tbody>
                <tr>
                    <td style="text-align:right; padding-right:5em"><strong>Add: {{$per_month_interest}}% for 5 mos. until the account is fully paid</strong></td>
                    <td>&#8369; {{ $total_expenses*($interest_rate/100) }}</td>
                </tr>
                <tr>
                    <td style="text-align:right; padding-right:5em"><strong>Total Expenses:</strong></td>
                    <td>&#8369; {{ $total_expenses*($interest_rate/100) + $total_expenses }}</td>
                </tr>
                <tr>
                    <td style="text-align:right; padding-right:5em"><strong>Grand Total:</strong></td>
                    <td>&#8369; {{ $total_expenses*($interest_rate/100) + $total_expenses + $total_sold }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <p>Prepared by: ___________________________ Date:</p>
            <p align="right" class="mt-4">Received by: ___________________________ Date:</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

</body>

</html>