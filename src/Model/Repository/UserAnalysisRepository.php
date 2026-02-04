<?php

namespace App\Model\Repository;

use PDO;
use App\Config\Conf;

class UserAnalysisRepository
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
     * Enregistre une nouvelle analyse utilisateur
     */
    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO user_analyses (user_id, metric, start_date, end_date, avg_value, min_value, max_value, count_measures, analysis_data)
            VALUES (:user_id, :metric, :start_date, :end_date, :avg_value, :min_value, :max_value, :count_measures, :analysis_data)
        ";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'metric' => $data['metric'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'avg_value' => $data['avg_value'],
            'min_value' => $data['min_value'],
            'max_value' => $data['max_value'],
            'count_measures' => $data['count_measures'],
            'analysis_data' => json_encode($data['analysis_data'] ?? [])
        ]);
    }

    /**
     * Récupère les dernières analyses d'un utilisateur
     */
    public function findByUserId(int $userId, int $limit = 10): array
    {
        $sql = "
            SELECT 
                id,
                metric,
                start_date,
                end_date,
                avg_value,
                min_value,
                max_value,
                count_measures,
                analysis_data,
                created_at
            FROM user_analyses 
            WHERE user_id = :user_id 
            ORDER BY created_at DESC 
            LIMIT :limit
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $analyses = $stmt->fetchAll();
        
        // Décoder les données JSON pour chaque analyse
        foreach ($analyses as &$analysis) {
            $analysis['analysis_data'] = json_decode($analysis['analysis_data'], true) ?: [];
        }
        
        return $analyses;
    }

    /**
     * Compte le nombre d'analyses d'un utilisateur
     */
    public function countByUserId(int $userId): int
    {
        $sql = "SELECT COUNT(*) FROM user_analyses WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return (int) $stmt->fetchColumn();
    }

    /**
     * Supprime une analyse
     */
    public function delete(int $analysisId, int $userId): bool
    {
        $sql = "DELETE FROM user_analyses WHERE id = :id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('id', $analysisId, PDO::PARAM_INT);
        $stmt->bindValue('user_id', $userId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Récupère les statistiques d'analyses d'un utilisateur
     */
    public function getUserStats(int $userId): array
    {
        $sql = "
            SELECT 
                COUNT(*) as total_analyses,
                COUNT(DISTINCT metric) as unique_metrics,
                MAX(created_at) as last_analysis,
                AVG(count_measures) as avg_measures_per_analysis
            FROM user_analyses 
            WHERE user_id = :user_id
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch() ?: [];
    }

    /**
     * Récupère les analyses par métrique pour un utilisateur
     */
    public function findByMetric(int $userId, string $metric, int $limit = 5): array
    {
        $sql = "
            SELECT 
                id,
                metric,
                start_date,
                end_date,
                avg_value,
                min_value,
                max_value,
                count_measures,
                created_at
            FROM user_analyses 
            WHERE user_id = :user_id AND metric = :metric
            ORDER BY created_at DESC 
            LIMIT :limit
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue('metric', $metric, PDO::PARAM_STR);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}
