<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataCreateRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\{
  Data,
  Location
};

class DashboardController extends Controller
{
  private $mainFolder = "dashboard";

  public function index(Request $request)
  {
    $data["mainFolder"]   = $this->mainFolder;
    $data["cities"]       = Location::select("city")->groupBy("city")->get();
    $data["cityList"]     = Data::select("city")->distinct('address')->groupBy("city")->get();

    return view("{$this->mainFolder}.index", $data);
  }

  public function store(DataCreateRequest $request)
  {
    $insert = new Data();
    $insert->fill($request->all());
    $insert->save();

    if($insert){
      return response()->json([
          'status' => true,
          'data' => [
              'title' => 'Kayıt Başarılı',
              'message' => 'Veri başarıyla eklendi',
              'status' => 'success',
          ]
      ]);
    }else{
        return response()->json([
            'status' => false,
            'data' => [
                'title' => 'Kayıt Başarısız',
                'message' => 'Veri eklenirken bir hata oluştu',
                'status' => 'error',
            ]
        ]);
    }
  }

  public function datatable(Request $request)
  {
    $query  = Data::orderBy("id", "DESC");

    return Datatables::of($query)
      ->addColumn("city", function($row) {
        return $row->city . " / " . $row->district . " / " . $row->street;
      })
      ->addColumn("address", function($row) {
        return $row->street2 . " " . $row->apartment . " / No: " . $row->apartment_no . " Kat: " . $row->apartment_floor;
      })
      ->addColumn("address_detail", function($row) {
        return $row->address;
      })
      ->addColumn("fullname", function($row) {
        return $row->fullname;
      })
      ->filterColumn('fullname', function($query, $keyword) {
        $query->where(function($query) use ($keyword) {
          $query->where("fullname", "like", "%{$keyword}%")
                ->orWhere("address", "like", "%{$keyword}%");
        });
      })
      ->make(true);

    // return Datatables::of($query)
    //   ->addColumn("city", function($row) {
    //     return $row?->city . " / " . $row?->district . " / " . $row?->street;
    //   })
    //   ->addColumn("address", function($row) {
    //     return $row?->street2 . " " . $row?->apartment . " / No: " . $row?->apartment_no . " Kat: " . $row?->apartment_floor;
    //   })
    //   ->addColumn("address_detail", function($row) {
    //     return $row?->address;
    //   })
    //   ->addColumn("fullname", function($row) {
    //     return $row?->fullname;
    //   })
    //   ->filterColumn('fullname', function($query, $keyword) {
    //     $query->whereRaw("fullname LIKE ?", ["%{$keyword}%"])
    //           ->orWhereRaw("address LIKE ?", ["%{$keyword}%"]);
    //   })
    //   ->make(true);
  }

  public function list(Request $request)
  {

  }

  public function get_district(Request $request)
  {
    $districts = Location::select("district")->where("city", $request->city)->groupBy("district")->get();

    return response()->json([
      "status"  => "success",
      "data"    => $districts
    ]);
  }

  public function get_street(Request $request)
  {
    $streets = Location::select("street")->where("district", $request->district)->groupBy("street")->get();

    return response()->json([
      "status"  => "success",
      "data"    => $streets
    ]);
  }
}
