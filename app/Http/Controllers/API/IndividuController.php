<?php

namespace App\Http\Controllers\API;

use App\Models\Animal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class IndividuController extends Controller
{
    public function index($site_id)
    {
        $animals = Animal::where('site_id', $site_id)->get();
        return response()->json($animals, 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            if ($request->hasFile('photo')) {
                $name = $request['id'] . '_animal.' . $request->photo->extension();
                $data['photo'] = $request->photo->storeAs('animal', $name, 'public');
            }
            
            if (Animal::find($data['id']) !== null) {
                $animal = Animal::find($data['id']);
                $animal->update($data);
            } else {
                $animal = Animal::create($data);
            }

            if (!DB::table('site_specie')->where('site_id', $animal->site_id)->where('specie_id', $animal->specie_id)->exists()) {
                DB::table('site_specie')->insert(
                    [
                        'id' => Str::ulid(),
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
