<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\SanitaryState;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSanitaryStateRequest;
use App\Http\Requests\UpdateSanitaryStateRequest;

class SanitaryStateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('App/SanitaryState/Index', [
            'sanitaryStates' => SanitaryState::where('ong_id', Auth::user()->ong_id)->get(),
            'csrf' => csrf_token(),
            'my_actions' => $this->sanitaryStateActions(),
            'my_attributes' => $this->sanitaryStateColumns(),
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
    public function store(StoreSanitaryStateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SanitaryState $sanitaryState)
    {
        return Inertia::render('App/SanitaryState/Show', [
            'my_fields' => $this->sanitaryStateFields(),
            'csrf' => csrf_token(),
            'sanitaryState' => $sanitaryState,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SanitaryState $sanitaryState)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSanitaryStateRequest $request, SanitaryState $sanitaryState)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SanitaryState $sanitaryState)
    {
        //
    }

    private function sanitaryStateColumns()
    {
        $columns = [
            'user_name' => 'Agent',
            'animal_name' => 'Individu',
            'label' => 'Intitulé',
            'description' => 'Description',
            'corrective_action' => 'Action Correctif',
            'cost' => 'Coût',
            'temperature' => 'Température',
            'height' => 'Taille',
            'weight' => 'Poids',
        ];
        return $columns;
    }

    private function sanitaryStateActions()
    {
        $actions = [
            'show' => "Voir",
        ];
        return $actions;
    }

    private function sanitaryStateFields()
    {
        $fields = [
            'user' => [
                'title' => "Agent",
                'field' => 'model',
                'relation' => 'user->name',
            ],
            'animal' => [
                'title' => "Individu",
                'field' => 'model',
                'relation' => 'animal->french_name',
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
