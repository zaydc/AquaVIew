<?php
/**
 * Controleur pour l'exportation des donnees oceaniques
 * BUT2 - S3 - AquaView Project
 * Gere l'export des donnees dans differents formats (JSON, CSV, NetCDF)
 */

declare(strict_types=1);

namespace App\Controller;

use App\Model\Repository\OceanDataRepository;
use App\Lib\TimeHelper;

/**
 * ExportController - Gestion des exports de donnees
 * 
 * Ce controleur permet d'exporter les donnees oceaniques dans :
 * - JSON : Format standard pour les applications web
 * - CSV : Format tableur compatible Excel
 * - NetCDF : Format scientifique pour les donnees climatiques
 */
class ExportController
{
    /** @var OceanDataRepository Repository pour les donnees oceaniques */
    private OceanDataRepository $repo;

    /**
     * Constructeur - Initialise le repository des donnees oceaniques
     */
    public function __construct()
    {
        $this->repo = new OceanDataRepository();
    }

    /**
     * Point d'entree principal pour les exportations
     * Route les requetes vers le bon format d'export
     * 
     * Parametres GET attendus :
     * - format : json|csv|netcdf
     * - metric : type de donnee (dissoxygen, temperature, etc.)
     * - start_date / end_date : periode personnalisee
     * - periode : nombre d'annees (alternative aux dates)
     */
    public function export(): void
    {
        $format = $_GET['format'] ?? 'json';
        $metric = $_GET['metric'] ?? 'dissoxygen';
        
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;
        $years = isset($_GET['periode']) ? (int)$_GET['periode'] : null;

        // Construction des filtres temporels
        if ($startDate || $endDate) {
            // Periode personnalisee avec dates exactes
            $wherePeriod = TimeHelper::getDateRangeCondition($startDate, $endDate);
        } else {
            // Periode par defaut en annees (1 an si non specifie)
            $wherePeriod = TimeHelper::getTimePeriod($years ?? 1);
        }

        // Recuperation des donnees depuis le repository
        $stats = $this->repo->getMetricStats($metric, $wherePeriod);
        $evolution = $this->repo->getMetricEvolution($metric, $wherePeriod);
        $nbMesures = $this->repo->countMeasures($wherePeriod);

        // Structuration des donnees pour l'export
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

        // Routage vers la methode d'export appropriee
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
     * Exportation au format JSON
     * Format standard pour les APIs et applications JavaScript
     * @param array $data Donnees structurees a exporter
     */
    private function exportJson(array $data): void
    {
        // En-tetes HTTP pour le telechargement
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="aqua_view_' . $data['metric'] . '_' . date('Y-m-d') . '.json"');
        
        // Encodage JSON avec pretty print et support UTF-8
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Exportation au format CSV
     * Format tableur compatible avec Excel et LibreOffice Calc
     * Utilise le point-virgule comme separateur (standard francais)
     * @param array $data Donnees structurees a exporter
     */
    private function exportCsv(array $data): void
    {
        // En-tetes HTTP pour le telechargement CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="aqua_view_' . $data['metric'] . '_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Ajout du BOM UTF-8 pour une meilleure compatibilite avec Excel
        fwrite($output, "\xEF\xBB\xBF");
        
        // En-tetes de colonnes avec point-virgule comme separateur
        fputcsv($output, ['Date', 'Valeur', 'Nombre de mesures', 'Latitude', 'Longitude'], ';');
        
        // Parcours et ecriture des donnees d'evolution
        foreach ($data['evolution'] as $row) {
            fputcsv($output, [
                $row['date'],
                // Conversion des nombres decimaux : virgule francaise → point international
                is_numeric($row['value']) ? str_replace(',', '.', (string)$row['value']) : $row['value'],
                $row['count_measures'],
                // Formatage des coordonnees geographiques avec 6 decimales
                is_numeric($row['latitude']) ? number_format((float)$row['latitude'], 6, '.', '') : $row['latitude'],
                is_numeric($row['longitude']) ? number_format((float)$row['longitude'], 6, '.', '') : $row['longitude']
            ], ';');
        }
        
        fclose($output);
    }

    /**
     * Exportation au format NetCDF (simplifie)
     * Format scientifique standard pour les donnees climatiques et oceanographiques
     * Note : Implementation simplifiee, en production utiliser la bibliotheque netCDF PHP
     * @param array $data Donnees structurees a exporter
     */
    private function exportNetCdf(array $data): void
    {
        // En-tetes HTTP pour le telechargement binaire
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="aqua_view_' . $data['metric'] . '_' . date('Y-m-d') . '.nc"');
        
        // Pour NetCDF, nous creons un format binaire simplifie
        // En production, il faudrait utiliser la bibliotheque netCDF PHP
        $output = fopen('php://output', 'wb');
        
        // En-tete NetCDF simplifie avec metadonnees
        $header = "NETCDF3\n";
        $header .= "Metric: " . $data['metric'] . "\n";
        $header .= "Period: " . ($data['start_date'] ?? 'auto') . " to " . ($data['end_date'] ?? 'auto') . "\n";
        $header .= "Records: " . count($data['evolution']) . "\n";
        $header .= "---DATA---\n";
        
        fwrite($output, $header);
        
        // Ecriture des donnees binaires (format double precision)
        foreach ($data['evolution'] as $row) {
            // Pack des donnees en binaire :
            $record = pack('d', strtotime($row['date'])); // Timestamp (double)
            $record .= pack('d', (float)$row['value']);    // Valeur metrique (double)
            $record .= pack('d', (float)$row['latitude']); // Latitude (double)
            $record .= pack('d', (float)$row['longitude']); // Longitude (double)
            fwrite($output, $record);
        }
        
        // Ajout d'un pied de page pour terminer le fichier NetCDF
        $footer = "\n---END---\n";
        fwrite($output, $footer);
        
        fclose($output);
    }
}
