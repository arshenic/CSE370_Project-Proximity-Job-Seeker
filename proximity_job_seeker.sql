-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2026 at 06:25 PM
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
-- Database: `proximity_job_seeker`
--

-- --------------------------------------------------------

--
-- Table structure for table `applies`
--

CREATE TABLE `applies` (
  `CandidateID` int(11) NOT NULL,
  `JobID` int(11) NOT NULL,
  `ApplicationDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applies`
--

INSERT INTO `applies` (`CandidateID`, `JobID`, `ApplicationDate`) VALUES
(1, 101, '2026-04-12'),
(1, 104, '2026-04-17'),
(2, 102, '2026-04-13'),
(3, 103, '2026-04-14'),
(4, 104, '2026-04-16');

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `CandidateID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `NID` varchar(50) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `CGPA` float(3,2) DEFAULT NULL,
  `CurrentEdBackground` varchar(100) DEFAULT NULL,
  `CV` varchar(100) DEFAULT NULL,
  `Area` varchar(50) DEFAULT NULL,
  `Gender` enum('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`CandidateID`, `Name`, `Phone`, `Email`, `Password`, `NID`, `DOB`, `CGPA`, `CurrentEdBackground`, `CV`, `Area`, `Gender`) VALUES
(1, 'Tanvir Ahmed', '01711223344', 'tanvir@gmail.com', '12345', 'NID001', '2001-03-15', 3.72, 'BSc in CSE', 'tanvir_cv.pdf', 'Agrabad', 'Male'),
(2, 'Nusrat Jahan', '01822334455', 'nusrat@gmail.com', '12345', 'NID002', '2000-07-22', 3.88, 'BSc in CSE', 'nusrat_cv.pdf', 'Uttara', 'Female'),
(3, 'Mehedi Hasan', '01933445566', 'mehedi@gmail.com', '12345', 'NID003', '2001-11-08', 3.55, 'BSc in EEE', 'mehedi_cv.pdf', 'Mirpur', 'Male'),
(4, 'Ayesha Siddika', '01644556677', 'ayesha@gmail.com', '12345', 'NID004', '2002-01-19', 3.90, 'BSc in CSE', 'ayesha_cv.pdf', 'GEC', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `EmployerID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Housing` varchar(100) DEFAULT NULL,
  `Street` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `Area` varchar(50) DEFAULT NULL,
  `PostalCode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`EmployerID`, `Name`, `Phone`, `Email`, `Password`, `Housing`, `Street`, `City`, `Area`, `PostalCode`) VALUES
(1, 'Rahman Software Ltd.', '01755667788', 'hr@rahman.com', '12345', 'House 22', 'Road 11', 'Dhaka', 'Banani', '1213'),
(2, 'Dhaka Power Solutions', '01866778899', 'career@dhakapower.com', '12345', 'Building 5', 'Industrial Area Road', 'Gazipur', 'Tongi', '1710'),
(3, 'SoftBD Solutions', '01977889900', 'career@softbd.com', '12345', 'Floor 4', 'Agrabad C/A', 'Chattogram', 'Agrabad', '4100');

-- --------------------------------------------------------

--
-- Table structure for table `hired`
--

