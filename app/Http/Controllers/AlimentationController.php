<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Alimentation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAlimentationRequest;
use App\Http\Requests\UpdateAlimentationRequest;

class AlimentationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('App/Alimentation/Index', [
            'alimentations' => Alimentation::where('ong_id', Auth::user()->ong_id)->get(),
                        'csrf' => csrf_token(),
'my_actions' => $this->alimentationActions(),
            'my_attributes' => $this->alimentationColumns(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlimentationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Alimentation $alimentation)
    {
        return Inertia::render('App/Alimentation/Show', [
            'alimentation' => $alimentation,
            'my_fields' => $this->alimentationFields(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alimentation $alimentation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlimentationRequest $request, Alimentation $alimentation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alimentation $alimentation)
    {
        //
    }

    private function alimentationColumns()
    {
        $columns = [
            'user_name' => 'Agent',
            'specie_name' => 'Espèce',
            'age_range' => 'Age',
            'food' => 'Alimentation',
            'frequency' => 'Fréquence',
            'quantity' => 'Quantitée',
            'cost' => 'Coût',
        ];
        return $columns;
    }

    private function alimentationActions()
    {
        $actions = [
            'show' => "Voir",
        ];
        return $actions;
    }

    private function alimentationFields()
    {
        $fields = [
            'user' => [
                'title' => "Agent",
                'field' => 'model',
                'relation' => 'user->name',
            ],
            'specie' => [
                'title' => "Espèce",
                'field' => 'model',
                'relation' => 'specie->french_name',
            ],
            'label' => [
                'title' => "Intitulé",
                'field' => 'text',
            ],
            'description' => [
                'title' => "Description",
                'field' => 'textarea',
            ],
            'corrective_action' => [
                'title' => "Action Correctif",
                'field' => 'text',
            ],
            'cost' => [
                'title' => "Coût",
                'field' => 'number',
            ],
            'temperature' => [
                'title' => "Température",
                'field' => 'text',
            ],
            'height' => [
                'title' => "Taille",
                'field' => 'text',
            ],
            'weight' => [
                'title' => "Poids",
                'field' => 'text',
            ],
        ];
        return $fields;
    }
}
