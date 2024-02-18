<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle "
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @php
                    $data = App\Models\UserFoto::where('id_user', Auth::user()->id_user)->first();
                @endphp
                @if ($data)
                    <img src="{{ asset('/data/user/foto/' . @$data->foto) }}" class="img-circle elevation-2"
                        style="width: 40px;height:40px;object-fit:cover" alt="User Image">
                @else
                    <img src="{{ asset('/admin/dist/img/avatar5.png') }}" class="img-circle elevation-2"
                        style="width: 40px;height:40px;object-fit:cover" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->nama_user }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar nav-collapse-hide-child nav-child-indent flex-column"
                data-widget="treeview" role="menu" data-accordion="false" id="list-sidebar">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt bkg-blue"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">MASTER</li>
                {{-- Data User --}}
                <li class="nav-item">
                    <a href="{{ route('admin.data-user') }}"
                        class="nav-link {{ request()->routeIs('admin.data-user') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user bkg-orange"></i>
                        <p>Data User</p>
                    </a>
                </li>
                {{-- Menu User --}}
                <li class="nav-item">
                    <a href="{{ route('admin.menu') }}"
                        class="nav-link {{ request()->routeIs('admin.menu') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-laptop bkg-purple"></i>
                        <p>Data Menu</p>
                    </a>
                </li>
                <li class="nav-header">LOG</li>
                {{-- User Activity --}}
                <li class="nav-item">
                    <a href="{{ route('admin.user-activity') }}"
                        class="nav-link {{ request()->routeIs('admin.user-activity') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-eye bkg-grey"></i>
                        <p>User Activity</p>
                    </a>
                </li>
                {{-- Log Error --}}
                <li class="nav-item">
                    <a href="{{ route('admin.error-application') }}"
                        class="nav-link {{ request()->routeIs('admin.error-application') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-laptop bkg-red"></i>
                        <p>Log Error Application</p>
                    </a>
                </li>
                <li class="nav-header">MENU</li>
                @php
                    $menu = App\Models\MenuUser::join('menu', 'menu.menu_id', '=', 'menu_user.menu_id')
                        ->join('users', 'users.id_user', '=', 'menu_user.id_user')
                        ->where('users.id_user', Auth::user()->id_user)
                        ->where('menu_user.delete_mark', 0)
                        ->get();
                    $currentUrl = Request::url();
                    $menuLink = URL::to('/administrator/menu/'); //fix url to dokumen
                @endphp
                @foreach ($menu as $val)
                    <li class="nav-item">
                        <a href="{{ route('admin.data-menu.index', ['menu' => $val->menu_link]) }}"
                            class="nav-link {{ str_contains($currentUrl, "$menuLink/$val->menu_link") ? 'active' : '' }}">
                            <i class="{{ $val->menu_icon }} nav-icon"></i>
                            <p>{{ $val->menu_name }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
