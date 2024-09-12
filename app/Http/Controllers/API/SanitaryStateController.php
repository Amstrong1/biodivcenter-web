<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\SanitaryState;
use App\Http\Controllers\Controller;

class SanitaryStateController extends Controller
{
    public function index($site_id)
    {
        $sanitaryStates = SanitaryState::where('site_id', $site_id)
            ->select('id', 'label', 'animal_id')
            ->orderBy('id', 'desc')
            ->get()
            ->append('animal_name');
        return response()->json($sanitaryStates, 200);
    }

    public function show($id)
    {
        $sanitaryState = SanitaryState::find($id);
        return response()->json($sanitaryState);
    }

    public function store(Request $request)
    {
        try {
            SanitaryState::create($request->all());
            return response()->json(201);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $sanitaryState = SanitaryState::find($id);
            $sanitaryState->update($request->all());
            return response()->json([$sanitaryState], 200);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $sanitaryState = SanitaryState::find($id);
            $sanitaryState->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
