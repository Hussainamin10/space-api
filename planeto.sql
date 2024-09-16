-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2024 at 11:13 PM
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
-- Database: `planeto`
--

-- --------------------------------------------------------

--
-- Table structure for table `astronauts`
--

CREATE TABLE `astronauts` (
  `astronautID` int(11) NOT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `numOfMissions` int(11) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `inSpace` tinyint(1) DEFAULT NULL,
  `dateOfDeath` date DEFAULT NULL,
  `flightsCount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `astronauts`
--

INSERT INTO `astronauts` (`astronautID`, `firstName`, `lastName`, `dateOfBirth`, `numOfMissions`, `nationality`, `inSpace`, `dateOfDeath`, `flightsCount`) VALUES
(1, 'Yuri', 'Gagarin', '1934-03-09', 1, 'Russian', 0, '1968-03-27', 1),
(2, 'Neil', 'Armstrong', '1930-08-05', 1, 'American', 0, '2012-08-25', 1),
(3, 'Buzz', 'Aldrin', '1930-01-20', 3, 'American', 0, NULL, 2),
(4, 'Sally', 'Ride', '1951-05-26', 1, 'American', 0, '2012-07-23', 1),
(5, 'Valentina', 'Tereshkova', '1937-03-06', 1, 'Russian', 0, NULL, 1),
(6, 'John', 'Glenn', '1921-07-18', 2, 'American', 0, '2016-12-08', 2),
(7, 'Gherman', 'Titov', '1935-09-11', 1, 'Russian', 0, '2000-09-20', 1),
(8, 'Mae', 'Jemison', '1956-10-17', 1, 'American', 0, NULL, 1),
(9, 'Alexander', 'Gerst', '1976-11-27', 3, 'German', 1, NULL, 2),
(10, 'André', 'Kuipers', '1958-10-05', 2, 'Dutch', 0, NULL, 2),
(11, 'Peggy', 'Whitson', '1960-02-09', 10, 'American', 0, NULL, 6),
(12, 'Chris', 'Hadfield', '1959-08-29', 3, 'Canadian', 0, NULL, 3),
(13, 'Michael', 'Collins', '1930-10-31', 1, 'American', 0, '2021-04-28', 1),
(14, 'Eileen', 'Collins', '1956-11-19', 6, 'American', 0, NULL, 6),
(15, 'Jim', 'Lovell', '1928-03-25', 2, 'American', 0, NULL, 2),
(16, 'Alan', 'Bean', '1932-03-15', 4, 'American', 0, '2018-05-26', 4),
(17, 'Wally', 'Funk', '1939-02-01', 1, 'American', 0, NULL, 1),
(18, 'Serena', 'Aunon-Chancellor', '1966-12-19', 2, 'American', 0, NULL, 2),
(19, 'Tim', 'Peake', '1972-04-24', 2, 'British', 0, NULL, 2),
(20, 'Robert', 'Behnken', '1970-07-28', 2, 'American', 0, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `astronautspacemission`
--

CREATE TABLE `astronautspacemission` (
  `astronautID` int(11) NOT NULL,
  `missionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `astronautspacemission`
--

INSERT INTO `astronautspacemission` (`astronautID`, `missionID`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 4),
(5, 5),
(6, 8),
(7, 9),
(8, 5),
(9, 11),
(10, 14),
(11, 11),
(12, 18),
(13, 13),
(14, 21),
(15, 25),
(16, 26),
(17, 28),
(18, 29),
(19, 30),
(20, 31);

-- --------------------------------------------------------

--
-- Table structure for table `planet`
--

CREATE TABLE `planet` (
  `planetID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `sideralOrbit` float DEFAULT NULL,
  `sideralRotation` float DEFAULT NULL,
  `mass` decimal(12,8) DEFAULT NULL,
  `equaRadius` float DEFAULT NULL,
  `gravity` decimal(10,8) DEFAULT NULL,
  `discoveryDate` date DEFAULT NULL,
  `discoveredBy` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `planet`
--

INSERT INTO `planet` (`planetID`, `name`, `sideralOrbit`, `sideralRotation`, `mass`, `equaRadius`, `gravity`, `discoveryDate`, `discoveredBy`) VALUES
(1, 'Mercury', 87.969, 58.646, 0.33000000, 2439.7, 3.70000000, NULL, NULL),
(2, 'Venus', 224.701, 243.018, 4.87000000, 6051.8, 8.87000000, NULL, NULL),
(3, 'Earth', 365.256, 0.997, 5.97000000, 6371, 9.81000000, NULL, NULL),
(4, 'Mars', 686.971, 1.026, 0.64200000, 3389.5, 3.71000000, NULL, NULL),
(5, 'Jupiter', 4332.59, 0.415, 1898.00000000, 69911, 24.79000000, NULL, NULL),
(6, 'Saturn', 10759.2, 0.444, 568.00000000, 58232, 10.44000000, NULL, NULL),
(7, 'Uranus', 30687.2, 0.718, 86.80000000, 25362, 8.69000000, NULL, NULL),
(8, 'Neptune', 60182, 0.671, 102.00000000, 24622, 11.15000000, NULL, NULL),
(9, 'Pluto', 90560, 6.387, 0.01460000, 1188.3, 0.65800000, '1930-02-18', 'Clyde Tombaugh'),
(10, 'Ceres', 1680, 0.379, 0.00093000, 473, 0.27000000, '1801-01-01', 'Giuseppe Piazzi'),
(11, 'Haumea', 1030, 0, 0.00006000, 632, 0.44000000, '2004-07-07', 'Mike Brown and team'),
(12, 'Makemake', 1110, 0, 0.00004800, 715, 0.44000000, '2005-03-31', 'Mike Brown and team'),
(13, 'Eris', 12200, 0, 0.00017000, 1163, 0.82000000, '2005-01-05', 'Mike Brown and team'),
(14, 'Pallas', 1680, 0.379, 0.00093000, 512, 0.28000000, '1802-03-28', 'Wilhelm Olbers'),
(15, 'Juno', 1430, 0.4, 0.00040000, 258, 0.24000000, '1804-09-01', 'Karl Ludwig Harding'),
(16, 'Vesta', 1320, 0.36, 0.00025000, 525, 0.28000000, '1807-03-29', 'Wilhelm Olbers'),
(17, 'Hygiea', 1850, 0.365, 0.00020000, 434, 0.32000000, '1849-04-12', 'Annibale de Gasparis'),
(18, 'Psyche', 2500, 0.4, 0.00028000, 200, 0.20000000, '1852-03-17', 'Ippolito Zuccal'),
(19, 'Eros', 1270, 0.1, 0.00008000, 16.84, 0.00200000, '1898-08-13', 'Gustav Witt'),
(20, 'Juno', 1430, 0.4, 0.00040000, 258, 0.24000000, '1804-09-01', 'Karl Ludwig Harding');

-- --------------------------------------------------------

--
-- Table structure for table `rocket`
--

CREATE TABLE `rocket` (
  `rocketName` varchar(100) NOT NULL,
  `companyName` varchar(100) DEFAULT NULL,
  `rocketHeight` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `liftOfThrust` float DEFAULT NULL,
  `rocketWeight` decimal(10,2) DEFAULT NULL,
  `numberOfStages` int(11) DEFAULT NULL,
  `launchCost` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rocket`
--

INSERT INTO `rocket` (`rocketName`, `companyName`, `rocketHeight`, `status`, `liftOfThrust`, `rocketWeight`, `numberOfStages`, `launchCost`) VALUES
('Atlas-Agena', 'NASA', 32.00, 'Retired', 1900, 58000.00, 2, 11000000.00),
('Falcon 9', 'SpaceX', 70.00, 'Active', 7600, 54900.00, 2, 62000000.00),
('New Shepard', 'Blue Origin', 18.30, 'Active', 7400, 15000.00, 2, 10000000.00),
('Saturn V', 'NASA', 110.00, 'Retired', 7600, 297000.00, 3, 35000000.00),
('Soyuz FG', 'Roscosmos', 46.00, 'Active', 4000, 30500.00, 2, 50000000.00),
('Space Shuttle', 'NASA', 56.00, 'Retired', 2800, 204000.00, 2, 150000000.00),
('Vostok-K', 'Roscosmos', 29.00, 'Retired', 2450, 29200.00, 2, 1000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `rocketspacemission`
--

CREATE TABLE `rocketspacemission` (
  `rocketName` varchar(100) NOT NULL,
  `missionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rocketspacemission`
--

INSERT INTO `rocketspacemission` (`rocketName`, `missionID`) VALUES
('Atlas-Agena', 4),
('Falcon 9', 31),
('Falcon 9', 32),
('New Shepard', 28),
('Saturn V', 2),
('Saturn V', 3),
('Saturn V', 20),
('Saturn V', 25),
('Saturn V', 26),
('Saturn V', 27),
('Soyuz FG', 11),
('Soyuz FG', 12),
('Soyuz FG', 13),
('Soyuz FG', 14),
('Soyuz FG', 15),
('Soyuz FG', 16),
('Soyuz FG', 17),
('Soyuz FG', 19),
('Soyuz FG', 29),
('Soyuz FG', 30),
('Space Shuttle', 7),
('Space Shuttle', 8),
('Space Shuttle', 10),
('Space Shuttle', 18),
('Space Shuttle', 21),
('Space Shuttle', 22),
('Space Shuttle', 23),
('Space Shuttle', 24),
('Vostok-K', 1),
('Vostok-K', 5),
('Vostok-K', 9);

-- --------------------------------------------------------

--
-- Table structure for table `spacecompany`
--

CREATE TABLE `spacecompany` (
  `companyName` varchar(100) NOT NULL,
  `foundedDate` date DEFAULT NULL,
  `founder` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `totalNumOfMissions` int(11) DEFAULT NULL,
  `missionSuccessRate` decimal(10,2) DEFAULT NULL,
  `annualRevenue` decimal(20,8) DEFAULT NULL,
  `numberOfEmployees` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `spacecompany`
--

INSERT INTO `spacecompany` (`companyName`, `foundedDate`, `founder`, `location`, `totalNumOfMissions`, `missionSuccessRate`, `annualRevenue`, `numberOfEmployees`) VALUES
('Blue Origin', '2000-09-08', 'Jeff Bezos', 'Kent, Washington, USA', 20, 85.00, NULL, 3500),
('ESA', '1975-05-30', 'European Governments', 'Paris, France', 500, 85.00, 6000000000.00000000, 2200),
('NASA', '1958-07-29', 'U.S. Government', 'Washington D.C., USA', 500, 85.00, 25000000000.00000000, 17000),
('Roscosmos', '1992-02-25', 'Russian Government', 'Moscow, Russia', 500, 80.00, 3000000000.00000000, 250000),
('SpaceX', '2002-03-14', 'Elon Musk', 'Hawthorne, California, USA', 200, 90.00, 5700000000.00000000, 12000);

-- --------------------------------------------------------

--
-- Table structure for table `spacemissions`
--

CREATE TABLE `spacemissions` (
  `missionID` int(11) NOT NULL,
  `companyName` varchar(100) DEFAULT NULL,
  `spaceStationId` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `launchDate` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `costOfTheMissions` decimal(12,2) DEFAULT NULL,
  `missionDuration` decimal(10,2) DEFAULT NULL,
  `crewSize` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `spacemissions`
--

INSERT INTO `spacemissions` (`missionID`, `companyName`, `spaceStationId`, `location`, `launchDate`, `status`, `costOfTheMissions`, `missionDuration`, `crewSize`) VALUES
(1, 'Roscosmos', NULL, 'Baikonur Cosmodrome', '1961-04-12', 1, 100000.00, 1.00, 1),
(2, 'NASA', NULL, 'Kennedy Space Center, FL', '1969-07-16', 1, 355000000.00, 8.00, 3),
(3, 'NASA', NULL, 'Kennedy Space Center, FL', '1969-07-16', 1, 355000000.00, 8.00, 3),
(4, 'NASA', NULL, 'Cape Canaveral, FL', '1966-11-11', 1, 19000000.00, 5.00, 2),
(5, 'NASA', NULL, 'Kennedy Space Center, FL', '1983-06-18', 1, 150000000.00, 6.00, 5),
(6, 'Roscosmos', NULL, 'Baikonur Cosmodrome', '1963-06-16', 1, 100000.00, 3.00, 1),
(7, 'NASA', NULL, 'Cape Canaveral, FL', '1962-02-20', 1, 50000000.00, 1.00, 1),
(8, 'NASA', NULL, 'Kennedy Space Center, FL', '1998-10-29', 1, 150000000.00, 9.00, 7),
(9, 'Roscosmos', NULL, 'Baikonur Cosmodrome', '1961-08-06', 1, 100000.00, 1.00, 1),
(10, 'NASA', NULL, 'Kennedy Space Center, FL', '1992-09-12', 1, 150000000.00, 8.00, 7),
(11, 'ESA', 1, 'Baikonur Cosmodrome', '2014-05-28', 1, 70000000.00, 166.00, 6),
(12, 'ESA', 1, 'Baikonur Cosmodrome', '2016-07-07', 1, 70000000.00, 139.00, 3),
(13, 'ESA', 1, 'Baikonur Cosmodrome', '2011-12-21', 1, 70000000.00, 6.00, 6),
(14, 'NASA', 1, 'Baikonur Cosmodrome', '2002-04-09', 1, 70000000.00, 183.00, 6),
(15, 'NASA', 1, 'Baikonur Cosmodrome', '2007-10-10', 1, 70000000.00, 188.00, 6),
(16, 'NASA', 1, 'Baikonur Cosmodrome', '2010-10-07', 1, 70000000.00, 182.00, 6),
(17, 'NASA', 1, 'Baikonur Cosmodrome', '2016-11-17', 1, 70000000.00, 153.00, 6),
(18, 'NASA', NULL, 'Kennedy Space Center, FL', '2001-04-19', 1, 150000000.00, 11.00, 7),
(19, 'ESA', 1, 'Baikonur Cosmodrome', '2013-12-19', 1, 70000000.00, 146.00, 6),
(20, 'NASA', NULL, 'Kennedy Space Center, FL', '1969-07-16', 1, 355000000.00, 8.00, 3),
(21, 'NASA', NULL, 'Kennedy Space Center, FL', '1995-02-03', 1, 150000000.00, 7.00, 7),
(22, 'NASA', NULL, 'Kennedy Space Center, FL', '1997-05-03', 1, 150000000.00, 11.00, 7),
(23, 'NASA', NULL, 'Kennedy Space Center, FL', '1999-07-23', 1, 150000000.00, 9.00, 7),
(24, 'NASA', NULL, 'Kennedy Space Center, FL', '2005-07-26', 1, 150000000.00, 13.00, 7),
(25, 'NASA', NULL, 'Kennedy Space Center, FL', '1970-04-11', 1, 355000000.00, 5.00, 3),
(26, 'NASA', NULL, 'Kennedy Space Center, FL', '1969-11-14', 1, 355000000.00, 10.00, 3),
(27, 'NASA', 1, 'Kennedy Space Center, FL', '1973-07-26', 1, 150000000.00, 59.00, 3),
(28, 'Blue Origin', NULL, 'Blue Origin Launch Site, TX', '2021-07-20', 1, NULL, 0.18, 4),
(29, 'NASA', 1, 'Baikonur Cosmodrome', '2018-06-06', 1, 70000000.00, 197.00, 6),
(30, 'ESA', 1, 'Baikonur Cosmodrome', '2015-12-15', 1, 70000000.00, 186.00, 6),
(31, 'SpaceX', 1, 'Kennedy Space Center, FL', '2020-05-30', 1, 220000000.00, 64.00, 2),
(32, 'SpaceX', 1, 'Kennedy Space Center, FL', '2021-04-23', 1, 220000000.00, 180.00, 4);

-- --------------------------------------------------------

--
-- Table structure for table `spacestation`
--

CREATE TABLE `spacestation` (
  `stationID` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `founded` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `owners` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `spacestation`
--

INSERT INTO `spacestation` (`stationID`, `name`, `status`, `type`, `founded`, `description`, `owners`) VALUES
(1, 'International Space Station', 1, 'Space Station', '1998-11-20', 'The International Space Station is a large spacecraft in low Earth orbit that serves as a home and research laboratory for astronauts.', 'International cooperation among NASA, Roscosmos, ESA, JAXA, and CSA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `astronauts`
--
ALTER TABLE `astronauts`
  ADD PRIMARY KEY (`astronautID`);

--
-- Indexes for table `astronautspacemission`
--
ALTER TABLE `astronautspacemission`
  ADD PRIMARY KEY (`astronautID`,`missionID`),
  ADD KEY `missionID` (`missionID`);

--
-- Indexes for table `planet`
--
ALTER TABLE `planet`
  ADD PRIMARY KEY (`planetID`);

--
-- Indexes for table `rocket`
--
ALTER TABLE `rocket`
  ADD PRIMARY KEY (`rocketName`),
  ADD KEY `companyName` (`companyName`);

--
-- Indexes for table `rocketspacemission`
--
ALTER TABLE `rocketspacemission`
  ADD PRIMARY KEY (`rocketName`,`missionID`),
  ADD KEY `missionID` (`missionID`);

--
-- Indexes for table `spacecompany`
--
ALTER TABLE `spacecompany`
  ADD PRIMARY KEY (`companyName`);

--
-- Indexes for table `spacemissions`
--
ALTER TABLE `spacemissions`
  ADD PRIMARY KEY (`missionID`),
  ADD KEY `companyName` (`companyName`),
  ADD KEY `spaceStationId` (`spaceStationId`);

--
-- Indexes for table `spacestation`
--
ALTER TABLE `spacestation`
  ADD PRIMARY KEY (`stationID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `astronautspacemission`
--
ALTER TABLE `astronautspacemission`
  ADD CONSTRAINT `astronautspacemission_ibfk_1` FOREIGN KEY (`astronautID`) REFERENCES `astronauts` (`astronautID`),
  ADD CONSTRAINT `astronautspacemission_ibfk_2` FOREIGN KEY (`missionID`) REFERENCES `spacemissions` (`missionID`);

--
-- Constraints for table `rocket`
--
ALTER TABLE `rocket`
  ADD CONSTRAINT `rocket_ibfk_1` FOREIGN KEY (`companyName`) REFERENCES `spacecompany` (`companyName`);

--
-- Constraints for table `rocketspacemission`
--
ALTER TABLE `rocketspacemission`
  ADD CONSTRAINT `rocketspacemission_ibfk_1` FOREIGN KEY (`rocketName`) REFERENCES `rocket` (`rocketName`),
  ADD CONSTRAINT `rocketspacemission_ibfk_2` FOREIGN KEY (`missionID`) REFERENCES `spacemissions` (`missionID`);

--
-- Constraints for table `spacemissions`
--
ALTER TABLE `spacemissions`
  ADD CONSTRAINT `spacemissions_ibfk_1` FOREIGN KEY (`companyName`) REFERENCES `spacecompany` (`companyName`),
  ADD CONSTRAINT `spacemissions_ibfk_2` FOREIGN KEY (`spaceStationId`) REFERENCES `spacestation` (`stationID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
