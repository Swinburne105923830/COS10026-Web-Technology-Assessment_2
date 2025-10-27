-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2025 at 01:08 PM
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
-- Table structure for table `jobs_list`
--

CREATE TABLE `jobs_list` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `reference_no` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pay_min` int(11) DEFAULT NULL,
  `pay_max` int(11) DEFAULT NULL,
  `responsibility` text DEFAULT NULL,
  `responsibility_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`responsibility_list`)),
  `qualifications_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`qualifications_list`)),
  `desired_skills_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`desired_skills_list`)),
  `report_line_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`report_line_list`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs_list`
--

INSERT INTO `jobs_list` (`id`, `title`, `reference_no`, `description`, `pay_min`, `pay_max`, `responsibility`, `responsibility_list`, `qualifications_list`, `desired_skills_list`, `report_line_list`) VALUES
(1, 'Lecturer (Computing & Software Engineering)', 'DLL35', 'The recently established Digital Learning Department at Hogwarts University are seeking an experienced development professional to join their team of dedicated Witches and Wizards in developing platforms to enhance digital learning across the campus. This role seeks to attract those who are confident in their abilities to lead a team in designing new solutions to help our students thrive in this new learning environment.\r\nYou will collaborate with our Software and Engineering department, and contribute to the development of a new era of teaching and learning at Hogwarts.', 46000, 51000, 'As a lecturer at Hogwarts University, your primary responsibilities are as follows:', '[\"Designing and delivering quality lectures.\", \"Conducting tutorials.\", \"Developing relevant curriculums.\", \"Providing academic guidance and mentorship to students.\", \"Contributing to relevant research at Hogwarts and with its collaborators.\"]', '[\"Master’s qualification in Computer Science, Information Techonology or Software Engineering.\", \"Demonstrated proficiency in a range of programming languages.\", \"At least 2 years of relevant industry experience.\"]', '[\"Previous teaching/education qualifications.\", \"Knowledge of learning management systems.\", \"Familiarity with emerging technologies.\", \"Excellent communication and presentation skills.\", \"Familiarity with Hogwarts High School and/or Hogwarts University’s education system.\"]', '[\"Hogwarts Digital Learning Comittee\", \"Head of Teaching and Learning\"]'),
(2, 'Senior Developer', 'DLD22', 'The recently established Digital Learning Department at Hogwarts University are seeking an experienced development professional to join their team of dedicated Witches and Wizards in developing platforms to enhance digital learning across the campus. This role seeks to attract those who are confident in their abilities to lead a team in designing new solutions to help our students thrive in this new learning environment.\r\nYou will collaborate with our Software and Engineering department, and contribute to the development of a new era of teaching and learning at Hogwarts.', 56000, 60000, 'As a Senior Developer at Hogwarts, your primary responsibilities are as follows:', '[\"Designing and implementing software to support both teaching and learning.\", \"Leading and managing development projects from conception to deployment.\", \"Mentoring junior developers.\", \"Collaborating with IT leadership to align development efforts with institutional goals.\"]', '[\"Demonstrated proficiency in programming with PL/SQL, Javascript, HTML5 and CSS.\", \"Experience with AWS database services such as RDS, DynamoDB or Aurora.\", \"At least 5 years of relevant industry experience.\"]', '[\"Previous excperience in industry-based mentoring.\", \"Strong and analytical  problem solving abilities.\", \"Knowledge of learning management systems.\", \"Familiarity with emerging technologies.\", \"Excellent communication and presentation skills.\", \"Familiarity with Hogwarts High School and/or Hogwarts University’s education system.\"]', '[\"Hogwarts Digital Learning Comittee\", \"Director of IT\"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs_list`
--
ALTER TABLE `jobs_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs_list`
--
ALTER TABLE `jobs_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
