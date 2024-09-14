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
        if (Auth::user()->role == 'adminONG') {
            $sites = Site::where('ong_id', Auth::user()->ong_id)->get()->append('type_habitat_name')->append('biodiv_value');
        } else {
            $sites = Site::all()->append('type_habitat_name')->append('biodiv_value');
        }

        return Inertia::render('App/Site/Index', [
            'sites' => $sites,
            'csrf' => csrf_token(),
            'my_actions' => $this->siteActions(),
            'my_attributes' => $this->siteColumns(),
            'my_fields' => $this->siteFields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiteRequest $request)
    {
        $site = new Site();

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'], '_');
        $data['ong_id'] = Auth::user()->ong_id;
        $data['type_habitat_id'] = $data['type_habitat'];


        unset($data['type_habitat']);
        if ($request->hasFile('logo')) {
            $logo = $request->name . '_logo.' . $request->logo->extension();
            $data['logo'] = $request->logo->storeAs('site', $logo, 'public');
        }

        if ($request->hasFile('photo')) {
            $photo = $request->name . '_photo.' . $request->photo->extension();
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
                    'lat' => convertToDecimal($site->lat),
                    'lng' => convertToDecimal($site->lng),
                ],
                'draggable' => false
            ],
        ];

        return Inertia::render('App/Site/Show', [
            'site' => $site->append('type_habitat_name'),
            'my_fields' => $this->siteFields(),
            'infoCards' => $infoCards,
            'initialMarkers' => $initialMarkers,
            'species' => $site->siteSpecies,
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

    private function updateImg($old, $owner, $image, $folder)
    {
        try {
            // Storage::delete($old);
            $name = $owner . '_file.' . $image->extension();
            $path = $image->storeAs($folder, $name, 'public');

            return $path;
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiteRequest $request, Site $site)
    {
        if ($request->file('logo') != null) {
            $site->logo = $this->updateImg($site->logo, $site->slug, $request->logo, 'site');
        }

        if ($request->file('photo') != null) {
            $site->photo = $this->updateImg($site->photo, $site->slug, $request->photo, 'site');
        }
        try {
            $data = $request->validated();
            $data['type_habitat_id'] = $request->type_habitat;
            unset($data['type_habitat']);

            $site->update($data);
            return redirect()->route('sites.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        try {
            if ($site->logo != null) {
                Storage::delete($site->logo);
            }
            if ($site->photo != null) {
                Storage::delete($site->photo);
            }

            $site = $site->delete();
            return redirect()->route('sites.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    private function siteColumns()
    {
        $columns = [
            'logo' => '',
            'type_habitat_name' => 'Type d\'habitat',
            'name' => 'Nom',
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
            'lat' => [
                'title' => "Latitude",
                'placeholder' => 'Entrez la latitude du site',
                'field' => 'text',
                'required' => false,
                'required_on_edit' => false,
            ],
            'lng' => [
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
                    'type_habitat' => [
                        'title' => "Type d'habitat",
                        'placeholder' => 'Selectionnez le type d\'habitat',
                        'field' => 'model',
                        'required' => true,
                        'required_on_edit' => true,
                        'options' => TypeHabitat::all('name', 'id'),
                    ],
                ],
                $fields
            );
        }

        return $fields;
    }
}
