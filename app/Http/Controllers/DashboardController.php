<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\service_offers;
use App\Models\schedule_list;
use Auth;
class DashboardController extends Controller
{
    public function dashboard()
    {
        $doctors = User::where('user_type','doctor')->get();
        $services = service_offers::all();
        
        if(Auth::user()->user_type == 'patient'){
            return view('appointment',['doctors' => $doctors, 'services' => $services]);
        }else{
            $registered_user = User::where('user_type','patient')->count();
            $registered_doctor = User::where('user_type','doctor')->count();
            $appointments = schedule_list::count();
            return view('dashboard',['user'=>$registered_user,'doctors'=>$registered_doctor,'appointments'=>$appointments]);
        }
        
    }

   
}