CREATE TABLE `hired` (
  `CandidateID` int(11) NOT NULL,
  `JobID` int(11) NOT NULL,
  `StartingDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hired`
--

INSERT INTO `hired` (`CandidateID`, `JobID`, `StartingDate`) VALUES
(1, 101, '2026-05-01'),
(3, 103, '2026-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `interview`
--

CREATE TABLE `interview` (
  `EmployerID` int(11) NOT NULL,
  `CandidateID` int(11) NOT NULL,
  `JobID` int(11) NOT NULL,
  `InterviewDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interview`
--

INSERT INTO `interview` (`EmployerID`, `CandidateID`, `JobID`, `InterviewDate`) VALUES
(1, 1, 101, '2026-04-20'),
(1, 2, 102, '2026-04-21'),
(2, 3, 103, '2026-05-30'),
(3, 4, 104, '2026-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `JobID` int(11) NOT NULL,
  `JobTitle` varchar(100) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `WorkingHours` varchar(50) DEFAULT NULL,
  `PreferredEdBackground` varchar(100) DEFAULT NULL,
  `PreferredAge` int(11) DEFAULT NULL,
  `RequiredCGPA` float(3,2) DEFAULT NULL,
  `Salary` int(11) DEFAULT NULL,
  `JobType` varchar(50) DEFAULT NULL,
  `JobPeriod` varchar(50) DEFAULT NULL,
  `WorkingDays` varchar(50) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `SkillsDescription` text DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`JobID`, `JobTitle`, `StartDate`, `WorkingHours`, `PreferredEdBackground`, `PreferredAge`, `RequiredCGPA`, `Salary`, `JobType`, `JobPeriod`, `WorkingDays`, `Status`, `SkillsDescription`, `Description`) VALUES
(101, 'Junior Software Engineer', '2026-05-01', '9 AM - 5 PM', 'BSc in CSE', 25, 3.20, 40000, 'Full-time', '1 Year', 'Sunday-Thursday', 'Closed', 'PHP, Laravel, MySQL', 'Develop and maintain web applications'),
(102, 'Frontend Developer Intern', '2026-05-10', '10 AM - 4 PM', 'BSc in CSE', 24, 3.00, 25000, 'Internship', '6 Months', 'Sunday-Thursday', 'Open', 'HTML, CSS, JavaScript, Bootstrap', 'Design responsive frontend pages'),
(103, 'Electrical Maintenance Assistant', '2026-06-01', '9 AM - 5 PM', 'BSc in EEE', 27, 3.10, 30000, 'Full-time', '1 Year', 'Saturday-Wednesday', 'Closed', 'Circuit Analysis, Power System', 'Assist engineers in electrical maintenance'),
(104, 'Database Assistant', '2026-06-15', '9 AM - 3 PM', 'BSc in CSE', 26, 3.20, 25000, 'Part-time', '8 Months', 'Sunday-Wednesday', 'Open', 'SQL, Database Design, MS Excel', 'Maintain database records and reports');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `EmployerID` int(11) NOT NULL,
  `JobID` int(11) NOT NULL,
  `PostingDate` date DEFAULT NULL,
  `ExpiryDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`EmployerID`, `JobID`, `PostingDate`, `ExpiryDate`) VALUES
(1, 101, '2026-04-01', '2026-04-30'),
(1, 102, '2026-04-05', '2026-05-05'),
(2, 103, '2026-04-10', '2026-05-10'),
(3, 104, '2026-04-15', '2026-05-15');

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `EmployerID` int(11) NOT NULL,
  `CandidateID` int(11) NOT NULL,
  `Rating` float(2,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`EmployerID`, `CandidateID`, `Rating`) VALUES
(1, 2, 4.3),
(2, 3, 4.0),
(3, 4, 4.4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applies`
--
ALTER TABLE `applies`
  ADD PRIMARY KEY (`CandidateID`,`JobID`),
  ADD KEY `JobID` (`JobID`);

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`CandidateID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD PRIMARY KEY (`EmployerID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `hired`
--
ALTER TABLE `hired`
  ADD PRIMARY KEY (`CandidateID`,`JobID`),
  ADD KEY `JobID` (`JobID`);

--
-- Indexes for table `interview`
--
ALTER TABLE `interview`
  ADD PRIMARY KEY (`EmployerID`,`CandidateID`,`JobID`),
  ADD KEY `CandidateID` (`CandidateID`),
  ADD KEY `JobID` (`JobID`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`JobID`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`EmployerID`,`JobID`),
  ADD KEY `JobID` (`JobID`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`EmployerID`,`CandidateID`),
  ADD KEY `CandidateID` (`CandidateID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applies`
--
ALTER TABLE `applies`
  ADD CONSTRAINT `applies_ibfk_1` FOREIGN KEY (`CandidateID`) REFERENCES `candidate` (`CandidateID`),
  ADD CONSTRAINT `applies_ibfk_2` FOREIGN KEY (`JobID`) REFERENCES `job` (`JobID`);

--
-- Constraints for table `hired`
--
ALTER TABLE `hired`
  ADD CONSTRAINT `hired_ibfk_1` FOREIGN KEY (`CandidateID`) REFERENCES `candidate` (`CandidateID`),
  ADD CONSTRAINT `hired_ibfk_2` FOREIGN KEY (`JobID`) REFERENCES `job` (`JobID`);

--
-- Constraints for table `interview`
--
ALTER TABLE `interview`
  ADD CONSTRAINT `interview_ibfk_1` FOREIGN KEY (`EmployerID`) REFERENCES `employer` (`EmployerID`),
  ADD CONSTRAINT `interview_ibfk_2` FOREIGN KEY (`CandidateID`) REFERENCES `candidate` (`CandidateID`),
  ADD CONSTRAINT `interview_ibfk_3` FOREIGN KEY (`JobID`) REFERENCES `job` (`JobID`);

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`EmployerID`) REFERENCES `employer` (`EmployerID`),
  ADD CONSTRAINT `offers_ibfk_2` FOREIGN KEY (`JobID`) REFERENCES `job` (`JobID`);

--
-- Constraints for table `rates`
--
ALTER TABLE `rates`
  ADD CONSTRAINT `rates_ibfk_1` FOREIGN KEY (`EmployerID`) REFERENCES `employer` (`EmployerID`),
  ADD CONSTRAINT `rates_ibfk_2` FOREIGN KEY (`CandidateID`) REFERENCES `candidate` (`CandidateID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
