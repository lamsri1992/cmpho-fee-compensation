<?php

namespace App\Http\Controllers\Creditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class creditor extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
            ->select('uuid','claim_id','vn','visitdate','hospmain','h_code','name','hn','h_name',
            'icd10','fs_code','total','nhso_code','nhso_name','nhso_unit','nhso_cost','p_name','p_icon','p_text_color')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hcode')
            ->leftjoin('p_status','p_status.id','claim_list.p_status')
            ->where('hospmain',$hcode)
            ->where('p_status',3)
            ->orderby('claim_id','desc')
            ->get();
        return view('creditor.index',['data'=>$data]);
    }
    
    public function hospital()
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
                ->select(DB::raw('COUNT(DISTINCT vn) AS num,SUM(total) AS total'),'hcode','h_name',)
                ->join('hospital','h_code','claim_list.hcode')
                ->where('hospmain',$hcode)
                ->where('p_status',3)
                ->whereRaw('MONTH(process_date) = MONTH(CURDATE())')
                ->whereRaw('YEAR(process_date) = YEAR(CURDATE())')
                ->groupBy('hcode','h_name')
                ->get();
        return view('creditor.hospital',
        [
            'data'=>$data
        ]);
    }

    public function hospitalSearch(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $year = $request->year - 543;
        $data = DB::table('claim_list')
                ->select(DB::raw('COUNT(DISTINCT vn) AS num,SUM(total) AS total'),'hcode','h_name',)
                ->join('hospital','h_code','claim_list.hcode')
                ->where('hospmain',$hcode)
                ->where('p_status',3)
                ->whereRaw('MONTH(process_date) = '.$request->month.'')
                ->whereRaw('YEAR(process_date) = '.$year.'')
                ->groupBy('hcode','h_name')
                ->get();
        return view('creditor.hospitalMonth',
        [
            'data'=>$data
        ]);
    }

    public function hospitalList(string $id,$month)
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
            ->select(DB::raw('DISTINCT vn , SUM(total) as total'),'visitdate','person_id','name','hcode','h_name')
            ->leftjoin('hospital','hospital.h_code','claim_list.hcode')
            ->where('hcode',$id)
            ->where('hospmain',$hcode)
            ->whereRaw('MONTH(process_date) = '.$month.'')
            ->where('p_status',3)
            ->groupby('vn','visitdate','person_id','name','hcode','h_name')
            ->get();
        return view('creditor.hospitalList',
        [
            'data'=>$data,
            'id'=>$id
        ]);
    }

    public function vn(string $id)
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
            ->select('vn','visitdate','hospmain','hcode','name','hn',
            'h_name','auth_code','person_id','age','sex_name','sex_icon')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->leftjoin('sex_type','sex_type.sex_id','claim_list.sex')
            ->where('vn', $id)
            ->where('hospmain', $hcode)
            ->first();

        $list = DB::table('claim_list')
            ->select('uuid','icd10','fs_code','total','nhso_code','nhso_name','nhso_unit','nhso_cost')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->where('vn', $id)
            ->where('hospmain', $hcode)
            ->where('p_status','<>', 5)
            ->get();

        $deny = DB::table('claim_list')
            ->select('uuid','icd10','fs_code','total','nhso_code','nhso_name','nhso_unit','nhso_cost')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->where('vn', $id)
            ->where('hospmain', $hcode)
            ->where('p_status', 5)
            ->get();
        return view('creditor.vn',
            [
                'data'=>$data,
                'list'=>$list,
                'deny'=>$deny,
            ]
        );
    }

    public function deny($id)
    {
        $currentDate = date('Y-m-d H:i:s');
        $data = DB::table('claim_list')->where('uuid',$id)->update(
            [
                "p_status" => 5,
                "updated_at" => $currentDate
                
            ]
        );
        return back()->with('success','ยืนยันไม่จ่ายรายการแล้ว');
    }

}
