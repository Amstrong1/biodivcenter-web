<?php

namespace App\Http\Controllers\API;

use App\Models\Animal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IndividuController extends Controller
{
    public function index($site_id)
    {
        $animals = Animal::where('site_id', $site_id)
            ->orderBy('id', 'desc')
            ->get()
            ->append('parent')
            ->append('formated_created_at')
            ->append('sanitary_state_label')
            ->append('sanitary_state_detail')
            ->append('specie_name');
        return response()->json($animals, 200);
    }

    public function show($id)
    {
        $animal = Animal::find($id);
        return response()->json($animal);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $name = $request['slug'] . '_animal.' . $request->photo->extension();
            $data['photo'] = $request->photo->storeAs('animal', $name, 'public');
        }
        try {
            $animal = Animal::create($data);
            if (!DB::table('site_specie')->where('site_id', $animal->site_id)->where('specie_id', $animal->specie_id)->exists()) {
                DB::table('site_specie')->insert(
                    [
                        'site_id' => $animal->site_id,
                        'specie_id' => $animal->specie_id,
                    ]
                );
            }
            return response()->json(201);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            $animal = Animal::findOrFail($id);

            if ($request->hasFile('photo')) {
                $name = $animal['slug'] . '_animal.' . $request->photo->extension();
                $data['photo'] = $request->photo->storeAs('animal', $name, 'public');

                if ($animal->photo) {
                    Storage::delete($animal->photo);
                }
            }
            $animal->update($data);
            return response()->json(200);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $animal = Animal::find($id);
            if ($animal->photo != null) {
                Storage::delete($animal->photo);
            }
            $animal->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
