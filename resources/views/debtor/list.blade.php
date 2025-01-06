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
                        <li class="breadcrumb-item active">
                            ข้อมูลนำเข้ารอตรวจสอบ
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fa-solid fa-spinner fa-spin"></i>
                                ข้อมูลนำเข้ารอตรวจสอบ
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">VN</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">สถานบริการหลัก</th>
                                        <th class="text-center">HN</th>
                                        <th class="text-center">รหัสบริการ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">ค่าใช้จ่าย</th>
                                        <th class="text-center">รวม</th>
                                        <th class="text-center">อัตราจ่าย</th>
                                        <th class="text-center">สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @foreach ($data as $rs)
                                    @php $i++; @endphp
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
                                        <td class="text-center">
                                            <a href="{{ route('debtor.show',$rs->vn) }}">
                                                {{ $rs->vn }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ date("d/m/Y", strtotime($rs->visitdate)) }}</td>
                                        <td class="text-center">{{ $rs->hospmain." : ".$rs->h_name }}</td>
                                        <td class="text-center">{{ $rs->hn }}</td>
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
                                            <a href="#" class="{{ $rs->p_text_color }}"
                                                onclick="
                                                Swal.fire({
                                                    title: '{{ $rs->p_name }}',
                                                });
                                            ">
                                                {!! $rs->p_icon !!}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                        extend: 'excelHtml5',
                        text: '<i class="fa-solid fa-file-excel text-success"></i> Export Excel',
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            sheet.querySelectorAll('row c[r^="C"]').forEach((el) => {
                                el.setAttribute('s', '2');
                            });
                        }
                    },
                    {
                        text: '<i class="fa-solid fa-square-arrow-up-right text-primary"></i> ส่งข้อมูลไปยัง สสจ.',
                        action: function (e, dt, node, config) {
                            var count = {{ count($data) }};
                            if(count <= 0){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ไม่มีข้อมูล',
                                    text: count + ' รายการ',
                                    showCancelButton: false,
                                });
                            }else{
                                Swal.fire({
                                icon: 'warning',
                                title: 'ยืนยันการส่งข้อมูล ?',
                                text: 'ส่งข้อมูลเฉพาะสถานะรอนำส่ง',
                                showCancelButton: true,
                                confirmButtonText: "ส่งข้อมูล",
                                cancelButtonText: "ยกเลิก",
                                confirmButtonColor: "#3085d6",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url:"{{ route('debtor.send') }}",
                                        method:'GET',
                                        success:function(data){
                                            let timerInterval
                                            Swal.fire({
                                                timer: 3000,
                                                timerProgressBar: true,
                                                title: 'กำลังส่งข้อมูล',
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timerProgressBar: true,
                                                didOpen: () => {
                                                    Swal.showLoading();
                                                    const timer = Swal.getPopup().querySelector("b");
                                                },
                                                willClose: () => {
                                                    clearInterval(timerInterval);
                                                }
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'ส่งข้อมูลสำเร็จ',
                                                        showConfirmButton: false,
                                                        allowOutsideClick: false,
                                                        allowEscapeKey: false,
                                                        timer: 10000
                                                    })
                                                    window.setTimeout(function () {
                                                        location.reload()
                                                    }, 3000);
                                                }
                                            })
                                        }
                                    });
                                }
                            });   
                            }
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
        // scrollX: true,
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
