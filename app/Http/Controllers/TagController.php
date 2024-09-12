<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('App/Tag/Index', [
            'tags' => Tag::where('ong_id', Auth::user()->ong_id)->get(),
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
    public function store(StoreTagRequest $request)
    {
        $tag = new Tag();

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'], '_');
        $tag->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return Inertia::render('App/Tag/Show', [
            'my_fields' => $this->tagFields(),
            'tag' => $tag,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return Inertia::render('App/Tag/Edit', [
            'my_fields' => $this->tagFields(),
            'csrf' => csrf_token(),
            'tag' => $tag,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        try {
            $tag->update($request->validated());
            return redirect()->route('tags.index');
        } catch (\Throwable $th) {
            redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag = $tag->delete();
            return redirect()->route('tags.index');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    private function tagColumns()
    {
        $columns = [
            'type' => 'Type',
            'manufacturer' => 'Fabricant',
            'model' => 'Modèle',
            'weight' => 'Poids',
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
            'type' => [
                'title' => "Type",
                'placeholder' => 'Entrez le type d\'appareil',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
            'manufacturer' => [
                'title' => "Fabricant",
                'placeholder' => 'Entrez le fabricant de l\'appareil',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
            'model' => [
                'title' => "Modèle",
                'placeholder' => 'Entrez le modèle de l\'appareil',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
            'weight' => [
                'title' => "Poids",
                'placeholder' => 'Entrez le poids de l\'appareil',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
        ];
        return $fields;
    }
}
