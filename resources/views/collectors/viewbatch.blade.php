@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-6"><h2 class="main-title">Batch # {{ $batch_id }} of {{ $collector_name }}</h2></div>
            <div class="col-2"> 
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addpayment">Add Payment</button>
            </div>
            <div class="col-2">
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Add Items
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" role="button" data-bs-toggle="collapse" href="#addproductstobatch">Add Products</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" role="button" data-bs-toggle="collapse" href="#addexpensestobatch">Add Expenses</a></li>
                </ul>
              </div>
            </div>
            <div class="col-2">
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Print Files
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
              </div>
            </div>
        </div>
        <div class="collapse" id="addproductstobatch">
          <div class="card card-body d-flex justify-content-center">
            <h5 class="mb-3"><strong>Add Product</strong></h5>
            <div class="row">
              <div class="col-2">
                <label for="" class="form-label">Product Code</label>
                <input type="text" class="form-control">
              </div>
              <div class="col-2">
                <label for="" class="form-label">Unit</label>
                <select class="form-select" name="" id="">
                  <option value="">Box</option>
                  <option value="">Pc</option>
                  <option value="">Pack</option>
                </select>
              </div>
              <div class="col-2">
                <label for="" class="form-label">Price</label>
                <input type="text" class="form-control">
              </div>
              <div class="col-2">
                <label for="" class="form-label">Total</label>
                <input type="text" class="form-control">
              </div>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="posts-table">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($batch_withdrawals as $key => $withdrawal)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $withdrawal->product_code }}</td>
                        <td>{{ $withdrawal->description }}</td>
                        <td>{{ $withdrawal->qty }}</td>
                        <td>{{ $withdrawal->unit }}</td>
                        <td>{{ $withdrawal->price }}</td>
                        <td>{{ $withdrawal->total_amount }}</td>
                    </tr>
                @endforeach
              </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

@endsection
