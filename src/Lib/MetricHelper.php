<?php

namespace App\Lib;

class MetricHelper
{
    public static function getAvailableMetrics(): array
    {
        return [
            'dissoxygen' => 'Niveau d\'oxygène',
            'water_temp' => 'Température',
            'salinity' => 'Salinité',
            'ph' => 'pH'
        ];
    }

    public static function getMetricColumn(string $metric): string
    {
        return match ($metric) {
            'dissoxygen' => 'v.variable_name = \'dissoxygen\'',
            'water_temp' => 'v.variable_name = \'water_temp\'',
            'salinity' => 'v.variable_name = \'salinity\'',
            'ph' => 'v.variable_name = \'ph\'',
            default => 'v.variable_name = \'dissoxygen\''
        };
    }

    public static function getMetricUnit(string $metric): string
    {
        return match ($metric) {
            'dissoxygen' => 'mg/L',
            'water_temp' => '°C',
            'salinity' => 'PSU',
            'ph' => 'pH',
            default => ''
        };
    }
}
