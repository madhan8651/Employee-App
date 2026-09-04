<?php

require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../controllers/EmployeeController.php";

AuthMiddleware::check();

if (!isset($_GET["employee_id"])) {
    header("Location: index.php");
    exit;
}

$employeeId = $_GET["employee_id"];

$controller = new EmployeeController();

$controller->deactivateEmployee($employeeId);

header("Location: index.php");
exit;