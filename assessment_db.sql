-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 01:54 PM
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
CREATE DATABASE IF NOT EXISTS `assessment_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `assessment_db`;

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `applicant_id` int(11) NOT NULL,
  `job_reference` varchar(5) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female','other','') NOT NULL,
  `address` varchar(40) NOT NULL,
  `suburb` varchar(40) NOT NULL,
  `state` enum('VIC','NSW','QLD','TAS','NT','ACT','SA','WA') NOT NULL,
  `postcode` int(4) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone_number` int(12) NOT NULL,
  `skills` enum('Teaching Qualification','Management Systems Knowledge','Technology Expertise','Communication Skills','PL/SQL Proficiency','HTML Proficiency','CSS Proficiency','AWS Database Experience','5+ Years Industry Experience') NOT NULL,
  `other_skills` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `reference_no` varchar(5) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` text NOT NULL,
  `pay_min` int(11) NOT NULL,
  `pay_max` int(11) NOT NULL,
  `responsibility` text NOT NULL,
  `responsibility_list` text NOT NULL,
  `qualifications_list` text NOT NULL,
  `desired_skills_list` longtext NOT NULL,
  `report_line_list` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`reference_no`, `title`, `description`, `pay_min`, `pay_max`, `responsibility`, `responsibility_list`, `qualifications_list`, `desired_skills_list`, `report_line_list`) VALUES
('DLD22', 'Senior Developer', 'The recently established Digital Learning Department at Hogwarts University are seeking an experienced development professional to join their team of dedicated Witches and Wizards in developing platforms to enhance digital learning across the campus. This role seeks to attract those who are confident in their abilities to lead a team in designing new solutions to help our students thrive in this new learning environment.\r\nYou will collaborate with our Software and Engineering department, and contribute to the development of a new era of teaching and learning at Hogwarts.', 56000, 60000, 'As a Senior Developer at Hogwarts, your primary responsibilities are as follows:', '[\"Designing and implementing software to support both teaching and learning.\", \"Leading and managing development projects from conception to deployment.\", \"Mentoring junior developers.\", \"Collaborating with IT leadership to align development efforts with institutional goals.\"]', '[\"Demonstrated proficiency in programming with PL/SQL, Javascript, HTML5 and CSS.\", \"Experience with AWS database services such as RDS, DynamoDB or Aurora.\", \"At least 5 years of relevant industry experience.\"]', '[\"Previous excperience in industry-based mentoring.\", \"Strong and analytical  problem solving abilities.\", \"Knowledge of learning management systems.\", \"Familiarity with emerging technologies.\", \"Excellent communication and presentation skills.\", \"Familiarity with Hogwarts High School and/or Hogwarts University’s education system.\"]', '[\"Hogwarts Digital Learning Comittee\", \"Director of IT\"]'),
('DLL35', 'Lecturer (Computing & Software Engineeri', 'The recently established Digital Learning Department at Hogwarts University are seeking an experienced development professional to join their team of dedicated Witches and Wizards in developing platforms to enhance digital learning across the campus. This role seeks to attract those who are confident in their abilities to lead a team in designing new solutions to help our students thrive in this new learning environment.\r\nYou will collaborate with our Software and Engineering department, and contribute to the development of a new era of teaching and learning at Hogwarts.', 46000, 51000, 'As a lecturer at Hogwarts University, your primary responsibilities are as follows:', '[\"Designing and delivering quality lectures.\", \"Conducting tutorials.\", \"Developing relevant curriculums.\", \"Providing academic guidance and mentorship to students.\", \"Contributing to relevant research at Hogwarts and with its collaborators.\"]', '[\"Master’s qualification in Computer Science, Information Techonology or Software Engineering.\", \"Demonstrated proficiency in a range of programming languages.\", \"At least 2 years of relevant industry experience.\"]', '[\"Previous teaching/education qualifications.\", \"Knowledge of learning management systems.\", \"Familiarity with emerging technologies.\", \"Excellent communication and presentation skills.\", \"Familiarity with Hogwarts High School and/or Hogwarts University’s education system.\"]', '[\"Hogwarts Digital Learning Comittee\", \"Head of Teaching and Learning\"]');

-- --------------------------------------------------------

--
-- Table structure for table `member_contributions`
--

CREATE TABLE `member_contributions` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `project1_contributions` text NOT NULL,
  `project2_contributions` text NOT NULL,
  `profile_image` varchar(100) DEFAULT NULL,
  `fun_fact` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member_contributions`
--

INSERT INTO `member_contributions` (`id`, `student_id`, `name`, `project1_contributions`, `project2_contributions`, `profile_image`, `fun_fact`, `created_at`) VALUES
(1, '105747580', 'Jacob', 'HTML structure, CSS styling, Header/Footer components, Home page layout', 'Database integration, PHP backend, Form validation, Team contributions section', 'wizard_jacob.png', 'Likes to ride bikes', '2025-10-27 10:51:39'),
(2, '105352793', 'Lachlan', 'Jobs page content, HTML structure, Job descriptions formatting', 'Content refinement, Accessibility improvements, Job listings enhancement', 'wizard_lachlan.png', 'Likes old video games', '2025-10-27 10:51:39'),
(3, '105923830', 'Damian', 'CSS styling, Layout design, Color scheme implementation', 'Database design, CSS optimization, Responsive design improvements', 'wizard_damian.png', 'Likes to solve rubiks cubes', '2025-10-27 10:51:39'),
(4, '105523230', 'Maher', 'Content writing, About page information, Team details', 'Content updates, Testing, Documentation', 'wizard_maher.png', 'Likes Football(Soccer)', '2025-10-27 10:51:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`applicant_id`),
  ADD KEY `job_reference` (`job_reference`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`reference_no`) USING BTREE;

--
-- Indexes for table `member_contributions`
--
ALTER TABLE `member_contributions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `applicant_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_contributions`
--
ALTER TABLE `member_contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eoi`
--
ALTER TABLE `eoi`
  ADD CONSTRAINT `eoi_ibfk_1` FOREIGN KEY (`job_reference`) REFERENCES `jobs` (`reference_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
