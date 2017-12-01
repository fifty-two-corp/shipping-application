<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Indonesia;

class IndonesiaController extends Controller
{
    public function getCity($id) {
        $city = Indonesia::findProvince($id, ['cities']);
        $city = $city->cities;
        return response()->json($city);
    }

    public function getDistrict($id) {
        $districts = Indonesia::findCity($id, ['districts']);
        $districts = $districts->districts;
        return response()->json($districts);
    }
}
