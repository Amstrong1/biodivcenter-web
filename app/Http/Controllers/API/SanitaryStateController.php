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
            ->orderBy('id', 'desc')
            ->get()
            ->append('animal_name')
            ->append('formated_date');
        return response()->json($sanitaryStates, 200);
    }

    public function show($id)
    {
        $sanitaryState = SanitaryState::where('animal_id', $id)
            ->orderBy('id', 'desc')
            ->first()
            ->append('animal_name')
            ->append('formated_date');
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
