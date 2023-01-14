<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\service_offers;
use App\Models\schedule_list;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserVerification;
use Illuminate\Support\Facades\Notification;
use Auth;

class UsersController extends Controller
{
    //users
    public function viewDoctors(){
        return view('users');
    }

    public function getAllDoctors(){
        $query = User::where('user_type','doctor')->get();
        return DataTables::of($query)->make(true);
    }

    public function addDoctor(Request $request){
        $check_email = User::where('email',$request['email'])->count();
		if($check_email > 0){
			return 'email already in use';
		}

		DB::beginTransaction();

		$user = new User;
		$user->name = $request['name'];
        $user->email = $request['email'];
        $user->birthdate = $request['birthdate'];
        $user->contact = $request['contact'];
        $user->address = $request['address'];
        $user->is_verified = '1';
		$user->user_type = 'doctor';
        $user->password = Hash::make($request['password']);
		$user->save();

		if($user){		
			DB::commit();
			return 'success';
		}else{
			return 'Something went wrong';
		}
    }

    public function updateDoctorData(Request $request){

        DB::beginTransaction();

        $user = User::where('id',$request['data_id'])->first();
		$user->name = $request['name'];
        $user->email = $request['email'];
        $user->birthdate = $request['birthdate'];
        $user->contact = $request['contact'];
        $user->address = $request['address'];
		$user->save();

		if($user){		
			DB::commit();
			return 'success';
		}else{
			return 'Something went wrong';
		}
    }

    public function viewAppointment(){
        $doctors = User::where('user_type','doctor')->get();
        $services = service_offers::all();
        return view('appointment',['doctors' => $doctors, 'services' => $services]);
    }

    public function viewScheduledAppointment(){
        
        $query = DB::table('schedule_lists as a')
                   ->join('users as b','b.id','a.user_id')
                   ->join('users as c','c.id','a.doctor')
                   ->join('service_offers as d','d.id','a.service')
                   ->select('a.*','b.name as patient','c.name as doctor_name','d.service_name as service','d.id as service_id'
                   ,'d.price');
        if(Auth::user()->user_type == 'doctor'){
            $query = $query->where('a.doctor',Auth::user()->id);
        }else if(Auth::user()->user_type == 'patient'){
            $query = $query->where('a.user_id',Auth::user()->id);
        }else{
            $query = $query->get();
        }
        
        

        return DataTables::of($query)->make(true);
    }

    public function createAppointmentSchedule(Request $request){

        DB::beginTransaction();
        $check_appointment = schedule_list::where('user_id',Auth::user()->id)
                                          ->where('schedule_date',$request['schedule_date'])
                                          ->where('status','0')
                                          ->count();

        if($check_appointment > 0){
            return 'You have pending appointment schedule.! Please wait for confirmation';
        }

        $book_appointment = new schedule_list;
        $book_appointment->user_id = Auth::user()->id;
        $book_appointment->schedule_date = $request['schedule_date'];
        $book_appointment->service = $request['service'];
        $book_appointment->doctor = $request['doctor'];
        $book_appointment->status = '0';
        $book_appointment->save();

        if($book_appointment){
            DB::commit();
            return 'success';
        }else{
            return 'Something went wrong!';
        }
       
    }

    public function updateAppointmentSchedule(Request $request){

        DB::beginTransaction();
        $update = schedule_list::where('id',$request['data_id'])
                                ->update([
                                        'doctor' => $request['doctor'],
                                        'service' => $request['service'],
                                        'schedule_date' => $request['schedule_date']
                                    ]);

        if($update){
            
            DB::commit();
            return 'success';
        }else{
            return 'Something went wrong!';
        }
       
    }
    
    public function approveAppointmentSchedule($id,$status,$patientid){
        $stats = $status == 'approved' ? '1' : '2';
        DB::beginTransaction();
        $update = schedule_list::where('id',$id)->update(['status' => $stats]);

        if($update){
            $patient = User::where('id',$patientid)->first();
            $info = [
				'name' => $patient->name,
				'email_message' => $status == 'approved' ? 'Good day.! Please be inform that your appointment has been approved.' : 'Good day.! Please be inform that your appointment has been disapproved.',
				'is_sent' => true,
				
			];
			$patient->notify(new UserVerification($info));
            DB::commit();
            return 'success';
        }else{
            return 'Something went wrong!';
        }
       
    }

    public function getMonthlyAnalytics(){
        $data = DB::select('SELECT COUNT(1) AS no_of_book,MONTHNAME(schedule_date) months FROM schedule_lists GROUP BY MONTH(schedule_date)');
        return $data;
    }

    public function changePass(){
        return view('changepass');
    }

    public function updatePassword(Request $request){
        $new = Hash::make($request['new_password']);
        $update = User::where('id',Auth::user()->id)->update(['password' => $new]);

        if($update){
            return 'success';
        }else{
            return 'Something went wrong!';
        }
    }
    
}
