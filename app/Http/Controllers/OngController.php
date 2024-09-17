<?php

namespace App\Http\Controllers;

use App\Models\Ong;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOngRequest;
use App\Http\Requests\UpdateOngRequest;
use Illuminate\Support\Facades\Storage;

class OngController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $query = Ong::where('id', '>', 1)->orderBy('id', 'desc');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $ongs = $query->paginate(15)->withQueryString();

        if (Auth::user()->role == 'admin') {
            return Inertia::render('App/Ong/Index', [
                'ongs' => $ongs,
                'csrf' => csrf_token(),
                'my_actions' => $this->ongActions(),
                'my_attributes' => $this->ongColumns(),
                'my_fields' => $this->ongFields(),
                'filters' => request('search'),
            ]);
        } else {
            return Inertia::render('App/Ong/Index', [
                'ongs' => $ongs,
                'my_attributes' => $this->ongColumns(),
                'filters' => request('search'),
            ]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOngRequest $request)
    {
        $data = $request->validated();
        $data['mdt_membership'] = $request->mdt_membership == 0 ? false : true;
        $data['slug'] = Str::slug($request['name'], '_');

        if ($request->hasFile('logo')) {
            try {
                $name = $data['slug'] . '_logo.' . $request->logo->extension();
                $data['logo'] = $request->logo->storeAs('ong', $name, 'public');
            } catch (\Exception $e) {
                return back();
            }
        }

        try {
            Ong::create($data);
            return redirect()->route('ongs.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ong $ong)
    {
        return Inertia::render('App/Ong/Edit', [
            'ong' => $ong,
            'csrf' => csrf_token(),
            'my_fields' => $this->ongFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOngRequest $request, Ong $ong)
    {
        if ($request->file('logo') != null) {
            try {
                Storage::delete($ong->logo);
                $name = $ong->slug . '_logo.' . $request->logo->extension();
                $ong->logo = $request->logo->storeAs('ong', $name, 'public');
            } catch (\Exception $e) {
                return response()->json($e);
            }
        }

        $data = $request->validated();
        $data['mdt_membership'] = $request->mdt_membership == 0 ? false : true;

        try {
            $ong->update($data);
            return redirect()->route('ongs.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ong $ong)
    {
        try {
            Storage::delete("storage/" . $ong->logo);
            $ong = $ong->delete();
            return redirect()->route('ongs.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    private function ongColumns()
    {
        $columns = [
            'logo' => '',
            'name' => 'Nom',
            'country' => 'Pays',
            'siege_social' => 'Siege sociale',
            'formated_mdt_membership' => 'Membre de MDT',
        ];
        return $columns;
    }

    private function ongActions()
    {
        if (Auth::user()->role == 'admin') {
            $actions = [
                'edit' => "Modifier",
                'delete' => "Supprimer",
            ];
        } else {
            $actions = [
                'edit' => "Modifier",
            ];
        }
        return $actions;
    }

    private function ongFields()
    {
        $countries = config('global.countries');

        $fields = [
            'name' => [
                'title' => "Nom",
                'placeholder' => 'Entrez le nom de l\'ONG',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
                'colspan' => true
            ],
            'country' => [
                'title' => "Pays",
                'placeholder' => 'Sélectionnez un pays',
                'field' => 'select',
                'required' => true,
                'required_on_edit' => true,
                'options' => $countries,
                'colspan' => true
            ],
            'siege_social' => [
                'title' => "Siege sociale",
                'placeholder' => 'Entrez le siege sociale',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
                'colspan' => true
            ],
            'logo' => [
                'title' => "Logo",
                'placeholder' => '',
                'field' => 'file',
                'required' => false,
                'required_on_edit' => false,
                'colspan' => true
            ],
            'mdt_membership' => [
                'title' => "Cette ONG est membre de MDT",
                'placeholder' => 'Sélectionnez une option',
                'field' => 'select',
                'required' => true,
                'required_on_edit' => true,
                'options' => [
                    '1' => 'Oui',
                    '0' => 'Non',
                ],
                'colspan' => true
            ],
        ];
        return $fields;
    }
}
