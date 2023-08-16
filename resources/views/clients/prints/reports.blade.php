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
    <div class="row pb-2">
    <h4 style="border-bottom:1px solid #cbcbcb" class="text-center py-2">Client's Ledger</h4>
    <div class="col-7" style="font-size: 13px;">
        <div class="row">
            <div class="col-4">Client Name:</div>
            <div class="col-8">{{ $client_name }}</div>
        </div>
        <div class="row">
            <div class="col-4">Client Address:</div>
            <div class="col-8">{{ $client_address }}</div>
        </div>
        <div class="row">
            <div class="col-4">Contact Person:</div>
            <div class="col-8">{{ $contact_person }}</div>
        </div>
        <div class="row">
            <div class="col-4">Contact No.:</div>
            <div class="col-8">{{ $contact_num }}</div>
        </div>
    </div>
    <div class="col-5" style="font-size: 13px;">
        <div class="row">
            <div class="col-6">Total Payments:</div>
            <div class="col-6">&#8369; {{ number_format($total_payment,2) }}</div>
        </div>
        <div class="row">
            <div class="col-6">Total Charges:</div>
            <div class="col-6">&#8369; {{ number_format($total_charges,2) }}</div>
        </div>
        <div class="row">
            <div class="col-6">Remaining Balance:</div>
            <div class="col-6">&#8369; {{ number_format($balance,2) }}</div>
        </div>
    </div>
    </div>
    <div class="row">
        <table class="table table-striped" style="font-size: 11px;">
            <thead style="padding-left:1em">
              <tr class="users-table-info">
                <th>#</th>
                <th>Date</th>
                <th>Ref No</th>
                <th>Description</th>
                <th>Payments</th>
                <th>Charges</th>
                <th>Balance</th>
                <th>Remarks</th>
              </tr>
            </thead>
            <tbody>
              @foreach($client_trans as $key => $ct)
                  <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $ct->trans_date }}</td>
                      <td>{{ $ct->ref_no }}</td>
                      <td>{{ $ct->trans_description }}</td>
                      <td>&#8369; {{ number_format($ct->payments,2) }}</td>
                      <td>&#8369; {{ number_format($ct->charges,2) }}</td>
                      <td>&#8369; {{ number_format($ct->balance,2)  }}</td>
                      <td>{{ $ct->remarks }}</td>
                  </tr>
              @endforeach
          </tbody>
          </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

</body>

</html>