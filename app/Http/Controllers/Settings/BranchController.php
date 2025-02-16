<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $data = Branch::where('del', 1)->get();
        return response()->json([
            'branches' => $data
        ], 200);
    }
    public function update(Request $request, $id)
    {
        try {
            $branch = Branch::find($id);
            if (!$branch) {
                return response()->json(['message' => 'Branch not found'], 404);
            }
            $branch_data = $request->only([
                'name_la',
                'name_en',
                'name_cn',
                'phone',
                'email',
                'address_la',
                'address_en',
                'address_cn',
                'whatapps',
                'facebook',
                'youtube',
                'google_map',
                'play_store',
                'app_store',
                'app_gallery',
                'director_sign',
                'chechker_sign',
                'customer_sign',
                'staff_sign',
                'bill_header',
                'bill_footer'
            ]);
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoname = now()->format('YmdHis') . '_' . $logo->getClientOriginalName();
                if(!empty($logo)){
                    if(!empty($branch->logo) && file_exists($branch->logo)){
                       unlink(public_path($branch->logo));
                    }
                }
                $logo->move(public_path('upload/branches'), $logoname);
                $branch_data['logo'] = 'upload/branches/' . $logoname;
            }
            $branch->update(array_filter($branch_data, fn($value) => $value !== null));
            if (isset($branch_data['logo'])) {
                $branch->forceFill(['logo' => $branch_data['logo']])->save();
            }
            return response()->json(['data' => $branch], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
