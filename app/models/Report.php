<?php

class Report
{
    use Model;
    
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
