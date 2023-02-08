<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    private $mainFolder = 'dashboard';

    public function index(Request $request)
    {
        $data['mainFolder'] = $this->mainFolder;
        $data['cityList'] = Data::select('city')->distinct('address')->groupBy('city')->get();

        return view("{$this->mainFolder}.index", $data);
    }

    public function datatable(Request $request)
    {
        $query = Data::orderBy('id', 'DESC');

        return Datatables::of($query)
            ->addColumn('city', function ($row) {
                return $row?->city.' / '.$row?->district.' / '.$row?->street;
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
            ->filterColumn('fullname', function ($query, $keyword) {
                $query
                    ->where("fullname", "like", "%{$keyword}%")
                    ->orWhere("address", "like", "%{$keyword}%")
                    ->orWhere("city", "like", "%{$keyword}%")
                    ->orWhere("district", "like", "%{$keyword}%")
                    ->orWhere("street", "like", "%{$keyword}%")
                    ->orWhere("address_detail", "like", "%{$keyword}%")
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
}
