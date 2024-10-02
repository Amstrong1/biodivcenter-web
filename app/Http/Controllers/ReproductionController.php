<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Reproduction;
use Illuminate\Support\Facades\Auth;

class ReproductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        $query = Reproduction::where('ong_id', Auth::user()->ong_id)->orderBy('id', 'desc');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $reproductions = $query->paginate(15)->withQueryString();

        $reproductions->getCollection()->transform(function ($reproduction) {
            return $reproduction->append('animal_name');
        });

        return Inertia::render('App/Reproduction/Index', [
            'reproductions' => $reproductions,
            'csrf' => csrf_token(),
            'my_attributes' => $this->reproductionColumns(),
        ]);
    }

    private function reproductionColumns()
    {
        $columns = [
            'animal_name' => 'Animal',
            'phase' => 'Phase',
            'litter_size' => 'Portée',
            'date' => 'Date',
            'observation' => 'Observation',
        ];
        return $columns;
    }
}
