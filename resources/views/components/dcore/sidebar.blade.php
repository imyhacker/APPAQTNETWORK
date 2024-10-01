<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('login')}}">{{ env('APP_NAME') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('login')}}">AN</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Server</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-server"></i> <span>Server</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('datavpn') }}">Data VPN</a></li>
                    @if(session('mikrotik_connected'))
                    <li><a class="nav-link" href="{{ route('dashboardmikrotik', ['ipmikrotik' => session('ipmikrotik')]) }}">Dashboard Mikrotik</a></li>
                    @else
                    <li><a class="nav-link" href="{{ route('datamikrotik') }}">Data Mikrotik</a></li>

                    @endif
                    <li><a class="nav-link" href="">Data OLT</a></li>
                </ul>
            </li>

            {{-- Conditionally show IP and Setting menus if connected to MikroTik --}}
            @if(session('mikrotik_connected'))
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-route"></i> <span>IP</span></a>
                    <ul class="dropdown-menu">
                    <li><a href="{{route('active-connection', ['ipmikrotik' => session('ipmikrotik')])}}">Active Connection</a></li>
                    <li><a href="{{route('aksessecret', ['ipmikrotik' => session('ipmikrotik')])}}">Secret</a></li>
                    <li><a href="{{route('aksesnightbore', ['ipmikrotik' => session('ipmikrotik')])}}">Neighbore</a></li>
                    <li><a href="{{route('aksesinterface', ['ipmikrotik' => session('ipmikrotik')])}}">Interface</a></li>
                    <li><a href="">Pool</a></li>
                    <li><a href="">Service</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-plug"></i> <span>Setting</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="">Schedule</a></li>
                        <li><a class="nav-link" href="">Reboot Mikrotik</a></li>
                        <li><a class="nav-link" href="">Users</a></li>
                    </ul>
                </li>
            @endif

            @can('isAdmin')
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i> <span>User</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="">Data Pengguna</a></li>
                        <li><a class="nav-link" href="">Daftar Mikrotik</a></li>
                    </ul>
                </li>
            @endcan
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
