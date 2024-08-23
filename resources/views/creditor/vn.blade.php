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
                <div class="col-md-4">
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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-regular fa-clipboard"></i>
                            รายการค่าใช้จ่าย
                        </div>
                        <div class="card-body box-profile">
                            <table id="basicTable" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">ICD10</th>
                                        <th class="text-center">รหัสบริการ</th>
                                        <th class="text-center">ค่าใช้จ่ายจริง</th>
                                        <th class="text-center">อัตราจ่าย FS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @php $total = 0; @endphp
                                    @foreach ($list as $rs)
                                    @php $i++; @endphp
                                    @php $total += $rs->total @endphp
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
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>
                                                รวมค่าใช้จ่ายจริง
                                                {{ number_format($total,2) }}
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
@endsection
@section('script')

@endsection
