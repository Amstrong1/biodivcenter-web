<?php

namespace App\Http\Controllers;

use App\Models\Ong;
use App\Models\Specie;
use App\Models\TypeHabitat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends Controller
{
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
                    'id' => Str::ulid(),
                    'scientific_name' => $data[0],
                    'french_name' => $data[1],
                    'status_uicn' => $data[2],
                    'status_cites' => $data[3],
                    'uicn_link' => $data[4] ?? "",
                    'inaturalist_link' => $data[5] ?? "",
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
                    'id' => Str::ulid(),
                    'name' => $data[0],
                    'description' => $data[1],
                ]);
            }
        }

        return back();
    }

    public function importOng(Request $request)
    {
        $ong = new Ong();

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
                $ong::create([
                    'name' => $data[0],
                    'country' => $data[1],
                    'siege_social' => $data[2],
                    'mdt_membership' => $data[3] == 'Oui' ? true : false,
                ]);
            }
        }

        return back();
    }
}
