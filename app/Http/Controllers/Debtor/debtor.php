<?php

namespace App\Http\Controllers\Debtor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClaimImport;
use Illuminate\Support\Str;
use DB;
use Auth;
use File;

class debtor extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $sum_debtor = DB::table('claim_list')
                ->select(DB::raw('SUM(total) as total'))
                ->where('hcode',$hcode)
                ->first();
        $count_check = DB::table('claim_list')->where('hcode',$hcode)->count();
        $count_sents = DB::table('claim_list')->where('hcode',$hcode)->whereIn('p_status', [2, 3, 4, 7])->count();
        $count_deny = DB::table('claim_list')->where('hcode',$hcode)->where('p_status', 5)->count();
        $history = DB::table('import_log')->where('hcode',$hcode)->get();

        return view('debtor.index',
        [
            'sum_debtor'=>$sum_debtor,
            'count_check'=>$count_check,
            'count_sents'=>$count_sents,
            'count_deny'=>$count_deny,
            'history'=>$history,
        ]);
    }

    public function import(Request $request) 
    {
        $hcode = Auth::user()->hcode;
        $validatedData = $request->validate(
            [
                'file' => 'required|max:2048|mimes:xls,xlsx',
            ],
            [
                'file.required' => 'กรุณาแนบไฟล์',
            ],
        );
  
        Excel::import(new ClaimImport, $request->file('file'));
        $file  = $request->file('file');
        $fileName = $hcode."_".date('Ymdhis').".xls";
        $destination = public_path('uploads/');

        File::makeDirectory($destination, 0755, true, true);
        $file->move(public_path('uploads/'), $fileName);

        DB::table('import_log')->insert(
            [
                'ex_file' => $fileName,
                'import_date' => date("Y-m-d"),
                'hcode' => $hcode,
            ]
        );

        return back()->with('success', 'นำเข้าข้อมูลสำเร็จ');
    }

    public function create()
    {
        $nhso = DB::table('nhso')->get();
        $hosp = DB::table('hospital')->where('h_type',1)->get();
        return view('debtor.create',['nhso'=>$nhso,'hosp'=>$hosp]);
    }

    public function add(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $currentDate = date('Y-m-d H:i:s');

        $validatedData = $request->validate(
            [
                'vn' => 'required',
                'visitdate' => 'required',
                'hospmain' => 'required',
                'person_id' => 'required',
                'hn' => 'required',
                'name' => 'required',
                'age' => 'required',
                'sex' => 'required',
            ],
            [
                'vn.required' => 'ระบุ VN',
                'visitdate.required' => 'ระบุวันที่รับบริการ',
                'hospmain.required' => 'ระบุโรงพยาบาล',
                'person_id.required' => 'ระบุเลข 13 หลัก',
                'hn.required' => 'ระบุ HN',
                'name.required' => 'ระบุชื่อ-สกุล',
                'age.required' => 'ระบุอายุ',
                'sex.required' => 'ระบุเพศ',
            ],
        );

        foreach ($request->addField as $key => $value) {
            DB::table('claim_list')->insert(
                [
                    'uuid' => Str::uuid()->toString(),
                    'vn' => $request->vn,
                    'visitdate' => $request->visitdate,
                    'hospmain' => $request->hospmain,
                    'person_id' => $request->person_id,
                    'hn' => $request->hn,
                    'name' => $request->name,
                    'age' => $request->age,
                    'sex' => $request->sex,
                    'auth_code' => $request->auth_code,
                    'icd10' => $value['icd10'],
                    'fs_code' => $value['fs_code'],
                    'total' => $value['total'],
                    'hcode' => $hcode,
                    'created_at' => $currentDate,
                    'updated_at' => $currentDate
                ]
            );
        }
        return back()->with('success','เพิ่มข้อมูลลูกหนี้สำเร็จ');
    }

    public function list()
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
            ->select('uuid','claim_id','vn','visitdate','hospmain','hcode','name','hn','h_name',
            'icd10','fs_code','total','nhso_code','nhso_name','nhso_unit','nhso_cost','p_name','p_icon','p_text_color')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->leftjoin('p_status','p_status.id','claim_list.p_status')
            // ->where('p_status', 1)
            ->where('hcode',$hcode)
            ->orderby('claim_id','desc')
            ->get();
        return view('debtor.list',['data'=>$data]);
    }

    public function show(string $id)
    {
        $data = DB::table('claim_list')
            ->select('vn','visitdate','hospmain','hcode','name','hn',
            'h_name','auth_code','person_id','age','sex_name','sex_icon')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->leftjoin('sex_type','sex_type.sex_id','claim_list.sex')
            ->where('vn', $id)
            ->first();

        $list = DB::table('claim_list')
            ->select('icd10','fs_code','total','nhso_code','nhso_name','nhso_unit','nhso_cost')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->where('vn', $id)
            ->get();
        // echo $list;
        return view('debtor.show',['data'=>$data,'list'=>$list]);
    }

    public function send()
    {
        $currentDate = date('Y-m-d');
        $hcode = Auth::user()->hcode;
        $transCode = $hcode.date('Ym').substr(rand(),1,5);

        DB::table('claim_list')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->where('hcode',$hcode)
            // ->whereNotNull('nhso_code')
            ->whereNull('trans_code')
            ->update(
                [
                    'trans_code' => $transCode,
                    'p_status' => 2,
                    'updated_at' => $currentDate
                ]
            );
    }
}
