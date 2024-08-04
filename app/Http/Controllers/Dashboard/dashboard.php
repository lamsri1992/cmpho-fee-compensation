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
            return view('welcome');
        }
    }
    
    public function nhso()
    {
        $data = DB::table('nhso')->get();
        return view('nhso',['data'=>$data]);
    }
}
