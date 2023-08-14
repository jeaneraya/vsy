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
    <h4 style="border-bottom:1px solid #cbcbcb" class="text-center py-2">Accounts Payable Summary</h4>
    <p class="p-0 text-center"><em>Period Covered: </em></p>
    </div>
    <div class="row">
        <table class="table table-striped" style="font-size: 13px;">
            <thead style="padding-left:1em">
              <tr class="users-table-info">
                <th>#</th>
                <th>Date</th>
                <th>Pay To</th>
                <th>Remarks</th>
                <th>Payment Info</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
                @php
                $amount_payable = 0;
                @endphp
              @foreach($accounts_payable as $key => $ap)
              @php
                $amount_payable += $ap->amount_paid;
              @endphp
                  <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $ap->schedule_date }}</td>
                      <td>{{ $ap->name }}</td>
                      <td>{{ $ap->remarks }}</td>
                      <td>{{ $ap->bank }} {{$ap->check_num}}</td>
                      <td>&#8369; {{ number_format($ap->amount_paid,2)  }}</td>
                  </tr>
              @endforeach
          </tbody>
          <tfoot>
            <tr>
                <td colspan="4"></td>
                <td><strong>TOTAL:</strong></td>
                <td><strong>&#8369; {{ number_format($amount_payable,2) }}</strong></td>
            </tr>
          </tfoot>
          </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

</body>

</html>