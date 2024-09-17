<?php

namespace App\Http\Controllers;

use App\Models\Pen;
use Illuminate\Support\Str;
use App\Http\Requests\StorePenRequest;
use App\Http\Requests\UpdatePenRequest;
use Inertia\Inertia;

class PenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $query = Pen::orderBy('id', 'desc');
        if ($search) {
            $query->where('number', 'like', '%' . $search . '%');
        }

        $pens = $query->paginate(15)->withQueryString();

        return Inertia::render('App/Pen/Index', [
            'pens' => $pens,
            'csrf' => csrf_token(),
            'my_actions' => $this->penActions(),
            'my_attributes' => $this->penColumns(),
            'my_fields' => $this->penFields(),
            'filters' => request('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenRequest $request)
    {
        $pen = new Pen();

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'], '_');

        try {
            $pen->create($data);
            return redirect()->route('pens.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pen $pen)
    {
        return Inertia::render('App/Pen/Edit', [
            'pen' => $pen,
            'csrf' => csrf_token(),
            'my_fields' => $this->penFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenRequest $request, Pen $pen)
    {
        try {
            $pen->update($request->validated());
            return redirect()->route('pens.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pen $pen)
    {
        try {
            $pen = $pen->delete();
            return redirect()->route('pens.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    private function penColumns()
    {
        $columns = [
            'name' => 'Libellé',
        ];
        return $columns;
    }

    private function penActions()
    {
        $actions = [
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function penFields()
    {
        $fields = [
            'number' => [
                'title' => "Numero",
                'placeholder' => '',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
        ];
        return $fields;
    }
}
