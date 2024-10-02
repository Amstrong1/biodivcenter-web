<?php

namespace App\Http\Controllers\API;

use App\Models\Observation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObservationController extends Controller
{
    public function index($site_id)
    {
        $observations = Observation::where('site_id', $site_id)->get();
        return response()->json($observations, 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('photo')) {
                $name = $request['id'] . '_observation.' . $request->photo->extension();
                $data['photo'] = $request->photo->storeAs('observation', $name, 'public');
            }

            if (Observation::find($data['id']) !== null) {
                $observation = Observation::find($data['id']);
                $observation->update($data);
            } else {
                Observation::create($data);
            }
            return response()->json(201);
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
