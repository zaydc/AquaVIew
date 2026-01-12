<?php

namespace App\Model\Repository;

use PDO;
use App\Config\Conf;
use App\Lib\MetricHelper;

class OceanDataRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            'mysql:host=' . Conf::getHostname() . ';dbname=' . Conf::getDatabase() . ';charset=utf8',
            Conf::getLogin(),
            Conf::getPassword(),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    /**
     * Applique les filtres de période
     */
    public function countMeasures(
        string $wherePeriod
    ): int {
        $sql = "
            SELECT COUNT(*)
            FROM mesures m
            WHERE
                $wherePeriod
        ";

        return (int) $this->pdo->query($sql)->fetchColumn();
    }

    /**
     * Obtient les statistiques pour une métrique spécifique
     */
    public function getMetricStats(
        string $metric,
        string $wherePeriod
    ): array {
        $metricCondition = MetricHelper::getMetricColumn($metric);

        $sql = "
            SELECT 
                AVG(v.valeur) AS avg_value,
                MIN(v.valeur) AS min_value,
                MAX(v.valeur) AS max_value,
                COUNT(*)      AS count_measures
            FROM mesures m
            JOIN variables v ON m.id = v.mesure_id
            WHERE
                $wherePeriod
            AND
                $metricCondition
            AND
                v.qa_flag = 1
            AND
                v.valeur IS NOT NULL
        ";

        return $this->pdo->query($sql)->fetch() ?: [];
    }

    /**
     * Obtient l'évolution temporelle d'une métrique avec coordonnées
     */
    public function getMetricEvolution(
        string $metric,
        string $wherePeriod
    ): array {
        $metricCondition = MetricHelper::getMetricColumn($metric);
        
        $sql = "
            SELECT 
                DATE(m.date_mesure) as date,
                AVG(v.valeur) as value,
                COUNT(*) as count_measures,
                m.latitude,
                m.longitude
            FROM mesures m
            JOIN variables v ON m.id = v.mesure_id
            WHERE
                $wherePeriod
            AND
                $metricCondition
            AND
                v.qa_flag = 1
            AND
                v.valeur IS NOT NULL
            GROUP BY DATE(m.date_mesure), m.latitude, m.longitude
            ORDER BY m.date_mesure ASC
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Obtient les dates minimales et maximales disponibles dans les données
     */
    public function getDateRange(): array
    {
        $sql = "
            SELECT 
                MIN(DATE(date_mesure)) as min_date,
                MAX(DATE(date_mesure)) as max_date
            FROM mesures
            WHERE date_mesure IS NOT NULL
        ";

        $result = $this->pdo->query($sql)->fetch();
        return [
            'min_date' => $result['min_date'] ?? null,
            'max_date' => $result['max_date'] ?? null
        ];
    }

    /**
     * Analyse des données par conditions météo
     */
    public function getWeatherAnalysis(
        string $metric,
        string $wherePeriod
    ): array {
        $metricCondition = MetricHelper::getMetricColumn($metric);

        $sql = "
            SELECT 
                m.weather,
                COUNT(*) as count_measures,
                AVG(v.valeur) as avg_value,
                MIN(v.valeur) as min_value,
                MAX(v.valeur) as max_value,
                STDDEV(v.valeur) as std_deviation,
                SUBSTRING_INDEX(GROUP_CONCAT(DISTINCT DATE(m.date_mesure) ORDER BY m.date_mesure SEPARATOR ','), ',', 10) as sample_dates
            FROM mesures m
            JOIN variables v ON m.id = v.mesure_id
            WHERE
                $wherePeriod
            AND
                m.weather IS NOT NULL
            AND
                m.weather != ''
            AND
                $metricCondition
            AND
                v.qa_flag = 1
            AND
                v.valeur IS NOT NULL
            GROUP BY m.weather
            ORDER BY count_measures DESC
        ";

        $stmt = $this->pdo->query($sql);
        $results = $stmt->fetchAll() ?: [];

        // Analyse complémentaire : répartition par type de météo
        $distributionSql = "
            SELECT 
                m.weather,
                COUNT(*) as total_count,
                ROUND(COUNT(*) * 100.0 / SUM(COUNT(*)) OVER(), 2) as percentage
            FROM mesures m
            WHERE
                $wherePeriod
            AND
                m.weather IS NOT NULL
            AND
                m.weather != ''
            GROUP BY m.weather
            ORDER BY total_count DESC
        ";

        $distStmt = $this->pdo->query($distributionSql);
        $distribution = $distStmt->fetchAll() ?: [];

        // Statistiques globales
        $globalStatsSql = "
            SELECT 
                COUNT(DISTINCT m.weather) as weather_types_count,
                COUNT(*) as total_measures_with_weather,
                ROUND(COUNT(DISTINCT m.weather) * 100.0 / COUNT(*), 2) as weather_coverage
            FROM mesures m
            WHERE
                $wherePeriod
            AND
                m.weather IS NOT NULL
            AND
                m.weather != ''
        ";

        $globalStats = $this->pdo->query($globalStatsSql)->fetch() ?: [];

        return [
            'by_weather_type' => $results,
            'distribution' => $distribution,
            'global_stats' => $globalStats,
            'analysis_summary' => $this->generateWeatherSummary($results, $globalStats)
        ];
    }

    /**
     * Génère un résumé de l'analyse météo
     */
    private function generateWeatherSummary(array $weatherData, array $globalStats): array
    {
        if (empty($weatherData)) {
            return [
                'dominant_weather' => 'N/A',
                'most_variable_weather' => 'N/A',
                'weather_impact_level' => 'low'
            ];
        }

        // Trouver la météo dominante (plus de mesures)
        $dominantWeather = $weatherData[0]['weather'] ?? 'N/A';
        
        // Calculer la variabilité pour chaque type de météo
        $maxVariability = 0;
        $mostVariableWeather = 'N/A';
        
        foreach ($weatherData as $data) {
            $variability = ($data['max_value'] - $data['min_value']) / ($data['avg_value'] ?? 1);
            if ($variability > $maxVariability) {
                $maxVariability = $variability;
                $mostVariableWeather = $data['weather'];
            }
        }

        // Déterminer le niveau d'impact
        $weatherTypesCount = $globalStats['weather_types_count'] ?? 0;
        $impactLevel = 'low';
        if ($weatherTypesCount > 5) {
            $impactLevel = 'high';
        } elseif ($weatherTypesCount > 2) {
            $impactLevel = 'medium';
        }

        return [
            'dominant_weather' => $dominantWeather,
            'most_variable_weather' => $mostVariableWeather,
            'weather_impact_level' => $impactLevel,
            'total_weather_types' => $weatherTypesCount
        ];
    }

}
