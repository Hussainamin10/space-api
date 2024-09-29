-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2024 at 05:23 PM
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
CREATE DATABASE IF NOT EXISTS `planeto` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `planeto`;

-- --------------------------------------------------------

--
-- Table structure for table `astronauts`
--

CREATE TABLE `astronauts` (
  `astronautID` int(11) NOT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `numOfMissions` int(11) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `inSpace` tinyint(1) DEFAULT NULL,
  `dateOfDeath` date DEFAULT NULL,
  `flightsCount` int(11) DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `wiki` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `astronauts`
--

INSERT INTO `astronauts` (`astronautID`, `firstName`, `lastName`, `numOfMissions`, `nationality`, `inSpace`, `dateOfDeath`, `flightsCount`, `dateOfBirth`, `bio`, `wiki`, `image`, `thumbnail`) VALUES
(1, 'Yuri', 'Gagarin', 1, 'Russian', 0, '1968-03-27', 1, '1934-03-09', 'Yuri Alekseyevich Gagarin was a Soviet pilot and cosmonaut. He became the first human to journey into outer space when his Vostok spacecraft completed one orbit of the Earth on 12 April 1961.', 'https://en.wikipedia.org/wiki/Yuri_Gagarin', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/yuri2520gagarin_image_20200211151614.jpg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305191209.jpeg'),
(2, 'Neil', 'Armstrong', 1, 'American', 0, '2012-08-25', 1, '1930-08-05', 'Neil Alden Armstrong was an American astronaut and aeronautical engineer who was the first person to walk on the Moon. He was also a naval aviator, test pilot, and university professor.', 'https://en.wikipedia.org/wiki/Neil_Armstrong', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/neil2520armstrong_image_20190426143653.jpeg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305190707.jpeg'),
(3, 'Buzz', 'Aldrin', 3, 'American', 0, NULL, 2, '1930-01-20', 'Buzz Aldrin; born Edwin Eugene Aldrin Jr.; is an American engineer, former astronaut, and fighter pilot. As Lunar Module Pilot on the Apollo 11 mission, he and mission commander Neil Armstrong were the first two humans to land on the Moon.', 'https://en.wikipedia.org/wiki/Buzz_Aldrin', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/buzz_aldrin_image_20220911034547.jpeg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305185225.jpeg'),
(4, 'Sally', 'Ride', 1, 'American', 0, '2012-07-23', 1, '1951-05-26', 'Sally Kristen Ride was an American astronaut, physicist, and engineer. Born in Los Angeles, she joined NASA in 1978 and became the first American woman in space in 1983. Ride was the third woman in space overall, after USSR cosmonauts Valentina Tereshkova (1963) and Svetlana Savitskaya (1982). Ride remains the youngest American astronaut to have traveled to space, having done so at the age of 32. After flying twice on the Orbiter Challenger, she left NASA in 1987. She worked for two years at Stanford University\'s Center for International Security and Arms Control, then at the University of California, San Diego as a professor of physics, primarily researching nonlinear optics and Thomson scattering. She served on the committees that investigated the Challenger and Columbia space shuttle disasters, the only person to participate in both. Ride died of pancreatic cancer on July 23, 2012.', 'https://en.wikipedia.org/wiki/Sally_Ride', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/sally2520ride_image_20190421143600.jpeg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305185614.jpeg'),
(5, 'Valentina', 'Tereshkova', 1, 'Russian', 0, NULL, 1, '1937-03-06', 'Valentina Vladimirovna Tereshkova (born 6 March 1937) is a retired Russian cosmonaut, engineer, and politician. She is the first woman to have flown in space, having been selected from more than 400 applicants and five finalists to pilot Vostok 6 on 16 June 1963. In order to join the Cosmonaut Corps, Tereshkova was honorarily inducted into the Soviet Air Force and thus she also became the first civilian to fly in space.', 'https://en.wikipedia.org/wiki/Valentina_Tereshkova', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/valentina2520tereshkova_image_20181201222143.jpg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305185716.jpeg'),
(6, 'John', 'Glenn', 2, 'American', 0, '2016-12-08', 2, '1921-07-18', 'Colonel John Herschel Glenn Jr. was a United States Marine Corps aviator, engineer, astronaut, businessman, and politician. He was the first American to orbit the Earth, circling it three times in 1962. Following his retirement from NASA, he served from 1974 to 1999 as a Democratic United States Senator from Ohio.', 'https://en.wikipedia.org/wiki/John_Glenn', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/john2520glenn_image_20181128141704.jpg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305190045.jpeg'),
(7, 'Gherman', 'Titov', 1, 'Russian', 0, '2000-09-20', 1, '1935-09-11', 'Gherman Stepanovich Titov was a Soviet cosmonaut who, on 6 August 1961, became the second human to orbit the Earth, aboard Vostok 2, preceded by Yuri Gagarin on Vostok 1. He was the fourth person in space, counting suborbital voyages of US astronauts Alan Shepard and Gus Grissom.', 'https://en.wikipedia.org/wiki/Gherman_Titov', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/gherman2520titov_image_20181201222559.jpg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305190117.jpeg'),
(8, 'Mae', 'Jemison', 1, 'American', 0, NULL, 1, '1956-10-17', 'Mae Carol Jemison is an American engineer, physician and NASA astronaut. She became the first African American woman to travel in space when she went into orbit aboard the Space Shuttle Endeavour on September 12, 1992. After medical school and a brief general practice, Jemison served in the Peace Corps from 1985 until 1987, when she was selected by NASA to join the astronaut corps. She resigned from NASA in 1993 to found a company researching the application of technology to daily life. She has appeared on television several times, including as an actress in an episode of Star Trek: The Next Generation. She is a dancer and holds nine honorary doctorates in science, engineering, letters, and the humanities. She is the current principal of the 100 Year Starship organization.', 'https://en.wikipedia.org/wiki/Mae_Jemison', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/mae_jemison_image_20220911033619.jpeg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305190022.jpeg'),
(9, 'Alexander', 'Gerst', 3, 'German', 1, NULL, 2, '1976-05-03', 'Alexander Gerst is a German European Space Agency astronaut and geophysicist, who was selected in 2009 to take part in space training. He was part of the International Space Station Expedition 40 and 41 from May to November 2014. Gerst returned to space on June 6, 2018, as part of Expedition 56/57 as the ISS Commander.', 'https://en.wikipedia.org/wiki/Alexander_Gerst', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/alexander2520gerst_image_20181127211820.jpg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305190641.jpeg'),
(10, 'André', 'Kuipers', 2, 'Dutch', 0, NULL, 2, '1958-10-05', 'André Kuipers is a Dutch physician and ESA astronaut. He became the second Dutch citizen, third Dutch-born and fifth Dutch-speaking astronaut upon launch of Soyuz TMA-4 on 19 April 2004. Kuipers returned to Earth aboard Soyuz TMA-3 11 days later.\r\n\r\nKuipers is the first Dutch astronaut to return to space. On 5 August 2009, Dutch minister of economic affairs Maria van der Hoeven, announced Kuipers was selected as an astronaut for International Space Station (ISS) Expeditions 30 and 31. He was launched to space on 21 December 2011 and returned to Earth on 1 July 2012.', 'https://en.wikipedia.org/wiki/Andr%C3%A9_Kuipers', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/andr25c325a92520kuipers_image_20181129234401.jpg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305190327.jpeg'),
(11, 'Peggy', 'Whitson', 10, 'American', 0, NULL, 6, '1960-02-09', 'Peggy Annette Whitson is an American biochemistry researcher, retired NASA astronaut, and former NASA Chief Astronaut. Her first space mission was in 2002, with an extended stay aboard the International Space Station as a member of Expedition 5. Her second mission launched October 10, 2007, as the first female commander of the ISS with Expedition 16. She was on her third long-duration space flight and was the commander of the International Space Station for Expedition 51, before handing over command to Fyodor Yurchikhin on June 1, 2017.', 'https://en.wikipedia.org/wiki/Peggy_Whitson', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/peggy_whitson_image_20210210144848.jpeg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305190851.jpeg'),
(12, 'Chris', 'Hadfield', 3, 'Canadian', 0, NULL, 3, '1959-08-29', 'Chris Austin Hadfield is a Canadian retired astronaut, engineer, and former Royal Canadian Air Force fighter pilot. The first Canadian to walk in space, Hadfield has flown two space shuttle missions and served as commander of the International Space Station.', 'https://en.wikipedia.org/wiki/Chris_Hadfield', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/chris_hadfield_image_20220911034200.jpeg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305190208.jpeg'),
(13, 'Michael', 'Collins', 1, 'American', 0, '2021-04-28', 1, '1930-10-31', 'Michael Collins (born October 31, 1930) (Major General, USAF, Ret.) was an American former astronaut and test pilot. Selected as part of the third group of fourteen astronauts in 1963, he flew into space twice. His first spaceflight was on Gemini 10, in which he and Command Pilot John Young performed two rendezvous with different spacecraft and undertook two extra-vehicular activities (EVAs, also known as spacewalks). His second spaceflight was as the Command Module Pilot for Apollo 11. While he stayed in orbit around the Moon, Neil Armstrong and Buzz Aldrin left in the Lunar Module to make the first manned landing on its surface. He is one of 24 people to have flown to the Moon. Collins was the fourth person, and third American, to perform an EVA; and is the first person to have performed more than one EVA.', 'https://en.wikipedia.org/wiki/Michael_Collins_(astronaut)', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/michael_collins_image_20210428162316.jpeg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305185402.jpeg'),
(14, 'Eileen', 'Collins', 6, 'American', 0, NULL, 6, '1956-11-19', 'Eileen Marie Collins is a retired NASA astronaut and a retired United States Air Force colonel. A former military instructor and test pilot, Collins was the first female pilot and first female commander of a Space Shuttle. She was awarded several medals for her work. Colonel Collins has logged 38 days 8 hours and 20 minutes in outer space. Collins retired on May 1, 2006, to pursue private interests, including service as a board member of USAA.', 'https://en.wikipedia.org/wiki/Eileen_Collins', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/eileen_collins_image_20220911034300.jpeg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305190225.jpeg'),
(15, 'Jim', 'Lovell', 2, 'American', 0, NULL, 2, '1928-03-25', 'James Arthur Lovell Jr. is a former NASA astronaut, Naval Aviator, and retired Navy captain. Lovell is known for being the commander of the ill-fated Apollo 13 mission, which suffered a critical failure en route to the Moon but was brought back safely to Earth through the efforts of the crew and mission control. In addition to being part of the Apollo 13 crew, Lovell was the command module pilot of Apollo 8, the first Apollo mission to enter lunar orbit.', 'https://en.wikipedia.org/wiki/Jim_Lovell', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/jim2520lovell_image_20181128143638.jpg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305190932.jpeg'),
(16, 'Alan', 'Bean', 4, 'American', 0, '2018-05-26', 4, '1932-03-15', 'Alan LaVern Bean was an American naval officer and naval aviator, aeronautical engineer, test pilot, and NASA astronaut; he was the fourth person to walk on the Moon. He was selected to become an astronaut by NASA in 1963 as part of Astronaut Group 3.\n\nHe made his first flight into space aboard Apollo 12, the second manned mission to land on the Moon, at age 37 in November 1969. He made his second and final flight into space on the Skylab 3 mission in 1973, the second manned mission to the Skylab space station. After retiring from the United States Navy in 1975 and NASA in 1981, he pursued his interest in painting, depicting various space-related scenes and documenting his own experiences in space as well as that of his fellow Apollo program astronauts. He was the last living crew member of Apollo 12.', 'https://en.wikipedia.org/wiki/Alan_Bean', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/alan2520bean_image_20181128145355.jpg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305191125.jpeg'),
(17, 'Wally', 'Funk', 1, 'American', 0, NULL, 1, '1938-02-01', 'Mary Wallace \"Wally\" Funk is an American aviator and Goodwill Ambassador. She was the first female air safety investigator for the National Transportation Safety Board, the first female civilian flight instructor at Fort Sill, Oklahoma, and the first female Federal Aviation Agency inspector, as well as one of the Mercury 13.', 'https://en.wikipedia.org/wiki/Wally_Funk', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/wally_funk_image_20220911033704.jpeg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305185840.jpeg'),
(18, 'Serena', 'Aunon-Chancellor', 2, 'American', 0, NULL, 2, '1976-04-09', 'Serena Maria Auñón-Chancellor is an American physician, engineer, and NASA astronaut. She has been in space since June 6, 2018, serving as a flight engineer in Expedition 56/57 to the International Space Station.', 'https://en.wikipedia.org/wiki/Serena_Au%C3%B1%C3%B3n-Chancellor', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/serena_au25c3_image_20220911033856.jpeg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305185714.jpeg'),
(19, 'Tim', 'Peake', 2, 'British', 0, NULL, 2, '1972-04-07', 'Major Timothy Nigel Peake CMG is a British Army Air Corps officer, former European Space Agency astronaut and International Space Station (ISS) crew member. He is the first British ESA astronaut, the second astronaut to bear a flag of the United Kingdom patch, the sixth person born in the United Kingdom to go on board the International Space Station and the seventh UK-born person in space. He began the ESA\'s intensive astronaut basic training course in September 2009 and graduated on 22 November 2010.', 'https://en.wikipedia.org/wiki/Tim_Peake', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/tim_peake_image_20230120154350.jpg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305185843.jpeg'),
(20, 'Robert', 'Behnken', 2, 'American', 0, NULL, 2, '1970-07-28', 'Robert Louis \"Bob\" Behnken is a United States Air Force officer, retired NASA astronaut and former Chief of the Astronaut Office. Behnken holds a Ph.D in Mechanical Engineering and holds the rank of Colonel in the U.S. Air Force. Col. Behnken has logged over 1,000 flight hours in 25 different aircraft. He flew aboard Space Shuttle missions STS-123 and STS-130 as a Mission Specialist, accumulating over 378 hours in space, including 19 hours of spacewalk time. Behnken was also assigned as Mission Specialist 1 to the STS-400 rescue mission. He is married to fellow astronaut K. Megan McArthur.', NULL, 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/robert_l._behnk_image_20200421075919.jpeg', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/images/255bauto255d__image_thumbnail_20240305190951.jpeg');

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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `countryCode` varchar(10) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `mapImage` varchar(255) DEFAULT NULL,
  `timezone` varchar(100) DEFAULT NULL,
  `launchCount` int(11) DEFAULT NULL,
  `landingCount` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `countryCode`, `description`, `mapImage`, `timezone`, `launchCount`, `landingCount`, `url`) VALUES
(4, 'Palmachim Airbase, State of Israel', 'ISR', '', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_4_20200803142418.jpg', 'Asia/Jerusalem', 12, 0, 'https://lldev.thespacedevs.com/2.2.0/location/4/'),
(12, 'Cape Canaveral, FL', 'USA', '', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_12_20200803142519.jpg', 'America/New_York', 974, 56, 'https://lldev.thespacedevs.com/2.2.0/location/12/'),
(13, 'Guiana Space Centre, French Guiana', 'GUF', 'The Guiana Space Centre is a European spaceport to the northwest of Kourou in French Guiana, a region of France in South America. Kourou is located at a latitude of 5°. In operation since 1968, it is a suitable location for a spaceport because of its equatorial location and open sea to the east.', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_13_20200803142412.jpg', 'America/Cayenne', 322, 0, 'https://lldev.thespacedevs.com/2.2.0/location/13/'),
(15, 'Baikonur Cosmodrome', 'KAZ', '', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_15_20200803142517.jpg', 'Asia/Qyzylorda', 1551, 0, 'https://lldev.thespacedevs.com/2.2.0/location/15/'),
(18, 'Vostochny Cosmodrome, Siberia, Russian Federation', 'RUS', '', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_18_20200803142401.jpg', 'Asia/Yakutsk', 17, 0, 'https://lldev.thespacedevs.com/2.2.0/location/18/'),
(19, 'Taiyuan Satellite Launch Center, People\'s Republic of China', 'CHN', '', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_19_20200803142421.jpg', 'Asia/Shanghai', 131, 0, 'https://lldev.thespacedevs.com/2.2.0/location/19/'),
(27, 'Kennedy Space Center, FL', 'USA', '', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_27_20200803142447.jpg', 'America/New_York', 243, 0, 'https://lldev.thespacedevs.com/2.2.0/location/27/'),
(30, 'Kapustin Yar, Russian Federation', 'RUS', '', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_30_20200803142515.jpg', 'Europe/Volgograd', 101, 0, 'https://lldev.thespacedevs.com/2.2.0/location/30/'),
(146, 'Svobodny Cosmodrome, Russian Federation', 'RUS', '', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_146_20200803142450.jpg', 'Asia/Yakutsk', 5, 0, 'https://lldev.thespacedevs.com/2.2.0/location/146/'),
(150, 'Alcântara Space Center, Federative Republic of Brazil', 'BRA', 'The Alcântara Space Center, formerly known as Alcântara Launch Center is a space center and launching facility of the Brazilian Space Agency in the city of Alcântara, located on Brazil\'s northern Atlantic coast, in the state of Maranhão.', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_150_20200803142405.jpg', 'America/Fortaleza', 2, 0, 'https://lldev.thespacedevs.com/2.2.0/location/150/'),
(153, 'Tonghae Satellite Launching Ground', 'PRK', '', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_153_20200803142503.jpg', 'Asia/Pyongyang', 2, 0, 'https://lldev.thespacedevs.com/2.2.0/location/153/'),
(156, 'Whalers Way Orbital Launch Complex, South Australia', 'AUS', '', 'https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_whalers_way_orbital_launch_complex_20210910042508.jpg', 'Australia/Adelaide', 1, 0, 'https://lldev.thespacedevs.com/2.2.0/location/156/');

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
  `rocketID` int(11) NOT NULL,
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

INSERT INTO `rocket` (`rocketID`, `rocketName`, `companyName`, `rocketHeight`, `status`, `liftOfThrust`, `rocketWeight`, `numberOfStages`, `launchCost`) VALUES
(1, 'Atlas-Agena', 'NASA', 32.00, 'Retired', 1900, 58000.00, 2, 11000000.00),
(2, 'Falcon 9', 'SpaceX', 70.00, 'Active', 7600, 54900.00, 2, 62000000.00),
(3, 'New Shepard', 'Blue Origin', 18.30, 'Active', 7400, 15000.00, 2, 10000000.00),
(4, 'Saturn V', 'NASA', 110.00, 'Retired', 7600, 297000.00, 3, 35000000.00),
(5, 'Soyuz FG', 'Roscosmos', 46.00, 'Active', 4000, 30500.00, 2, 50000000.00),
(6, 'Space Shuttle', 'NASA', 56.00, 'Retired', 2800, 204000.00, 2, 150000000.00),
(7, 'Vostok-K', 'Roscosmos', 29.00, 'Retired', 2450, 29200.00, 2, 1000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `rocketspacemission`
--

CREATE TABLE `rocketspacemission` (
  `rocketID` int(11) NOT NULL,
  `missionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rocketspacemission`
--

INSERT INTO `rocketspacemission` (`rocketID`, `missionID`) VALUES
(1, 4),
(2, 31),
(2, 32),
(3, 28),
(4, 2),
(4, 3),
(4, 20),
(4, 25),
(4, 26),
(4, 27),
(5, 11),
(5, 12),
(5, 13),
(5, 14),
(5, 15),
(5, 16),
(5, 17),
(5, 19),
(5, 29),
(5, 30),
(6, 7),
(6, 8),
(6, 10),
(6, 18),
(6, 21),
(6, 22),
(6, 23),
(6, 24),
(7, 1),
(7, 5),
(7, 9);

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
  `launchDate` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `costOfTheMissions` decimal(12,2) DEFAULT NULL,
  `missionDuration` decimal(10,2) DEFAULT NULL,
  `crewSize` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `spacemissions`
--

INSERT INTO `spacemissions` (`missionID`, `companyName`, `spaceStationId`, `launchDate`, `status`, `costOfTheMissions`, `missionDuration`, `crewSize`, `location_id`) VALUES
(1, 'Roscosmos', NULL, '1961-04-12', 1, 100000.00, 1.00, 1, 15),
(2, 'NASA', NULL, '1969-07-16', 1, 355000000.00, 8.00, 3, 27),
(3, 'NASA', NULL, '1969-07-16', 1, 355000000.00, 8.00, 3, 27),
(4, 'NASA', NULL, '1966-11-11', 1, 19000000.00, 5.00, 2, 12),
(5, 'NASA', NULL, '1983-06-18', 1, 150000000.00, 6.00, 5, 27),
(6, 'Roscosmos', NULL, '1963-06-16', 1, 100000.00, 3.00, 1, 15),
(7, 'NASA', NULL, '1962-02-20', 1, 50000000.00, 1.00, 1, 12),
(8, 'NASA', NULL, '1998-10-29', 1, 150000000.00, 9.00, 7, 27),
(9, 'Roscosmos', NULL, '1961-08-06', 1, 100000.00, 1.00, 1, 15),
(10, 'NASA', NULL, '1992-09-12', 1, 150000000.00, 8.00, 7, 27),
(11, 'ESA', 1, '2014-05-28', 1, 70000000.00, 166.00, 6, 15),
(12, 'ESA', 1, '2016-07-07', 1, 70000000.00, 139.00, 3, 15),
(13, 'ESA', 1, '2011-12-21', 1, 70000000.00, 6.00, 6, 15),
(14, 'NASA', 1, '2002-04-09', 1, 70000000.00, 183.00, 6, 15),
(15, 'NASA', 1, '2007-10-10', 1, 70000000.00, 188.00, 6, 15),
(16, 'NASA', 1, '2010-10-07', 1, 70000000.00, 182.00, 6, 15),
(17, 'NASA', 1, '2016-11-17', 1, 70000000.00, 153.00, 6, 15),
(18, 'NASA', NULL, '2001-04-19', 1, 150000000.00, 11.00, 7, 27),
(19, 'ESA', 1, '2013-12-19', 1, 70000000.00, 146.00, 6, 15),
(20, 'NASA', NULL, '1969-07-16', 1, 355000000.00, 8.00, 3, 27),
(21, 'NASA', NULL, '1995-02-03', 1, 150000000.00, 7.00, 7, 27),
(22, 'NASA', NULL, '1997-05-03', 1, 150000000.00, 11.00, 7, 27),
(23, 'NASA', NULL, '1999-07-23', 1, 150000000.00, 9.00, 7, 27),
(24, 'NASA', NULL, '2005-07-26', 1, 150000000.00, 13.00, 7, 27),
(25, 'NASA', NULL, '1970-04-11', 1, 355000000.00, 5.00, 3, 27),
(26, 'NASA', NULL, '1969-11-14', 1, 355000000.00, 10.00, 3, 27),
(27, 'NASA', 1, '1973-07-26', 1, 150000000.00, 59.00, 3, 27),
(28, 'Blue Origin', NULL, '2021-07-20', 1, NULL, 0.18, 4, NULL),
(29, 'NASA', 1, '2018-06-06', 1, 70000000.00, 197.00, 6, 15),
(30, 'ESA', 1, '2015-12-15', 1, 70000000.00, 186.00, 6, 15),
(31, 'SpaceX', 1, '2020-05-30', 1, 220000000.00, 64.00, 2, 27),
(32, 'SpaceX', 1, '2021-04-23', 1, 220000000.00, 180.00, 4, 27);

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
(1, 'International Space Station', 1, 'Space Station', '1998-11-20', 'The International Space Station is a large spacecraft in low Earth orbit that serves as a home and research laboratory for astronauts.', 'International cooperation among NASA, Roscosmos, ESA, JAXA, and CSA'),
(2, 'Tiangong space station', 1, 'Government', '2021-04-29', 'The Tiangong space station is a space station placed in Low Earth orbit between 340 and 450 km above the surface. It will be roughly one-fifth the mass of the International Space Station and about the size of the Mir space station.', 'China Aerospace Science and Technology Corporation'),
(3, 'Mir Space Station', 0, 'Government', '1986-02-20', 'The Mir Space Station was a Soviet space station that operated in low Earth orbit from 1986 to 2001. It served as a pioneering modular space station.', 'Soviet Space Program, Russian Space Agency'),
(4, 'Skylab', 0, 'Government', '1973-05-14', 'Skylab was the United States\' first space station, orbiting Earth from 1973 to 1979. It was used for scientific research and solar observations.', 'NASA'),
(5, 'Almaz', 0, 'Military', '1973-04-03', 'Almaz was a series of military space stations developed by the Soviet Union in the 1970s for reconnaissance and research purposes.', 'Soviet Space Program'),
(6, 'Freedom Space Station', 0, 'International', '0000-00-00', 'Freedom was a proposed modular space station that was a precursor to the International Space Station. It was a collaborative project involving NASA, ESA, JAXA, and Canada, but was never launched.', 'NASA, ESA, JAXA, CSA'),
(9, 'Buran Space Station', 0, 'Government', '0000-00-00', 'The Buran Space Station was a proposed Soviet space station that would have supported the Buran space shuttle program. It was ultimately never built.', 'Soviet Space Program'),
(10, 'Salyut 1', 0, 'Government', '1971-04-19', 'Salyut 1 was the world\'s first space station, launched by the Soviet Union in 1971. It paved the way for future modular space stations.', 'Soviet Space Program');

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
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `planet`
--
ALTER TABLE `planet`
  ADD PRIMARY KEY (`planetID`);

--
-- Indexes for table `rocket`
--
ALTER TABLE `rocket`
  ADD PRIMARY KEY (`rocketID`) USING BTREE,
  ADD UNIQUE KEY `rocketName` (`rocketName`),
  ADD KEY `companyName` (`companyName`);

--
-- Indexes for table `rocketspacemission`
--
ALTER TABLE `rocketspacemission`
  ADD PRIMARY KEY (`rocketID`,`missionID`) USING BTREE,
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
  ADD KEY `fk_location` (`location_id`);

--
-- Indexes for table `spacestation`
--
ALTER TABLE `spacestation`
  ADD PRIMARY KEY (`stationID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `spacestation`
--
ALTER TABLE `spacestation`
  MODIFY `stationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  ADD CONSTRAINT `rocketspacemission_ibfk_2` FOREIGN KEY (`missionID`) REFERENCES `spacemissions` (`missionID`),
  ADD CONSTRAINT `rocketspacemission_ibfk_3` FOREIGN KEY (`rocketID`) REFERENCES `rocket` (`rocketID`);

--
-- Constraints for table `spacemissions`
--
ALTER TABLE `spacemissions`
  ADD CONSTRAINT `fk_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `spacemissions_ibfk_1` FOREIGN KEY (`companyName`) REFERENCES `spacecompany` (`companyName`),
  ADD CONSTRAINT `spacemissions_ibfk_2` FOREIGN KEY (`spaceStationId`) REFERENCES `spacestation` (`stationID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
