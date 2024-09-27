<?php

namespace App\Http\Controllers;

use App\Models\Genus;
use App\Models\Order;
use App\Models\Reign;
use App\Models\Branch;
use App\Models\Family;
use App\Models\Specie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Classification;
use App\Models\TypeHabitat;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends Controller
{
    public function importOrder()
    {
        $order = new Order();

        $import = importExcel(request(), $order);

        if ($import == true) {
            return back();
        }
    }

    public function importReign()
    {
        $reign = new Reign();

        $import = importExcel(request(), $reign);

        if ($import == true) {
            return back();
        }
    }

    public function importGenus()
    {
        $genus = new Genus();

        $import = importExcel(request(), $genus);

        if ($import == true) {
            return back();
        }
    }

    public function importFamily()
    {
        $family = new Family();

        $import = importExcel(request(), $family);

        if ($import == true) {
            return back();
        }
    }

    public function importBranch()
    {
        $branch = new Branch();

        $import = importExcel(request(), $branch);

        if ($import == true) {
            return back();
        }
    }

    public function importClassification()
    {
        $classification = new Classification();

        $import = importExcel(request(), $classification);

        if ($import == true) {
            return back();
        }
    }

    public function importSpecie(Request $request)
    {
        $specie = new Specie();

        // Valider le fichier Excel
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Ouvrir le fichier Excel avec PhpSpreadsheet
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());

        // Sélectionner la première feuille du fichier Excel
        $sheet = $spreadsheet->getActiveSheet();

        // Parcourir les lignes du fichier Excel
        foreach ($sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Itérer même les cellules vides

            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue(); // Lire la valeur de chaque cellule
            }

            // Vérifier que la ligne n'est pas vide avant d'insérer dans la base de données
            if (!empty($data[0]) && !empty($data[1]) && !empty($data[2]) && !empty($data[3])) {
                $specie::create([
                    'scientific_name' => $data[0],
                    'french_name' => $data[1],
                    'status_uicn' => $data[2],
                    'status_cites' => $data[3],
                    'uicn_link' => $data[4] ?? "",
                    'inaturalist_link' => $data[5] ?? "",
                    'slug' => Str::slug($data[0], '_'),
                ]);
            }
        }

        return back();
    }

    public function importHabitatType(Request $request)
    {
        $type_habitat = new TypeHabitat();

        // Valider le fichier Excel
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Ouvrir le fichier Excel avec PhpSpreadsheet
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());

        // Sélectionner la première feuille du fichier Excel
        $sheet = $spreadsheet->getActiveSheet();

        // Parcourir les lignes du fichier Excel
        foreach ($sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Itérer même les cellules vides

            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue(); // Lire la valeur de chaque cellule
            }

            // Vérifier que la ligne n'est pas vide avant d'insérer dans la base de données
            if (!empty($data[0]) && !empty($data[1])) {
                $type_habitat::create([
                    'name' => $data[0],
                    'description' => $data[1],
                    'slug' => Str::slug($data[0], '_'),
                ]);
            }
        }

        return back();
    }
}
