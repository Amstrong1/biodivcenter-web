<?php

namespace App\Http\Controllers\API;

use App\Models\Reproduction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReproductionController extends Controller
{
    public function index($site_id)
    {
        $reproductions = Reproduction::where('site_id', $site_id)
            ->select('id', 'phase', 'date', 'animal_id')
            ->orderBy('id', 'desc')
            ->get()
            ->append('animal_name');
        return response()->json($reproductions, 200);
    }

    public function show($id)
    {
        $reproduction = Reproduction::find($id);
        return response()->json($reproduction);
    }

    public function store(Request $request)
    {
        try {
            Reproduction::create($request->all());
            return response()->json(201);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $reproduction = Reproduction::find($id);
            $reproduction->update($request->all());
            return response()->json([$reproduction], 200);
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
