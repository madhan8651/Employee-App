-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 10, 2026 at 11:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `description`, `status`) VALUES
(1, 'HR', 'Human Resources', 'Active'),
(2, 'IT', 'Information Technology', 'Active'),
(3, 'Finance', 'Finance Department', 'Active'),
(4, 'Sales', 'Sales Department', 'Inactive'),
(5, 'Marketing', 'Marketing Department', 'Inactive'),
(6, 'Operations', 'Maximize efficiency in production and delivery.', 'Inactive'),
(7, 'Data Science & Analytics', 'manage corporate databases, build data pipelines, and utilize machine learning models', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `date_of_joining` date NOT NULL,
  `department_id` int(11) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `first_name`, `last_name`, `email`, `phone`, `date_of_birth`, `gender`, `date_of_joining`, `department_id`, `department`, `designation`, `salary`, `address`, `profile_photo`, `status`, `created_at`, `updated_at`) VALUES
('EMP001', 'Arul', 'Selvan', 'arun.kumar6@gmail.com', '9876543210', '1998-07-16', 'Male', '2026-08-14', 2, 'IT', 'Team Lead', 90000.00, 'Chennai', 'emp_6a9d6c2d272c18.69422223.jpg', 'Inactive', '2026-09-02 07:43:22', '2026-09-10 04:57:58'),
('EMP002', 'Arjun', 'Kannan', 'arjun@gmail.com', '9876543223', '2000-10-17', 'Male', '2026-06-24', 2, 'IT', 'Senior Software Tester', 50000.00, 'Kolkata', 'emp_6a981afe5db4a0.98187616.webp', 'Active', '2026-09-02 07:46:53', '2026-09-09 20:21:06'),
('EMP003', 'Ajith', 'Kumar', 'ajithkumar@gmail.com', '1234567891', '1996-06-11', 'Male', '2026-06-10', 2, 'IT', 'Team Lead', 70000.00, 'Coimbatore', 'emp_6a9eb01d3f8561.55273882.webp', 'Inactive', '2026-09-02 11:13:58', '2026-09-10 05:23:49'),
('EMP004', 'Vijay', 'Samuel', 'vijaykumar@gmail.com', '7894561238', '1997-06-10', 'Male', '2026-03-19', 4, 'Sales', 'Sales Manager', 25000.00, 'Bengaluru', 'emp_6a985105529eb4.69781985.jpg', 'Inactive', '2026-09-02 16:38:29', '2026-09-09 20:21:06'),
('EMP005', 'Mahesh', 'Kumar', 'mahesh@gmail.com', '4567891236', '1998-06-09', 'Male', '2026-06-24', 3, 'Finance', 'Accounting Operations', 40000.00, 'Coimbatore', 'emp_6a986037e9f000.30833679.webp', 'Active', '2026-09-02 17:43:19', '2026-09-09 20:21:06'),
('EMP006', 'Dinesh', 'Paul', 'dinesh@gmail.com', '6549873211', '1998-08-06', 'Male', '2026-08-06', 4, 'Sales', 'Sales Executive', 35000.00, 'Kolkata', 'emp_6a9a4da28a3ff6.52652964.jpg', 'Inactive', '2026-09-04 04:48:34', '2026-09-09 20:21:06'),
('EMP007', 'Tharun', 'Karthick', 'tharun@gmail.com', '7986542311', '1996-05-21', 'Male', '2026-06-17', 2, 'IT', 'Senior Network Engineer', 70000.00, 'Coimbatore', 'emp_6a9d5fe096eb50.93011896.jpg', 'Inactive', '2026-09-06 12:43:12', '2026-09-09 20:21:06'),
('EMP008', 'Vishnu', 'Vardhan', 'vishu@gmail.com', '7984563215', '2004-04-02', 'Male', '2026-08-13', 2, 'IT', 'Junior Software Engineer', 24000.00, 'Coimbatore', 'emp_6a9d61d33d9900.97541120.jpg', 'Active', '2026-09-06 12:51:31', '2026-09-09 20:21:06'),
('EMP009', 'Deepak', 'choudary', 'deepak@gmail.com', '7891471234', '2004-05-09', 'Male', '2026-08-15', 2, 'IT', 'junior Test Engineer', 24000.00, 'Coimbatore', 'emp_6a9d632a346968.94622551.jpg', 'Active', '2026-09-06 12:57:14', '2026-09-09 20:21:06'),
('EMP010', 'Shiva', 'Kumar', 'shiva@gmial.com', '8974712315', '2004-01-08', 'Male', '2026-08-04', 2, 'IT', 'Junior Software Engineer', 25000.00, 'Chennai', 'emp_6a9d664d688d15.44362347.jpg', 'Inactive', '2026-09-06 13:10:37', '2026-09-09 20:21:06'),
('EMP011', 'Ashok', 'Selvan', 'ashok@gmail.com', '7412369874', '2004-06-15', 'Male', '2026-08-12', 2, 'IT', 'Junior Software Engineer', 25000.00, 'Chennai', 'emp_6aa23692cff983.20955068.jpg', 'Active', '2026-09-10 04:48:18', '2026-09-10 04:48:18'),
('EMP012', 'Sunil', 'Dev', 'sunil@gmail.com', '7412369875', '2004-06-02', 'Male', '2026-07-23', 2, 'IT', 'Software Tester', 24000.00, 'Coimbatore', 'emp_6aa2638e928c79.72057918.jpg', 'Active', '2026-09-10 08:00:14', '2026-09-10 08:00:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Employee') NOT NULL DEFAULT 'Employee',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `username`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin', '$2y$10$ap.lchHdBgk69qawLB/BteRB90fD6ZtJvanrdpTyQfi5QpbcXBhFO', 'Admin', 'Active', '2026-08-31 07:38:21'),
(2, 'Employee', 'employee@gmail.com', 'employee', '$2y$10$Cu4DP8lge7zXtlJRLulICe..GGIkIIdZmR2zwI1mFgSv439EZVbEy', 'Employee', 'Active', '2026-08-31 09:58:14'),
(4, 'Madhan M', '6871madhan@gmail.com', 'madhan@123', '$2y$10$Gownn/L3hqggHTay.JtdMO8Al0exeBZnit.Kd7QdblIJ84AsXrrGO', 'Employee', 'Active', '2026-09-01 11:54:22'),
(5, 'Test User', 'testuser@gmail.com', 'testuser', '$2y$10$69idtKmcud2Bs6iazFBIiOVHzAdoEsj4a3.oGs/XSOlrv20Y0WHXu', 'Admin', 'Active', '2026-09-03 07:18:07'),
(6, 'Employee2', 'emp@gmail.com', 'emp@123', '$2y$10$g48CDTMmBtAyum49zHHTQemvoz3oWro59G0yjGcD/j/QXdx7SpP/y', 'Employee', 'Active', '2026-09-03 11:27:19'),
(7, 'admin test', 'admintest@gmail.com', 'admin@1', '$2y$10$u0yS35Vha7IqCvfh/SSPm.xnfvbXYmP6MdBc0eSHv2OBLbrMRpMEy', 'Admin', 'Inactive', '2026-09-03 12:09:55'),
(8, 'tester', 'testr@gmail.com', 'testr_1', '$2y$10$GsK.Ew0EDVjTfer0eLRH9esegFacIwDnZAIYKM52GqhvEiOtos7Wa', 'Admin', 'Active', '2026-09-06 17:40:54'),
(9, 'Arun Kumar', 'arun.kumar6@gmail.com', 'arun', '$2y$12$0swqa0an.kd8XDEYg0AMjOkcL3D9QFCzbybpNJ/vXVMF550qwIb9i', 'Employee', 'Active', '2026-09-09 12:11:53'),
(10, 'Arjun Kumar', 'arjun@gmail.com', 'arjun', '$2y$12$0swqa0an.kd8XDEYg0AMjOkcL3D9QFCzbybpNJ/vXVMF550qwIb9i', 'Employee', 'Active', '2026-09-09 12:11:53'),
(11, 'Ajith Kumar', 'ajithkumar@gmail.com', 'ajith', '$2y$12$0swqa0an.kd8XDEYg0AMjOkcL3D9QFCzbybpNJ/vXVMF550qwIb9i', 'Employee', 'Active', '2026-09-09 12:11:53'),
(12, 'Vijay Kumar', 'vijaykumar@gmail.com', 'vijay', '$2y$12$0swqa0an.kd8XDEYg0AMjOkcL3D9QFCzbybpNJ/vXVMF550qwIb9i', 'Employee', 'Active', '2026-09-09 12:11:53'),
(13, 'Mahesh Kumar', 'mahesh@gmail.com', 'mahesh', '$2y$12$0swqa0an.kd8XDEYg0AMjOkcL3D9QFCzbybpNJ/vXVMF550qwIb9i', 'Employee', 'Active', '2026-09-09 12:11:53'),
(14, 'Dinesh Paul', 'dinesh@gmail.com', 'dinesh', '$2y$10$1GencAfrw/5NJvwRRmEFFu7JYNFlTOMVeL9ZjPa4WuMcAgM4q41kG', 'Employee', 'Active', '2026-09-09 12:11:53'),
(15, 'Tharun Karthick', 'tharun@gmail.com', 'tharun', '$2y$12$0swqa0an.kd8XDEYg0AMjOkcL3D9QFCzbybpNJ/vXVMF550qwIb9i', 'Employee', 'Active', '2026-09-09 12:11:53'),
(16, 'Vishu Vardhan', 'vishu@gmail.com', 'vishu', '$2y$12$0swqa0an.kd8XDEYg0AMjOkcL3D9QFCzbybpNJ/vXVMF550qwIb9i', 'Employee', 'Active', '2026-09-09 12:11:53'),
(17, 'Deepak Choudary', 'deepak@gmail.com', 'deepak', '$2y$12$0swqa0an.kd8XDEYg0AMjOkcL3D9QFCzbybpNJ/vXVMF550qwIb9i', 'Employee', 'Active', '2026-09-09 12:11:53'),
(18, 'Shiva Kumar', 'shiva@gmail.com', 'shiva', '$2y$12$0swqa0an.kd8XDEYg0AMjOkcL3D9QFCzbybpNJ/vXVMF550qwIb9i', 'Employee', 'Active', '2026-09-09 12:11:53'),
(19, 'Tester1', 'gh@gmail.com', 'gh_12', '$2y$10$SyC/kyvUH5CmKQRj7Qe7Oe5IkLaN5iboxCLkvjAxUs9RgjRVfkVBO', 'Admin', 'Active', '2026-09-10 05:12:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`),
  ADD UNIQUE KEY `department_name` (`department_name`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_employees_department` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_employees_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
