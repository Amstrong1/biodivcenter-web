<?php

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

function convertToDecimal($coord) {
    // Vérifier si la coordonnée est au format Degrés Minutes Secondes (DMS)
    // Exemple de format DMS : 10° 46' 7.68" N ou S pour latitude, E ou W pour longitude
    if (preg_match('/^(\d{1,3})°\s*(\d{1,2})\'\s*([\d\.]+)"\s*([NSEW])$/', $coord, $matches)) {
        $degrees = (float)$matches[1];
        $minutes = (float)$matches[2];
        $seconds = (float)$matches[3];
        $direction = strtoupper($matches[4]);

        // Convertir en degrés décimaux
        $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

        // Inverser la valeur pour les directions Sud (S) et Ouest (W)
        if ($direction == 'S' || $direction == 'W') {
            $decimal = -$decimal;
        }

        // Validation des plages pour la latitude (N/S) et la longitude (E/W)
        if (($direction == 'N' || $direction == 'S') && ($decimal < -90 || $decimal > 90)) {
            throw new Exception("Latitude invalide : $coord");
        }
        if (($direction == 'E' || $direction == 'W') && ($decimal < -180 || $decimal > 180)) {
            throw new Exception("Longitude invalide : $coord");
        }

        return $decimal;
    }

    // Si c'est déjà au format DD (degrés décimaux)
    if (is_numeric($coord)) {
        $decimal = (float)$coord;

        // Validation de la plage pour les valeurs numériques (décimales)
        if ($decimal < -180 || $decimal > 180) {
            throw new Exception("Coordonnée décimale invalide : $coord");
        }

        return $decimal;
    }

    // Retourner une erreur si le format est incorrect
    throw new Exception("Coordonnée invalide : $coord");
}
