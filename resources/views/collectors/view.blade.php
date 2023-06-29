@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-6"><h2 class="main-title">Batch Transactions of {{ $collector_name }}</h2></div>
            <div class="col-2">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addbatch">
                Add Batch
              </button>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="posts-table">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>Batch #</th>
                    <th>Period From</th>
                    <th>Period To</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($batch_trans as $key => $batch_tran)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $batch_tran->period_from }}</td>
        <td>{{ $batch_tran->period_to }}</td>
        <td>{{ $batch_tran->status }}</td>
        <td class="text-center">
            <span class="p-relative">
                <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item fs-6" href="{{ route('collectors.withdrawals', ['collector_id' => $batch_tran-> collector_id, 'batch_id' => $batch_tran->id, 'name' => $collector_name]) }}">View</a></li>
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

      <!-- ADD COLLECTOR MODAL -->
      <div class="modal fade" id="addbatch" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Batch</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-batch') }}" method="POST">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-4 mb-3">
                      <label for="c" class="form-label">Batch #:</label>
                      <input type="text" class="form-control" id="batch_num" name="batch_num" value="{{ $batchTransCount + 1 }}" readonly>
                      <input type="number" name="collector_id" value="{{ $collector_id }}" hidden>
                      <input type="text" name="collector_name" value="{{ $collector_name }}" hidden>
                    </div>
                </div>
                <div class="row">
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Period From:</label>
                    <input type="date" class="form-control" id="period_from" name="period_from" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Period To:</label>
                    <input type="date" class="form-control" id="period_to" name="period_to">
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Addon Interest:</label>
                    <input type="number" class="form-control" step="any" id="addon_interest" name="addon_interest">
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">First Collection:</label>
                    <input type="date" class="form-control" id="first_collection" name="first_collection">
                </div>
                <div class="col-12 mb-3">
                    <label for="" class="form-label">Remarks:</label>
                    <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="3"></textarea>
                </div>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Add Batch" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD COLLECTOR MODAL -->

@endsection
