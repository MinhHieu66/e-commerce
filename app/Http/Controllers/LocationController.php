<?php
namespace App\Http\Controllers;

use App\Models\Districts;
use App\Models\Wards;

class LocationController extends Controller
{
    public function getDistricts($province_id)
    {
        $districts = Districts::where('province_id', $province_id)->get();
        return response()->json($districts);
    }

    public function getWards($district_id)
    {
        $wards = Wards::where('district_id', $district_id)->get();
        return response()->json($wards);
    }

}
