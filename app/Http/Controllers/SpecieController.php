<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Specie;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSpecieRequest;
use App\Http\Requests\UpdateSpecieRequest;

class SpecieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $query = Specie::orderBy('id', 'desc');
        if ($search) {
            $query->where('scientific_name', 'like', '%' . $search . '%')
                ->orWhere('french_name', 'like', '%' . $search . '%');
        }

        $species = $query->paginate(15)->withQueryString();

        return Inertia::render('App/Specie/Index', [
            'species' => $species,
            'csrf' => csrf_token(),
            'my_actions' => $this->specieActions(),
            'my_attributes' => $this->specieColumns(),
            'my_fields' => $this->specieFields(),
            'filters' => request('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpecieRequest $request)
    {
        $data = $request->validated();

        $data['id'] = Str::ulid();

        try {
            Specie::create($data);
            return redirect()->route('species.index');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($specie)
    {
        $specie = Specie::find($specie);

        $infoCards = [
            [
                'title' => 'Informations d\'identification',
                'infoList' => [
                    'Nom scientifique' => $specie->scientific_name,
                    'Nom francais' => $specie->french_name,
                    'Statut UICN' => $specie->status_uicn_label,
                    'Statut CITES' => $specie->status_cites,
                    'Lien UICN' => $specie->uicn_link ?? 'Non défini',
                    'Lien Inaturalist' => $specie->inaturalist_link ?? 'Non défini',
                ]
            ],
        ];

        return Inertia::render('App/Specie/Show', [
            'infoCards' => $infoCards,
            'my_fields' => $this->specieFields(),
        ]);
    }

    public function edit($specie)
    {
        $specie = Specie::find($specie);
        return Inertia::render('App/Specie/Edit', [
            'specie' => $specie,
            'csrf' => csrf_token(),
            'my_fields' => $this->specieFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecieRequest $request, Specie $specie)
    {
        try {
            $specie->update($request->validated());
            return redirect()->route('species.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specie $specie)
    {
        try {
            $specie = $specie->delete();
            return redirect()->route('species.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    private function specieColumns()
    {
        $columns = [
            'scientific_name' => 'Nom scientifique',
            'french_name' => 'Nom Français',
            'status_uicn' => 'Statut UICN',
            'status_cites' => 'Statut CITES',
            'uicn_link' => 'Lien UICN',
            'inaturalist_link' => 'Lien Inaturalist',
        ];
        return $columns;
    }

    private function specieActions()
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'supervisor') {
            $actions = [
                'show' => 'Voir',
                'edit' => 'Modifier',
                'delete' => "Supprimer"
            ];
        } else {
            $actions = [
                'show' => "Voir",
            ];
        }
        return $actions;
    }

    private function specieFields()
    {
        $uicn = config('global.uicn_labels');
        $cites = config('global.cites_labels');
        $diet = config('global.diet');
        $classifications = config('global.classifications');

        $fields = [
            'scientific_name' => [
                'title' => "Nom scientifique",
                'placeholder' => 'Saisissez le nom scientifique',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
            'french_name' => [
                'title' => "Nom francais",
                'placeholder' => 'Saisissez le nom en francais',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
            'status_uicn' => [
                'title' => "Statut UICN",
                'placeholder' => 'Selectionnez une option',
                'field' => 'select',
                'required' => true,
                'required_on_edit' => true,
                'options' => $uicn,
            ],
            'status_cites' => [
                'title' => "Statut CITES",
                'placeholder' => 'Selectionnez une option',
                'field' => 'select',
                'required' => true,
                'required_on_edit' => true,
                'options' => $cites
            ],
            'uicn_link' => [
                'title' => "Lien UICN (optionnel)",
                'placeholder' => 'Saisissez le lien UICN',
                'field' => 'url',
                'required' => true,
                'required_on_edit' => true,
            ],
            'inaturalist_link' => [
                'title' => "Lien iNaturalist (optionnel)",
                'placeholder' => 'Saisissez le lien iNaturalist',
                'field' => 'url',
                'required' => true,
                'required_on_edit' => true,
            ],
            'classification' => [
                'title' => "Regime alimentaire",
                'placeholder' => '',
                'field' => 'select',
                'options' => $classifications,
                'required' => true,
                'required_on_edit' => true,
            ],
            'diet' => [
                'title' => "Regime alimentaire",
                'placeholder' => '',
                'field' => 'select',
                'options' => $diet,
                'required' => true,
                'required_on_edit' => true,
            ],
        ];

        return $fields;
    }
}
