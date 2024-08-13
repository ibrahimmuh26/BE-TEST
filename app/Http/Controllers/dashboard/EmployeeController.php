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
        dd($request->input('name'));
        try {

            $validated = $request->validate([

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
}
