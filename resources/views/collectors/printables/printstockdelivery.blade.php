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

<div class="container mt-3">
{{ now()->format('F j, Y') }}
    <div class="row pb-2 info-and-trans-details mt-4" style="border-bottom: 1px solid #cbcbcb">
        <div class="col-4" style="font-size:14px">
            <h5 class="pb-2" style="border-bottom: 1px solid #cbcbcb"><strong>Personal Information</strong></h5>
            @foreach($am_infos as $am_info)
            <div class="row">
                <div class="col-3">Fullame:</div>
                <div class="col-8"><strong>{{ $am_info->name }}</strong></div>
            </div>
            <div class="row">
                <div class="col-3">Mobile:</div>
                <div class="col-9"><strong>{{ $am_info->contact }}</strong></div>
            </div>
            <div class="row">
                <div class="col-3">Address:</div>
                <div class="col-9"><strong class="text capitalize">{{ $am_info->address }}</strong></div>
            </div>
            <div class="row">
                <div class="col-3">Birthdate:</div>
                <div class="col-9"><strong>{{ date('m-d-Y', strtotime($am_info->birthday)) }}</strong></div>
            </div>
        </div>
        <div class="col-4" style="font-size:14px">
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
        <div class="col-4" style="font-size:14px">
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
            <p>Prepared by: ___________________________ </p><br/>
            <div class="row mb-5">
                <div class="col-6"></div>
                <div class="col-6 text-center">
                    <div class="preparation received-by">
                    Received by: <u style="text-transform:capitalize"><strong class="px-2">{{@$am_info->name}} </strong></u>
                    </div>
                    <div class="signature">Signature Over Printed Name</div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 text-center">
                    <div class="preparation approved-by">
                    Checked and Approved By: <u><strong class="px-2">Virgilio S. Yumul </strong></u>
                    </div>
                    <div class="signature">Signature Over Printed Name</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

</body>

</html>