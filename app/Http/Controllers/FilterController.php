<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function index(){
        $cities = Location::select('city')->groupBy('city')->get();
        $data = [
            'cities' => $cities
        ];
        return view('filter.index', $data);
    }

    public function filter(Request $request){
        $city = $request->get('city');
        $district = $request->get('district');
        $street = $request->get('street');
        $keyword = $request->get('keyword');

        if (!$city || !$district){
            $data = [];
        }else{
            $data = Data::
            select(['city', 'district', 'street', 'street2', 'apartment', 'apartment_no', 'apartment_floor', 'address', 'fullname', 'source', 'created_at'])
                ->where(function ($q) use ($city, $district, $street){
                    if ($city && $district){
                        $q
                            ->where("city", $city)
                            ->where("district", $district);
                    }
                    if ($street){
                        $q->where("street", $street);
                    }
                })
                ->where(function ($q) use ($keyword){
                    if ($keyword){
                        $q
                            ->where("fullname", "like", "%{$keyword}%")
                            ->orWhere("address", "like", "%{$keyword}%")
                            ->orWhere("street2", "like", "%{$keyword}%")
                        ;
                    }
                })
                ->orderBy('id', 'DESC')
                ->get();

        }

        $result = [
            'data' => $data
        ];
        return response()->json($result);
    }
}
