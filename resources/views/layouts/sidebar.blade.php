    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #031B4D;">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">EventMan | App <sup>v1</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="{{ url('/home') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Pages Collapse Company Menu -->
      <li class="nav-item {{ Request::is('company*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCoy" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-building"></i>
          <span>Company</span>
        </a>
        <div id="collapseCoy" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Companies:</h6>
            <a class="collapse-item" href="{{route('company.index')}}">All Companies</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Pages Collapse Events Menu -->
      <li class="nav-item {{ Request::is('event*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-building"></i>
          <span>Events</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Events:</h6>
            <a class="collapse-item" href="{{route('event.index')}}">All Events</a>
          </div>
        </div>
      </li>


      <!-- Nav Item - Pages Collapse Menu -->
    {{--
    @if(Auth::user()->role_id < 3)
      <li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users"></i>
          <span>Users</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">User Management:</h6>
            <a class="collapse-item" href="{{route('users.index')}}">All Users</a>
            <!-- <a class="collapse-item" href="register.html">Create User</a> -->
            <!-- <a class="collapse-item" href="forgot-password.html">Forgot Password</a> -->
            <a class="collapse-item" href="{!!route('manage-api') !!}">API Tokens</a>
            <a class="collapse-item" href="{!!route('apilogs.index') !!}">API Log</a>
            <!-- <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a> -->
          </div>
        </div>
      </li>
    @endif
    --}}
      <!-- Nav Item - Charts -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li> -->

      <!-- Nav Item - Tables -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li> -->


      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Import Templates
      </div>

      <li class="nav-item">
        <small class=""><a class="nav-link" href="{{asset('participantsImport.csv')}}">Attendees Import</a></small>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->