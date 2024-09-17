<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Animal;
use App\Models\Reproduction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Requests\StoreReproductionRequest;
use App\Http\Requests\UpdateReproductionRequest;

class ReproductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('App/Reproduction/Index', [
            'reproductions' => Reproduction::where('ong_id', Auth::user()->ong_id)->orderBy('id', 'desc')->paginate(),
            'csrf' => csrf_token(),
            'my_actions' => $this->reproductionActions(),
            'my_attributes' => $this->reproductionColumns(),
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
    public function store(StoreReproductionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reproduction $reproduction)
    {
        return Inertia::render('App/Reproduction/Show', [
            'my_fields' => $this->reproductionFields(),
            'reproduction' => $reproduction,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reproduction $reproduction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReproductionRequest $request, Reproduction $reproduction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reproduction $reproduction)
    {
        //
    }

    private function reproductionColumns()
    {
        $columns = [
            'animal_id' => 'Animal',
            'phase' => 'Phase',
            'litter_size' => 'Portée',
            'date' => 'Date',
            'observation' => 'Observation',
        ];
        return $columns;
    }

    private function reproductionActions()
    {
        $actions = [
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function reproductionFields()
    {
        $fields = [
            'animal' => [
                'title' => "Individu",
                'field' => 'model',
                'relation' => 'animal->name',
            ],
            'phase' => [
                'title' => "Phase",
                'field' => 'text',
            ],
            'litter_size' => [
                'title' => "Portée",
                'field' => 'number',
            ],
            'date' => [
                'title' => "Date",
                'field' => 'date',
            ],
            'observation' => [
                'title' => "Observation",
                'field' => 'textarea',
            ],
        ];
        return $fields;
    }
}
