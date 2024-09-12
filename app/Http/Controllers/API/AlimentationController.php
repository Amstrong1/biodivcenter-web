<?php

namespace App\Http\Controllers\API;

use App\Models\Alimentation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlimentationController extends Controller
{
    public function index($site_id)
    {
        $alimentations = Alimentation::where('site_id', $site_id)
            ->select('id', 'food', 'specie_id')
            ->orderBy('id', 'desc')
            ->get()
            ->append('specie_name');
        return response()->json($alimentations, 200);
    }

    public function show($id)
    {
        $alimentation = Alimentation::find($id);
        return response()->json($alimentation);
    }

    public function store(Request $request)
    {
        try {
            Alimentation::create($request->all());
            return response()->json(201);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $alimentation = Alimentation::find($id);
            $alimentation->update($request->all());
            return response()->json([$alimentation], 200);
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
