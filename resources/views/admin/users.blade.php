@extends("layout.design")

@section ("contents")
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="container">
        <h2 class="main-title">Users</h2>
        <div class="row stat-cards">
          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon primary">
                <iconify-icon icon="fluent:money-16-filled"></iconify-icon>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">&#8369; 500,000.00</p>
                <p class="stat-cards-info__title">Total Collections</p>
              </div>
            </article>
          </div>
          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon warning">
                <iconify-icon icon="fluent-mdl2:product-list"></iconify-icon>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">1200</p>
                <p class="stat-cards-info__title">Total Products</p>
              </div>
            </article>
          </div>
          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon purple">
                <iconify-icon icon="fa:group"></iconify-icon>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">850</p>
                <p class="stat-cards-info__title">Total Collectors</p>
              </div>
            </article>
          </div>
          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon success">
                <iconify-icon icon="mingcute:group-fill"></iconify-icon>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">100</p>
                <p class="stat-cards-info__title">Total Employees</p>
              </div>
            </article>
          </div>
        </div>
          <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-3">
                <a type="button" class="btn btn-primary" href="{{route('get_user_create')}}">Add</a>
                </div>
            </div>
            <div class="users-table table-wrapper">
              <table class="posts-table">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>ID</th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{App\Models\Constants::getRolevalue()[$user->role]}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td><span class="badge-pending">{{ App\Models\Constants::getAccountStatusValue()[$user->approval_status]}}</span></td>
                        <td class="text-center">
                            <span class="p-relative">
                            <button class="btn p-0" data-bs-toggle="dropdown" aria-expande="false"><iconify-icon icon="gg:more-r"></iconify-icon></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item fs-6" href="#">View</a></li>
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

@endsection
