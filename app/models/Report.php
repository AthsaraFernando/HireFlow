<?php

class Report
{
    use Model;

    private $tableSupportCache = [];
    
    /**
     * Get recruitment funnel statistics
     */
    public function getRecruitmentFunnelStats()
    {
        $query = "SELECT 
                    COUNT(*) as total_applications,
                    SUM(CASE WHEN status IN ('Under Review', 'Shortlisted', 'Interview Scheduled', 'Offered', 'Hired') THEN 1 ELSE 0 END) as screening_passed,
                    SUM(CASE WHEN status IN ('Interview Scheduled', 'Offered', 'Hired') THEN 1 ELSE 0 END) as interviews_scheduled,
                    SUM(CASE WHEN status = 'Offered' OR status = 'Hired' THEN 1 ELSE 0 END) as offers_extended,
                    SUM(CASE WHEN status = 'Hired' THEN 1 ELSE 0 END) as successful_hires
                  FROM applications
                  WHERE applied_at >= DATE_SUB(NOW(), INTERVAL 90 DAY)";
        
        return $this->get_row($query);
    }
    
    /**
     * Get applications over time (weekly data)
     */
    public function getApplicationsOverTime($weeks = 12)
    {
        $weeks = (int)$weeks; // Ensure it's an integer
        
        $query = "SELECT 
                    CONCAT('Week ', WEEK(a.applied_at, 1)) as period,
                    YEARWEEK(a.applied_at, 1) as year_week,
                    COUNT(*) as total_applications,
                    SUM(CASE WHEN a.status IN ('Under Review', 'Shortlisted') THEN 1 ELSE 0 END) as screenings,
                    SUM(CASE WHEN a.status = 'Interview Scheduled' THEN 1 ELSE 0 END) as interviews,
                    SUM(CASE WHEN a.status = 'Offered' THEN 1 ELSE 0 END) as offers,
                    SUM(CASE WHEN a.status = 'Hired' THEN 1 ELSE 0 END) as hires,
                    DATE(MIN(a.applied_at)) as week_start,
                    DATE(MAX(a.applied_at)) as week_end
                  FROM applications a
                  WHERE a.applied_at >= DATE_SUB(NOW(), INTERVAL {$weeks} WEEK)
                  GROUP BY YEARWEEK(a.applied_at, 1)
                  ORDER BY year_week DESC
                  LIMIT {$weeks}";
        
        return $this->query($query);
    }
    
    /**
     * Get monthly application trends
     */
    public function getMonthlyApplicationTrends($months = 6)
    {
        $months = (int)$months; // Ensure it's an integer
        
        $query = "SELECT 
                    DATE_FORMAT(applied_at, '%Y-%m') as month,
                    DATE_FORMAT(applied_at, '%b %Y') as month_name,
                    COUNT(*) as total_applications,
                    SUM(CASE WHEN status = 'Hired' THEN 1 ELSE 0 END) as hires
                  FROM applications
                  WHERE applied_at >= DATE_SUB(NOW(), INTERVAL {$months} MONTH)
                  GROUP BY DATE_FORMAT(applied_at, '%Y-%m')
                  ORDER BY month DESC";
        
        return $this->query($query);
    }
    
