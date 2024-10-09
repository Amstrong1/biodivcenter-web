<?php

function convertToDecimal($coord)
{
    if (preg_match(
        '/^(\d{1,3})°\s*(\d{1,2})\'\s*([\d\.]+)"\s*([NSEW])?$/',
        $coord,
        $matches
    )) {
        $degrees = (float)$matches[1];
        $minutes = (float)$matches[2];
        $seconds = (float)$matches[3];
        $direction = strtoupper($matches[4] ?? '');

        $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

        if ($direction == 'S' || $direction == 'W') {
            $decimal = -$decimal;
        }

        if (($direction == 'N' || $direction == 'S') && ($decimal < -90 || $decimal > 90)) {
            throw new Exception("Latitude invalide : $coord");
        }
        if (($direction == 'E' || $direction == 'W') && ($decimal < -180 || $decimal > 180)) {
            throw new Exception("Longitude invalide : $coord");
        }

        return $decimal;
    }

    if (is_numeric($coord)) {
        $decimal = (float)$coord;

        if ($decimal < -180 || $decimal > 180) {
            throw new Exception("Coordonnée décimale invalide : $coord");
        }

        return $decimal;
    }

    throw new Exception("Coordonnée invalide : $coord");
}
