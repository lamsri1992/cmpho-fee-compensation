<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                สวัสดี , {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-center">
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fa-solid fa-circle-h mr-2"></i>
                    ข้อมูลหน่วยบริการ
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link class="dropdown-item" :href="route('logout')" 
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fa-solid fa-right-from-bracket mr-2" style="font-size: 16px;"></i>
                        <span style="font-size: 16px;">ออกจากระบบ</span>
                    </x-dropdown-link>
                </form>
            </div>
        </li>
    </ul>
</nav>