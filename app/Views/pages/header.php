<header class="topbar" data-navbarbg="skin6">
  <nav class="navbar top-navbar navbar-expand-md navbar-light">
    <div class="navbar-header" data-logobg="skin6">
      <a class="navbar-brand" href="<?php echo base_url("/dashboard"); ?>">
        <!-- Logo icon -->
        <b class="logo-icon">
          <i class="wi wi-sunset"></i>
          <!-- Dark Logo icon -->
          <img src="../../assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
          <!-- Light Logo icon -->
          <img src="../../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
        </b>
        <!--End Logo icon -->
        <!-- Logo text -->
        <span class="logo-text">
          <!-- dark Logo text -->
          <img src="../../assets/images/logo-text.png" alt="homepage" class="dark-logo" />
          <!-- Light Logo text -->
          <img src="../../assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
        </span>
      </a>
      <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a>
    </div>
    <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
      <ul class="navbar-nav float-start me-auto">
        <li class="nav-item search-box">
          <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-magnify me-1"></i>
            <span class="font-16">Search</span></a>
          <form class="app-search position-absolute">
            <input type="text" class="form-control" placeholder="Search &amp; enter" />
            <a class="srh-btn"><i class="mdi mdi-window-close"></i></a>
          </form>
        </li>
      </ul>
      <ul class="navbar-nav float-end">
        <li class="nav-item dropdown">
          <a class="
                    nav-link
                    dropdown-toggle
                    text-muted
                    waves-effect waves-dark
                    pro-pic
                  " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../../assets/images/users/profile.png" alt="user" class="rounded-circle" width="31" />
          </a>
          <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?php echo base_url("/login"); ?>"><i class="mdi mdi-account m-r-5 m-l-5"></i> Logout</a>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>