<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $data = User::with(['role:id,name', 'village:id,name_la', 'district:id,name_la', 'province:id,name_la']) // Load specific columns only
            ->select([
                'id',
                'firstname',
                'lastname',
                'phone',
                'email',
                'role_id',
                'vill_id',
                'dis_id',
                'pro_id',
                'del'
            ])
            ->where('branches_id', auth()->user()->branches_id)
            ->orderBy('id', 'desc') // Sorting by an indexed column for faster retrieval
            ->get();

        return response()->json([
            'users' => $data
        ], 200);
    }


    public function store(Request $request)
    {
        try {
            $data = new User();
            $data->firstname  = $request->firstname;
            $data->lastname  = $request->lastname;
            $data->phone  = $request->phone;
            if ($request->email) {
                $data->email  = $request->email;
            }
            $data->branches_id = auth()->user()->branches_id;
            if ($request->password) {
                $data->password  = bcrypt($request->password);
            }
            if ($request->role_id) {
                $data->role_id  = $request->role_id;
            }
            if ($request->vill_id) {
                $data->vill_id  = $request->vill_id;
            }
            if ($request->dis_id) {
                $data->dis_id  = $request->dis_id;
            }
            if ($request->pro_id) {
                $data->pro_id  = $request->pro_id;
            }
            $data->save();
            return response()->json(['users' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $data = User::find($id);
            if (!$data) {
                return response()->json(['message' => 'Branch not found'], 404);
            }
            $data->firstname  = $request->firstname;
            $data->lastname  = $request->lastname;
            $data->phone  = $request->phone;
            if ($request->email) {
                $data->email  = $request->email;
            }
            if ($request->password) {
                $data->password  = bcrypt($request->password);
            }
            if ($request->role_id) {
                $data->role_id  = $request->role_id;
            }
            if ($request->vill_id) {
                $data->vill_id  = $request->vill_id;
            }
            if ($request->dis_id) {
                $data->dis_id  = $request->dis_id;
            }
            if ($request->pro_id) {
                $data->pro_id  = $request->pro_id;
            }
            if ($request->del) {
                $data->del =  $request->del;
            }
            $data->update();
            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = User::find($id);
            $data->delete();
            DB::commit();
            return response()->json(['message' => 'Delete successfully'], 200); // Changed status code to 200
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update role: ' . $ex->getMessage()], 500); // Detailed error message
        }
    }
}
