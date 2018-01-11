-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2017 at 09:21 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `preregistration`
--

-- --------------------------------------------------------

--
-- Table structure for table `admintable`
--

CREATE TABLE `admintable` (
  `adminID` varchar(50) NOT NULL,
  `adminName` varchar(100) DEFAULT NULL,
  `adminPassword` varchar(100) DEFAULT NULL,
  `adminEmail` varchar(100) DEFAULT NULL,
  `adminMobile` varchar(20) DEFAULT NULL,
  `hashIdentity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admintable`
--

INSERT INTO `admintable` (`adminID`, `adminName`, `adminPassword`, `adminEmail`, `adminMobile`, `hashIdentity`) VALUES
('admin', 'Akib', 'admin', 'akib9ctg@gmail.com', '01839231133', '274ad4786c3abca69fa097b85867d9a4');

-- --------------------------------------------------------

--
-- Table structure for table `coursetable`
--

CREATE TABLE `coursetable` (
  `CourseCode` varchar(10) NOT NULL,
  `CourseName` varchar(100) NOT NULL,
  `Credit` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coursetable`
--

INSERT INTO `coursetable` (`CourseCode`, `CourseName`, `Credit`) VALUES
('CHEM-2301', 'Chemistry', '3'),
('CSE-1101', 'Computer Fundamental', '2'),
('CSE-1201', 'Structured Programming', '3'),
('CSE-1202', 'Structured Programming Sessional', '1'),
('CSE-2301', 'Object Oriented Programming-1', '3'),
('CSE-2303', 'Data Structures', '3'),
('CSE-2403', 'Computer Algorithms', '3'),
('CSE-2407', 'Database System', '3'),
('CSE-2408', 'Database System Sessional', '1.5'),
('CSE-3501', 'Microprocessors and Microcontroller', '3'),
('CSE-3502', 'Microprocessors and Microcontroller sessional', '1'),
('CSE-3601', 'Data Communication', '3'),
('CSE-3603', 'Operating System', '3'),
('CSE-3605', 'System Analysis & Design', '2'),
('CSE-4701', 'Computer Networks', '3'),
('CSE-4703', 'Computer Graphics', '3'),
('CSE-4708', 'Field Work', '1'),
('CSE-4801', 'Compiler', '2'),
('CSE-4802', 'Compiler Sessional ', '1'),
('CSE-4822', 'General Viva', '1'),
('EEE-1101', 'Basic Electrical Engineering', '3'),
('Math-1101', 'Mathematics-1', '3'),
('MATH-3501', 'Mathematics-V', '3'),
('PHY-1201', 'Physics-2', '3'),
('URIS-3605', 'Biography of Prophet Mohammad (Saw)', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pendinglist`
--

CREATE TABLE `pendinglist` (
  `CourseCodeStudentID` varchar(50) NOT NULL,
  `studentID` varchar(10) DEFAULT NULL,
  `courseCode` varchar(10) DEFAULT NULL,
  `CourseName` varchar(100) NOT NULL,
  `CourseCredit` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `registrationtable`
--

CREATE TABLE `registrationtable` (
  `CourseCodeStudentID` varchar(50) NOT NULL,
  `studentID` varchar(10) DEFAULT NULL,
  `CourseName` varchar(100) NOT NULL,
  `courseCode` varchar(10) DEFAULT NULL,
  `CourseCredit` varchar(10) NOT NULL,
  `section` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registrationtable`
--

INSERT INTO `registrationtable` (`CourseCodeStudentID`, `studentID`, `CourseName`, `courseCode`, `CourseCredit`, `section`) VALUES
('CHEM-2301.C163001', 'C163001', 'Chemistry', 'CHEM-2301', '3', 'AM'),
('CHEM-2301.C173002', 'C173002', 'Chemistry', 'CHEM-2301', '3', 'Pending'),
('CSE-1101.C151006', 'C151006', 'Computer Fundamental', 'CSE-1101', '2', 'AM'),
('CSE-1101.C151021', 'C151021', 'Computer Fundamental', 'CSE-1101', '2', 'Pending'),
('CSE-1101.C173002', 'C173002', 'Computer Fundamental', 'CSE-1101', '2', 'AM'),
('CSE-1201.C153010', 'C153010', 'Structured Programming', 'CSE-1201', '3', 'BM'),
('CSE-1201.C171035', 'C171035', 'Structured Programming', 'CSE-1201', '3', 'BM'),
('CSE-1202.C153010', 'C153010', 'Structured Programming Sessional', 'CSE-1202', '1', 'Pending'),
('CSE-1202.C171035', 'C171035', 'Structured Programming Sessional', 'CSE-1202', '1', 'BM'),
('CSE-3501.C153010', 'C153010', 'Microprocessors and Microcontroller', 'CSE-3501', '3', 'AM'),
('CSE-3601.C151006', 'C151006', 'Data Communication', 'CSE-3601', '3', 'AM'),
('CSE-3601.C151020', 'C151020', 'Data Communication', 'CSE-3601', '3', 'AM'),
('CSE-3601.C151021', 'C151021', 'Data Communication', 'CSE-3601', '3', 'AM'),
('CSE-3605.C151021', 'C151021', 'System Analysis & Design', 'CSE-3605', '2', 'AM'),
('CSE-4701.C151020', 'C151020', 'Computer Networks', 'CSE-4701', '3', 'Pending'),
('EEE-1101.C151021', 'C151021', 'Basic Electrical Engineering', 'EEE-1101', '3', 'Pending'),
('EEE-1101.C173001', 'C173001', 'Basic Electrical Engineering', 'EEE-1101', '3', 'AM');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` varchar(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `section` varchar(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `registrationStatus` tinyint(1) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `contactNumber` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `forgetPasswordIdentity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `section`, `semester`, `registrationStatus`, `password`, `contactNumber`, `email`, `forgetPasswordIdentity`) VALUES
('C141001', 'Shomser Uddin', 'AM', 8, 0, 'C141001', '01841445566', 'demo@gmail.com', ''),
('C141002', 'Shomsher Miya', 'AM', 8, 0, 'C141002', '01965789789', 'demo@gmail.com', ''),
('C141003', 'Towhid Uddin', 'AM', 8, 0, 'C141003', '01985123123', 'demo@gmail.com', ''),
('C141041', 'Salauddin Mahmud', 'BM', 8, 0, 'C141041', '0195123123', 'demo@gmail.com', ''),
('C141042', 'Kader Masum', 'BM', 8, 0, 'C141042', '01856123123', 'demo@gmail.com', ''),
('C143001', 'Sheikh Ghazanfar', 'AM', 7, 0, 'C143001', '01735123123', 'demo@gmail.com', ''),
('C143002', 'Raihan Uddin', 'AM', 7, 0, 'C143002', '01832123123', 'demo@gmail.com', ''),
('C143003', 'Golam Rahman', 'AM', 7, 0, 'C143003', '01865123123', 'demo@gmail.com', ''),
('C143031', 'Akil Mahmud', 'BM', 7, 0, 'C143031', '01934123123', 'demo@gmail.com', ''),
('C143032', 'Kafil Uddin', 'BM', 7, 0, 'C143032', '01912123123', 'demo@gmail.com', ''),
('C151006', 'Ahasanul Kalam Akib', 'AM', 6, 1, 'C151006', '01521527954', 'akib9ctg@gmail.com', '28f0b864598a1291557bed248a998d4e'),
('C151020', 'Yamin Sobhan', 'AM', 6, 1, 'C151020', '01895123123', 'demo@gmail.com', ''),
('C151021', 'Misbah Ahmed Chowdhury Fahim', 'AM', 6, 1, 'C151021', '01914590820', 'imiiucian@gmail.com', ''),
('C151031', 'Rafid Rahman', 'BM', 6, 0, 'C151031', '01784123123', 'demo@gmail.com', ''),
('C151032', 'Shamim Rahman', 'BM', 6, 0, 'C151032', '01723000000', 'demo@gmail.com', ''),
('C151071', 'Forman Khan', 'CM', 6, 0, 'C151071', '01789123123', 'demo@gmail.com', ''),
('C151072', 'Kalim Amzad', 'CM', 6, 0, 'C151072', '01932123123', 'demo@gmail.com', ''),
('C151114', 'Abu Sufian Rafsan', 'AM', 5, 0, 'C151114', '01828812260', 'abusufianrafsan0@gmail.com', ''),
('C153006', 'Md Nayem Uddin', 'AM', 5, 0, 'C153006', '01826558545', 'nayem_uddin30@yahoo.com', ''),
('C153010', 'Mahi Al Jawad', 'AM', 5, 1, 'C153010', '01832220656', 'br.mahialjawad@gmail.com', ''),
('C153031', 'Jamshed Uddin', 'BM', 5, 0, 'C153031', '0160123123', 'demo@gmail.com', ''),
('C153032', 'Sazzad Hossain', 'BM', 5, 0, 'C153032', '01960000000', 'demo@gmail.com', ''),
('C161001', 'Mohammad Saimon Khan', 'AM', 4, 0, 'C161001', '01569456923', 'demo@gmail.com', ''),
('C161007', 'Mohammad Abir Khan', 'AM', 4, 0, 'C161007', '01850787444', 'Abirshanto588@gmail.com', ''),
('C161010', 'Fahim Ishtiaq', 'AM', 4, 0, 'C161010', '01784510392', 'fishtiaq34@gmail.com', ''),
('C161030', 'Sahab Uddin', 'BM', 4, 0, 'C161030', '01558920432', 'demo@gmail.com', ''),
('C161031', 'Gafur Mia', 'BM', 4, 0, 'C161031', '01700645654', 'demo@gmail.com', ''),
('C161061', 'Kamrul Hossain', 'CM', 4, 0, 'C161061', '01900123123', 'demo@gmail.com', ''),
('C161062', 'Solim Uddin', 'CM', 4, 0, 'C161062', '0160123123', 'demo@gmail.com', ''),
('C163001', 'Abir Mahmud', 'AM', 3, 0, 'C163001', '01945123123', 'demo@gmail.com', ''),
('C163002', 'Md Najat Uddin', 'AM', 3, 0, 'C163002', '01558920432', 'demo@gmail.com', ''),
('C163003', 'Samiul Mawla', 'AM', 3, 0, 'C163003', '01521325517', 'demo@gmail.com', ''),
('C163041', 'Abid Uddin', 'BM', 3, 0, 'C163041', '01569456923', 'demo@gmail.com', ''),
('C163042', 'Sifat Mahmud', 'BM', 3, 0, 'C163042', '01700789789', 'demo@gmail.com', ''),
('C171001', 'Sazzad', 'AM', 2, 0, 'C171001', '01837230543', 'sazzad591@gmail.com', ''),
('C171002', 'Md Nayeem Mahmud', 'AM', 2, 0, 'C171002', '01945123123', 'demo@gmail.com', ''),
('C171035', 'MD Labib Hossen', 'BM', 2, 0, 'C171035', '01521325517', 'labib97cghs@gmail.com', ''),
('C171053', 'Jaohar Islam Dudaeb Sagar', 'BM', 2, 0, 'C171053', '01684805208', 'dudaeb1996@gmail.com', ''),
('C171058', 'Muhammed Arif', 'BM', 2, 0, 'C171058', '01819035995', 'md.ariftk@gmail.com', ''),
('C171078', 'MEHEDI HASSAN', 'CM', 2, 0, 'C171078', '01829054675', 'mehedihassan.ctg299@gmail.com', ''),
('C171079', 'Abdur Rahman Mishu', 'CM', 2, 0, 'C171079', '01945123123', 'demo@gmail.com', ''),
('C171092', 'Mubtasim Fuad', 'BM', 2, 0, 'C171092', '01558920432', 'mubtasimfuad@live.com', ''),
('C173001', 'Abdul Karim', 'AM', 1, 1, 'C173001', '01521325517', 'akvba@gmail.com', ''),
('C173002', 'Md kalim', 'AM', 1, 1, 'C173002', '01569456923', 'demo@gmail.com', ''),
('C173003', 'Md Rahim', 'AM', 1, 0, 'C173003', '01700789789', 'demo@gmail.com', ''),
('C173031', 'Md Nayem', 'BM', 1, 0, 'C173031', '01932123123', 'demo@gmail.com', ''),
('C173032', 'Salim Uddin', 'BM', 1, 0, 'C173032', '01750123123', 'demo@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `temptable`
--

CREATE TABLE `temptable` (
  `CourseCodeStudentID` varchar(50) NOT NULL,
  `studentID` varchar(10) DEFAULT NULL,
  `courseCode` varchar(10) DEFAULT NULL,
  `CourseName` varchar(100) NOT NULL,
  `Credit` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temptable`
--

INSERT INTO `temptable` (`CourseCodeStudentID`, `studentID`, `courseCode`, `CourseName`, `Credit`) VALUES
('CSE-3601.C151006', 'C151006', 'CSE-3601', 'Data Communication', '3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admintable`
--
ALTER TABLE `admintable`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `coursetable`
--
ALTER TABLE `coursetable`
  ADD PRIMARY KEY (`CourseCode`);

--
-- Indexes for table `pendinglist`
--
ALTER TABLE `pendinglist`
  ADD PRIMARY KEY (`CourseCodeStudentID`);

--
-- Indexes for table `registrationtable`
--
ALTER TABLE `registrationtable`
  ADD PRIMARY KEY (`CourseCodeStudentID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temptable`
--
ALTER TABLE `temptable`
  ADD PRIMARY KEY (`CourseCodeStudentID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
