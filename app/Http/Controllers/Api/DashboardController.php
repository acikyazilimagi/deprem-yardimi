<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Data;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = [
            'city' => $request->city,
            'district' => $request->district,
            'street' => $request->street,
            'street2' => $request->street2,
            'fullname' => $request->fullname,
        ];

        $data = Data::filter($filter)->paginate($request->per_page ?? 25);

        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Bad Request',
            ], 404);
        }
    }

    public function list_all(Request $request)
    {
        $filter = [
            'city' => $request->city,
            'district' => $request->district,
            'street' => $request->street,
            'street2' => $request->street2,
            'fullname' => $request->fullname,
        ];

        $data = Data::filter($filter)->get();

        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Bad Request',
            ], 404);
        }
    }
}
