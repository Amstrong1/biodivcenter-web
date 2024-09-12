<?php

namespace App\Http\Controllers\API;

use App\Models\Observation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObservationController extends Controller
{
    public function index($site_id)
    {
        $observations = Observation::where('site_id', $site_id)
            ->select('id', 'subject')
            ->orderBy('id', 'desc')
            ->get()
            ->append('formated_date');
        return response()->json($observations, 200);
    }

    public function show($id)
    {
        $observation = Observation::find($id);
        return response()->json($observation);
    }

    public function store(Request $request)
    {
        try {
            Observation::create($request->all());
            return response()->json(201);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $observation = Observation::find($id);
            $observation->update($request->all());
            return response()->json([$observation], 200);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $observation = Observation::find($id);
            $observation->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
