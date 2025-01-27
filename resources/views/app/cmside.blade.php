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
                        class="nav-link {{ request()->is('cmpho/dashboard') ? 'active':'' }}">
                        <i class="nav-icon fa-solid fa-chart-pie"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li
                    class="nav-item {{ request()->is('cmpho/opae') || request()->is('cmpho/ctmri') ? 'menu-is-opening menu-open':'' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('cmpho/opae') ? 'active':'' }}">
                        <i class="nav-icon fas fa-spinner fa-spin"></i>
                        <p>
                            ข้อมูลรอประมวลผล
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('cmpho.opae.index') }}"
                                class="nav-link {{ request()->is('cmpho/opae*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ข้อมูล OPAE</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cmpho.ctmri.index') }}"
                                class="nav-link {{ request()->is('cmpho/ct*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ข้อมูล CT - MRI</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="modal" data-target="#report"
                        class="nav-link {{ request()->is('cmpho/report') ? 'active':'' }}">
                        <i class="nav-icon fa-solid fa-print"></i>
                        <p>
                            พิมพ์รายงานข้อมูล
                        </p>
                    </a>
                </li>
                <li
                    class="nav-item {{ request()->is('cmpho/config*') ? 'menu-is-opening menu-open':'' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('cmpho/config*') ? 'active':'' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            ตั้งค่าระบบ
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('config.hospital') }}"
                                class="nav-link {{ request()->is('cmpho/config/hospital*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ข้อมูลหน่วยบริการ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('config.users') }}"
                                class="nav-link {{ request()->is('cmpho/config/users*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ข้อมูลผู้ใช้งาน</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item {{ request()->is('nhso*') ? 'menu-is-opening menu-open':'' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('nhso*') ? 'active':'' }}">
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
                                class="nav-link {{ request()->is('nhso/drug*') ? 'active':'' }}">
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

<!-- Modal -->
<div class="modal fade" id="report" tabindex="-1" aria-labelledby="reportLabel" aria-hidden="true">
    <form action="{{ route('cmpho.report') }}" method="GET">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportLabel">
                        พิมพ์รายงานข้อมูลสรุปการเรียกเก็บ
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <select name="month" class="custom-select" @required(true)>
                                <option value="">-- เลือกเดือน --</option>
                                <option value="01">มกราคม</option>
                                <option value="02">กุมภาพันธ์</option>
                                <option value="03">มีนาคม</option>
                                <option value="04">เมษายน</option>
                                <option value="05">พฤษภาคม</option>
                                <option value="06">มิถุนายน</option>
                                <option value="07">กรกฏาคม</option>
                                <option value="08">สิงหาคม</option>
                                <option value="09">กันยายน</option>
                                <option value="10">ตุลาคม</option>
                                <option value="11">พฤศจิกายน</option>
                                <option value="12">ธันวาคม</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label>ระบุปี พ.ศ.</label>
                            <input type="text" class="form-control" name="year" @required(true) placeholder="กรุณาระบุปี พ.ศ.">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">
                        <i class="fa-solid fa-print"></i>
                        ออกรายงาน
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
