<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\service_offers;
use Illuminate\Support\Facades\DB;
use DataTables;

class ServicesController extends Controller
{
    //

    public function viewServices(){
        return view('services');
    }

    public function getAllServices(){
        $query = service_offers::all();
        return DataTables::of($query)->make(true);
    }

    public function createService(Request $request){
        
        $check = service_offers::where('service_name',$request['service_name'])->count();

        if($check > 0){
            return 'already exists!';
        }

        $service = new service_offers;
        $service->service_name = $request['service_name'];
        $service->price = $request['price'];
        $service->save();

        return 'success';
    }

    public function updateServiceData(Request $request){
        
        $update = service_offers::where('id',$request['hidden_id_edit'])
                              ->update(['service_name' => $request['edit_service_name'], 'price' => $request['edit_price']]);

        if($update){
            return 'success';  
        }else{
            return 'Something went wrong';
        }

    }
}
