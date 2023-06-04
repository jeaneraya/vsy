@extends("layout.design")

@section ("contents")

<div class="container">
        <h2 class="main-title">Dashboard</h2>
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
        <div class="row">
          <div class="col-lg-12">
            <div class="users-table table-wrapper">
              <table class="posts-table">
                <thead style="padding-left:1em">
                  <tr class="users-table-info">
                    <th>#</th>
                    <th>Collector's Name</th>
                    <th>Payment Schedule</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>SARAH DELOS SANTOS</td>
                    <td>06-04-2023</td>
                    <td>&#8369; 80,000.00</td>
                    <td><span class="badge-pending">Pending</span></td>
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
                  <tr>
                    <td>2</td>
                    <td>SARAH DELOS SANTOS</td>
                    <td>06-04-2023</td>
                    <td>&#8369; 80,000.00</td>
                    <td><span class="badge-pending">Pending</span></td>
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
                  <tr>
                    <td>3</td>
                    <td>SARAH DELOS SANTOS</td>
                    <td>06-04-2023</td>
                    <td>&#8369; 80,000.00</td>
                    <td><span class="badge-active">Paid</span></td>
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
                  <tr>
                    <td>4</td>
                    <td>SARAH DELOS SANTOS</td>
                    <td>06-04-2023</td>
                    <td>&#8369; 80,000.00</td>
                    <td><span class="badge-active">Paid</span></td>
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
                  <tr>
                    <td>5</td>
                    <td>SARAH DELOS SANTOS</td>
                    <td>06-04-2023</td>
                    <td>&#8369; 80,000.00</td>
                    <td><span class="badge-pending">Pending</span></td>
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
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

@endsection
