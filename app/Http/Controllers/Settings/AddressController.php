<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Village;
class AddressController extends Controller
{
    public function village()
    {
        $data = Village::select('id', 'name_la', 'name_en', 'name_cn', 'district_id')->get();
        return response()->json([
            'villages' => $data
        ], 200);
    }
    public function district()
    {
        $data = District::select('id', 'name_la', 'name_en', 'name_cn', 'province_id')->get();
        return response()->json([
            'districts' => $data
        ], 200);
    }
    public function province()
    {
        $data = Province::select('id', 'name_la', 'name_en', 'name_cn')->get();
        return response()->json([
            'provinces' => $data
        ], 200);
    }
}
