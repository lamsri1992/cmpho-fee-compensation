<?php

namespace App\Http\Controllers\Cmpho;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class dataController extends Controller
{
    public function index()
    {
        $sql = "SELECT DISTINCT(claim_list.hcode),hospital.h_name,COUNT(claim_list.trans_code) AS total
                FROM claim_list
                LEFT JOIN hospital ON hospital.h_code = claim_list.hcode
                WHERE p_status = '2'
                GROUP BY claim_list.hcode,hospital.h_name,claim_list.trans_code";
         $data = DB::select($sql);
        return view('cmpho.welcome',['data'=>$data]);
    }

    public function process()
    {
        $currentDate = date('Y-m-d');
        $hcode = Auth::user()->hcode;

        DB::table('claim_list')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->where('p_status',2)
            ->whereNotNull('trans_code')
            ->update(
                [
                    'p_status' => 3,
                    'process_date' => $currentDate
                ]
            );
    }

    public function report(Request $request)
    {
        $sql = "SELECT claim_list.hcode,hospital_a.h_name AS visit_hospital,
                claim_list.hospmain,hospital_b.h_name AS main_hospital,
                COUNT(claim_list.trans_code) AS cases,
                SUM(claim_list.total) AS total
                FROM claim_list
                LEFT JOIN hospital as hospital_a ON hospital_a.h_code = claim_list.hcode
                LEFT JOIN hospital as hospital_b ON hospital_b.h_code = claim_list.hospmain
                WHERE claim_list.p_status = 3
                AND MONTH(claim_list.process_date) = $request->month
                GROUP BY claim_list.trans_code,claim_list.hcode,claim_list.hospmain,hospital_a.h_name,hospital_b.h_name
                ORDER BY hospital_a.h_code,hospital_b.h_code ASC";
        $data = DB::select($sql);
        $month = $request->month;
        return view('cmpho.report',['data'=>$data,'month'=>$month]);
    }

}
