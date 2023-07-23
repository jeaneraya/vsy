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
    <h4 style="border-bottom:1px solid #cbcbcb" class="text-center py-2">Stocks Withdrawals & Return Summary</h4>
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
            
            @foreach($transactions as $transaction)
            <div class="row">
                <div class="col-5">Period Covered:</div>
                <div class="col-7"> {{ date('m-d-Y', strtotime($transaction->period_from)) }} to {{ date('m-d-Y', strtotime($transaction->period_to)) }}</div>
            </div>
            <div class="row">
                <div class="col-5">Batch #:</div>
                <div class="col-7"> {{ $transaction->num }}</div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <table class="table table-striped" style="font-size: 12px;">
            <thead style="padding-left:1em">
            <tr>
                <th><strong>Delivered Stocks</strong></th>
            </tr>
              <tr class="users-table-info">
                <th>Date</th>
                <th>Ref No.</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Description</th>
                <th>Remarks</th>
                <th>Signature</th>
              </tr>
            </thead>
            <tbody>
            @php 
            $total_qty = 0;
            @endphp
            @foreach($batch_withdrawals as $withdrawals)
            @php 
            $total_qty += $withdrawals->qty
            @endphp
                  <tr>
                      <td>{{ $withdrawals->date_delivered}}</td>
                      <td>{{ $withdrawals->ref_no }}</td>
                      <td>{{ $withdrawals->qty }}</td>
                      <td>{{ $withdrawals->unit }}</td>
                      <td>{{ $withdrawals->description }}</td>
                      <td></td>
                      <td></td>
                  </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td>{{ $total_qty }}</td>
                <td>pcs</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
          </tfoot>
          </table>
    </div>
    <div class="row">
        <table class="table table-striped" style="font-size:12px">
            <thead>
                <tr>
                    <th><strong>Stocks Returned</strong></th>
                </tr>
                <tr>
                    <th>Date</th>
                    <th>Ref No.</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Description</th>
                    <th>Remarks</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_qty_returned = 0;
                @endphp
                @foreach($returned_products as $returns)
                @php 
                $total_qty_returned += $returns->return_qty
                @endphp
                <tr>
                    <td>{{ $returns->date_returned }}</td>
                    <td>{{ $returns->ref_no }}</td>
                    <td>{{ $returns->return_qty }}</td>
                    <td>{{ $returns->unit }}</td>
                    <td>{{ $returns->description }}</td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td>{{ $total_qty_returned }}</td>
                <td>pcs</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
          </tfoot>
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