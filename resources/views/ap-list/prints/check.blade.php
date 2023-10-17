<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-size: 20px;
        }
        .content {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body onload="window.print();">
    <br/>
    <br/>
    <div class="row">
        <div class="col-10"></div>
        <div class="col-2">
            <h6 class="schedule_date">{{$schedule_date}}</h6>
        </div>
        <div class="col-10">
            <h6 class="name">{{$at_name}}</h6>
        </div>
        <div class="col-2">
            <h6 class="amount">{{$amount}}</h6>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>
</body>
</html>
