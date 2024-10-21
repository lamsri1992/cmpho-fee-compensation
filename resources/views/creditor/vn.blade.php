@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('creditor.hospital') }}">
                                ข้อมูลเจ้าหนี้
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ $data->vn }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-regular fa-id-card"></i>
                            ข้อมูลผู้รับบริการ
                        </div>
                        <div class="card-body box-profile">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>VN</th>
                                        <td>{{ $data->vn }}</td>
                                    </tr>
                                    <tr>
                                        <th>วันที่</th>
                                        <td>{{ date("d/m/Y", strtotime($data->visitdate)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>โรงพยาบาลหลัก</th>
                                        <td>{{ $data->h_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>CID</th>
                                        <td>{{ $data->person_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>HN</th>
                                        <td>{{ $data->hn }}</td>
                                    </tr>
                                    <tr>
                                        <th>ผู้รับบริการ</th>
                                        <td>{{ $data->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>อายุ</th>
                                        <td>{{ $data->age." ปี" }}</td>
                                    </tr>
                                    <tr>
                                        <th>เพศ</th>
                                        <td>
                                            {!! $data->sex_icon !!}
                                            {{ $data->sex_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>AuthenCode</th>
                                        <td>{{ $data->auth_code }}</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-regular fa-clipboard"></i>
                            รายการค่าใช้จ่าย
                        </div>
                        <div class="col-md-12 mt-2">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-list" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                        <i class="fa-solid fa-list"></i>
                                        รายการค่าใช้จ่าย
                                    </button>
                                    <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-deny" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                                        <i class="fa-solid fa-times"></i>
                                        รายการปฏิเสธจ่าย
                                    </button>
                                </div>
                            </nav>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                                <div class="card-body box-profile">
                                    <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">ICD10</th>
                                                <th class="text-center">รหัสบริการ</th>
                                                <th class="text-center">ค่าใช้จ่ายจริง</th>
                                                <th class="text-center">อัตราจ่าย FS</th>
                                                <th class="text-center"><i class="fa-solid fa-bars"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = 0; @endphp
                                            @php $total = 0; @endphp
                                            @php $paid = 0; @endphp
                                            @foreach ($list as $rs)
                                            @php $i++; @endphp
                                            @php $total += $rs->total @endphp
                                            @php $paid += $rs->nhso_cost @endphp
                                            @if (!isset($rs->nhso_code))
                                                @php 
                                                    $icon = 'error';
                                                    $text = 'ไม่พบข้อมูลใน NHSO FS-CODE';
                                                    $check = $rs->fs_code;
                                                    $bg = 'bg-danger';
                                                @endphp
                                            @else
                                                @php 
                                                    $icon = 'success';
                                                    $text = '';
                                                    $check = $rs->nhso_code;
                                                    $bg = 'bg-success';
                                                @endphp
                                            @endif
                                            <tr>
                                                <td class="text-center">{{ $i }}</td>
                                                <td class="text-center">{{ $rs->icd10 }}</td>
                                                <td class="text-center {{ $bg }}">
                                                    <a href="#" 
                                                        onclick="
                                                            Swal.fire({
                                                                icon: '{{ $icon }}',
                                                                title: '{{ $check }}',
                                                                text: '{{ $text.$rs->nhso_name }}',
                                                            });
                                                        ">
                                                        {{ $check }}
                                                    </a>
                                                </td>
                                                <td class="text-center {{ $bg }}">{{ number_format($rs->total,2) }}</td>
                                                <td class="text-center {{ $bg }}">{{ number_format($rs->nhso_cost,2) }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('creditor.vn.deny',$rs->uuid) }}" method="POST">
                                                        @csrf
                                                        <button type="button" class="btn btn-default btn-sm"
                                                            onclick="Swal.fire({
                                                                icon: 'error',
                                                                title: 'ยืนยันไม่จ่ายรายการนี้ ?',
                                                                text: 'รายการรหัส : '+'{{ $rs->fs_code }}',
                                                                showDenyButton: false,
                                                                showCancelButton: true,
                                                                confirmButtonText: 'ยืนยัน',
                                                                cancelButtonText: 'ยกเลิก'
                                                                }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    form.submit();
                                                                }
                                                            });">
                                                            <i class="fa-solid fa-times-circle text-danger"></i>
                                                            ปฏิเสธการจ่าย
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td class="text-center">
                                                    <span class="fw-bold text-primary">
                                                        รวมค่าใช้จ่ายจริง
                                                        {{ number_format($total,2) }} ฿
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="fw-bold text-success">
                                                        รวมค่าใช้ตามเกณฑ์
                                                        {{ number_format($paid,2) }} ฿
                                                    </span>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-deny" role="tabpanel" aria-labelledby="nav-deny-tab">
                                <div class="card-body box-profile">
                                    <table id="nhso_table2" class="table table-striped table-bordered nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">ICD10</th>
                                                <th class="text-center">รหัสบริการ</th>
                                                <th class="text-center">ค่าใช้จ่ายจริง</th>
                                                <th class="text-center">อัตราจ่าย FS</th>
                                                <th class="text-center"><i class="fa-solid fa-bars"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = 0; @endphp
                                            @php $total = 0; @endphp
                                            @php $paid = 0; @endphp
                                            @foreach ($deny as $rs)
                                            @php $i++; @endphp
                                            @php $total += $rs->total @endphp
                                            @php $paid += $rs->nhso_cost @endphp
                                            @if (!isset($rs->nhso_code))
                                                @php 
                                                    $icon = 'error';
                                                    $text = 'ไม่พบข้อมูลใน NHSO FS-CODE';
                                                    $check = $rs->fs_code;
                                                    $bg = 'bg-danger';
                                                @endphp
                                            @else
                                                @php 
                                                    $icon = 'success';
                                                    $text = '';
                                                    $check = $rs->nhso_code;
                                                    $bg = 'bg-success';
                                                @endphp
                                            @endif
                                            <tr>
                                                <td class="text-center">{{ $i }}</td>
                                                <td class="text-center">{{ $rs->icd10 }}</td>
                                                <td class="text-center {{ $bg }}">
                                                    <a href="#" 
                                                        onclick="
                                                            Swal.fire({
                                                                icon: '{{ $icon }}',
                                                                title: '{{ $check }}',
                                                                text: '{{ $text.$rs->nhso_name }}',
                                                            });
                                                        ">
                                                        {{ $check }}
                                                    </a>
                                                </td>
                                                <td class="text-center {{ $bg }}">{{ number_format($rs->total,2) }}</td>
                                                <td class="text-center {{ $bg }}">{{ number_format($rs->nhso_cost,2) }}</td>
                                                <td class="text-center">
                                                    <i class="fa-solid fa-times-circle text-danger"></i>
                                                    ปฏิเสธการจ่าย
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td class="text-center">
                                                    <span class="fw-bold text-primary">
                                                        รวมค่าใช้จ่ายจริง
                                                        {{ number_format($total,2) }} ฿
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="fw-bold text-success">
                                                        รวมค่าใช้ตามเกณฑ์
                                                        {{ number_format($paid,2) }} ฿
                                                    </span>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script>
    new DataTable('#nhso_table', {
        layout: {
            topStart: {
                buttons: [
                    {
                        text: '<i class="fa-solid fa-check-circle text-success"></i> ยืนยันการจ่าย',
                        action: function (e, dt, node, config) {
                            Swal.fire({
                                icon: "question",
                                title: "ยืนยันการจ่าย ?",
                                text: "คำอธิบาย : คือการยืนยันการจ่ายรายการ VN นี้ทั้งหมด",
                                showDenyButton: false,
                                showCancelButton: true,
                                confirmButtonText: "ยืนยัน",
                                cancelButtonText: "ยกเลิก"
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire("ยืนยันการจ่ายแล้ว", "", "success");
                                }
                            });
                        }
                    },
                    {
                        text: '<i class="fa-solid fa-times-circle text-danger"></i> ปฏิเสธการจ่าย',
                        action: function (e, dt, node, config) {
                            Swal.fire({
                                icon: "question",
                                title: "ปฏิเสธการจ่าย ?",
                                text: "คำอธิบาย : คือการปฏิเสธจ่ายรายการ VN นี้ทั้งหมด",
                                showDenyButton: false,
                                showCancelButton: true,
                                confirmButtonText: "ปฏิเสธการจ่าย",
                                cancelButtonText: "ยกเลิก"
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire("ปฏิเสธการจ่ายแล้ว", "", "error");
                                }
                            });
                        }
                    }
                ]
            }
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        responsive: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        oLanguage: {
            oPaginate: {
                sFirst: '<small>หน้าแรก</small>',
                sLast: '<small>หน้าสุดท้าย</small>',
                sNext: '<small>ถัดไป</small>',
                sPrevious: '<small>กลับ</small>'
            },
            sSearch: '<small><i class="fa fa-search"></i> ค้นหา</small>',
            sInfo: '<small>ทั้งหมด _TOTAL_ รายการ</small>',
            sLengthMenu: '<small>แสดง _MENU_ รายการ</small>',
            sInfoEmpty: '<small>ไม่มีข้อมูล</small>'
        },
    });
    new DataTable('#nhso_table2', {
        layout: {
            topStart: {
                buttons: [
                    {
                        text: '<i class="fa-solid fa-check-circle text-success"></i> ยืนยันการจ่าย',
                        action: function (e, dt, node, config) {
                            Swal.fire({
                                icon: "question",
                                title: "ยืนยันการจ่าย ?",
                                text: "คำอธิบาย : คือการยืนยันการจ่ายรายการ VN นี้ทั้งหมด",
                                showDenyButton: false,
                                showCancelButton: true,
                                confirmButtonText: "ยืนยัน",
                                cancelButtonText: "ยกเลิก"
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire("ยืนยันการจ่ายแล้ว", "", "success");
                                }
                            });
                        }
                    },
                    {
                        text: '<i class="fa-solid fa-times-circle text-danger"></i> ปฏิเสธการจ่าย',
                        action: function (e, dt, node, config) {
                            Swal.fire({
                                icon: "question",
                                title: "ปฏิเสธการจ่าย ?",
                                text: "คำอธิบาย : คือการปฏิเสธจ่ายรายการ VN นี้ทั้งหมด",
                                showDenyButton: false,
                                showCancelButton: true,
                                confirmButtonText: "ปฏิเสธการจ่าย",
                                cancelButtonText: "ยกเลิก"
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire("ปฏิเสธการจ่ายแล้ว", "", "error");
                                }
                            });
                        }
                    }
                ]
            }
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        responsive: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        oLanguage: {
            oPaginate: {
                sFirst: '<small>หน้าแรก</small>',
                sLast: '<small>หน้าสุดท้าย</small>',
                sNext: '<small>ถัดไป</small>',
                sPrevious: '<small>กลับ</small>'
            },
            sSearch: '<small><i class="fa fa-search"></i> ค้นหา</small>',
            sInfo: '<small>ทั้งหมด _TOTAL_ รายการ</small>',
            sLengthMenu: '<small>แสดง _MENU_ รายการ</small>',
            sInfoEmpty: '<small>ไม่มีข้อมูล</small>'
        },
    });
</script>
@endsection
