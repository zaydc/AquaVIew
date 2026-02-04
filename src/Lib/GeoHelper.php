<?php

namespace App\Lib;

class GeoHelper
{
    public static function getRegions(): array
    {
        return [
            'Méditerranée' => 'Méditerranée',
            'Atlantique' => 'Atlantique', 
            'Pacifique' => 'Pacifique'
        ];
    }

    public static function regionWhere(string $region): string
    {
        return match ($region) {
            'Méditerranée' =>
                "m.latitude BETWEEN 30 AND 46
                 AND m.longitude BETWEEN -6 AND 36",

            'Atlantique' =>
                "m.longitude BETWEEN -80 AND -10",

            'Pacifique' =>
                "(m.longitude < -80 OR m.longitude > 120)",

            default =>
                "1=1"
        };
    }
}
