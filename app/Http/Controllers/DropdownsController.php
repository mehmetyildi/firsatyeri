<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class DropdownsController extends Controller
{


    public function getDistrictList(Request $request)
    {
        $districts = DB::table("districts")
            ->where("city_id",$request->city_id)
            ->pluck("name","id");
        return response()->json($districts);
    }
}
