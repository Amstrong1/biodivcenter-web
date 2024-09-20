<?php

namespace App\Http\Controllers;

use App\Models\Genus;
use App\Models\Order;
use App\Models\Reign;
use App\Models\Branch;
use App\Models\Family;
use App\Models\Classification;

class ExcelController extends Controller
{
    public function importOrder() {
        $order = new Order();

        $import = importExcel(request(), $order);

        if ($import == true) {
            return back();
        }
    }

    public function importReign() {
        $reign = new Reign();

        $import = importExcel(request(), $reign);

        if ($import == true) {
            return back();
        }
    }

    public function importGenus() {
        $genus = new Genus();

        $import = importExcel(request(), $genus);

        if ($import == true) {
            return back();
        }
    }

    public function importFamily() {
        $family = new Family();

        $import = importExcel(request(), $family);

        if ($import == true) {
            return back();
        }
    }

    public function importBranch() {
        $branch = new Branch();

        $import = importExcel(request(), $branch);

        if ($import == true) {
            return back();
        }
    }

    public function importClassification() {
        $classification = new Classification();

        $import = importExcel(request(), $classification);

        if ($import == true) {
            return back();
        }
    }
}
