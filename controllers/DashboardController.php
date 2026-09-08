<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Dashboard.php";
require_once __DIR__ . "/../services/DashboardService.php";

class DashboardController
{
    private $dashboardModel;
    private $dashboardService;


    public function __construct()
    {
        global $pdo;

        $this->dashboardModel =
            new Dashboard($pdo);

        $this->dashboardService =
            new DashboardService(
                $this->dashboardModel
            );
    }


    // =========================
    // GET DASHBOARD SUMMARY
    // =========================

    public function getSummary()
    {
        return $this->dashboardService
            ->getDashboardSummary();
    }


    // =========================
    // GET EMPLOYEES BY DEPARTMENT
    // =========================

    public function getEmployeesByDepartment()
    {
        return $this->dashboardService
            ->getEmployeesByDepartment();
    }
}