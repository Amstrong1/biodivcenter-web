<?php

return [
    'uicn_labels' => [
        'NE' => 'Non Évalué (NE)',
        'DD' => 'Données insuffisantes (DD)',
        'LC' => 'Préoccupation mineure (LC)',
        'NT' => 'Espèce quasi menacée (NT)',
        'VU' => 'Espèce vulnérable (VU)',
        'EN' => 'Espèce en danger (EN)',
        'CR' => 'En danger critique d\'extinction (CR)',
        'EW' => 'Éteint à l\'état sauvage (EW)',
        'EX' => 'Éteint (EX)',
    ],

    'uicn_values' => [
        'NE' => 0,
        'DD' => 1,
        'LC' => 5,
        'NT' => 10,
        'VU' => 25,
        'EN' => 50,
        'CR' => 100,
        'EW' => 200,
        'EX' => 500,
    ],

    'cites_labels' => [
        'Pas Listé' => 'Pas Listé',
        'I' => 'Annexe I',
        'II' => 'Annexe II',
        'III' => 'Annexe III',
    ],

    'conservation_types' => [
        'Mixte' => 'Mixte',
        'Faunique' => 'Faunique',
        'Floristique' => 'Floristique',
    ],

    'pen_states' => [
        'Disponible' => 'Disponible',
        'Indisponible' => 'Indisponible',
    ],

    'reproduction_phases' => [
        'Ponte' => 'Ponte',
        'Eclosion' => 'Eclosion',
        'Mise bas' => 'Mise bas',
    ],

    'countries' => [
        'Benin' => 'Benin',
        'Burkina Faso' => 'Burkina Faso',
        'Niger' => 'Niger',
    ],

    'roles' => [
        'admin' => 'Administrateur',
        'guest' => 'Visiteur',
        'adminONG' => 'Administrateur ONG',
        'partner' => 'Partenaire',
        'supervisor' => 'Superviseur',
        'agent' => 'Agent',
    ],
];
