<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Data;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HelpController extends Controller
{
    public function index(Request $request)
    {
        return view("help.index");
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
}
