<?php

namespace App\Lib;

class TimeHelper

{
    public static function getTimePeriod(int $years): string

    {
        $years =  max(1, min($years, 20)); 

        return "
            m.date_mesure >= DATE_SUB(
                (SELECT MAX(date_mesure) FROM mesures),
                INTERVAL $years YEAR
            )
        ";
    }

    public static function getAvailablePeriods(): array
    {
        return [1, 5, 10, 15, 20];
    }

    /**
     * Crée une condition WHERE pour une plage de dates personnalisée
     */
    public static function getDateRangeCondition(?string $startDate = null, ?string $endDate = null): string
    {
        $conditions = [];
        
        if ($startDate) {
            $conditions[] = "DATE(m.date_mesure) >= '$startDate'";
        }
        
        if ($endDate) {
            $conditions[] = "DATE(m.date_mesure) <= '$endDate'";
        }
        
        if (empty($conditions)) {
            return self::getTimePeriod(1); // Par défaut : 1 an
        }
        
        return '(' . implode(' AND ', $conditions) . ')';
    }

    /**
     * Valide une plage de dates par rapport aux dates disponibles
     */
    public static function validateDateRange(?string $startDate, ?string $endDate, array $availableDates): array
    {
        $errors = [];
        
        if ($startDate && $endDate && $startDate > $endDate) {
            $errors[] = "La date de début doit être antérieure à la date de fin";
        }
        
        if ($startDate && $availableDates['min_date'] && $startDate < $availableDates['min_date']) {
            $errors[] = "La date de début ne peut être antérieure à " . $availableDates['min_date'];
        }
        
        if ($endDate && $availableDates['max_date'] && $endDate > $availableDates['max_date']) {
            $errors[] = "La date de fin ne peut être postérieure à " . $availableDates['max_date'];
        }
        
        return $errors;
    }
}