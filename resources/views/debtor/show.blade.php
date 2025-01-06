@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('debtor.index') }}">
                                รายการลูกหนี้
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('debtor.list') }}">
                                รายการข้อมูลลูกหนี้
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ "VN : ".$data->vn }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card" style="height: 100%;">
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
                    <div class="card" style="height: 100%;">
                        <div class="card-header">
                            <i class="fa-regular fa-clipboard"></i>
                            รายการค่าใช้จ่าย
                        </div>
                        <div class="card-body box-profile">
                            <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">ICD10</th>
                                        <th class="text-center">รหัสบริการ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">ค่าใช้จ่าย</th>
                                        <th class="text-center">รวม</th>
                                        <th class="text-center">อัตราจ่าย</th>
                                        <th class="text-center"><i class="fa-solid fa-trash"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @php $total = 0; @endphp
                                    @foreach ($list as $rs)
                                    @php $i++; @endphp
                                    @php $total += $rs->total * $rs->unit @endphp
                                    @if (!isset($rs->nhso_code) && !isset($rs->tpuid))
                                    @php 
                                        $icon = 'error';
                                        $text = 'ไม่พบข้อมูลใน NHSO FS-CODE';
                                        $bg = 'bg-danger';
                                    @endphp
                                    @else
                                    @php 
                                        $icon = 'success';
                                        $text = '';
                                        $bg = 'bg-success';
                                    @endphp
                                    @endif
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-center">{{ $rs->icd10 }}</td>
                                        <td class="text-center {{ $bg }}">
                                            @if ($rs->nhso_code != "")
                                            <a href="#" 
                                                onclick="
                                                    Swal.fire({
                                                        icon: '{{ $icon }}',
                                                        title: '{{ $rs->nhso_code }}',
                                                        text: '{{ $rs->nhso_name }}',
                                                    });
                                                ">
                                                {{ $rs->nhso_code }}
                                            </a>
                                            @endif
                                            @if ($rs->tpuid != "")
                                            <a href="#" 
                                                onclick="
                                                    Swal.fire({
                                                        icon: '{{ $icon }}',
                                                        title: '{{ $rs->tpuid }}',
                                                        text: '{{ $rs->fsn }}',
                                                    });
                                                ">
                                                {{ $rs->tpuid }}
                                            </a>
                                            @endif
                                            @if ($rs->nhso_code == "" && $rs->tpuid == "") 
                                            <a href="#" 
                                                onclick="
                                                    Swal.fire({
                                                        icon: '{{ $icon }}',
                                                        title: '{{ $rs->fs_code }}',
                                                        text: '{{ $text }}',
                                                    });
                                                ">
                                                {{ $rs->fs_code }}
                                            </a>    
                                            @endif
                                        </td>
                                        <td class="text-center {{ $bg }}">
                                            {{ number_format($rs->unit) }}
                                        </td>
                                        <td class="text-center {{ $bg }}">
                                            {{ number_format($rs->total,2) }}
                                        </td>
                                        <td class="text-center {{ $bg }}">
                                            {{ number_format($rs->total * $rs->unit,2) }}
                                        </td>
                                        <td class="text-center bg-warning">
                                            @if (!isset($rs->nhso_code) && !isset($rs->tpuid))
                                                0.00
                                            @else
                                            {{ number_format($rs->total * $rs->unit,2) }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('debtor.list.delete',$rs->uuid) }}" method="GET">
                                                @csrf
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    {{ ($rs->p_status) != 1 ? 'disabled' : '' }}
                                                    onclick="
                                                    Swal.fire({
                                                        icon: 'warning',
                                                        title: 'ลบรายการ - ' + '{{ $rs->fs_code }}',
                                                        text: '{{ $rs->uuid }}',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'ลบรายการ',
                                                        cancelButtonText: 'ยกลก',
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            form.submit()
                                                        } else if (result.isDenied) {
                                                            form.clear()
                                                    }
                                                    });
                                                ">
                                                    ลบรายการ
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <h5>
                                                รวมทั้งหมด
                                                {{ number_format($total,2)." บาท" }}
                                            </h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="addList" tabindex="-1" aria-labelledby="addListLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('debtor.list.add',$data->vn) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addListLabel">
                        <i class="fa-solid fa-plus-circle text-success"></i>
                        เพิ่มรายการ
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>วันที่</label>
                            <input type="text" class="form-control" value="{{ date("d/m/Y", strtotime($data->visitdate)) }}" @disabled(true)>
                        </div>
                        <div class="form-group col-md-6">
                            <label>VN</label>
                            <input type="text" name="vn" class="form-control" value="{{ $data->vn }}" @disabled(true)>
                        </div>
                        <div class="form-group col-md-12">
                            <label>ICD10</label>
                            <input type="text" name="icd10" class="form-control" value="{{ $rs->icd10 }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>รหัสบริการ</label>
                            <input type="text" name="fs_code" class="form-control" placeholder="ระบุรหัสบริการ">
                        </div>
                        <div class="form-group col-md-4">
                            <label>จำนวน</label>
                            <input type="text" name="unit" class="form-control" placeholder="ระบุจำนวน">
                        </div>
                        <div class="form-group col-md-4">
                            <label>ค่าใช้จ่าย</label>
                            <input type="text" name="total" class="form-control" placeholder="ระบุค่าใช้จ่าย">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-success"
                        onclick="
                            Swal.fire({
                                icon: 'success',
                                title: 'เพิ่มรายการค่าใช้จ่าย ?',
                                showCancelButton: true,
                                confirmButtonText: 'เพิ่มรายการ',
                                cancelButtonText: 'ยกลก',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit()
                                } else if (result.isDenied) {
                                    form.clear()
                            }
                            });
                        ">
                        <i class="fa-regular fa-save"></i>
                        บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    new DataTable('#nhso_table', {
        layout: {
            topStart: {
                buttons: [
                    {
                        text: '<i class="fa-solid fa-plus-circle text-success"></i> เพิ่มรายการ',
                        action: function (e, dt, node, config) {
                            $('#addList').modal('show')
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
