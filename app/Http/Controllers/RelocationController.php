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
        $relocations = Relocation::where('ong_origin_id', Auth::user()->ong_id)
            ->orWhere('ong_destination_id', Auth::user()->ong_id)
            ->orderBy('id', 'desc')
            ->paginate();

        return Inertia::render('App/Relocation/Index', [
            'relocations' => $relocations,
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
        $relocation->create($data);

        $newAnimal = $animal->replicate();
        $newAnimal->ong_id = $data->ong_destination_id;
        $newAnimal->site_id = $data->site_destination_id;
        $newAnimal->origin = $animal->ong->name . ' - ' . $animal->site->name;
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
            'animal_id' => [
                'title' => "Individu",
                'placeholder' => 'Sélectionner un individu',
                'field' => 'model',
                'required' => true,
                'required_on_edit' => true,
                'options' => Animal::where('ong_id', Auth::user()->ong_id)->select('id', 'name')->get(),
            ],
            'ong_destination_id' => [
                'title' => "ONG Destination",
                'placeholder' => 'Sélectionner ONG',
                'field' => 'model',
                'required' => true,
                'required_on_edit' => true,
                'options' => Ong::where('mdt_membership', true)->select('id', 'name')->get(),
            ],
            'site_destination_id' => [
                'title' => "Site Destination",
                'placeholder' => 'Sélectionner Site',
                'field' => 'model-optgroup',
                'required' => true,
                'required_on_edit' => true,
                'options' => Site::all('id', 'name', 'ong_id')->append('ong_name')
                    ->groupBy('ong_name')
                    ->map(function ($sites, $ong_name) {
                        return [
                            'label' => $ong_name,
                            'options' => $sites->select('name', 'id'),
                        ];
                    }),
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
