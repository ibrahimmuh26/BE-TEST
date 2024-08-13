<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\division;

class DivisionController extends Controller
{
    //
    public function getData(Request $request)
    {

        if ($request->name == NULL) {
            $division = division::paginate(15);;
            return response()->json([
                'status' => 'success',
                'message' => 'Data All Division',
                'data' => $division


            ]);
        } else {
            $division = division::where('name', 'like', '%' . $request->name . '%');
            if ($division->count() == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data Not Found',
                ], 404);
            } else {

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Filter Division',
                    'data' => $division->paginate(15)

                ]);
            }
        }
    }
}
