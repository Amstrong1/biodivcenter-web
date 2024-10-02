<?php

namespace App\Http\Controllers\API;

use App\Models\Alimentation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlimentationController extends Controller
{
    public function index($site_id)
    {
        $alimentations = Alimentation::where('site_id', $site_id)->get();
        return response()->json($alimentations, 200);
    }

    public function store(Request $request)
    {
        try {
            if (Alimentation::find($request['id']) !== null) {
                $alimentation = Alimentation::find($request['id']);
                $alimentation->update($request->all());
            } else {
                Alimentation::create($request->all());
            }

            Alimentation::create($request->all());
            return response()->json(201);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $alimentation = Alimentation::find($id);
            $alimentation->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
