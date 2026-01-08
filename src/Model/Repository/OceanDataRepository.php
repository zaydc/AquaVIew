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

}
