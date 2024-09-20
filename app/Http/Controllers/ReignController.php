<?php

namespace App\Http\Controllers;

use App\Models\Reign;
use Illuminate\Support\Str;
use App\Http\Requests\StoreReignRequest;
use App\Http\Requests\UpdateReignRequest;
use Inertia\Inertia;

class ReignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $query = Reign::where('id', '>', 1)->orderBy('id', 'desc');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $reigns = $query->paginate(15)->withQueryString();

        return Inertia::render('App/Reign/Index', [
            'reigns' => $reigns,
            'csrf' => csrf_token(),
            'my_actions' => $this->reignActions(),
            'my_attributes' => $this->reignColumns(),
            'my_fields' => $this->reignFields(),
            'filters' => request('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReignRequest $request)
    {
        $reign = new Reign();

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'], '_');
        $reign->create($data);

        return redirect()->route('reigns.index');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Reign $reign)
    {
        return Inertia::render('App/Reign/Edit', [
            'reign' => $reign,
            'csrf' => csrf_token(),
            'my_fields' => $this->reignFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReignRequest $request, Reign $reign)
    {
        try {
            $reign->update($request->validated());
            return redirect()->route('reigns.index');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reign $reign)
    {
        try {
            $reign->delete();
            return redirect()->route('reigns.index');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    private function reignColumns()
    {
        $columns = [
            'name' => 'Libellé',
        ];
        return $columns;
    }

    private function reignActions()
    {
        $actions = [
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function reignFields()
    {
        $fields = [
            'name' => [
                'title' => "Regne",
                'placeholder' => '',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
        ];
        return $fields;
    }
}