    /**
     * Get status distribution for all applications
     */
    public function getStatusDistribution()
    {
        $query = "SELECT 
                    status,
                    COUNT(*) as count,
                    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM applications)), 2) as percentage
                  FROM applications
                  GROUP BY status
                  ORDER BY count DESC";
        
        return $this->query($query);
    }
    
    /**
     * Get interview statistics
     */
    public function getInterviewStats()
    {
        $query = "SELECT 
                    COUNT(*) as total_interviews,
                    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed,
                    SUM(CASE WHEN status = 'Scheduled' OR status = 'Pending' THEN 1 ELSE 0 END) as scheduled,
                    SUM(CASE WHEN status = 'Canceled' THEN 1 ELSE 0 END) as canceled,
                    COUNT(DISTINCT interviewer_id) as total_interviewers,
                    COUNT(DISTINCT application_id) as unique_candidates
                  FROM interviews
                  WHERE scheduled_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        
        return $this->get_row($query);
    }
    
    /**
     * Get department-wise statistics
     */
    public function getDepartmentStats()
    {
        $query = "SELECT 
                    d.name as department_name,
                    COUNT(DISTINCT jp.id) as open_positions,
                    COUNT(a.id) as total_applications,
                    SUM(CASE WHEN a.status = 'Hired' THEN 1 ELSE 0 END) as hires
                  FROM departments d
                  LEFT JOIN job_posts jp ON d.id = jp.department_id AND jp.status = 'Active'
                  LEFT JOIN applications a ON jp.id = a.job_id
                  GROUP BY d.id, d.name
                  ORDER BY total_applications DESC";
        
        return $this->query($query);
    }

    /**
     * Get live KPI metrics for report dashboard cards
     */
    public function getDashboardKpiMetrics()
    {
        $totals = $this->get_row("SELECT
                                    COUNT(*) as total_applications,
                                    SUM(CASE WHEN status = 'Hired' THEN 1 ELSE 0 END) as successful_hires
                                  FROM applications");

        $avgTimeResult = $this->get_row("SELECT
                                            ROUND(AVG(CASE WHEN status = 'Hired' THEN DATEDIFF(CURDATE(), DATE(applied_at)) END), 0) as avg_time_to_hire
                                         FROM applications");

        $totalApplications = (int)($totals['total_applications'] ?? 0);
        $successfulHires = (int)($totals['successful_hires'] ?? 0);
        $avgTimeToHire = (int)($avgTimeResult['avg_time_to_hire'] ?? 0);

        $configuredCostPerHire = $this->getConfiguredCostPerHire();
        $costPerHire = $configuredCostPerHire !== null
            ? $configuredCostPerHire
            : $this->getEstimatedCostPerHire($successfulHires, $totalApplications);

        return [
            'total_applications' => $totalApplications,
            'successful_hires' => $successfulHires,
            'avg_time_to_hire' => $avgTimeToHire,
            'cost_per_hire' => $costPerHire
        ];
    }

    /**
     * Get top performing job posts for reports table
     */
    public function getTopPerformingJobPosts($limit = 5)
    {
        $limit = max(1, (int)$limit);

        $query = "SELECT
                    jp.id,
                    jp.title as job_title,
                    COUNT(DISTINCT a.id) as applications_count,
                    COUNT(DISTINCT i.id) as interviews_count,
                    SUM(CASE WHEN a.status = 'Hired' THEN 1 ELSE 0 END) as hires_count,
                    ROUND(
                        CASE
                            WHEN COUNT(DISTINCT i.id) = 0 THEN 0
                            ELSE (SUM(CASE WHEN a.status = 'Hired' THEN 1 ELSE 0 END) * 100.0 / COUNT(DISTINCT i.id))
                        END,
                        1
                    ) as conversion_rate,
                    ROUND(
                        AVG(
                            CASE
                                WHEN a.status = 'Hired' THEN DATEDIFF(CURDATE(), DATE(a.applied_at))
                                ELSE NULL
                            END
                        ),
                        0
                    ) as avg_days_to_hire
                  FROM job_posts jp
                  LEFT JOIN applications a ON a.job_id = jp.id
                  LEFT JOIN interviews i ON i.application_id = a.id
                  GROUP BY jp.id, jp.title
                  HAVING COUNT(DISTINCT a.id) > 0
                  ORDER BY conversion_rate DESC, hires_count DESC, applications_count DESC
                  LIMIT {$limit}";

        return $this->query($query);
    }

    /**
     * Get interviewer performance for reports table
     */
    public function getInterviewerPerformance($limit = 10)
    {
        $limit = max(1, (int)$limit);

        if ($this->tableExists('feedback')) {
            $query = "SELECT
                        u.id,
                        u.full_name as interviewer_name,
                        COUNT(DISTINCT i.id) as interviews_conducted,
                        ROUND(AVG(f.overall_rating) / 2, 1) as avg_rating,
                        ROUND(
                            CASE
                                WHEN COUNT(DISTINCT i.application_id) = 0 THEN 0
                                ELSE (
                                    COUNT(DISTINCT CASE WHEN a.status = 'Hired' THEN i.application_id END) * 100.0 /
                                    COUNT(DISTINCT i.application_id)
                                )
                            END,
                            1
                        ) as hire_rate,
                        ROUND(
                            AVG((COALESCE(f.technical_rating, 0) + COALESCE(f.communication_rating, 0) + COALESCE(f.overall_rating, 0)) / 3) / 2,
                            1
                        ) as feedback_score
                      FROM users u
                      JOIN interviews i ON i.interviewer_id = u.id
                      LEFT JOIN applications a ON a.id = i.application_id
                      LEFT JOIN feedback f ON f.interview_id = i.id
                      WHERE u.role_id IN (2, 3)
                      GROUP BY u.id, u.full_name
                      ORDER BY interviews_conducted DESC, hire_rate DESC, avg_rating DESC
                      LIMIT {$limit}";
        } else {
            $query = "SELECT
                        u.id,
                        u.full_name as interviewer_name,
                        COUNT(DISTINCT i.id) as interviews_conducted,
                        NULL as avg_rating,
                        ROUND(
                            CASE
                                WHEN COUNT(DISTINCT i.application_id) = 0 THEN 0
                                ELSE (
                                    COUNT(DISTINCT CASE WHEN a.status = 'Hired' THEN i.application_id END) * 100.0 /
                                    COUNT(DISTINCT i.application_id)
                                )
                            END,
                            1
                        ) as hire_rate,
                        NULL as feedback_score
                      FROM users u
                      JOIN interviews i ON i.interviewer_id = u.id
                      LEFT JOIN applications a ON a.id = i.application_id
                      WHERE u.role_id IN (2, 3)
                      GROUP BY u.id, u.full_name
                      ORDER BY interviews_conducted DESC, hire_rate DESC
                      LIMIT {$limit}";
        }

        return $this->query($query);
    }

    private function tableExists($tableName)
    {
        if (array_key_exists($tableName, $this->tableSupportCache)) {
            return $this->tableSupportCache[$tableName];
        }

        $query = "SELECT COUNT(*) as table_count
                  FROM information_schema.tables
                  WHERE table_schema = DATABASE()
                  AND table_name = ?";

        $result = $this->get_row($query, [$tableName]);
        $this->tableSupportCache[$tableName] = (int)($result['table_count'] ?? 0) > 0;

        return $this->tableSupportCache[$tableName];
    }

    private function getConfiguredCostPerHire()
    {
        if (!$this->tableExists('system_settings')) {
            return null;
        }

        $query = "SELECT setting_value
                  FROM system_settings
                  WHERE setting_key IN ('cost_per_hire', 'avg_cost_per_hire', 'estimated_cost_per_hire')
                  ORDER BY FIELD(setting_key, 'cost_per_hire', 'avg_cost_per_hire', 'estimated_cost_per_hire')
                  LIMIT 1";

        $result = $this->get_row($query);
        if (!$result || !isset($result['setting_value'])) {
            return null;
        }

        $numericValue = preg_replace('/[^0-9.]/', '', (string)$result['setting_value']);
        if ($numericValue === '' || !is_numeric($numericValue)) {
            return null;
        }

        return (float)$numericValue;
    }

    private function getEstimatedCostPerHire($successfulHires, $totalApplications)
    {
        if ($successfulHires <= 0) {
            return 0;
        }

        $interviewCount = 0;
        if ($this->tableExists('interviews')) {
            $interviewStats = $this->get_row("SELECT COUNT(*) as total_interviews FROM interviews");
            $interviewCount = (int)($interviewStats['total_interviews'] ?? 0);
        }

        $estimatedTotalCost = ($totalApplications * 25) + ($interviewCount * 100);

        return round($estimatedTotalCost / $successfulHires, 0);
    }
    
    /**
     * Calculate conversion rates between stages
     */
    public function getConversionRates()
    {
        $stats = $this->getRecruitmentFunnelStats();
        
        if (!$stats || $stats['total_applications'] == 0) {
            return [
                'screening_rate' => 0,
                'interview_rate' => 0,
                'offer_rate' => 0,
                'hire_rate' => 0
            ];
        }
        
        return [
            'screening_rate' => round(($stats['screening_passed'] / $stats['total_applications']) * 100, 1),
            'interview_rate' => $stats['screening_passed'] > 0 ? round(($stats['interviews_scheduled'] / $stats['screening_passed']) * 100, 1) : 0,
            'offer_rate' => $stats['interviews_scheduled'] > 0 ? round(($stats['offers_extended'] / $stats['interviews_scheduled']) * 100, 1) : 0,
            'hire_rate' => $stats['offers_extended'] > 0 ? round(($stats['successful_hires'] / $stats['offers_extended']) * 100, 1) : 0
        ];
    }
    
    /**
     * Get time to hire average
     * Note: Returns 0 as applications table doesn't have hire date tracking
     */
    public function getAverageTimeToHire()
    {
        // Would need a hired_at or updated_at column to calculate actual time to hire
        // For now, return 0 or estimate based on current data
        return 0;
    }
    
    /**
     * Get overall success rate
     */
    public function getSuccessRate()
    {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'Hired' THEN 1 ELSE 0 END) as hired
                  FROM applications
                  WHERE applied_at >= DATE_SUB(NOW(), INTERVAL 90 DAY)";
        
        $result = $this->get_row($query);
        
        if ($result && $result['total'] > 0) {
            return round(($result['hired'] / $result['total']) * 100, 1);
        }
        
        return 0;
    }
}
?>
