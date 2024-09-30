<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
// use App\Models\Genus;
// use App\Models\Order;
// use App\Models\Reign;
// use App\Models\Branch;
// use App\Models\Family;
use App\Models\Specie;
use Illuminate\Support\Str;
// use App\Models\Classification;
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
        $data['slug'] = Str::slug($request['scientific_name'], '_');
        // $data['order_id'] = $request['order'];
        // $data['classification_id'] = $request['classification'];
        // $data['family_id'] = $request['family'];
        // $data['genus_id'] = $request['genus'];
        // $data['reign_id'] = $request['reign'];
        // $data['branch_id'] = $request['branch'];

        // unset($data['order']);
        // unset($data['classification']);
        // unset($data['family']);
        // unset($data['genus']);
        // unset($data['reign']);
        // unset($data['branch']);

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
                    // 'Ordre' => $specie->order->name,
                    // 'Classe' => $specie->classification->name,
                    // 'Famille' => $specie->family->name,
                    // 'Genre' => $specie->genus->name,
                    // 'Regne' => $specie->reign->name,
                    // 'Branche' => $specie->branch->name,
                    'Nom scientifique' => $specie->scientific_name,
                    'Nom francais' => $specie->french_name,
                    // 'Nom anglais' => $specie->english_name ?? 'Non défini',
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
                // ->append('order_name')
                // ->append('classification_name')
                // ->append('family_name')
                // ->append('genus_name')
                // ->append('reign_name')
                // ->append('branch_name'),
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
            // 'english_name' => 'Nom Anglais',
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
            // 'english_name' => [
            //     'title' => "Nom anglais",
            //     'placeholder' => 'Saisissez le nom en anglais',
            //     'field' => 'text',
            //     'required' => true,
            //     'required_on_edit' => true,
            // ],
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
        ];

        // if (request()->routeIs('species.show')) {
        //     $fields = array_merge(
        //         [
        //             'order_name' => [
        //                 'title' => "Ordre",
        //                 'field' => 'text',
        //             ],
        //             'classification_name' => [
        //                 'title' => "Classification",
        //                 'field' => 'text',
        //             ],
        //             'family_name' => [
        //                 'title' => "Famille",
        //                 'field' => 'text',
        //             ],
        //             'genus_name' => [
        //                 'title' => "Genre",
        //                 'field' => 'text',
        //             ],
        //             'reign_name' => [
        //                 'title' => "Regne",
        //                 'field' => 'text',
        //             ],
        //             'branch_name' => [
        //                 'title' => "Branche",
        //                 'field' => 'text',
        //             ],
        //         ],
        //         $fields
        //     );
        // } else {
        //     $fields = array_merge(
        //         [

        //             'order' => [
        //                 'title' => "Ordre",
        //                 'placeholder' => 'Sélectionnez un ordre',
        //                 'field' => 'model',
        //                 'required' => true,
        //                 'required_on_edit' => true,
        //                 'options' => Order::all('id', 'name'),
        //             ],
        //             'classification' => [
        //                 'title' => "Classification",
        //                 'placeholder' => 'Sélectionnez une classification',
        //                 'field' => 'model',
        //                 'required' => true,
        //                 'required_on_edit' => true,
        //                 'options' => Classification::all('id', 'name'),
        //             ],
        //             'family' => [
        //                 'title' => "Famille",
        //                 'placeholder' => 'Sélectionnez une famille',
        //                 'field' => 'model',
        //                 'required' => true,
        //                 'required_on_edit' => true,
        //                 'options' => Family::all('id', 'name'),
        //             ],
        //             'genus' => [
        //                 'title' => "Genre",
        //                 'placeholder' => 'Sélectionnez un genre',
        //                 'field' => 'model',
        //                 'required' => true,
        //                 'required_on_edit' => true,
        //                 'options' => Genus::all('id', 'name'),
        //             ],
        //             'reign' => [
        //                 'title' => "Regne",
        //                 'placeholder' => 'Sélectionnez un regne',
        //                 'field' => 'model',
        //                 'required' => true,
        //                 'required_on_edit' => true,
        //                 'options' => Reign::all('id', 'name'),
        //             ],
        //             'branch' => [
        //                 'title' => "Branche",
        //                 'placeholder' => 'Sélectionnez une branche',
        //                 'field' => 'model',
        //                 'required' => true,
        //                 'required_on_edit' => true,
        //                 'options' => Branch::all('id', 'name'),
        //             ],

        //         ],
        //         $fields
        //     );
        // }

        return $fields;
    }
}
