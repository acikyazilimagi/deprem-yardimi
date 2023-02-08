<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $cities_cache_key = 'cities_';

        if (Cache::has($cities_cache_key)){
            $cities = Cache::get($cities_cache_key);
        }else{
            $cities = Data::select('city')->distinct('address')->groupBy('city')->get();
            Cache::set($cities_cache_key, $cities);
        }

        $data = [
            'cityList' => $cities
        ];

        return view("dashboard.index", $data);
    }

    public function datatable(Request $request)
    {
        $query = Data::orderBy('id', 'DESC');

        return Datatables::of($query)
            ->addColumn('city', function ($row) {
                return $row?->city.' / '.$row?->district.' / '.$row?->street;
            })
            ->addColumn('city_raw', function ($row) {
                return $row?->city;
            })
            ->addColumn('address', function ($row) {
                return $row?->street2.' '.$row?->apartment.' / No: '.$row?->apartment_no.' Kat: '.$row?->apartment_floor;
            })
            ->addColumn('address_detail', function ($row) {
                return $row?->address;
            })
            ->addColumn('fullname', function ($row) {
                return $row?->fullname;
            })
            ->addColumn('maps_link', function ($row) {
                return $row?->maps_link;
            })
            ->filterColumn('fullname', function ($query, $keyword) {
                $query
                    ->where("fullname", "like", "%{$keyword}%")
                    ->orWhere("address", "like", "%{$keyword}%")
                    ->orWhere("city", "like", "%{$keyword}%")
                    ->orWhere("district", "like", "%{$keyword}%")
                    ->orWhere("street", "like", "%{$keyword}%")
                ;
            })
            ->make(true);
    }

    public function list(Request $request)
    {
    }

    public function get_district(Request $request)
    {
        $districts = Location::select('district')->where('city', $request->city)->groupBy('district')->get();

        return response()->json([
            'status' => 'success',
            'data' => $districts,
        ]);
    }

    public function get_street(Request $request)
    {
        $streets = Location::select('street')->where('district', $request->district)->groupBy('street')->get();

        return response()->json([
            'status' => 'success',
            'data' => $streets,
        ]);
    }

    public function fast_search(Request $request)
    {
        return view("dashboard.fast_search");
    }

}
