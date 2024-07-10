<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            {{-- <a href="index.html">e-YM</a> --}}
            <img src="{{ asset('assets/img/e-ym/eym.png') }}" width="120" class="img-fluid mb-2" alt="">
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">YM</a>
        </div>
        <ul class="sidebar-menu">

            <li class="menu-header">Dashboard</li>
            <li class="{{ \Route::is('apps.dashboard') ? 'active' : '' }}">
                <a href="{{ route('apps.dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>


            <li class="menu-header">Kegiatan</li>

            @if (Auth::user()->role == 'User')
                <li class="{{ \Route::is('form.create.donasi') ? 'active' : '' }}">
                    <a href="{{ route('form.create.donasi') }}" class="nav-link"><i
                            class="fas fa-hand-holding-heart"></i>
                        <span>Form Donasi</span></a>
                </li>



                <li class="{{ \Route::is('form.index.donasi') ? 'active' : '' }}">
                    <a href="{{ route('form.index.donasi') }}" class="nav-link"><i class="fas fa-list"></i>
                        <span>Daftar Donasi</span></a>
                </li>
            @endif


            @php
                $activeRoutes = [
                    'index.view.distribusi',
                    'index.create.distribusi',
                    'index.edit.distribusi',
                    'index.view.distribusibarang',
                    'index.create.distribusibarang',
                    'index.edit.distribusibarang',
                    'index.search.distribusi',
                ];
                $activeRoutesDropdown = [
                    'index.view.penyaluran',
                    'index.view.kprogram',
                    'index.create.penyaluran',
                    'index.edit.penyaluran',
                    'index.create.kprogram',
                    'index.edit.kprogram',
                ];
                $activeRoutesDonatur = [
                    'index.view.datadonasi',
                    'index.create.datadonasi',
                    'index.edit.datadonasi',
                    'form.show.donasi_admin',
                    'form.create.donasi_admin',
                    'form.edit.donasi_admin',
                ];
            @endphp

            @if (Auth::user()->role == 'Admin')
                <li class="{{ in_array(\Route::currentRouteName(), $activeRoutes) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('index.view.distribusi') }}">
                        <i class="fas fa-box-open"></i>
                        <span>Distribusi</span>
                    </a>
                </li>


                <li
                    class="{{ \Route::is('index.view.program') || \Route::is('index.create.program') || \Route::is('index.edit.program') ? 'active' : '' }}">
                    <a href="{{ route('index.view.program') }}" class="nav-link"><i class="far fa-file-alt"></i>
                        <span>Program</span></a>
                </li>


                <li
                    class="{{ \Route::is('index.view') || \Route::is('index.create') || \Route::is('index.edit') ? 'active' : '' }}">
                    <a href="{{ route('index.view') }}" class="nav-link"><i class="fas fa-folder-open"></i>
                        <span>Jenis Arsip</span></a>
                </li>



                <li
                    class="{{ \Route::is('index.view.arsip') || \Route::is('index.create.arsip') || \Route::is('index.edit.arsip') ? 'active' : '' }}">
                    <a href="{{ route('index.view.arsip') }}" class="nav-link"><i class="fas fa-folder"></i></i>
                        <span>Arsip</span></a>
                </li>



                <li class="{{ in_array(\Route::currentRouteName(), $activeRoutesDonatur) ? 'active' : '' }}">
                    <a href="{{ route('index.view.datadonasi') }}" class="nav-link"><i class="fas fa-donate"></i>
                        <span>Data Donatur</span></a>
                </li>



                <li class="dropdown{{ \Route::is(...$activeRoutesDropdown) ? ' active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-columns"></i>
                        <span>Kelola Konten</span></a>
                    <ul class="dropdown-menu">
                        <li
                            class="{{ \Route::is('index.view.penyaluran') || \Route::is('index.create.penyaluran') || \Route::is('index.edit.penyaluran') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('index.view.penyaluran') }}">Konten Penyaluran</a>
                        </li>
                        <li
                            class="{{ \Route::is('index.view.kprogram') || \Route::is('index.create.kprogram') || \Route::is('index.edit.kprogram') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('index.view.kprogram') }}">Konten Program</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </aside>
</div>
