<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\TypeHabitat;
use Illuminate\Support\Str;
use App\Http\Requests\StoreTypeHabitatRequest;
use App\Http\Requests\UpdateTypeHabitatRequest;

class TypeHabitatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $query = TypeHabitat::orderBy('id', 'desc');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $typeHabitats = $query->paginate(15)->withQueryString();

        return Inertia::render('App/TypeHabitat/Index', [
            'typeHabitats' => $typeHabitats,
            'csrf' => csrf_token(),
            'my_actions' => $this->typeHabitatActions(),
            'my_attributes' => $this->typeHabitatColumns(),
            'my_fields' => $this->typeHabitatFields(),
            'filters' => request('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeHabitatRequest $request)
    {
        $typeHabitat = new TypeHabitat();

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'], '_');
        try {
            $typeHabitat->create($data);
            return redirect()->route('type-habitats.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeHabitat $typeHabitat)
    {
        return Inertia::render('App/TypeHabitat/Show', [
            'typeHabitat' => $typeHabitat,
            'my_fields' => $this->typeHabitatFields(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function edit(TypeHabitat $typeHabitat)
    {
        return Inertia::render('App/TypeHabitat/Edit', [
            'typeHabitat' => $typeHabitat,
            'csrf' => csrf_token(),
            'my_fields' => $this->typeHabitatFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeHabitatRequest $request, TypeHabitat $typeHabitat)
    {
        try {
            $typeHabitat->update($request->validated());
            return redirect()->route('type-habitats.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeHabitat $typeHabitat)
    {
        try {
            $typeHabitat = $typeHabitat->delete();
            return redirect()->route('type-habitats.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    private function typeHabitatColumns()
    {
        $columns = [
            'name' => 'Nom',
            'description' => 'Description',
        ];
        return $columns;
    }

    private function typeHabitatActions()
    {
        $actions = [
            'show' => "Voir",
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function typeHabitatFields()
    {
        $fields = [
            'name' => [
                'title' => "Nom",
                'placeholder' => 'Entrez le nom',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
                'colspan' => true
            ],
            'description' => [
                'title' => "Description",
                'placeholder' => 'Entrez la description',
                'field' => 'richtext',
                'required' => true,
                'required_on_edit' => true,
                'colspan' => true
            ],
        ];
        return $fields;
    }
}
