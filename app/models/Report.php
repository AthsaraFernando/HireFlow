<?php

class Report
{
    use Model;

    protected $table = 'recruitment_reports';

    protected $allowedColumns = [
        'title',
        'from_date',
        'to_date',
        'report_type',
        'generated_by',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    private $tableSupportCache = [];

    public function getApplicantsByDateRangeAndType($fromDate, $toDate, $type, $selectedIds = [])
    {
        $query = "SELECT
                    a.id as application_id,
                    a.status,
                    DATE(a.applied_at) as applied_date,
                    u.full_name as applicant_name,
                    u.email,
                    u.phone,
                    jp.title as job_title
                  FROM applications a
                  JOIN users u ON u.id = a.applicant_id
                  JOIN job_posts jp ON jp.id = a.job_id
                  WHERE DATE(a.applied_at) BETWEEN :from_date AND :to_date";

        $params = [
            'from_date' => $fromDate,
            'to_date' => $toDate
        ];

        $statusCondition = $this->buildStatusFilterSql($type, 'a.status');
        if ($statusCondition !== '') {
            $query .= " AND {$statusCondition}";
        }

        if (!empty($selectedIds)) {
            $idPlaceholders = [];
            foreach ($selectedIds as $index => $applicationId) {
                $key = 'app_id_' . $index;
                $idPlaceholders[] = ':' . $key;
                $params[$key] = (int) $applicationId;
            }
            $query .= " AND a.id IN (" . implode(', ', $idPlaceholders) . ")";
        }

        $query .= " ORDER BY a.applied_at DESC";

        return $this->query($query, $params);
    }

    public function getSummaryCounts($fromDate, $toDate)
    {
        $query = "SELECT
                    COUNT(*) as total_applications,
                    SUM(CASE WHEN status = 'Applied' THEN 1 ELSE 0 END) as applied_count,
                    SUM(CASE WHEN status = 'Shortlisted' THEN 1 ELSE 0 END) as shortlisted_count,
                    SUM(CASE WHEN status = 'Interview Scheduled' THEN 1 ELSE 0 END) as interview_scheduled_count,
                    SUM(CASE WHEN status = 'Offered' THEN 1 ELSE 0 END) as offered_count,
                    SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as rejected_count
                  FROM applications
                  WHERE DATE(applied_at) BETWEEN :from_date AND :to_date";

        return $this->get_row($query, [
            'from_date' => $fromDate,
            'to_date' => $toDate
        ]);
    }

    public function getTypeCount($fromDate, $toDate, $type)
    {
        if (strtolower($type) === 'all') {
            $summary = $this->getSummaryCounts($fromDate, $toDate);
            return (int) ($summary['total_applications'] ?? 0);
        }

        $query = "SELECT COUNT(*) as total
                  FROM applications
                  WHERE DATE(applied_at) BETWEEN :from_date AND :to_date";

        $statusCondition = $this->buildStatusFilterSql($type, 'status');
        if ($statusCondition !== '') {
            $query .= " AND {$statusCondition}";
        }

        $result = $this->get_row($query, [
            'from_date' => $fromDate,
            'to_date' => $toDate
        ]);

        return (int) ($result['total'] ?? 0);
    }

    public function createRecruitmentReport($payload, $selectedApplicantIds, $userId)
    {
        $reportId = $this->insert([
            'title' => $payload['title'],
            'from_date' => $payload['from_date'],
            'to_date' => $payload['to_date'],
            'report_type' => $payload['report_type'],
            'generated_by' => (int) $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if (!$reportId) {
            return false;
        }

        foreach ($selectedApplicantIds as $applicationId) {
            $this->query(
                "INSERT INTO recruitment_report_applications (report_id, application_id, created_at)
                 VALUES (:report_id, :application_id, :created_at)",
                [
                    'report_id' => (int) $reportId,
                    'application_id' => (int) $applicationId,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
        }

        return (int) $reportId;
    }

    public function updateRecruitmentReport($reportId, $payload, $selectedApplicantIds, $userId)
    {
        $updated = $this->update((int) $reportId, [
            'title' => $payload['title'],
            'from_date' => $payload['from_date'],
            'to_date' => $payload['to_date'],
            'report_type' => $payload['report_type'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if (!$updated) {
            return false;
        }

        $this->query(
            "DELETE FROM recruitment_report_applications WHERE report_id = :report_id",
            ['report_id' => (int) $reportId]
        );

        foreach ($selectedApplicantIds as $applicationId) {
            $this->query(
                "INSERT INTO recruitment_report_applications (report_id, application_id, created_at)
                 VALUES (:report_id, :application_id, :created_at)",
                [
                    'report_id' => (int) $reportId,
                    'application_id' => (int) $applicationId,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
        }

        return true;
    }

    public function getSavedReports($userId)
    {
        $query = "SELECT
                    rr.id,
                    rr.title,
                    rr.from_date,
                    rr.to_date,
                    rr.report_type,
                    rr.created_at,
                    rr.updated_at,
                    COUNT(rra.id) as selected_count
                  FROM recruitment_reports rr
                  LEFT JOIN recruitment_report_applications rra ON rra.report_id = rr.id
                  WHERE rr.generated_by = :user_id
                  AND rr.is_deleted = 0
                  GROUP BY rr.id
                  ORDER BY rr.created_at DESC";

        return $this->query($query, ['user_id' => (int) $userId]);
    }

    public function getSavedReportById($reportId, $userId)
    {
        $query = "SELECT id, title, from_date, to_date, report_type, generated_by, created_at, updated_at
                  FROM recruitment_reports
                  WHERE id = :report_id
                  AND generated_by = :user_id
                  AND is_deleted = 0
                  LIMIT 1";

        return $this->get_row($query, [
            'report_id' => (int) $reportId,
            'user_id' => (int) $userId
        ]);
    }

    public function getSavedReportApplicationIds($reportId)
    {
        $rows = $this->query(
            "SELECT application_id
             FROM recruitment_report_applications
             WHERE report_id = :report_id",
            ['report_id' => (int) $reportId]
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(static function ($row) {
            return (int) $row['application_id'];
        }, $rows);
    }

    public function softDeleteRecruitmentReport($reportId, $userId)
    {
        return $this->update((int) $reportId, [
            'is_deleted' => 1,
            'deleted_by' => (int) $userId,
            'deleted_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    private function buildStatusFilterSql($type, $statusColumn = 'status')
    {
        $normalized = strtolower(trim((string) $type));

        if ($normalized === 'all') {
            return "{$statusColumn} IN ('Applied', 'Shortlisted', 'Interview Scheduled', 'Offered', 'Rejected')";
        }

        $map = [
            'shortlisted' => "{$statusColumn} = 'Shortlisted'",
            'interview_scheduled' => "{$statusColumn} = 'Interview Scheduled'",
            'rejected' => "{$statusColumn} = 'Rejected'",
            'offered' => "{$statusColumn} = 'Offered'"
        ];

        return $map[$normalized] ?? "{$statusColumn} IN ('Applied', 'Shortlisted', 'Interview Scheduled', 'Offered', 'Rejected')";
    }

    private function normalizeAnalyticsFilters($filters = [])
    {
        $normalized = [
            'start_date' => null,
            'end_date' => null,
            'department_id' => null,
            'level' => '',
        ];

        if (!is_array($filters)) {
            return $normalized;
        }

        $startDate = trim((string)($filters['start_date'] ?? ''));
        $endDate = trim((string)($filters['end_date'] ?? ''));
        if ($startDate !== '' && $endDate !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate) && $startDate <= $endDate) {
            $normalized['start_date'] = $startDate;
            $normalized['end_date'] = $endDate;
        }

        $departmentId = (int)($filters['department_id'] ?? 0);
        if ($departmentId > 0) {
            $normalized['department_id'] = $departmentId;
        }

        $level = strtolower(trim((string)($filters['level'] ?? '')));
        if (in_array($level, ['entry', 'mid', 'senior', 'lead', 'executive'], true)) {
            $normalized['level'] = $level;
        }

        return $normalized;
    }

    private function getExperienceLevelVariants($level)
    {
        $map = [
            'entry' => ['entry', 'Entry', 'Entry Level'],
            'mid' => ['mid', 'Mid', 'Mid Level'],
            'senior' => ['senior', 'Senior', 'Senior Level'],
            'lead' => ['lead', 'Lead', 'Lead Level', 'Lead/Principal', 'Principal'],
            'executive' => ['executive', 'Executive', 'Executive Level'],
        ];

        return $map[$level] ?? [];
    }

    private function applyAnalyticsFilters(&$whereClauses, &$params, $filters, $options = [])
    {
        $normalized = $this->normalizeAnalyticsFilters($filters);

        $applicationAlias = $options['application_alias'] ?? 'a';
        $jobAlias = $options['job_alias'] ?? 'jp';
        $dateColumn = $options['date_column'] ?? 'applied_at';
        $useDate = $options['use_date'] ?? true;
        $defaultDays = isset($options['default_days']) ? (int)$options['default_days'] : null;
        $useDepartment = $options['use_department'] ?? true;
        $useLevel = $options['use_level'] ?? true;
        $paramPrefix = $options['param_prefix'] ?? 'flt';

        if ($useDate) {
            if (!empty($normalized['start_date']) && !empty($normalized['end_date'])) {
                $startKey = $paramPrefix . '_start';
                $endKey = $paramPrefix . '_end';
                $whereClauses[] = "DATE({$applicationAlias}.{$dateColumn}) BETWEEN :{$startKey} AND :{$endKey}";
                $params[$startKey] = $normalized['start_date'];
                $params[$endKey] = $normalized['end_date'];
            } elseif ($defaultDays !== null && $defaultDays > 0) {
                $whereClauses[] = "{$applicationAlias}.{$dateColumn} >= DATE_SUB(NOW(), INTERVAL {$defaultDays} DAY)";
            }
        }

        if ($useDepartment && !empty($normalized['department_id'])) {
            $deptKey = $paramPrefix . '_department_id';
            $whereClauses[] = "{$jobAlias}.department_id = :{$deptKey}";
            $params[$deptKey] = (int)$normalized['department_id'];
        }

        if ($useLevel && !empty($normalized['level'])) {
            $variants = $this->getExperienceLevelVariants($normalized['level']);
            if (!empty($variants)) {
                $levelPlaceholders = [];
                foreach ($variants as $index => $variant) {
                    $key = $paramPrefix . '_level_' . $index;
                    $levelPlaceholders[] = ':' . $key;
                    $params[$key] = $variant;
                }
                $whereClauses[] = "{$jobAlias}.experience_level IN (" . implode(', ', $levelPlaceholders) . ')';
            }
        }

        return $normalized;
    }
    
    /**
     * Get recruitment funnel statistics
     */
    public function getRecruitmentFunnelStats($filters = [])
    {
        $whereClauses = [];
        $params = [];
        $this->applyAnalyticsFilters($whereClauses, $params, $filters, [
            'application_alias' => 'a',
            'job_alias' => 'jp',
            'date_column' => 'applied_at',
            'default_days' => 90,
            'param_prefix' => 'funnel'
        ]);

        $query = "SELECT 
                    COUNT(*) as total_applications,
                    SUM(CASE WHEN a.status IN ('Under Review', 'Shortlisted', 'Interview Scheduled', 'Offered', 'Hired') THEN 1 ELSE 0 END) as screening_passed,
                    SUM(CASE WHEN a.status IN ('Interview Scheduled', 'Offered', 'Hired') THEN 1 ELSE 0 END) as interviews_scheduled,
                    SUM(CASE WHEN a.status = 'Offered' OR a.status = 'Hired' THEN 1 ELSE 0 END) as offers_extended,
                    SUM(CASE WHEN a.status = 'Hired' THEN 1 ELSE 0 END) as successful_hires
                  FROM applications a
                  LEFT JOIN job_posts jp ON jp.id = a.job_id";

        if (!empty($whereClauses)) {
            $query .= ' WHERE ' . implode(' AND ', $whereClauses);
        }
        
        return $this->get_row($query, $params);
    }
    
    /**
     * Get applications over time (weekly data)
     */
    public function getApplicationsOverTime($weeks = 12, $filters = [])
    {
        $weeks = (int)$weeks; // Ensure it's an integer
        $whereClauses = [];
        $params = [];
        $normalized = $this->applyAnalyticsFilters($whereClauses, $params, $filters, [
            'application_alias' => 'a',
            'job_alias' => 'jp',
            'date_column' => 'applied_at',
            'default_days' => null,
            'param_prefix' => 'timeline'
        ]);

        if (empty($normalized['start_date'])) {
            $whereClauses[] = "a.applied_at >= DATE_SUB(NOW(), INTERVAL {$weeks} WEEK)";
        }
        
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
                  LEFT JOIN job_posts jp ON jp.id = a.job_id";

        if (!empty($whereClauses)) {
            $query .= ' WHERE ' . implode(' AND ', $whereClauses);
        }

        $query .= "
                  GROUP BY YEARWEEK(a.applied_at, 1)
                  ORDER BY year_week DESC
                  LIMIT {$weeks}";
        
        return $this->query($query, $params);
    }
    
    /**
     * Get monthly application trends
     */
    public function getMonthlyApplicationTrends($months = 6, $filters = [])
    {
        $months = (int)$months; // Ensure it's an integer
        $whereClauses = [];
        $params = [];
        $normalized = $this->applyAnalyticsFilters($whereClauses, $params, $filters, [
            'application_alias' => 'a',
            'job_alias' => 'jp',
            'date_column' => 'applied_at',
            'default_days' => null,
            'param_prefix' => 'monthly'
        ]);

        if (empty($normalized['start_date'])) {
            $whereClauses[] = "a.applied_at >= DATE_SUB(NOW(), INTERVAL {$months} MONTH)";
        }
        
        $query = "SELECT 
                    DATE_FORMAT(a.applied_at, '%Y-%m') as month,
                    DATE_FORMAT(a.applied_at, '%b %Y') as month_name,
                    COUNT(*) as total_applications,
                    SUM(CASE WHEN a.status = 'Hired' THEN 1 ELSE 0 END) as hires
                  FROM applications a
                  LEFT JOIN job_posts jp ON jp.id = a.job_id";

        if (!empty($whereClauses)) {
            $query .= ' WHERE ' . implode(' AND ', $whereClauses);
        }

        $query .= "
                  GROUP BY DATE_FORMAT(a.applied_at, '%Y-%m')
                  ORDER BY month DESC";
        
        return $this->query($query, $params);
    }
    
    /**
     * Get status distribution for all applications
     */
    public function getStatusDistribution($filters = [])
    {
        $whereClauses = [];
        $params = [];
        $this->applyAnalyticsFilters($whereClauses, $params, $filters, [
            'application_alias' => 'a',
            'job_alias' => 'jp',
            'date_column' => 'applied_at',
            'default_days' => null,
            'param_prefix' => 'status'
        ]);

        $query = "SELECT 
                    a.status,
                    COUNT(*) as count,
                    0 as percentage
                  FROM applications a
                  LEFT JOIN job_posts jp ON jp.id = a.job_id";

        if (!empty($whereClauses)) {
            $query .= ' WHERE ' . implode(' AND ', $whereClauses);
        }

        $query .= "
                  GROUP BY a.status
                  ORDER BY count DESC";

        $rows = $this->query($query, $params);
        if (!is_array($rows) || empty($rows)) {
            return [];
        }

        $total = 0;
        foreach ($rows as $row) {
            $total += (int)($row['count'] ?? 0);
        }

        if ($total <= 0) {
            return $rows;
        }

        foreach ($rows as &$row) {
            $row['percentage'] = round((((int)($row['count'] ?? 0)) * 100) / $total, 2);
        }
        unset($row);

        return $rows;
    }
    
    /**
     * Get interview statistics
     */
    public function getInterviewStats($filters = [])
    {
        $whereClauses = [];
        $params = [];
        $this->applyAnalyticsFilters($whereClauses, $params, $filters, [
            'application_alias' => 'i',
            'job_alias' => 'jp',
            'date_column' => 'scheduled_date',
            'default_days' => 30,
            'param_prefix' => 'interview'
        ]);

        $whereClauses[] = 'a.id IS NOT NULL';

        $query = "SELECT 
                    COUNT(*) as total_interviews,
                    SUM(CASE WHEN i.status = 'Completed' THEN 1 ELSE 0 END) as completed,
                    SUM(CASE WHEN i.status = 'Scheduled' OR i.status = 'Pending' THEN 1 ELSE 0 END) as scheduled,
                    SUM(CASE WHEN i.status = 'Canceled' THEN 1 ELSE 0 END) as canceled,
                    COUNT(DISTINCT i.interviewer_id) as total_interviewers,
                    COUNT(DISTINCT i.application_id) as unique_candidates
                  FROM interviews i
                  LEFT JOIN applications a ON a.id = i.application_id
                  LEFT JOIN job_posts jp ON jp.id = a.job_id";

        if (!empty($whereClauses)) {
            $query .= ' WHERE ' . implode(' AND ', $whereClauses);
        }
        
        return $this->get_row($query, $params);
    }
    
    /**
     * Get department-wise statistics
     */
    public function getDepartmentStats($filters = [])
    {
        $normalized = $this->normalizeAnalyticsFilters($filters);
        $whereClauses = [];
        $params = [];

        if (!empty($normalized['start_date']) && !empty($normalized['end_date'])) {
            $whereClauses[] = 'DATE(a.applied_at) BETWEEN :dept_start_date AND :dept_end_date';
            $params['dept_start_date'] = $normalized['start_date'];
            $params['dept_end_date'] = $normalized['end_date'];
        }

        if (!empty($normalized['department_id'])) {
            $whereClauses[] = 'd.id = :dept_filter_id';
            $params['dept_filter_id'] = (int)$normalized['department_id'];
        }

        if (!empty($normalized['level'])) {
            $variants = $this->getExperienceLevelVariants($normalized['level']);
            if (!empty($variants)) {
                $levelPlaceholders = [];
                foreach ($variants as $index => $variant) {
                    $key = 'dept_level_' . $index;
                    $levelPlaceholders[] = ':' . $key;
                    $params[$key] = $variant;
                }
                $whereClauses[] = 'jp.experience_level IN (' . implode(', ', $levelPlaceholders) . ')';
            }
        }

        $query = "SELECT 
                    d.name as department_name,
                    COUNT(DISTINCT jp.id) as open_positions,
                    COUNT(a.id) as total_applications,
                    SUM(CASE WHEN a.status = 'Hired' THEN 1 ELSE 0 END) as hires
                  FROM departments d
                  LEFT JOIN job_posts jp ON d.id = jp.department_id AND jp.status IN ('Open', 'Active')
                  LEFT JOIN applications a ON jp.id = a.job_id";

        if (!empty($whereClauses)) {
            $query .= ' WHERE ' . implode(' AND ', $whereClauses);
        }

        $query .= "
                  GROUP BY d.id, d.name
                  ORDER BY total_applications DESC";
        
        return $this->query($query, $params);
    }

    /**
     * Get live KPI metrics for report dashboard cards
     */
    public function getDashboardKpiMetrics($filters = [])
    {
        $whereClauses = [];
        $params = [];
        $this->applyAnalyticsFilters($whereClauses, $params, $filters, [
            'application_alias' => 'a',
            'job_alias' => 'jp',
            'date_column' => 'applied_at',
            'default_days' => null,
            'param_prefix' => 'kpi'
        ]);

        $fromClause = ' FROM applications a LEFT JOIN job_posts jp ON jp.id = a.job_id';
        $whereSql = !empty($whereClauses) ? ' WHERE ' . implode(' AND ', $whereClauses) : '';

        $totals = $this->get_row("SELECT
                                    COUNT(*) as total_applications,
                                    SUM(CASE WHEN a.status = 'Hired' THEN 1 ELSE 0 END) as successful_hires
                                  {$fromClause}{$whereSql}", $params);

        $avgTimeResult = $this->get_row("SELECT
                                            ROUND(AVG(CASE WHEN a.status = 'Hired' THEN DATEDIFF(CURDATE(), DATE(a.applied_at)) END), 0) as avg_time_to_hire
                                         {$fromClause}{$whereSql}", $params);

        $totalApplications = (int)($totals['total_applications'] ?? 0);
        $successfulHires = (int)($totals['successful_hires'] ?? 0);
        $avgTimeToHire = (int)($avgTimeResult['avg_time_to_hire'] ?? 0);

        $configuredCostPerHire = $this->getConfiguredCostPerHire();
        $costPerHire = $configuredCostPerHire !== null
            ? $configuredCostPerHire
            : $this->getEstimatedCostPerHire($successfulHires, $totalApplications, $filters);

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
    public function getTopPerformingJobPosts($limit = 5, $filters = [])
    {
        $limit = max(1, (int)$limit);

        $whereClauses = [];
        $params = [];
        $this->applyAnalyticsFilters($whereClauses, $params, $filters, [
            'application_alias' => 'a',
            'job_alias' => 'jp',
            'date_column' => 'applied_at',
            'default_days' => null,
            'param_prefix' => 'jobs'
        ]);

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
                  LEFT JOIN interviews i ON i.application_id = a.id";

        if (!empty($whereClauses)) {
            $query .= ' WHERE ' . implode(' AND ', $whereClauses);
        }

        $query .= "
                  GROUP BY jp.id, jp.title
                  HAVING COUNT(DISTINCT a.id) > 0
                  ORDER BY conversion_rate DESC, hires_count DESC, applications_count DESC
                  LIMIT {$limit}";

        return $this->query($query, $params);
    }

    /**
     * Get interviewer performance for reports table
     */
    public function getInterviewerPerformance($limit = 10, $filters = [])
    {
        $limit = max(1, (int)$limit);

        $whereClauses = [];
        $params = [];
        $this->applyAnalyticsFilters($whereClauses, $params, $filters, [
            'application_alias' => 'i',
            'job_alias' => 'jp',
            'date_column' => 'scheduled_date',
            'default_days' => null,
            'param_prefix' => 'interviewer'
        ]);

        $filtersSql = '';
        if (!empty($whereClauses)) {
            $filtersSql = ' AND ' . implode(' AND ', $whereClauses);
        }

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
                      LEFT JOIN job_posts jp ON jp.id = a.job_id
                      LEFT JOIN feedback f ON f.interview_id = i.id
                      WHERE u.role_id IN (2, 3)
                      {$filtersSql}
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
                      LEFT JOIN job_posts jp ON jp.id = a.job_id
                      WHERE u.role_id IN (2, 3)
                      {$filtersSql}
                      GROUP BY u.id, u.full_name
                      ORDER BY interviews_conducted DESC, hire_rate DESC
                      LIMIT {$limit}";
        }

        return $this->query($query, $params);
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

    private function getEstimatedCostPerHire($successfulHires, $totalApplications, $filters = [])
    {
        if ($successfulHires <= 0) {
            return 0;
        }

        $interviewCount = 0;
        if ($this->tableExists('interviews')) {
            $whereClauses = [];
            $params = [];
            $this->applyAnalyticsFilters($whereClauses, $params, $filters, [
                'application_alias' => 'i',
                'job_alias' => 'jp',
                'date_column' => 'scheduled_date',
                'default_days' => null,
                'param_prefix' => 'cost'
            ]);

            $query = "SELECT COUNT(*) as total_interviews
                      FROM interviews i
                      LEFT JOIN applications a ON a.id = i.application_id
                      LEFT JOIN job_posts jp ON jp.id = a.job_id";

            if (!empty($whereClauses)) {
                $query .= ' WHERE ' . implode(' AND ', $whereClauses);
            }

            $interviewStats = $this->get_row($query, $params);
            $interviewCount = (int)($interviewStats['total_interviews'] ?? 0);
        }

        $estimatedTotalCost = ($totalApplications * 25) + ($interviewCount * 100);

        return round($estimatedTotalCost / $successfulHires, 0);
    }
    
    /**
     * Calculate conversion rates between stages
     */
    public function getConversionRates($filters = [])
    {
        $stats = $this->getRecruitmentFunnelStats($filters);
        
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
    public function getSuccessRate($filters = [])
    {
        $whereClauses = [];
        $params = [];
        $this->applyAnalyticsFilters($whereClauses, $params, $filters, [
            'application_alias' => 'a',
            'job_alias' => 'jp',
            'date_column' => 'applied_at',
            'default_days' => 90,
            'param_prefix' => 'success'
        ]);

        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN a.status = 'Hired' THEN 1 ELSE 0 END) as hired
                  FROM applications a
                  LEFT JOIN job_posts jp ON jp.id = a.job_id";

        if (!empty($whereClauses)) {
            $query .= ' WHERE ' . implode(' AND ', $whereClauses);
        }
        
        $result = $this->get_row($query, $params);
        
        if ($result && $result['total'] > 0) {
            return round(($result['hired'] / $result['total']) * 100, 1);
        }
        
        return 0;
    }
}
?>
