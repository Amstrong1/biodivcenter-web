<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\SanitaryState;
use Illuminate\Support\Facades\Auth;

class SanitaryStateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        $query = SanitaryState::where('ong_id', Auth::user()->ong_id)->orderBy('id', 'desc');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $sanitaryStates = $query->paginate(15)->withQueryString();

        $sanitaryStates->getCollection()->transform(function ($sanitaryState) {
            return $sanitaryState->append('user_name')->append('formated_date')->append('animal_name');
        });
        return Inertia::render('App/SanitaryState/Index', [
            'sanitaryStates' => $sanitaryStates,
            'csrf' => csrf_token(),
            'my_attributes' => $this->sanitaryStateColumns(),
        ]);
    }

    private function sanitaryStateColumns()
    {
        $columns = [
            'user_name' => 'Agent',
            'animal_name' => 'Individu',
            'label' => 'Intitulé',
            'description' => 'Description',
            'corrective_action' => 'Action Correctif',
            'cost' => 'Coût',
            'temperature' => 'Température',
            'height' => 'Taille',
            'weight' => 'Poids',
        ];
        return $columns;
    }
}
