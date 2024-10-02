<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Alimentation;
use Illuminate\Support\Facades\Auth;

class AlimentationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        if (Auth::user()->role == 'adminONG') {
            $query = Alimentation::where('ong_id', Auth::user()->ong_id)->orderBy('id', 'desc');
        } else {
            $query = Alimentation::orderBy('id', 'desc');
        }
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%');
        }

        $alimentations = $query->paginate(15)->withQueryString();

        return Inertia::render('App/Alimentation/Index', [
            'alimentations' => $alimentations,
            'csrf' => csrf_token(),
            'my_attributes' => $this->alimentationColumns(),
            'filters' => request('search'),
        ]);
    }

    private function alimentationColumns()
    {
        $columns = [
            'user_name' => 'Agent',
            'specie_name' => 'Espèce',
            'age_range' => 'Age',
            'food' => 'Alimentation',
            'frequency' => 'Fréquence',
            'quantity' => 'Quantitée',
            'cost' => 'Coût',
        ];
        return $columns;
    }
}
