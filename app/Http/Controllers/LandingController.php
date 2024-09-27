<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Inertia\Inertia;
use App\Models\Specie;

class LandingController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome');
    }

    public function indexSite()
    {
        $search = request('search');

        $query = Site::select('id', 'name', 'address', 'logo', 'ong_id', 'latitude', 'longitude')->orderBy('name', 'asc');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%')
                ->orderBy('name', 'asc');
        }

        $sites = $query->paginate(15)->withQueryString();

        $sites->getCollection()->transform(function ($site) {
            return $site->append('ong_country');
        });

        $initialMarkers = [];
        foreach ($sites as $site) {
            $initialMarkers[] = [
                'position' => [
                    'lat' => convertToDecimal($site->latitude),
                    'lng' => convertToDecimal($site->longitude),
                ],
                'draggable' => false

            ];
        }

        return Inertia::render('Site', [
            'sites' => $sites,
            'initialMarkers' => $initialMarkers,
            'filters' => request('search'),
        ]);
    }

    public function showSite($id)
    {
        $site = Site::where('id', $id)->firstOrFail();

        $infoCards = [
            [
                'title' => 'Informations d\'identification',
                'infoList' => [
                    'Nom' => $site->name,
                    'Adresse' => $site->address,
                    'Superficie' => $site->area,
                    'Type de conservation' => $site->type,
                    'Objectif principal' => $site->main_goal,
                    'Objectif secondaire' => $site->second_goal ?? 'Non renseigné',
                    'Valeur biodiv' => $site->biodiv_value,
                ]
            ],
        ];

        $initialMarkers = [
            [
                'position' => [
                    'lat' => convertToDecimal($site->latitude),
                    'lng' => convertToDecimal($site->longitude),
                ],
                'draggable' => false
            ],
        ];
        return Inertia::render(
            'SiteShow',
            [
                'infoCards' => $infoCards,
                'species' => $site->siteSpecies->append('animals_count'),
                'initialMarkers' => $initialMarkers
            ]
        );
    }

    public function indexSpecies()
    {
        $search = request('search');

        $query = Specie::orderBy('french_name', 'asc');

        if ($search) {
            $query = Specie::where('french_name', 'like', '%' . $search . '%')->orderBy('french_name', 'asc');
        }

        $species = $query->paginate(15)->withQueryString();

        $species->getCollection()->transform(function ($specie) {
            return $specie->append('animals_count');
        });

        return Inertia::render('Specie', ['species' => $species, 'filters' => request('search')]);
    }
}
