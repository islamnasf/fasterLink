 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('assets/dist/img/logo.png')}}" alt="logo" class="brand-image " style="opacity: .8"><!-- elevation-1 -->
      <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('admin.index')}}" class="nav-link {{ (request()->is('admin')) ? 'active' : '' }}">
              <i class="fas fa-home nav-icon"></i>
              <p>Home</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.currencies.index')}}" class="nav-link {{ (request()->is('admin/currencies')) ? 'active' : '' }}">
            <i class="fas fa-dollar-sign nav-icon"></i> 
            <p>Currencies</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.elements.index')}}" class="nav-link {{ (request()->is('admin/elements')) ? 'active' : '' }}">
            <i class="fas fa-cogs nav-icon"></i> 
            <p>Package Elements</p>
            </a>
          </li>
{{--               
          <li class="nav-item">
            <a href="{{route('panel.categories.index')}}" class="nav-link {{ (request()->is('panel/categories')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Categories
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('panel.users.index')}}" class="nav-link {{ (request()->is('panel/users')||request()->is('panel/users/cashback/*')||request()->is('panel/users/loyalty/*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('panel.stores.index')}}" class="nav-link {{ (request()->is('panel/stores')||request()->is('panel/stores/details/*')||request()->is('panel/stores/departments/*')||request()->is('panel/stores/branches/*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Stores
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('panel.faqs.index',['app'=>'user'])}}" class="nav-link {{ (request()->is('panel/faqs') && request()->query('app') === 'user') ? 'active' : '' }}">
              <i class="nav-icon fas fa-question-circle"></i>
              <p>
                FAQ (User App)
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('panel.faqs.index',['app'=>'store'])}}" class="nav-link {{ (request()->is('panel/faqs') && request()->query('app') === 'store') ? 'active' : '' }}">
              <i class="nav-icon fas fa-question-circle"></i>
              <p>
                FAQ (Store App)
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('panel.contact-us.index')}}" class="nav-link {{ (request()->is('panel/contact-us')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Contact Us
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('panel.join-requests.index')}}" class="nav-link {{ (request()->is('panel/join-requests')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-comment"></i>
              <p>
                Join Requests
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('panel.notifications.index')}}" class="nav-link {{ (request()->is('panel/notifications')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-bell"></i>
              <p>
                Notifications
              </p>
            </a>
          </li> --}}
          <li class="nav-item">
            <a href="{{route('admin.network.index')}}" class="nav-link {{ (request()->is('admin/network')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-network-wired"></i>
              <p>
                Network
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.nfc.index')}}" class="nav-link {{ (request()->is('admin/nfc')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-wifi"></i>
              <p>
                NFC
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.features.index')}}" class="nav-link {{ (request()->is('admin/features')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Features
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.settings.index')}}" class="nav-link {{ (request()->is('admin/settings')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
              </p>
            </a>
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
