<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\Classification;
use App\Http\Requests\StoreClassificationRequest;
use App\Http\Requests\UpdateClassificationRequest;

class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $query = Classification::where('id', '>', 1)->orderBy('id', 'desc');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $classifications = $query->paginate(15)->withQueryString();

        return Inertia::render('App/Classification/Index', [
            'classifications' => $classifications,
            'csrf' => csrf_token(),
            'my_actions' => $this->classificationActions(),
            'my_attributes' => $this->classificationColumns(),
            'my_fields' => $this->classificationFields(),
            'filters' => request('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassificationRequest $request)
    {
        $classification = new Classification();

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'], '_');

        try {
            $classification->create($data);
            return redirect('/classifications');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function edit(Classification $classification)
    {
        return Inertia::render('App/Classification/Edit', [
            'classification' => $classification,
            'csrf' => csrf_token(),
            'my_fields' => $this->classificationFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassificationRequest $request, Classification $classification)
    {
        try {
            $classification->update($request->validated());
            return redirect('/classifications');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classification $classification)
    {
        try {
            $classification = $classification->delete();
            return redirect('/classifications');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    private function classificationColumns()
    {
        $columns = [
            'name' => 'Libellé',
        ];
        return $columns;
    }

    private function classificationActions()
    {
        $actions = [
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function classificationFields()
    {
        $fields = [
            'name' => [
                'title' => "Classification",
                'placeholder' => 'Entrez un nom de classification',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
        ];
        return $fields;
    }
}
