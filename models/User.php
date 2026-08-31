<?php
require_once __DIR__ . "/../config/database.php";
class User
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
}