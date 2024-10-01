<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Inertia\Inertia;
use App\Models\TypeHabitat;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSiteRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateSiteRequest;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        if (Auth::user()->role == 'adminONG') {
            $query = Site::where('ong_id', Auth::user()->ong_id)->orderBy('id', 'desc');
        } else {
            $query = Site::orderBy('id', 'desc');
        }

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%');
        }

        $sites = $query->paginate(15)->withQueryString();

        $sites->getCollection()->transform(function ($site) {
            return $site->append('type_habitat_name')->append('biodiv_value');
        });

        return Inertia::render('App/Site/Index', [
            'sites' => $sites,
            'csrf' => csrf_token(),
            'my_actions' => $this->siteActions(),
            'my_attributes' => $this->siteColumns(),
            'my_fields' => $this->siteFields(),
            'filters' => request('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiteRequest $request)
    {
        $site = new Site();

        $data = $request->validated();
        $data['ong_id'] = Auth::user()->ong_id;
        $data['id'] = Str::ulid();

        if ($request->hasFile('logo')) {
            $logo = $data['id'] . '_logo.' . $request->logo->extension();
            $data['logo'] = $request->logo->storeAs('site', $logo, 'public');
        }

        if ($request->hasFile('photo')) {
            $photo = $data['id'] . '_photo.' . $request->photo->extension();
            $data['photo'] = $request->photo->storeAs('site', $photo, 'public');
        }
        $site->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site)
    {
        $infoCards = [
            [
                'title' => 'Informations d\'identification',
                'infoList' => [
                    'Nom' => $site->name,
                    'Adresse' => $site->address,
                    'Superficie' => $site->area,
                    'Type de conservation' => $site->type,
                    'Objectif principal' => $site->main_goal,
                    'Objectif secondaire' => $site->second_goal ?? 'Non renseigné',
                    'Valeur biodiv' => $site->biodiv_value,
                ]
            ],
        ];

        $initialMarkers = [
            [
                'position' => [
                    'lat' => convertToDecimal($site->latitude),
                    'lng' => convertToDecimal($site->longitude),
                ],
                'draggable' => false
            ],
        ];

        return Inertia::render('App/Site/Show', [
            'site' => $site->append('type_habitat_name'),
            'infoCards' => $infoCards,
            'initialMarkers' => $initialMarkers,
            'species' => $site->siteSpecies->append('animals_count'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        return Inertia::render('App/Site/Edit', [
            'site' => $site,
            'csrf' => csrf_token(),
            'my_fields' => $this->siteFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiteRequest $request, Site $site)
    { 
        try {
            $data = $request->validated();
            
            if ($request->file('logo') != null) {
                try {
                    if ($site->logo) {
                        Storage::delete($site->logo);
                    }
                    $name = $site->id . '_logo.' . $request->logo->extension();
                    $data['logo'] = $request->logo->storeAs('site', $name, 'public');
                } catch (\Exception $e) {
                    return $e;
                }
            }

            $site->update($data);
            return redirect()->route('sites.index');
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        if ($site->logo != null) {
            Storage::delete($site->logo);
        }
        if ($site->photo != null) {
            Storage::delete($site->photo);
        }

        $site = $site->delete();
    }

    private function siteColumns()
    {
        $columns = [
            'logo' => '',
            'name' => 'Nom',
            'type_habitat_name' => 'Type d\'habitat',
            'address' => 'Adresse',
            'biodiv_value' => 'Valeur Biodiv',

        ];
        return $columns;
    }

    private function siteActions()
    {
        if (Auth::user()->role  == 'admin') {
            $actions = [
                'show' => "Voir",
                'delete' => "Supprimer",
            ];
        } else {
            $actions = [
                'show' => "Voir",
                'edit' => "Modifier",
                'delete' => "Supprimer",
            ];
        }
        return $actions;
    }

    private function siteFields()
    {
        $types = config('global.conservation_types');
        $fields = [
            'name' => [
                'title' => "Nom",
                'placeholder' => 'Entrez le nom du site',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
            'address' => [
                'title' => "Adresse",
                'placeholder' => 'Entrez l\'adresse du site',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
            'tracking' => [
                'title' => "Tracking",
                'placeholder' => 'Entrez l\'adresse du site',
                'field' => 'text',
                'required' => false,
                'required_on_edit' => false,
            ],
            'area' => [
                'title' => "Superficie",
                'placeholder' => 'Entrez la superficie du site',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
            'type' => [
                'title' => "Type de conservation",
                'placeholder' => 'Sélectionnez le type de conservation',
                'field' => 'select',
                'required' => true,
                'required_on_edit' => true,
                'options' => $types
            ],
            'main_goal' => [
                'title' => "Objectif principal",
                'placeholder' => 'Entrez l\'objectif principal du site',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
            'second_goal' => [
                'title' => "Objectif secondaire",
                'placeholder' => 'Entrez l\'objectif secondaire du site',
                'field' => 'text',
                'required' => false,
                'required_on_edit' => false,
            ],
            'latitude' => [
                'title' => "Latitude",
                'placeholder' => 'Entrez la latitude du site',
                'field' => 'text',
                'required' => false,
                'required_on_edit' => false,
            ],
            'longitude' => [
                'title' => "Longitude",
                'placeholder' => 'Entrez la longitude du site',
                'field' => 'text',
                'required' => false,
                'required_on_edit' => false,
            ],
            'logo' => [
                'title' => "Logo",
                'placeholder' => 'Sélectionnez le logo du site',
                'field' => 'file',
                'required' => false,
                'required_on_edit' => false,
                'colspan' => true
            ],
            // 'photo' => [
            //     'title' => "Photo",
            //     'placeholder' => 'Sélectionnez une photo du site',
            //     'field' => 'file',
            //     'required' => true,
            //     'required_on_edit' => true,
            // ],
        ];

        if (request()->routeIs('sites.show')) {
            $fields = array_merge(
                [
                    'type_habitat_name' => [
                        'title' => "Type d'habitat",
                        'field' => 'text',
                    ],
                ],
                $fields
            );
        } else {
            $fields = array_merge(
                [
                    'type_habitat_id' => [
                        'title' => "Type d'habitat",
                        'placeholder' => 'Selectionnez le type d\'habitat',
                        'field' => 'model',
                        'required' => true,
                        'required_on_edit' => true,
                        'options' => TypeHabitat::select('name', 'id')->get(),
                    ],
                ],
                $fields
            );
        }

        return $fields;
    }
}
