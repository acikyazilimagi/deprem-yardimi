<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function index(Request $request)
    {
        $cities = Location::select('city')->groupBy('city')->get();
        
        $filter_city = $request->get('city');

        // TODO: Daha sonra geliştirilicek.
        // $filtered_data = [];
        // if($city) {
        //     $filtered_data = $this->filtered($city);
        // }

        $data = [
            'cities' => $cities,
            'filter_city' => $filter_city,
            'alert_message' => $filter_city ? 'Lütfen <b>ilçe</b> seçiniz ve <b>Ara</b> butonuna tıklayınız.' : null
        ];
        
        return view('filter.index', $data);
    }

    public function filter(Request $request)
    {
        $city = $request->get('city');
        $district = $request->get('district');
        $street = $request->get('street');
        $keyword = $request->get('keyword');

        if (!$city && !$district) {
            $data = [];
        } else {
            $data = $this->filtered($city, $keyword, $district, $street);
        }

        $result = [
            'data' => $data
        ];
        return response()->json($result);
    }

    function filtered($city, $keyword = null, $district = null, $street = null)
    {
        return Data::select(['city', 'district', 'street', 'street2', 'apartment', 'apartment_no', 'apartment_floor', 'address', 'fullname', 'source', 'created_at'])
            ->where(function ($q) use ($city, $district, $street) {
                if ($city) {
                    $q->where("city", $city);
                }
                if ($district) {
                    $q->where("district", $district);
                }
                if ($street) {
                    $q->where("street", $street);
                }
            })
            ->where(function ($q) use ($keyword) {
                if ($keyword) {
                    $q
                        ->where("fullname", "like", "%{$keyword}%")
                        ->orWhere("address", "like", "%{$keyword}%")
                        ->orWhere("street2", "like", "%{$keyword}%");
                }
            })
            ->orderBy('id', 'DESC')
            ->get();
    }
}
