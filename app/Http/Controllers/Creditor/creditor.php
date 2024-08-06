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
            ->orderby('claim_id','desc')
            ->get();
        return view('creditor.index',['data'=>$data]);
    }
}
