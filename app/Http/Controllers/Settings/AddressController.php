<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function village()
    {
        $data = Village::with('district:id,name_la')->select('id', 'name_la', 'name_en', 'name_cn', 'district_id')->get();
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
    //village
    public function store(Request $request)
    {
        try {
            $data = new Village();
            $data->name_la  = $request->name_la;
            if ($request->name_en) {
                $data->name_en  = $request->name_en;
            }
            if ($request->name_cn) {
                $data->name_cn  = $request->name_cn;
            }
            $data->district_id = $request->district_id;
            $data->save();
            return response()->json(['village' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $data = Village::find($id);
            if (!$data) {
                return response()->json(['message' => 'Branch not found'], 404);
            }
            $data->name_la  = $request->name_la;
            if ($request->name_en) {
                $data->name_en  = $request->name_en;
            }
            if ($request->name_cn) {
                $data->name_cn  = $request->name_cn;
            }
            if ($request->district_id) {
                $data->district_id  = $request->district_id;
            }
            $data->update();
            return response()->json(['village' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    // end
}
