<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\RolesResoures;
use App\Models\FunctionAvailable;
use App\Models\FunctionModel;
use App\Models\Roles;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RolesComtroller extends Controller
{

    public function index()
    {
        $roles = Roles::all();


        return response()->json([
            'roles' => $roles
        ], 200);
    }

    public function show($id)
    {
        try {
            // Find the role by ID
            $role = Roles::where('id', $id)->get();
            // return response()->json($role, 200);
            return response(['data' => RolesResoures::collection($role)], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Role not found', $ex], 404);
        }
    }


    public function get_function_models()
    {
        $data = FunctionModel::whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->with('grandchildren');
            }])
            ->get();
        $data->each(function ($parent) {
            $parent->children = $parent->children ?? collect();
            $parent->children->each(function ($child) {
                $child->grandchildren = $child->grandchildren ?? collect();
            });
        });
        return response()->json(['function' => $data], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ], [
            'name.required' => __('lang.please_fill_information_first'),
        ]);

        try {
            DB::beginTransaction();

            $data = new Roles();
            $data->name = $request->name;
            $data->des = $request->des;
            $data->save();

            // Ensure function_id is an array
            $functionIds = $request->input('function_id', []);

            foreach ($functionIds as $functionId) {
                $check_already = FunctionAvailable::where('role_id', $data->id)
                    ->where('function_id', $functionId)
                    ->first();

                if (!$check_already) {
                    FunctionAvailable::create([
                        'role_id' => $data->id,
                        'function_id' => $functionId,
                    ]);
                }
            }
            DB::commit();
            return response()->json(['message' => 'Role created successfully'], 201);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
           
    }


    public function update(Request $request, $id)
    {
        // Validate incoming data, making sure the name is unique but excluding the current role's id
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id, // Exclude the current role from uniqueness check
        ], [
            'name.required' => __('lang.please_fill_information_first'),
        ]);

        try {
            DB::beginTransaction();

            // Find the role to update
            $data = Roles::findOrFail($id); // Use findOrFail to throw an exception if role is not found
            $data->name = $request->name;
            $data->des = $request->des;
            $data->save(); // Use save() instead of update() to ensure it updates the model instance

            // Delete all existing function associations
            FunctionAvailable::where('role_id', $id)->delete();

            // Ensure function_id is an array and insert new relations
            $functionIds = $request->input('function_id', []);

            foreach ($functionIds as $functionId) {
                // Check if the function is already assigned to this role
                $checkAlready = FunctionAvailable::where('role_id', $data->id)
                    ->where('function_id', $functionId)
                    ->first();

                if (!$checkAlready) {
                    FunctionAvailable::create([
                        'role_id' => $data->id,
                        'function_id' => $functionId,
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Role updated successfully'], 200); // Changed status code to 200
        } catch (\Exception $ex) {
            DB::rollBack();

            // Log the error for debugging


            return response()->json(['error' => 'Failed to update role: ' . $ex->getMessage()], 500); // Detailed error message
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = Roles::find($id);
            FunctionAvailable::where('role_id', $id)->delete();
            $data->delete();
            DB::commit();
            return response()->json(['message' => 'Role delete successfully'], 200); // Changed status code to 200
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update role: ' . $ex->getMessage()], 500); // Detailed error message
        }
    }
}
