-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2024 at 05:56 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `astronautspacemission`
--

CREATE TABLE `astronautspacemission` (
  `astronautID` int(11) NOT NULL,
  `missionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `planet`
--

CREATE TABLE `planet` (
  `planetID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `sideralOrbit` float DEFAULT NULL,
  `sideralRotation` float DEFAULT NULL,
  `mass` decimal(12,2) DEFAULT NULL,
  `equaRadius` float DEFAULT NULL,
  `gravity` decimal(10,2) DEFAULT NULL,
  `discoveryDate` date DEFAULT NULL,
  `discoveredBy` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rocket`
--

CREATE TABLE `rocket` (
  `rocketName` varchar(100) NOT NULL,
  `companyName` varchar(100) DEFAULT NULL,
  `rocketHeight` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `liftOfThrust` float DEFAULT NULL,
  `rocketWeight` decimal(10,2) DEFAULT NULL,
  `numberOfStages` int(11) DEFAULT NULL,
  `launchCost` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rocketspacemission`
--

CREATE TABLE `rocketspacemission` (
  `rocketName` varchar(100) NOT NULL,
  `missionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `missionSuccessRate` float DEFAULT NULL,
  `annualRevenue` float DEFAULT NULL,
  `numberOfEmployees` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spacemissions`
--

CREATE TABLE `spacemissions` (
  `missionID` int(11) NOT NULL,
  `companyName` varchar(100) DEFAULT NULL,
  `spaceStationId` int(11) DEFAULT NULL,
  `rocketName` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `launchDate` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `costOfTheMissions` decimal(12,2) DEFAULT NULL,
  `missionDuration` decimal(10,2) DEFAULT NULL,
  `crewSize` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `owners` varchar(255) DEFAULT NULL,
  `orbit` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  ADD KEY `spaceStationId` (`spaceStationId`),
  ADD KEY `rocketName` (`rocketName`);

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
  ADD CONSTRAINT `spacemissions_ibfk_2` FOREIGN KEY (`spaceStationId`) REFERENCES `spacestation` (`stationID`),
  ADD CONSTRAINT `spacemissions_ibfk_3` FOREIGN KEY (`rocketName`) REFERENCES `rocket` (`rocketName`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
