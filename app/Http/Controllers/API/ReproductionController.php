<?php

namespace App\Http\Controllers\API;

use App\Models\Reproduction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReproductionController extends Controller
{
    public function index($site_id)
    {
        $reproductions = Reproduction::where('site_id', $site_id)->get();
        return response()->json($reproductions, 200);
    }

    public function store(Request $request)
    {
        try {
            if (Reproduction::find($request['id']) !== null) {
                $reproduction = Reproduction::find($request->id);
                $reproduction->update($request->all());
            } else {
                Reproduction::create($request->all());
            }

            return response()->json(201);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $reproduction = Reproduction::find($id);
            $reproduction->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
