<?php

namespace App\Http\Controllers;

use App\Models\Ong;
use App\Models\Site;
use Inertia\Inertia;
use App\Models\Animal;
use App\Models\Relocation;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRelocationRequest;
use App\Http\Requests\UpdateRelocationRequest;

class RelocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('App/Relocation/Index', [
            'relocations' => Relocation::where('ong_origin_id', Auth::user()->ong_id)->orWhere('ong_destination_id', Auth::user()->ong_id)->orderBy('id', 'desc')->paginate(),
            'csrf' => csrf_token(),
            'my_actions' => $this->relocationActions(),
            'my_attributes' => $this->relocationColumns(),
            'my_fields' => $this->relocationFields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRelocationRequest $request)
    {
        $relocation = new Relocation();

        $animal = Animal::find($request->animal_id);
        $animal->state = 'relocated';
        $animal->save();

        $data = $request->validated();
        $data['ong_origin_id'] = $animal->ong_id;
        $data['site_origin_id'] = $animal->site_id;
        $relocation->create($data);

        $newAnimal = $animal->replicate();
        $newAnimal->ong_id = $data->ong_destination;
        $newAnimal->site_id = $data->site_destination;
        $newAnimal->origin = $animal->ong_id;
        $newAnimal->state = 'present';
        $newAnimal->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Relocation $relocation)
    {
        return Inertia::render('App/Relocation/Show', [
            'my_fields' => $this->relocationFields(),
            'csrf' => csrf_token(),
            'relocation' => $relocation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Relocation $relocation)
    {
        return Inertia::render('App/Relocation/Edit', [
            'my_fields' => $this->relocationFields(),
            'relocation' => $relocation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRelocationRequest $request, Relocation $relocation)
    {
        try {
            $relocation->update($request->validated());
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Relocation $relocation)
    {
        try {
            $relocation = $relocation->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    private function relocationColumns()
    {
        $columns = [
            'animal_name' => 'Animal',
            'ong_origin_name' => 'ONG Provenance',
            'ong_destination_name' => 'ONG Destination',
            'site_origin_name' => 'Site Provenance',
            'site_destination_name' => 'Site Destination',
            'user_name' => 'Agent',
            'formated_date_transfert' => 'Date',
        ];
        return $columns;
    }

    private function relocationActions()
    {
        $actions = [
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function relocationFields()
    {
        $fields = [
            'animal' => [
                'title' => "Individu",
                'placeholder' => 'Sélectionner un individu',
                'field' => 'model',
                'required' => true,
                'required_on_edit' => true,
                'options' => Animal::where('ong_id', Auth::user()->ong_id)->select('id', 'name')->get(),
            ],
            'ong_destination' => [
                'title' => "ONG Destination",
                'placeholder' => 'Sélectionner ONG',
                'field' => 'model',
                'required' => true,
                'required_on_edit' => true,
                'options' => Ong::all('id', 'name'),
            ],
            'site_destination' => [
                'title' => "Site Destination",
                'placeholder' => 'Sélectionner Site',
                'field' => 'model',
                'required' => true,
                'required_on_edit' => true,
                'options' => Site::all('id', 'name'),
            ],
            'date_transfert' => [
                'title' => "Date de transfert",
                'placeholder' => '',
                'field' => 'date',
                'required' => true,
                'required_on_edit' => true,
            ],
            'comment' => [
                'title' => "Commentaire",
                'placeholder' => '',
                'field' => 'textarea',
                'required' => false,
                'required_on_edit' => false,
                'colspan' => true
            ],
        ];
        return $fields;
    }
}
