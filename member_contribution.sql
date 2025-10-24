-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2025 at 12:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assessment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `member_contributions`
--

CREATE TABLE IF NOT EXISTS `member_contributions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `project1_contributions` text NOT NULL,
  `project2_contributions` text NOT NULL,
  `profile_image` varchar(100) DEFAULT NULL,
  `fun_fact` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member_contributions`
--

INSERT INTO `member_contributions` (`student_id`, `name`, `project1_contributions`, `project2_contributions`, `profile_image`, `fun_fact`) VALUES
('105747580', 'Jacob', 'HTML structure, CSS styling, Header/Footer components, Home page layout', 'Database integration, PHP backend, Form validation, Team contributions section', 'wizard_jacob.png', 'Likes to ride bikes'),
('105352793', 'Lachlan', 'Jobs page content, HTML structure, Job descriptions formatting', 'Content refinement, Accessibility improvements, Job listings enhancement', 'wizard_lachlan.png', 'Likes old video games'),
('105923830', 'Damian', 'CSS styling, Layout design, Color scheme implementation', 'Database design, CSS optimization, Responsive design improvements', 'wizard_damian.png', 'Likes to solve rubiks cubes'),
('105523230', 'Maher', 'Content writing, About page information, Team details', 'Content updates, Testing, Documentation', 'wizard_maher.png', 'Likes Football(Soccer)');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;