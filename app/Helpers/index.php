<?php

// Fonction pour vérifier et convertir la latitude ou la longitude
function convertToDecimal($coord) {
    // Vérifier si la coordonnée est au format Degrés Minutes Secondes (DMS)
    // Exemple de format DMS : 10° 46' 7.68" N ou S pour latitude, E ou W pour longitude
    if (preg_match('/^(\d{1,3})°\s*(\d{1,3})\'\s*([\d\.]+)"\s*([NSEW])?$/i', $coord, $matches)) {
        $degrees = (float)$matches[1];
        $minutes = (float)$matches[2];
        $seconds = (float)$matches[3];
        $direction = isset($matches[4]) ? strtoupper($matches[4]) : null;
        // Convertir en degrés décimaux
        $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

        // Inverser la valeur pour les directions Sud (S) et Ouest (W)
        if ($direction == 'S' || $direction == 'W') {
            $decimal = -$decimal;
        }

        return $decimal;
    }

    // Si c'est déjà au format DD (degrés décimaux), on le retourne simplement
    if (is_numeric($coord)) {
        return (float)$coord;
    }

    // Retourner une erreur si le format est incorrect
    throw new Exception("Coordonnée invalide: $coord");
}

