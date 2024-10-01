<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Inertia\Inertia;
use App\Models\Observation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreObservationRequest;
use App\Http\Requests\UpdateObservationRequest;

class ObservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        if (Auth::user()->role == 'adminONG') {
            $query = Observation::where('ong_id', Auth::user()->ong_id)->orderBy('id', 'desc');
        } else {
            $query = Observation::orderBy('id', 'desc');
        }

        if ($search) {
            $query->where('subject', 'like', '%' . $search . '%')
                ->orWhere('observation', 'like', '%' . $search . '%');
        }

        $observations = $query->paginate(15)->withQueryString();

        if (Auth::user()->role == 'adminONG') {
            $observations->getCollection()->transform(function ($observation) {
                return $observation->append('site_name');
            });
        }

        return Inertia::render('App/Observation/Index', [
            'observations' => $observations,
            'csrf' => csrf_token(),
            'my_actions' => $this->observationActions(),
            'my_attributes' => $this->observationColumns(),
            'my_fields' => $this->observationFields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreObservationRequest $request)
    {
        $observation = new Observation();
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $photo = $request->name . '_photo.' . $request->photo->extension();
            $data['photo'] = $request->photo->storeAs('observation', $photo, 'public');
        }

        $data['ong_id'] = Auth::user()->ong_id;
        $observation->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Observation $observation)
    {
        $infoCards = [
            [
                'title' => 'Informations d\'identification',
                'infoList' => [
                    'Site' => $observation->site_name,
                    'Objet' => $observation->subject,
                    'Observation' => $observation->observation,
                ]
            ],
        ];

        return Inertia::render('App/Observation/Show', [
            'infoCards' => $infoCards,
            'my_fields' => $this->observationFields(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Observation $observation)
    {
        return Inertia::render('App/Observation/Edit', [
            'observation' => $observation,
            'csrf' => csrf_token(),
            'my_fields' => $this->observationFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateObservationRequest $request, Observation $observation)
    {
        try {

            $observation->update($request->validated());
            return redirect()->route('observations.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Observation $observation)
    {
        try {
            $observation = $observation->delete();
            return redirect()->route('observations.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    private function observationColumns()
    {
        $columns = [
            'site_name' => 'Site',
            'subject' => 'Objet',
            'observation' => 'Observation',
        ];
        return $columns;
    }

    private function observationActions()
    {
        $actions = [
            'show' => "Voir",
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function observationFields()
    {
        $fields = [
            'site_id' => [
                'title' => "Site",
                'placeholder' => 'Sélectionnez un site',
                'field' => 'model',
                'required' => true,
                'required_on_edit' => true,
                'colspan' => true,
                'options' => Site::where('ong_id', Auth::user()->ong_id)->select('id', 'name')->get(),
            ],
            'subject' => [
                'title' => "Objet",
                'placeholder' => 'Entrez l\'objet de l\'observation',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
                'colspan' => true
            ],
            'observation' => [
                'title' => "Observation",
                'placeholder' => 'Saisissez votre observation',
                'field' => 'richtext',
                'required' => true,
                'required_on_edit' => true,
                'colspan' => true
            ],
            'photo' => [
                'title' => "Photo",
                'placeholder' => 'Sélectionner une photo',
                'field' => 'file',
                'required' => false,
                'required_on_edit' => false,
                'colspan' => true
            ],
        ];
        return $fields;
    }
}
