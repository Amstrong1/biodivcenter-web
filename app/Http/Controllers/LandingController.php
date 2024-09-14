<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Specie;
use Inertia\Inertia;

class LandingController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome');
    }

    public function indexSite()
    {
        $sites = Site::all()->append('ong_country');
        $initialMarkers = [];
        foreach ($sites as $site) {
            $initialMarkers = [
                [
                    'position' => [
                        'lat' => convertToDecimal($site->lat),
                        'lng' => convertToDecimal($site->lng),
                    ],
                    'draggable' => false
                ],
            ];
        }

        return Inertia::render('Site', [
            'sites' => $sites,
            'initialMarkers' => $initialMarkers
        ]);
    }

    public function showSite($id)
    {
        $site = Site::where('slug', $id)->firstOrFail();
        $initialMarkers = [
            [
                'position' => [
                    'lat' => convertToDecimal($site->lat),
                    'lng' => convertToDecimal($site->lng),
                ],
                'draggable' => false
            ],
        ];
        return Inertia::render('SiteShow', ['site' => $site, 'initialMarkers' => $initialMarkers]);
    }

    public function indexSpecies()
    {
        $species = Specie::all()->append('animals_count');
        return Inertia::render('Specie', ['species' => $species]);
    }
}
