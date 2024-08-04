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
                        class="nav-link {{ request()->is('cmpho') ? 'active':'' }}">
                        <i class="nav-icon fa-solid fa-clipboard-check"></i>
                        <p>
                            รายการส่งข้อมูล
                        </p>
                    </a>
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
                    <select name="month" class="custom-select">
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
