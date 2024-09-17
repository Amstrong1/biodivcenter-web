<?php

namespace App\Http\Controllers;

use App\Models\Genus;
use Illuminate\Support\Str;
use App\Http\Requests\StoreGenusRequest;
use App\Http\Requests\UpdateGenusRequest;
use Inertia\Inertia;

class GenusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $query = Genus::where('id', '>', 1)->orderBy('id', 'desc');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $genera = $query->paginate(15)->withQueryString();

        return Inertia::render('App/Genus/Index', [
            'genera' => $genera,
            'csrf' => csrf_token(),
            'my_actions' => $this->genusActions(),
            'my_attributes' => $this->genusColumns(),
            'my_fields' => $this->genusFields(),
            'filters' => request('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenusRequest $request)
    {
        $genus = new Genus();

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'], '_');
        try {
            $genus->create($data);
            return redirect('/genera');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function edit(Genus $genus)
    {
        return Inertia::render('App/Genus/Edit', [
            'genus' => $genus,
            'csrf' => csrf_token(),
            'my_fields' => $this->genusFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenusRequest $request, Genus $genus)
    {
        try {
            $genus->update($request->validated());
            return redirect('/genera');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genus $genus)
    {
        try {
            $genus = $genus->delete();
            return redirect('/genera');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    private function genusColumns()
    {
        $columns = [
            'name' => 'Libellé',
        ];
        return $columns;
    }

    private function genusActions()
    {
        $actions = [
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function genusFields()
    {
        $fields = [
            'name' => [
                'title' => "Genre",
                'placeholder' => 'Entrez un nom de genre',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
        ];
        return $fields;
    }
}
