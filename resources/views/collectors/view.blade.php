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
            <div class="col-3">
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Select Items to Display
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('collectors.show', ['id' => $collector_id, 'name' => $collector_name]) }}">Show Active</a></li>
                  <li><a class="dropdown-item" href="{{ route('collectors.show-inactive', ['id' => $collector_id, 'name' => $collector_name]) }}">Show In-active</a></li>
                  <li><a class="dropdown-item" href="{{ route('collectors.show-all', ['id' => $collector_id, 'name' => $collector_name]) }}">Show All</a></li>
                </ul>
              </div>
            </div>
        </div>
        <div class="row container">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="table table-striped posts-table align-middle" id="batches-table">
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
                  @php
                  $status = [
                      0 => '<span class="badge-trashed">In-active</span>',
                      1 => '<span class="badge-success">Active</span>'
                    ];
                  @endphp
                @foreach($batch_trans as $key => $batch_tran)
                    <tr>
                        <td class="batch_num">{{ $batch_tran->num }}</td>
                        <td class="t_period_from">{{ $batch_tran->period_from }}</td>
                        <td class="t_period_to">{{ $batch_tran->period_to }}</td>
                        <td class="t_status">{!! $status[$batch_tran->status] !!}</td>
                        <td class="text-center">
                            <span class="p-relative">
                                <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item fs-6" href="{{ route('collectors.withdrawals', ['collector_id' => $batch_tran-> collector_id, 'batch_id' => $batch_tran->id, 'name' => $collector_name]) }}">View</a></li>
                                    <li><a class="dropdown-item fs-6 edit-batch" data-bs-toggle="modal" data-bs-target="#editBatch" data-id="{{ $batch_tran->id  }}" data-status="{{ $batch_tran->status  }}" data-period-from="{{ $batch_tran->period_from  }}" data-firstcollection = "{{ $batch_tran->first_collection }}" data-remarks = "{{ $batch_tran->remarks }}" data-addon-interest = "{{ $batch_tran->addon_interest }}">Edit</a></li>
                                    <li><a class="dropdown-item fs-6" href="{{ route('delete-batch', ['collector_id' => $batch_tran-> collector_id, 'batch_id' => $batch_tran->id ,'name' => $collector_name]) }}" onclick="return confirm('Are you sure you want to delete this batch?')">Trash</a></li>
                                </ul>
                            </span>
                        </td>
                    </tr>
                @endforeach
              </tbody>
              </table>
              <script>
                $(document).ready(function() {
                  $('#batches-table').DataTable();
                });
              </script>
            </div>
          </div>
        </div>
      </div>

      <!-- ADD BATCH MODAL -->
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
                    <input type="date" class="form-control" id="period_to" name="period_to" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Addon Interest:</label>
                    <input type="number" class="form-control" step="any" id="addon_interest" name="addon_interest">
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">First Collection:</label>
                    <input type="date" class="form-control" id="first_collection" name="first_collection" required>
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
      <!-- END OF ADD BATCH MODAL -->

      <!-- EDIT BATCH MODAL -->
      <div class="modal fade" id="editBatch" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Batch</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('edit-batch') }}" method="POST">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 mb-3">
                      <label for="c" class="form-label">Batch #:</label>
                      <input type="number" name="collector_id" value="{{ $collector_id }}" hidden>
                      <input type="text" name="collector_name" value="{{ $collector_name }}" hidden>
                      <input type="number" id="e_batch_id" name="e_batch_id" hidden>
                      <input type="text" class="form-control" id="e_batch_num" name="e_batch_num"  readonly>
                    </div>
                    <div class="col-6 mb-3">
                      <label class="form-label">Status:</label>
                      <select name="e_status" id="e_status" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">In-active</option>
                      </select>
                    </div>
                </div>
                <div class="row">
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Period From:</label>
                    <input type="date" class="form-control" id="e_period_from" name="e_period_from">
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Period To:</label>
                    <input type="date" class="form-control" id="e_period_to" name="e_period_to">
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Addon Interest:</label>
                    <input type="number" class="form-control" step="any" id="e_addon_interest" name="e_addon_interest">
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">First Collection:</label>
                    <input type="date" class="form-control" id="e_first_collection" name="e_first_collection">
                </div>
                <div class="col-12 mb-3">
                    <label for="" class="form-label">Remarks:</label>
                    <textarea class="form-control" name="e_remarks" id="e_remarks" cols="30" rows="3"></textarea>
                </div>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Update Batch" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD BATCH MODAL -->


      <script>
        $(document).on('click', '.edit-batch', function() {
          var _this = $(this).parents('tr');
          var status = $(this).data('status');
          var periodFrom = $(this).data('period-from');
          var firstcollection = $(this).data('firstcollection');
          var remarks = $(this).data('remarks');
          var addonInterest = $(this).data('addon-interest');
          var id = $(this).data('id');

          $('#e_batch_id').val(id);
          $('#e_batch_num').val(_this.find('.batch_num').text());
          
          $('#e_status').val(status.toString());
          $('#e_period_from').val(periodFrom);
          $('#e_period_to').val(_this.find('.t_period_to').text());
          $('#e_addon_interest').val(addonInterest);
          $('#e_first_collection').val(firstcollection);
          $('#e_remarks').val(remarks);
        })
      </script>

@endsection
