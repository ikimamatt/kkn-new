<!-- Left Sidebar Start -->
<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="{{ route('any', 'index') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="/images/sirat.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="/images/sirat.png" alt="" height="24">
                    </span>
                </a>
                <a href="{{ route('any', 'index') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="/images/sirat.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="/images/sirat.png" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Menu</li>

                <!-- Sidebar Menu -->
                <li>
                    <a href="{{ route(auth()->user()->role . '.dashboard') }}">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'administrator')

                <li>
                    <a href="{{ route('keuangan') }}"
                        class="{{ request()->is('warga/keuangan') || request()->is('superadmin/keuangan') ? 'text-primary' : '' }}">
                        <i data-feather="pie-chart"></i>
                        <span>Keuangan</span>
                    </a>
                </li>
                @endif
                <li class="menu-title mt-2">General</li>
                @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'administrator')
                    <li>
                        <a href="{{ route('block.index') }}">
                            <i data-feather="table"></i>
                            <span> Data Blok & Warga </span>
                        </a>
                    </li>

                @endif
                <li>
                        <a href="{{ route('emergency_units.index') }}">
                            <i data-feather="alert-circle"></i>
                            <span> Nomor Darurat </span>
                        </a>
                </li>

                {{-- <li>
                    <a href="#sidebarForms" data-bs-toggle="collapse">
                        <i data-feather="briefcase"></i>
                        <span> Forms </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarForms">
                        <ul class="nav-second-level">
                            <li>
                                <a class="tp-link" href="{{ route('second', ['forms', 'elements']) }}">General
                                    Elements</a>
                            </li>
                            <li>
                                <a class="tp-link" href="{{ route('second', ['forms', 'validation']) }}">Validation</a>
                            </li>
                            <li>
                                <a class="tp-link" href="{{ route('second', ['forms', 'quilljs']) }}">Quilljs Editor</a>
                            </li>
                            <li>
                                <a class="tp-link" href="{{ route('second', ['forms', 'pickers']) }}">Picker</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                <li class="menu-title mt-2">Kegiatan</li>

                <li>
                    <a href="#sidebarKegiatan" data-bs-toggle="collapse">
                        <i data-feather="calendar"></i>
                        <span> Kegiatan </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarKegiatan">
                        <ul class="nav-second-level">
                        <li>
                    <a class="tp-link" href="{{ route('kegiatan.index') }}">
                        List Kegiatan
                    </a>
                </li>
                        </ul>
                    </div>
                </li>
        </ul>
    </div>
</li>




            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
<!-- Left Sidebar End -->
