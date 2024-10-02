<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\SanitaryState;
use App\Http\Controllers\Controller;

class SanitaryStateController extends Controller
{
    public function index($site_id)
    {
        $sanitaryStates = SanitaryState::where('site_id', $site_id)->get();
        return response()->json($sanitaryStates, 200);
    }

    public function store(Request $request)
    {
        try {
            if (SanitaryState::find($request['id']) !== null) {
                $sanitaryState = SanitaryState::find($request['id']);
                $sanitaryState->update($request->all());
            } else {
                SanitaryState::create($request->all());
            }

            return response()->json(201);
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
