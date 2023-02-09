<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
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
}
