<?php

class DashboardService
{
    private $dashboardModel;

    public function __construct($dashboardModel)
    {
        $this->dashboardModel = $dashboardModel;
    }


    // =========================
    // GET DASHBOARD SUMMARY
    // =========================

    public function getDashboardSummary()
    {
        $summary =
            $this->dashboardModel->getDashboardSummary();

        return [
            "total_employees" =>
                (int) ($summary["total_employees"] ?? 0),

            "active_employees" =>
                (int) ($summary["active_employees"] ?? 0),

            "inactive_employees" =>
                (int) ($summary["inactive_employees"] ?? 0),

            "total_departments" =>
                (int) ($summary["total_departments"] ?? 0)
        ];
    }


    // =========================
    // GET EMPLOYEES BY DEPARTMENT
    // =========================

    public function getEmployeesByDepartment()
    {
        return $this->dashboardModel->getEmployeesByDepartment();
    }
}
