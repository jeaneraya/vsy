<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VSY Collection</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

  <!-- Material Icon -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <!-- Iconify -->
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

</head>

<body>
  <div class="layer"></div>
<!-- ! Body -->
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">
  <!-- ! Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <div class="row">
              <div class="col-12 text-center">
                <a href="/" class="logo-wrapper" title="Home">
                  <span class="sr-only">Home</span>
                  <img src="{{ asset('assets/images/logo/logo.png') }}" class="img m-auto">
                </a>
                <div class="logo-text">VSY System</div>
              </div>
            </div>
        </div>
        <div class="sidebar-body">
            <ul class="sidebar-body-menu">
                <li>
                    <a class="active" href="/"><span class="material-icons-outlined">dashboard</span>Dashboard</a>
                </li>
                <span class="system-menu__title">vsy enterprise</span>
                <ul class="sidebar-body-menu">
                    <li>
                        <a href="appearance.html"><span class="material-icons-outlined">diversity_3</span>Employees</a>
                    </li>
                    <li>
                        <a href="##"><span class="material-icons-outlined">receipt_long</span>Records</a>
                    </li>
                    <li>
                        <a href="appearance.html"><span class="material-icons-outlined">summarize</span>Payroll</a>
                    </li>
                </ul>
                <span class="system-menu__title">vsy collections</span>
                <ul class="sidebar-body-menu">
                    <li>
                        <a href="appearance.html"><span class="material-icons-outlined">groups</span>Collectors</a>
                    </li>
                    <li>
                        <a href="##"><span class="material-icons-outlined">group</span>Suppliers</a>
                    </li>
                    <li>
                        <a href="appearance.html"><span class="material-icons-outlined">inventory_2</span>Stocks</a>
                    </li>
                </ul>
            </ul>
            
        </div>
    </div>
</aside>
  <div class="main-wrapper">
    <!-- ! Main nav -->
    <nav class="main-nav--bg">
      <div class="container main-nav">
        <div class="main-nav-start">
        </div>
        <div class="main-nav-end">
          <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
            <span class="sr-only">Toggle menu</span>
            <span class="icon menu-toggle--gray" aria-hidden="true"></span>
          </button>
          <div class="notification-wrapper dropstart">
          <button class="btn p-0 p-relative" data-bs-toggle="dropdown" aria-expande="false">
            <span class=""><iconify-icon icon="mi:notification" class="font-size:1.5em"></iconify-icon></span>
            <span class="icon notification active" aria-hidden="true"></span>
            </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                    <li><a class="dropdown-item fs-6" href="#">View</a></li>
                    <li><a class="dropdown-item fs-6" href="#">Edit</a></li>
                    <li><a class="dropdown-item fs-6" href="#">Trash</a></li>
                </ul>
          </div>
          <div class="nav-user-wrapper dropstart">
            <button href="##" class="btn" data-bs-toggle="dropdown" aria-expande="false">
              <span class="sr-only">My profile</span>
              <span class="nav-user-img">
              <iconify-icon icon="ph:user-fill"></iconify-icon>
              </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
              <li class="dropdown-item"><a href="##">
                  <i data-feather="user" aria-hidden="true"></i>
                  <span>Profile</span>
                </a></li>
              <li class="dropdown-item"><a href="##">
                  <i data-feather="settings" aria-hidden="true"></i>
                  <span>Account settings</span>
                </a></li>
              <li class="dropdown-item"><a class="danger" href="##">
                  <i data-feather="log-out" aria-hidden="true"></i>
                  <span>Log out</span>
                </a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <!-- ! Main -->
    <main class="main users chart-page" id="skip-target">
      @yield("contents")
    </main>
    <!-- ! Footer -->
  </div>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

<!-- Custom scripts -->
<script src="{{ asset('assets/plugins/script.js') }"></script>

<!-- choose one -->
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</body>

</html>