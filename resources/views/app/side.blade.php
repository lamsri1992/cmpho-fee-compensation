<aside class="main-sidebar sidebar-dark-secondary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('img/logo_cmh.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">CMPHO - MFCIMS</span>
    </a>

    <div class="sidebar mt-2">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header text-muted">เมนูระบบ</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active':'' }}">
                        <i class="nav-icon fa-solid fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('twfiles.index') }}"
                        class="nav-link {{ request()->is('twfiles*') ? 'active':'' }}">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            ข้อมูล 12 แฟ้ม
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item {{ request()->is('debtor*') ? 'menu-is-opening menu-open':'' }}">
                    <a href="#" class="nav-link {{ request()->is('debtor*') ? 'active':'' }}">
                        <i class="nav-icon fas fa-list-check"></i>
                        <p>
                            ข้อมูลลูกหนี้
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('debtor.index') }}"
                                class="nav-link {{ request()->is('debtor') || request()->is('debtor/list*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายการลูกหนี้</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('debtor.create') }}" 
                                class="nav-link {{ request()->is('debtor/create*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>บันทึกข้อมูลผู้รับบริการ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('creditor.index') }}"
                        class="nav-link {{ request()->is('creditor*') ? 'active':'' }}">
                        <i class="nav-icon fa-solid fa-comment-dollar"></i>
                        <p>
                            ข้อมูลเจ้าหนี้
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('nhso*') ? 'menu-is-opening menu-open':'' }}">
                    <a href="#" class="nav-link {{ request()->is('nhso*') ? 'active':'' }}">
                        <i class="nav-icon fa-solid fa-clipboard-list"></i>
                        <p>
                            เกณฑ์ราคา สปสช.
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('nhso.list') }}"
                                class="nav-link {{ request()->is('nhso/list') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>อัตราจ่ายค่าบริการ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('nhso.drug') }}" 
                                class="nav-link {{ request()->is('debtor/create*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>อัตราจ่ายค่ายา</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
