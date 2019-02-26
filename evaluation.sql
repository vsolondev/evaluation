-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2019 at 04:17 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evaluation`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `AccountId` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Pin` int(11) NOT NULL,
  `IsLocked` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`AccountId`, `Username`, `Password`, `Pin`, `IsLocked`) VALUES
(1, 'admin1', 'admin1', 123456, 0),
(2, 'teacher1', 'teacher1', 123456, 0),
(3, 'teacher2', 'teacher2', 123456, 0),
(4, 'teacher3', 'teacher3', 123456, 0),
(5, 'teacher4', 'teacher4', 123456, 0),
(6, 'teacher5', 'teacher5', 123456, 0),
(7, 'student1', 'student1', 123456, 0),
(8, 'student2', 'student2', 123456, 0),
(9, 'student3', 'student3', 123456, 0),
(10, 'student4', 'student4', 123456, 0),
(11, 'student5', 'student5', 123456, 0);

-- --------------------------------------------------------

--
-- Table structure for table `accountimage`
--

CREATE TABLE `accountimage` (
  `AccountId` int(11) NOT NULL,
  `ImageName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accountimage`
--

INSERT INTO `accountimage` (`AccountId`, `ImageName`) VALUES
(1, '1897552846.jpg'),
(3, '2012850292.jpg'),
(2, '1053925961.jpg'),
(5, '458852202.jpg'),
(4, '831346562.jpg'),
(6, '552076826.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminId` int(11) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `MiddleName` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminId`, `FirstName`, `LastName`, `MiddleName`) VALUES
(1, 'Admin1', 'Admin1', 'Admin1');

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `AdminAccountId` int(11) NOT NULL,
  `AdminId` int(11) NOT NULL,
  `AccountId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`AdminAccountId`, `AdminId`, `AccountId`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CourseId` int(11) NOT NULL,
  `CourseName` varchar(150) NOT NULL,
  `CourseAcronym` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CourseId`, `CourseName`, `CourseAcronym`) VALUES
(1, 'Bachelor of Science in Information Technology', 'BSIT'),
(2, 'Bachelor of Science in Education', 'BSED'),
(3, 'Bachelor of Science in Business Administration', 'BSBA'),
(4, 'Bachelor of Science in Hospitality Management', 'BSHM');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DepartmentId` int(11) NOT NULL,
  `DepartmentName` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DepartmentId`, `DepartmentName`) VALUES
(1, 'IT Department'),
(2, 'Education Department'),
(3, 'Business Department'),
(4, 'Hospitality Management Department');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `EvaluationId` int(11) NOT NULL,
  `StudentId` int(11) NOT NULL,
  `TeacherId` int(11) NOT NULL,
  `EvaluationScheduleId` int(11) NOT NULL,
  `BadComment` varchar(255) DEFAULT '',
  `GoodComment` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`EvaluationId`, `StudentId`, `TeacherId`, `EvaluationScheduleId`, `BadComment`, `GoodComment`) VALUES
(1, 1, 1, 3, '', ''),
(2, 1, 2, 3, '', ''),
(3, 1, 3, 3, '', ''),
(4, 1, 4, 3, '', ''),
(5, 1, 5, 3, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_schedule`
--

CREATE TABLE `evaluation_schedule` (
  `EvaluationScheduleId` int(11) NOT NULL,
  `ScheduleDateFrom` date NOT NULL,
  `ScheduleDateTo` date NOT NULL,
  `IsActive` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation_schedule`
--

INSERT INTO `evaluation_schedule` (`EvaluationScheduleId`, `ScheduleDateFrom`, `ScheduleDateTo`, `IsActive`) VALUES
(1, '2018-12-24', '2018-12-24', 0),
(2, '2018-12-25', '2018-12-25', 0),
(3, '2018-12-26', '2018-12-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `PersonId` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `QuestionId` int(11) NOT NULL,
  `Question` varchar(250) NOT NULL,
  `IsActive` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`QuestionId`, `Question`, `IsActive`) VALUES
(1, 'question1', 1),
(2, 'question2', 1),
(3, 'question3', 1),
(4, 'question4', 1),
(5, 'question5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `RatingId` int(11) NOT NULL,
  `RatingDescription` varchar(50) NOT NULL,
  `RatingValue` int(11) NOT NULL,
  `IsActive` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`RatingId`, `RatingDescription`, `RatingValue`, `IsActive`) VALUES
(1, 'Very poor', 1, 1),
(2, 'Poor', 2, 1),
(3, 'Good', 3, 1),
(4, 'Very Good', 4, 1),
(5, 'Excellent', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `ScheduleId` int(11) NOT NULL,
  `ScheduleDay` varchar(50) NOT NULL,
  `ScheduleTimeFrom` time NOT NULL,
  `ScheduleTimeTo` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`ScheduleId`, `ScheduleDay`, `ScheduleTimeFrom`, `ScheduleTimeTo`) VALUES
(1, 'Monday To Friday', '08:00:00', '09:00:00'),
(2, 'Monday To Friday', '09:00:00', '10:00:00'),
(3, 'Monday To Friday', '10:00:00', '11:00:00'),
(4, 'Monday To Friday', '11:00:00', '12:00:00'),
(5, 'Monday To Friday', '12:00:00', '13:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `SectionId` int(11) NOT NULL,
  `SectionName` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`SectionId`, `SectionName`) VALUES
(1, 'section1'),
(2, 'section2'),
(3, 'section3'),
(4, 'section4'),
(5, 'section5');

-- --------------------------------------------------------

--
-- Table structure for table `section_subject_schedule`
--

CREATE TABLE `section_subject_schedule` (
  `SectionSubjectScheduleId` int(11) NOT NULL,
  `SectionId` int(11) NOT NULL,
  `SubjectId` int(11) NOT NULL,
  `ScheduleId` int(11) NOT NULL,
  `TeacherId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section_subject_schedule`
--

INSERT INTO `section_subject_schedule` (`SectionSubjectScheduleId`, `SectionId`, `SubjectId`, `ScheduleId`, `TeacherId`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 2, 2, 3),
(3, 1, 3, 3, 4),
(4, 1, 4, 4, 2),
(5, 1, 5, 5, 5),
(6, 2, 1, 5, 1),
(7, 2, 2, 4, 3),
(8, 2, 3, 3, 4),
(9, 2, 4, 2, 2),
(10, 2, 5, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `StudentId` int(11) NOT NULL,
  `IdNumber` varchar(255) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) DEFAULT NULL,
  `YearLevelId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StudentId`, `IdNumber`, `FirstName`, `LastName`, `MiddleName`, `YearLevelId`, `DepartmentId`, `CourseId`) VALUES
(1, '', 'student1', 'student1', 'student1', 1, 1, 1),
(2, '', 'student2', 'student2', 'student2', 1, 1, 1),
(3, '', 'student3', 'student3', 'student3', 1, 1, 1),
(4, '', 'student4', 'student4', 'student4', 1, 1, 1),
(5, '', 'student5', 'student5', 'student5', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_account`
--

CREATE TABLE `student_account` (
  `StudentAccountId` int(11) NOT NULL,
  `StudentId` int(11) NOT NULL,
  `AccountId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_account`
--

INSERT INTO `student_account` (`StudentAccountId`, `StudentId`, `AccountId`) VALUES
(1, 1, 7),
(2, 2, 8),
(3, 3, 9),
(4, 4, 10),
(5, 5, 11);

-- --------------------------------------------------------

--
-- Table structure for table `student_sss`
--

CREATE TABLE `student_sss` (
  `StudentSectionId` int(11) NOT NULL,
  `StudentId` int(11) NOT NULL,
  `SectionSubjectScheduleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_sss`
--

INSERT INTO `student_sss` (`StudentSectionId`, `StudentId`, `SectionSubjectScheduleId`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 2, 1),
(7, 2, 2),
(8, 2, 3),
(9, 2, 4),
(10, 2, 5),
(11, 3, 1),
(12, 3, 2),
(13, 3, 3),
(14, 3, 4),
(15, 3, 5),
(16, 4, 1),
(17, 4, 2),
(18, 4, 3),
(19, 4, 4),
(20, 4, 5),
(21, 5, 1),
(22, 5, 2),
(23, 5, 3),
(24, 5, 4),
(25, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `student_teacher_rating`
--

CREATE TABLE `student_teacher_rating` (
  `StudentTeacherRatingId` int(11) NOT NULL,
  `EvaluationId` int(11) NOT NULL,
  `QuestionId` int(11) NOT NULL,
  `RatingId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `SubjectId` int(11) NOT NULL,
  `SubjectName` varchar(150) NOT NULL,
  `SubjectAcronym` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`SubjectId`, `SubjectName`, `SubjectAcronym`) VALUES
(1, 'Programming 2', 'Programming2'),
(2, 'Database', 'Database'),
(3, 'Software Engineering', 'SofEng'),
(4, 'Programming 1', 'Programming1'),
(5, 'Web Development', 'WebDev');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `TeacherId` int(11) NOT NULL,
  `IdNumber` varchar(150) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `MiddleName` varchar(150) NOT NULL,
  `DepartmentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`TeacherId`, `IdNumber`, `FirstName`, `LastName`, `MiddleName`, `DepartmentId`) VALUES
(1, '', 'teacher1', 'teacher1', 'teacher1', 1),
(2, '', 'teacher2', 'teacher2', 'teacher2', 1),
(3, '', 'teacher3', 'teacher3', 'teacher3', 1),
(4, '', 'teacher4', 'teacher4', 'teacher4', 1),
(5, '', 'teacher5', 'teacher5', 'teacher5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_account`
--

CREATE TABLE `teacher_account` (
  `TeacherAccountId` int(11) NOT NULL,
  `TeacherId` int(11) NOT NULL,
  `AccountId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher_account`
--

INSERT INTO `teacher_account` (`TeacherAccountId`, `TeacherId`, `AccountId`) VALUES
(1, 1, 2),
(2, 2, 3),
(3, 3, 4),
(4, 4, 5),
(5, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `yearlevel`
--

CREATE TABLE `yearlevel` (
  `YearLevelId` int(11) NOT NULL,
  `YearLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `yearlevel`
--

INSERT INTO `yearlevel` (`YearLevelId`, `YearLevel`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`AccountId`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminId`);

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`AdminAccountId`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CourseId`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DepartmentId`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`EvaluationId`);

--
-- Indexes for table `evaluation_schedule`
--
ALTER TABLE `evaluation_schedule`
  ADD PRIMARY KEY (`EvaluationScheduleId`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`PersonId`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`QuestionId`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`RatingId`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`ScheduleId`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`SectionId`);

--
-- Indexes for table `section_subject_schedule`
--
ALTER TABLE `section_subject_schedule`
  ADD PRIMARY KEY (`SectionSubjectScheduleId`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`StudentId`);

--
-- Indexes for table `student_account`
--
ALTER TABLE `student_account`
  ADD PRIMARY KEY (`StudentAccountId`);

--
-- Indexes for table `student_sss`
--
ALTER TABLE `student_sss`
  ADD PRIMARY KEY (`StudentSectionId`);

--
-- Indexes for table `student_teacher_rating`
--
ALTER TABLE `student_teacher_rating`
  ADD PRIMARY KEY (`StudentTeacherRatingId`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`SubjectId`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`TeacherId`);

--
-- Indexes for table `teacher_account`
--
ALTER TABLE `teacher_account`
  ADD PRIMARY KEY (`TeacherAccountId`);

--
-- Indexes for table `yearlevel`
--
ALTER TABLE `yearlevel`
  ADD PRIMARY KEY (`YearLevelId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `AccountId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `AdminAccountId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `CourseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `DepartmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `EvaluationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `evaluation_schedule`
--
ALTER TABLE `evaluation_schedule`
  MODIFY `EvaluationScheduleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `PersonId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `QuestionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `RatingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ScheduleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `SectionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `section_subject_schedule`
--
ALTER TABLE `section_subject_schedule`
  MODIFY `SectionSubjectScheduleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `StudentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_account`
--
ALTER TABLE `student_account`
  MODIFY `StudentAccountId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_sss`
--
ALTER TABLE `student_sss`
  MODIFY `StudentSectionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `student_teacher_rating`
--
ALTER TABLE `student_teacher_rating`
  MODIFY `StudentTeacherRatingId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `SubjectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `TeacherId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teacher_account`
--
ALTER TABLE `teacher_account`
  MODIFY `TeacherAccountId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `yearlevel`
--
ALTER TABLE `yearlevel`
  MODIFY `YearLevelId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
