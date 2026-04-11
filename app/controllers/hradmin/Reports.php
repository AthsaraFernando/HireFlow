<?php

class Reports extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'HR Analytics & Reports';
        
        // Load Report model
        $reportModel = new Report();
        
        // Get recruitment funnel statistics
        $funnelStats = $reportModel->getRecruitmentFunnelStats();
        $data['funnel_stats'] = $funnelStats;

        // Live KPI metrics for dashboard cards
        $data['dashboard_metrics'] = $reportModel->getDashboardKpiMetrics();
        
        // Calculate conversion rates
        $conversionRates = $reportModel->getConversionRates();
        $data['conversion_rates'] = $conversionRates;
        
        // Get applications over time (last 6 weeks)
        $applicationsOverTime = $reportModel->getApplicationsOverTime(6);
        $data['applications_timeline'] = $applicationsOverTime;
        
        // Get monthly trends
        $monthlyTrends = $reportModel->getMonthlyApplicationTrends(6);
        $data['monthly_trends'] = $monthlyTrends;
        
        // Get department statistics
        $departmentStats = $reportModel->getDepartmentStats();
        $data['department_stats'] = $departmentStats;
        
        // Get interview statistics
        $interviewStats = $reportModel->getInterviewStats();
        $data['interview_stats'] = $interviewStats;
        
        // Get status distribution
        $statusDistribution = $reportModel->getStatusDistribution();
        $data['status_distribution'] = $statusDistribution;

        // Detailed dynamic table data
        $data['top_performing_jobs'] = $reportModel->getTopPerformingJobPosts(5);
        $data['interviewer_performance'] = $reportModel->getInterviewerPerformance(5);
        
        // Hero stats
        $data['total_hires'] = $funnelStats['successful_hires'] ?? 0;
        $data['avg_time_to_hire'] = $reportModel->getAverageTimeToHire();
        $data['success_rate'] = $reportModel->getSuccessRate();
        
        // Overall metrics
        $data['hiring_metrics'] = [
            'total_applications' => $funnelStats['total_applications'] ?? 0,
            'screening_passed' => $funnelStats['screening_passed'] ?? 0,
            'interviews_scheduled' => $funnelStats['interviews_scheduled'] ?? 0,
            'offers_extended' => $funnelStats['offers_extended'] ?? 0,
            'successful_hires' => $funnelStats['successful_hires'] ?? 0,
            'average_time_to_hire' => $data['avg_time_to_hire'],
            'success_rate' => $data['success_rate']
        ];
        
        $this->view('hradmin/reports', $data);
    }
}
