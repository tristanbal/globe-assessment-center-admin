<div class="main-header">
  <!-- Logo Header -->
  <div class="logo-header" data-background-color="blue">

    <a href="{{route('home')}}" class="logo">
      <!--<img src="../assets/img/logo.svg" alt="navbar brand" class="navbar-brand">-->
      <div class="navbar-brand text-white text-center">ADMINISTRATOR</div>
    </a>
    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">
        <i class="icon-menu"></i>
      </span>
    </button>
    <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
    <div class="nav-toggle">
      <button class="btn btn-toggle toggle-sidebar">
        <i class="icon-menu"></i>
      </button>
    </div>
  </div>
  <!-- End Logo Header -->

  <!-- Navbar Header -->
  <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

    <div class="container-fluid">
      <div class="collapse" id="search-nav">
        <div class="navbar-brand text-white text-center">ASSESSMENT PORTAL</div>
      </div>
      <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
        
        
        
          <li class="nav-item dropdown hidden-caret">
              <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fas fa-layer-group"></i>
              </a>
              <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                <div class="quick-actions-header">
                  <span class="title mb-1">Quick Actions</span>
                  <span class="subtitle op-8">Shortcuts</span>
                </div>
                <div class="quick-actions-scroll scrollbar-outer">
                  <div class="quick-actions-items">
                    <div class="row m-0">
                      <a class="col-6 col-md-4 p-0" href="https://globeuniversity.globe.com.ph/assessment-portal/">
                        <div class="quick-actions-item">
                          <i class="flaticon-file-1"></i>
                          <span class="text">Old Portal</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="https://globeuniversity.globe.com.ph/assessment-report/">
                        <div class="quick-actions-item">
                          <i class="flaticon-database"></i>
                          <span class="text">Assessment Reports</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="https://globeuniversity.globe.com.ph/assessment-model/">
                        <div class="quick-actions-item">
                          <i class="flaticon-pen"></i>
                          <span class="text">Model Builder</span>
                        </div>
                      </a>
                      
                    </div>
                  </div>
                </div>
              </div>
            </li>
        <li class="nav-item dropdown hidden-caret">
          <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
              <div class="avatar-sm">
                  <img src="@if(auth()->user()->profileImage == 'no-image.png')
                  {{asset('stock/'.auth()->user()->profileImage)}}
                @else
                  {{auth()->user()->profileImage}}
                @endif" alt="..." class="avatar-img rounded-circle">
                </div>
          </a>
          <ul class="dropdown-menu dropdown-user animated fadeIn">
            <div class="dropdown-user-scroll scrollbar-outer">
              <li>
                <div class="user-box">
                  <div class="avatar-lg"><img src="
                    @if(auth()->user()->profileImage == 'no-image.png')
                      {{asset('stock/'.auth()->user()->profileImage)}}
                    @else
                      {{auth()->user()->profileImage}}
                    @endif
                    " alt="image profile" class="avatar-img rounded"></div>
                  <div class="u-text">
                    <h4>Hizrian</h4>
                    <p class="text-muted">hello@example.com</p><a href="profile.html" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                  </div>
                </div>
              </li>
              <li>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">My Profile</a>
                <a class="dropdown-item" href="#">My Balance</a>
                <a class="dropdown-item" href="#">Inbox</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Account Setting</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                 {{ __('Logout') }}</a>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </li>
            </div>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End Navbar -->
</div>