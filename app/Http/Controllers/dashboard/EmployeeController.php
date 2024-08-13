<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\employee;

class EmployeeController extends Controller
{
    //
    public function create(Request $request)
    {
        try {

            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'name' => 'required|string',
                'phone' => 'required|string',
                'division_id' => 'required|string',
                'position' => 'required|string',

            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }


        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/image', $image_name);


        $employee = new employee();
        $employee->image = $image_name;
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->division_id = $request->division_id;
        $employee->position = $request->position;
        $employee->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Employee created successfully',
            'data' => $employee
        ]);
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);
        try {

            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'name' => 'required|string',
                'phone' => 'required|string',
                'division_id' => 'required|string',
                'position' => 'required|string',

            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/image', $image_name);

        $employee = employee::find($id);

        $employee->image = $image_name;
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->division_id = $request->division_id;
        $employee->position = $request->position;
        $employee->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Employee updated successfully',

        ]);
    }

    public function delete($id)
    {

        $employee = employee::find($id);
        $employee->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Employee deleted successfully',
        ]);
    }


    public function getData(Request $request)
    {

        // dd($request->all());
        try {

            $validated = $request->validate([
                'division_id' => 'required|string',
                'name' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }


        $employees = employee::where('name', 'like', '%' . $request->name . '%')->where('division_id', $request->division_id)->with(
            [
                'division' => function ($query) {
                    $query->select('id', 'name');
                }
            ]
        )->first();
        // dd($employees);
        if ($employees->count() > 0) {

            return response()->json([
                'status' => 'success',
                'message' => 'Employees fetched successfully',
                'data' => $employees
            ]);
        } else {

            return response()->json([
                'status' => 'error',
                'message' => 'Employees not found',
            ]);
        }
    }
}
