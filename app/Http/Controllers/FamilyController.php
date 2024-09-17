<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Support\Str;
use App\Http\Requests\StoreFamilyRequest;
use App\Http\Requests\UpdateFamilyRequest;
use Inertia\Inertia;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $query = Family::where('id', '>', 1)->orderBy('id', 'desc');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $families = $query->paginate(15)->withQueryString();

        return Inertia::render('App/Family/Index', [
            'families' => $families,
            'csrf' => csrf_token(),
            'my_actions' => $this->familyActions(),
            'my_attributes' => $this->familyColumns(),
            'my_fields' => $this->familyFields(),
            'filters' => request('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyRequest $request)
    {
        $family = new Family();

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'], '_');
        try {
            $family->create($data);
            return redirect('/families');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Edit the specified resource.
     */
    public function edit(Family $family)
    {
        return Inertia::render('App/Family/Edit', [
            'family' => $family,
            'csrf' => csrf_token(),
            'my_fields' => $this->familyFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyRequest $request, Family $family)
    {
        try {
            $family->update($request->validated());
            return redirect('/families');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family $family)
    {
        try {
            $family->delete();
            return back();
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    private function familyColumns()
    {
        $columns = [
            'name' => 'Libellé',
        ];
        return $columns;
    }

    private function familyActions()
    {
        $actions = [
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function familyFields()
    {
        $fields = [
            'name' => [
                'title' => "Famille",
                'placeholder' => 'Entrez un nom de famille',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
        ];
        return $fields;
    }
}
