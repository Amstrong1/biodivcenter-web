<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Site;
use Inertia\Inertia;
use App\Models\Animal;
use Illuminate\Support\Str;
use App\Models\TagDeployment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTagDeploymentRequest;
use App\Http\Requests\UpdateTagDeploymentRequest;

class TagDeploymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('App/TagDeployment/Index', [
            'tags' => TagDeployment::where('ong_id', Auth::user()->ong_id)->orderBy('id', 'desc')->paginate(),
            'csrf' => csrf_token(),
            'my_actions' => $this->tagActions(),
            'my_attributes' => $this->tagColumns(),
            'my_fields' => $this->tagFields(),
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
    public function store(StoreTagDeploymentRequest $request)
    {
        $tagDeployment = new TagDeployment();

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'], '_');
        $tagDeployment->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(TagDeployment $tagDeployment)
    {
        return Inertia::render('App/TagDeployment/Show', [
            'my_fields' => $this->tagFields(),
            'tagDeployment' => $tagDeployment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TagDeployment $tagDeployment)
    {
        return Inertia::render('App/TagDeployment/Edit', [
            'my_fields' => $this->tagFields(),
            'csrf' => csrf_token(),
            'tagDeployment' => $tagDeployment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagDeploymentRequest $request, TagDeployment $tagDeployment)
    {
        try {
            $tagDeployment = $tagDeployment->update($request->validated());
            return redirect()->route('tags.index');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TagDeployment $tagDeployment)
    {
        try {
            $tagDeployment = $tagDeployment->delete();
            return redirect()->route('tags.index');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    private function tagColumns()
    {
        $columns = [
            'tag_name' => 'Type',
            'site_name' => 'Fabricant',
            'animal_name' => 'Modèle',
            'deployment_date_formated' => 'Date de déploiement',
            'retirement_date_formated' => 'Date de retrait'
        ];
        return $columns;
    }

    private function tagActions()
    {
        $actions = [
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function tagFields()
    {
        $fields = [
            'tag' => [
                'title' => "Tag",
                'placeholder' => 'Sélectionnez le tag',
                'field' => 'model',
                'required' => true,
                'required_on_edit' => true,
                'options' => Tag::where('ong_id', Auth::user()->ong_id)->get('id', 'name'),
            ],
            'site' => [
                'title' => "Site",
                'placeholder' => 'Sélectionnez le site',
                'field' => 'model',
                'required' => true,
                'required_on_edit' => true,
                'options' => Site::where('ong_id', Auth::user()->ong_id)->get('id', 'name'),
            ],
            'animal' => [
                'title' => "Individu",
                'placeholder' => 'Sélectionnez l\'individu',
                'field' => 'model',
                'required' => true,
                'required_on_edit' => true,
                'options' => Animal::where('ong_id', Auth::user()->ong_id)->get('id', 'name'),
            ],
            'deployment_date' => [
                'title' => "Date de déploiement",
                'placeholder' => '',
                'field' => 'date',
                'required' => true,
                'required_on_edit' => true,
            ],
        ];
        return $fields;
    }
}
