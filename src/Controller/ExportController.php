<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Repository\OceanDataRepository;
use App\Lib\TimeHelper;

class ExportController
{
    private OceanDataRepository $repo;

    public function __construct()
    {
        $this->repo = new OceanDataRepository();
    }

    /**
     * Point d'entrée principal pour les exportations
     */
    public function export(): void
    {
        $format = $_GET['format'] ?? 'json';
        $metric = $_GET['metric'] ?? 'dissoxygen';
        
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;
        $years = isset($_GET['periode']) ? (int)$_GET['periode'] : null;

        // Construction des filtres
        if ($startDate || $endDate) {
            $wherePeriod = TimeHelper::getDateRangeCondition($startDate, $endDate);
        } else {
            $wherePeriod = TimeHelper::getTimePeriod($years ?? 1);
        }

        // Récupération des données
        $stats = $this->repo->getMetricStats($metric, $wherePeriod);
        $evolution = $this->repo->getMetricEvolution($metric, $wherePeriod);
        $nbMesures = $this->repo->countMeasures($wherePeriod);

        $data = [
            'periode_ans' => $years,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'metric' => $metric,
            'nb_mesures' => $nbMesures,
            'stats' => [
                'avg_value' => $stats['avg_value'] ?? null,
                'min_value' => $stats['min_value'] ?? null,
                'max_value' => $stats['max_value'] ?? null,
                'count_measures' => $stats['count_measures'] ?? 0
            ],
            'evolution' => $evolution
        ];

        // Dispatch selon le format
        switch (strtolower($format)) {
            case 'csv':
                $this->exportCsv($data);
                break;
            case 'netcdf':
                $this->exportNetCdf($data);
                break;
            case 'json':
            default:
                $this->exportJson($data);
                break;
        }
    }

    /**
     * Exportation JSON
     */
    private function exportJson(array $data): void
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="aqua_view_' . $data['metric'] . '_' . date('Y-m-d') . '.json"');
        
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Exportation CSV
     */
    private function exportCsv(array $data): void
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="aqua_view_' . $data['metric'] . '_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Ajout du BOM pour une meilleure compatibilité avec Excel
        fwrite($output, "\xEF\xBB\xBF");
        
        // En-têtes CSV avec point-virgule comme séparateur
        fputcsv($output, ['Date', 'Valeur', 'Nombre de mesures', 'Latitude', 'Longitude'], ';');
        
        // Données d'évolution avec formatage des nombres
        foreach ($data['evolution'] as $row) {
            fputcsv($output, [
                $row['date'],
                // Conversion des nombres décimaux avec virgule en point
                is_numeric($row['value']) ? str_replace(',', '.', (string)$row['value']) : $row['value'],
                $row['count_measures'],
                // Formatage des coordonnées géographiques
                is_numeric($row['latitude']) ? number_format((float)$row['latitude'], 6, '.', '') : $row['latitude'],
                is_numeric($row['longitude']) ? number_format((float)$row['longitude'], 6, '.', '') : $row['longitude']
            ], ';');
        }
        
        fclose($output);
    }

    /**
     * Exportation NetCDF (simplifié)
     */
    private function exportNetCdf(array $data): void
    {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="aqua_view_' . $data['metric'] . '_' . date('Y-m-d') . '.nc"');
        
        // Pour NetCDF, nous allons créer un format binaire simplifié
        // Dans un environnement de production, il faudrait utiliser la bibliothèque netCDF PHP
        $output = fopen('php://output', 'wb');
        
        // En-tête NetCDF simplifié
        $header = "NETCDF3\n";
        $header .= "Metric: " . $data['metric'] . "\n";
        $header .= "Period: " . ($data['start_date'] ?? 'auto') . " to " . ($data['end_date'] ?? 'auto') . "\n";
        $header .= "Records: " . count($data['evolution']) . "\n";
        $header .= "---DATA---\n";
        
        fwrite($output, $header);
        
        // Données binaires
        foreach ($data['evolution'] as $row) {
            $record = pack('d', strtotime($row['date'])); // Timestamp
            $record .= pack('d', (float)$row['value']);    // Valeur
            $record .= pack('d', (float)$row['latitude']); // Latitude
            $record .= pack('d', (float)$row['longitude']); // Longitude
            fwrite($output, $record);
        }
        
        fclose($output);
    }
}
