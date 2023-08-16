@extends("layout.design")

@section ("contents")

<div class="container">
        <div class="row">
            <div class="col-4"><h2 class="main-title">Expenses</h2></div>
            <div class="col-2"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addexpenses">Add Expenses</button></div>
        </div>
        <div class="row container">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="table table-striped posts-table align-middle" id="main-expenses-table">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th hidden>Addon Interest</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($expenses as $key => $expense)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="code">{{ $expense->code }}</td>
                    <td class="description">{{ $expense->description }}</td>
                    <td class="addon_interest" hidden>{{ $expense->addon_interest }}</td>
                    <td class="text-center">
                        <span class="p-relative">
                        <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fs-6 edit-expenses" data-bs-toggle="modal" data-bs-target="#editExpenses" data-id="{{$expense->id}}">Edit</a></li>
                            <li><a class="dropdown-item fs-6" href="delete-expense/{{$expense->id}}" onclick="return confirm('Are you sure you want to delete this data?')">Trash</a></li>
                        </ul>
                        </span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <script>
                $(document).ready(function() {
                  $('#main-expenses-table').DataTable();
                });
              </script>
            </div>
          </div>
        </div>
      </div>

      <!-- ADD EXPENSES MODAL -->
      <div class="modal fade" id="addexpenses" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Expenses</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add-expenses') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="code" class="form-label">Code:</label>
                      <input type="text" class="form-control border border-secondary-subtle" id="code" name="code" required>
                    </div>
                    <div class="col-6 mb-3 d-none">
                      <label for="" class="form-label">Addon Interest:</label>
                      <input type="number" class="form-control border border-secondary-subtle" step="any" min="0" id="addon_interest" name="addon_interest">
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Description:</label>
                      <textarea class="form-control" name="description" id="description" cols="30" rows="3" required></textarea>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Save Data" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF ADD EXPENSES MODAL -->

      <!-- EDIT EXPENSES MODAL -->
      <div class="modal fade" id="editExpenses" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Expenses</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('edit-expenses') }}" method="POST">
                @csrf
            <div class="modal-body">

                  <div class="row">
                    <div class="col-6 mb-3">
                      <label for="code" class="form-label">Code:</label>
                      <input type="hidden" id="e_expense_id" name="e_expense_id">
                      <input type="text" class="form-control border border-secondary-subtle" id="e_code" name="e_code" required>
                    </div>
                    <div class="col-6 mb-3">
                      <label for="" class="form-label">Addon Interest:</label>
                      <input type="number" class="form-control border border-secondary-subtle" step="any" min="0" id="e_addon_interest" name="e_addon_interest">
                    </div>
                    <div class="col-12 mb-3">
                      <label for="" class="form-label">Description:</label>
                      <textarea class="form-control" name="e_description" id="e_description" cols="30" rows="3" required></textarea>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Update Data" class="btn btn-primary">
            </div>
        </form>
          </div>
        </div>
      </div>
      <!-- END OF EDIT EXPENSES MODAL -->
      
      <script>
        $(document).on('click', '.edit-expenses', function() {
          var _this = $(this).parents('tr');
          var expenses_id = $(this).data('id');

          $('#e_expense_id').val(expenses_id);
          $('#e_code').val(_this.find('.code').text());
          $('#e_addon_interest').val(_this.find('.addon_interest').text());
          $('#e_description').val(_this.find('.description').text());
        })
      </script>

@endsection
