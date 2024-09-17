<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Animal;
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        if (Auth::user()->role == 'adminONG') {
            $query = Animal::where('ong_id', Auth::user()->ong_id)->orderBy('name', 'asc');
        } else {
            $query = Animal::orderBy('id', 'desc');
        }

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $animals = $query->paginate(15)->withQueryString();

        $animals->getCollection()->transform(function ($animal) {
            return $animal->append('specie_name')->append('site_name');
        });

        return Inertia::render('App/Animal/Index', [
            'animals' => $animals,
            'csrf' => csrf_token(),
            'my_actions' => $this->animalActions(),
            'my_attributes' => $this->animalColumns(),
            'filters' => request('search'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        // $animal = $animal->append('site_name')->append('specie_name')->append('pen_number')->append('age')->append('parent');
        // return Inertia::render('App/Animal/Show', [
        //     'animal' => $animal,
        //     'my_fields' => $this->animalFields(),
        // ]);

        // Structurer les informations en une collection de tableaux avec title et infoList
        $infoCards = [
            [
                'title' => 'Informations d\'identification',
                'infoList' => [
                    'Sexe' => $animal->sex,
                    'Age' => $animal->age,
                    'Poids' => $animal->weight,
                    'Taille' => $animal->height,
                ]
            ],
            [
                'title' => 'Informations sur l\'origine',
                'infoList' => [
                    'ONG' => $animal->ong_name,
                    'Site' => $animal->site_name,
                    'Enclos' => $animal->pen->number ?? 'Non renseigné',
                    'Provenance' => $animal->origin ?? 'Non renseigné',
                    'Parent' => $animal->parent ?? 'Non renseigné',
                ]
            ],
            [
                'title' => 'Informations sur l\'état',
                'infoList' => [
                    'État' => $animal->state,
                    'Description' => $animal->description,
                ]
            ],
        ];

        return Inertia::render('App/Animal/Show', [
            'specie_name' => $animal->specie_name,
            'name' => $animal->name,
            'photo' => $animal->photo,
            'infoCards' => $infoCards
        ]);
    }

    private function animalColumns()
    {
        $columns = [
            'photo' => '',
            'name' => 'Nom',
            'specie_name' => 'Espèces',
            'origin' => 'Origine',
            'site_name' => 'Site',
            'state' => 'Etat',
        ];
        return $columns;
    }

    private function animalActions()
    {
        $actions = [
            'show' => "Voir",
        ];
        return $actions;
    }

    private function animalFields()
    {
        $fields = [
            'site_name' => [
                'title' => "Site",
                'field' => 'text',
            ],
            'specie_name' => [
                'title' => "Espèces",
                'field' => 'text',
            ],
            'pen_number' => [
                'title' => "Enclos",
                'field' => 'text',
            ],
            'name' => [
                'title' => "Nom",
                'field' => 'text',
            ],
            'weight' => [
                'title' => "Poids",
                'field' => 'text',
            ],
            'height' => [
                'title' => "Taille",
                'field' => 'text',
            ],
            'sex' => [
                'title' => "Sexe",
                'field' => 'text',
            ],
            'age' => [
                'title' => "Age",
                'field' => 'text',
            ],
            'description' => [
                'title' => "Description",
                'field' => 'textarea',
            ],
            'state' => [
                'title' => "Etat",
                'field' => 'text',
            ],
            'origin' => [
                'title' => "Provenance",
                'field' => 'text',
            ],
            'parent' => [
                'title' => "Parent",
                'field' => 'text',
            ],
            'photo' => [
                'title' => "Photo",
                'field' => 'file',
            ],
        ];
        return $fields;
    }
}
