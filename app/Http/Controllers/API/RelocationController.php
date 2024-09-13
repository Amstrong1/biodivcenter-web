<?php

namespace App\Http\Controllers\API;

use App\Models\Relocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RelocationController extends Controller
{
    public function index($site_id)
    {
        $relocations = Relocation::where('site_origin_id', $site_id)
            ->orWhere('site_destination_id', $site_id)
            ->select('id', 'date_transfert', 'animal_id')
            ->orderBy('id', 'desc')
            ->get()
            ->append('animal_name')
            ->append('pen_origin_name')
            ->append('pen_destination_name');
        return response()->json($relocations, 200);
    }

    public function show($id)
    {
        $relocation = Relocation::find($id);
        return response()->json($relocation);
    }

    public function store(Request $request)
    {
        try {
            Relocation::create($request->all());
            return response()->json(201);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $relocation = Relocation::find($id);
            $relocation->update($request->all());
            return response()->json([$relocation], 200);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $relocation = Relocation::find($id);
            $relocation->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
