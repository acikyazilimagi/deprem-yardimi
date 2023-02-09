<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictApiRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function districts(DistrictApiRequest $request): JsonResponse
    {
        $districts = Location::select('district')->where('city', $request->city)->groupBy('district')->get();

        return response()->json([
            'status' => 'success',
            'data' => $districts,
        ]);
    }

    public function streets(Request $request): JsonResponse
    {
        $streets = Location::select('street')->where('district', $request->district)->groupBy('street')->get();

        return response()->json([
            'status' => 'success',
            'data' => $streets,
        ]);
    }
}
