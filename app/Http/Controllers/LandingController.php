<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Inertia\Inertia;

class LandingController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome');
    }

    public function indexSite()
    {
        $sites = Site::all();
        $initialMarkers = [
            [
                'position' => [
                    'lat' => 6.36536,
                    'lng' => 2.41833,
                ],
                'draggable' => false
            ],
            [
                'position' => [
                    'lat' => 7.36536,
                    'lng' => 2.41833,
                ],
                'draggable' => false
            ],
        ];
        return Inertia::render('Site', [
            'sites' => $sites,
            'initialMarkers' => $initialMarkers
        ]);
    }

    public function showSite($slug)
    {
        $initialMarkers = [
            [
                'position' => [
                    'lat' => 6.36536,
                    'lng' => 2.41833,
                ],
                'draggable' => false
            ],
            [
                'position' => [
                    'lat' => 7.36536,
                    'lng' => 2.41833,
                ],
                'draggable' => false
            ],
        ];
        // $site = Site::where('slug', $slug)->firstOrFail();
        return Inertia::render('SiteShow', ['initialMarkers' => $initialMarkers]);
    }

    public function indexSpecies()
    {
        $site = Site::where('slug', request()->slug)->first();
        return Inertia::render('Specie');
    }
}
