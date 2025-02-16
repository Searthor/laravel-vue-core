<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data = User::with('role') // Eager load the role relationship
            ->select(
                'users.id',
                'users.firstname',
                'users.lastname',
                'users.phone',
                'users.email',
                'users.role_id',
                'users.vill_id',
                'users.dis_id',
                'users.pro_id'
            )
            ->where('branches_id', auth()->user()->branches_id)
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
            return response()->json(['data' => $data], 200);
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
}
