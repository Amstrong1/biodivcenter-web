<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('App/Branch/Index', [
            'branches' => Branch::where('id', '>', 1)->get(),
            'csrf' => csrf_token(),
            'my_actions' => $this->branchActions(),
            'my_attributes' => $this->branchColumns(),
            'my_fields' => $this->branchFields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request): RedirectResponse
    {
        $branch = new Branch();

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'], '_');

        try {
            $branch->create($data);
            return redirect()->route('branches.index');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function edit(Branch $branch)
    {
        return Inertia::render('App/Branch/Edit', [
            'branch' => $branch,
            'csrf' => csrf_token(),
            'my_fields' => $this->branchFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, Branch $branch): RedirectResponse
    {
        try {
            $branch->update($request->validated());
            return redirect()->route('branches.index');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch): RedirectResponse
    {
        try {
            $branch->delete();
            return redirect()->route('branches.index');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    private function branchColumns()
    {
        $columns = [
            'name' => 'Libellé',
        ];
        return $columns;
    }

    private function branchActions()
    {
        $actions = [
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function branchFields()
    {
        $fields = [
            'name' => [
                'title' => "Branche",
                'placeholder' => 'Entrez un nom de branche',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
        ];
        return $fields;
    }
}
