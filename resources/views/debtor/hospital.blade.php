@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ข้อมูลลูกหนี้</li>
                        <li class="breadcrumb-item active">ลูกหนี้แยกโรงพยาบาล</li>
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
                                <i class="fa-regular fa-hospital"></i>
                                ข้อมูลลูกหนี้แยกรายโรงพยาบาล
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="basicTable" class="table table-striped table-borderless table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">รหัสหน่วยบริการ</th>
                                        <th class="">หน่วยบริการ</th>
                                        <th class="">ค่าบริการ</th>
                                        <th class="text-center">เคส</th>
                                        <th class="text-center"><i class="fa-solid fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $rs)
                                    <tr>
                                        <td class="text-center">{{ $rs->hospmain }}</td>
                                        <td class="">{{ $rs->h_name }}</td>
                                        <td class="">{{ number_format($rs->total,2) }}</td>
                                        <td class="text-center">{{ number_format($rs->num) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('debtor.hospital.list',$rs->hospmain) }}" class="btn btn-secondary btn-sm">
                                                <i class="fa-solid fa-clipboard"></i>
                                                รายละเอียด
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

@endsection
