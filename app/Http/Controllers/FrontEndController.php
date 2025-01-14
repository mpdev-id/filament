<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CarService;
use App\Models\CarStore;
use App\Models\City;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{

    public function index() {
        $data['cities']    = City::all();
        $data['services']  = CarService::withCount('storeServices')->get();
        return view('front.index',compact('data'));
    }

    public function search(Request $request) {
        $cityId        = $request->input('city_id');
        $serviceTypeId = $request->input('service_type');

        // 1
        $data['carService'] = CarService::where('id',$serviceTypeId)->first();
        if(!$data['carService']) {
            return redirect()->back()->with('error','Service type not found');
        }

        $carService =$data['carService'];

        // 2
        $data['stores'] = CarStore::whereHas('storeServices', function($query) use ($carService) {
        //    dd($carService);
            $query->where('car_service_id', $carService->id);
        })->where('city_id', $cityId)->get();

        // 3
        $city = City::find($cityId);
        $data['cityName']= $city? $city->name : 'unknown city' ;

        session()->put('serviceTypeId',$request->input('service_type'));

        return view('front.stores',compact($data));
    }

}
