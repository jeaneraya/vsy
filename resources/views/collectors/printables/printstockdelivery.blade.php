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
        <div class="col-6">
            <h5 class="pb-2" style="border-bottom: 1px solid #cbcbcb"><strong>Personal Information</strong></h5>
            @foreach($am_infos as $am_info)
            <div class="row mt-1">
                <div class="col-3">Code:</div>
                <div class="col-9"><strong>{{ $am_info->code }}</strong></div>
            </div>
            <div class="row">
                <div class="col-3">Name:</div>
                <div class="col-9"><strong>{{ $am_info->name }}</strong></div>
            </div>
            <div class="row">
                <div class="col-3">Contact #:</div>
                <div class="col-9"><strong>{{ $am_info->contact }}</strong></div>
            </div>
            <div class="row">
                <div class="col-3">Address:</div>
                <div class="col-9"><strong>{{ $am_info->address }}</strong></div>
            </div>
            <div class="row">
                <div class="col-3">Birthdate:</div>
                <div class="col-9"><strong>{{ date('m-d-Y', strtotime($am_info->birthday)) }}</strong></div>
            </div>
            @endforeach
        </div>
        <div class="col-6">
            @php
            $total_payments = 0;
            $credit_limit = 0;
            $prev_bal = 0;
            $total_bal = 0;
            $latest_del = 0;
            @endphp
            @foreach($stock_deliveries as $stock_delivery)
            @php
            $total_payments += $stock_delivery->amount_paid;
            $credit_limit = $stock_delivery->credit_limit;
            $total_bal = $stock_delivery->balance;
            $latest_del = $stock_delivery->total_delivery;
            @endphp
            @endforeach
            <h5 class="pb-2" style="border-bottom: 1px solid #cbcbcb"><strong>General Transaction</strong></h5>
            <div class="row mt-1">
                <div class="col-4">Credit Limit:</div>
                <div class="col-8">&#8369; {{ number_format($credit_limit,2) }}</div>
            </div>
            <div class="row">
                <div class="col-5">Total Payments:</div>
                <div class="col-7">&#8369; {{ number_format($total_payments,2) }}</div>
            </div>
            <div class="row">
                <div class="col-5">Previous Balance:</div>
                <div class="col-7">&#8369; {{ number_format($previousBalance,2) }}</div>
            </div>
            <div class="row">
                <div class="col-5">Latest Delivery:</div>
                <div class="col-7">&#8369; {{ number_format($latest_del,2) }}</div>
            </div>
            <div class="row">
                <div class="col-5">Total Balance:</div>
                <div class="col-7">&#8369; {{ number_format($total_bal,2) }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped" style="font-size: 12px;">
            <thead style="padding-left:1em">
              <tr class="users-table-info">
                <th>Date</th>
                <th>Description</th>
                <th>DR Number</th>
                <th>Delivery</th>
                <th>Payment</th>
                <th>Balance</th>
              </tr>
            </thead>
            <tbody>
                @php
                $total_delivery = 0;
                $total_payment = 0;
                $outstanding_balance = 0;
                @endphp
              @foreach($stock_deliveries as $key => $stock_delivery)
              @php
              $total_delivery += $stock_delivery->total_delivery;
              $total_payment += $stock_delivery->amount_paid;
              $outstanding_balance = $stock_delivery->balance;
              @endphp
                  <tr>
                      <td>{{ ($stock_delivery->covered_date == null) ? '' : $stock_delivery->covered_date}}</td>
                      <td>{{ $stock_delivery->description }}</td>
                      <td>{{ ($stock_delivery->dr_num == null) ? '' : $stock_delivery->dr_num }}</td>
                      <td>{!! ($stock_delivery->total_delivery == null) ? '' : '&#8369;' . number_format($stock_delivery->total_delivery, 2) !!}</td>
                      <td>{!! ($stock_delivery->amount_paid == null) ? '0' : '&#8369;'.number_format($stock_delivery->amount_paid,2) !!}</td>
                      <td>&#8369; {{ number_format($stock_delivery->balance,2)  }}</td>
                  </tr>
              @endforeach
          </tbody>
          <tfoot>
            <tr>
                <td></td>
                <td colspan="2"><strong>TOTAL:</strong></td>
                <td>&#8369; {{ number_format($total_delivery,2) }}</td>
                <td>&#8369; {{ number_format($total_payment,2) }}</td>
                <td>&#8369; {{ number_format($outstanding_balance,2) }}</td>
            </tr>
          </tfoot>
          </table>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <p>Prepared by: ___________________________ Date:</p>
            <p align="right" class="mt-4">Received by: ___________________________ Date:</p>
            <p class="mt-4">Checked and Approved By:______________________________ Date:</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

</body>

</html>