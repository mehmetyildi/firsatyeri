<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Group;
class DropdownsController extends Controller
{


    public function getDistrictList(Request $request)
    {
        $districts = DB::table("districts")
            ->where("city_id",$request->city_id)
            ->pluck("name","id");
        return response()->json($districts);
    }


    public function getGroupBoardList(Request $request)
    {
        $group=Group::find($request->group_id);
        $boards = $group->boards->pluck("name","id");
        return response()->json($boards);
    }
}
