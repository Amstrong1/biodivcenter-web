<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Inertia\Inertia;
use App\Models\Animal;
use App\Models\Specie;
use App\Models\Reproduction;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke()
    {
        $speciesCount = Specie::count();
        $animalsCount = Auth::user()->role == 'adminONG' ? Animal::where('ong_id', Auth::user()->ong_id)->count() : Animal::count();
        $siteCount = Auth::user()->role == 'adminONG' ? Site::where('id', Auth::user()->site_id)->count() : Site::count();
        $newBornCount = Reproduction::whereRaw('ABS(TIMESTAMPDIFF(DAY, date, CURDATE())) < 1')->count();

        $data = [
            'labels' => ['Mammifère', 'Oiseaux', 'Primates', 'Lézard', 'Autres'],
            'datasets' => [
                [
                    'label' => 'Nombre',
                    'backgroundColor' => '#1e9a2c',
                    'data' => [150, 200, 170, 220, 300],
                ]
            ]
        ];

        return Inertia::render('Dashboard', [
            'speciesCount' => $speciesCount,
            'animalsCount' => $animalsCount,
            'siteCount' => $siteCount,
            'newBornCount' => $newBornCount,
            'chartData' => $data
        ]);
    }
}
