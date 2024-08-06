<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class dashboard extends Controller
{
    public function index()
    {
        if(Auth::user()->mode == 'Y'){
            return redirect()->route('cmpho.index');
        }else{
            $hcode = Auth::user()->hcode;
            $deb_cost = DB::table('claim_list')->select(DB::raw('SUM(total) as total'))->where('hcode',$hcode)->first();
            $due_cost = DB::table('claim_list')->select(DB::raw('SUM(total) as total'))->where('hospmain',$hcode)->first();
            $deb_count = DB::table('claim_list')->where('hcode',$hcode)->count();
            $due_count = DB::table('claim_list')->where('hospmain',$hcode)->count();
            return view('welcome',
            [
                'deb_cost' => $deb_cost,
                'due_cost' => $due_cost,
                'deb_count' => $deb_count,
                'due_count' => $due_count,
            ]);
        }
    }
    
    public function nhso()
    {
        $data = DB::table('nhso')->get();
        return view('nhso',['data'=>$data]);
    }

    public function drug()
    {
        $data = DB::table('nhso_drug')->get();
        return view('drug',['data'=>$data]);
    }
}
