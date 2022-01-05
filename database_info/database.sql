-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jan 05, 2022 at 08:18 AM
-- Server version: 8.0.27
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `ChessTour`
--

CREATE TABLE `ChessTour` (
  `ID` int NOT NULL,
  `User_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ChessTourRoom`
--

CREATE TABLE `ChessTourRoom` (
  `ID` int NOT NULL,
  `UserOpp` int NOT NULL,
  `GameID` int NOT NULL,
  `UserColor` varchar(50) NOT NULL,
  `LastMove` varchar(255) NOT NULL,
  `Finish` int NOT NULL,
  `Round` int NOT NULL,
  `UserID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Game`
--

CREATE TABLE `Game` (
  `ID` int NOT NULL,
  `UserGameOpponent` varchar(255) NOT NULL,
  `UserGameId` int NOT NULL,
  `LastMove` varchar(255) NOT NULL,
  `UserGameColor` varchar(255) NOT NULL,
  `FINISH` int NOT NULL,
  `UserID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Game`
--

INSERT INTO `Game` (`ID`, `UserGameOpponent`, `UserGameId`, `LastMove`, `UserGameColor`, `FINISH`, `UserID`) VALUES
(1, '', 0, '', '', 0, 1),
(3, '', 0, '', '', 0, 4),
(4, '', 0, '', '', 0, 9),
(5, '', 0, '', '', 0, 10),
(6, '', 0, '', '', 0, 8),
(7, '', 0, '', '', 0, 11),
(8, '', 0, '', '', 0, 12),
(9, '', 0, '', '', 0, 13),
(10, '', 0, '', '', 0, 14),
(11, '', 0, '', '', 0, 16),
(14, '', 0, '', '', 0, 19),
(15, '', 0, '', '', 0, 20),
(16, '', 0, '', '', 0, 21);

-- --------------------------------------------------------

--
-- Table structure for table `GameTic`
--

CREATE TABLE `GameTic` (
  `ID` int NOT NULL,
  `OppID` int NOT NULL,
  `GameID` int NOT NULL,
  `Color` varchar(20) NOT NULL,
  `Turn` int NOT NULL,
  `Finish` int NOT NULL,
  `UserID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `GameTic`
--

INSERT INTO `GameTic` (`ID`, `OppID`, `GameID`, `Color`, `Turn`, `Finish`, `UserID`) VALUES
(1, 0, 0, '', 0, 0, 1),
(3, 0, 1, '', 0, 0, 4),
(4, 0, 1, '', 0, 0, 9),
(5, 0, 0, '', 0, 0, 8),
(6, 0, 0, '', 0, 0, 10),
(7, 0, 1, '', 0, 0, 11),
(8, 0, 0, '', 0, 0, 12),
(9, 0, 0, '', 0, 0, 16),
(12, 0, 0, '', 0, 0, 19),
(13, 0, 0, '', 0, 0, 20),
(14, 0, 1, '', 0, 0, 13),
(15, 0, 1, '', 0, 0, 14),
(16, 0, 0, '', 0, 0, 21);

-- --------------------------------------------------------

--
-- Table structure for table `MovesTic`
--

CREATE TABLE `MovesTic` (
  `ID` int NOT NULL,
  `p00` int NOT NULL,
  `p01` int NOT NULL,
  `p02` int NOT NULL,
  `p10` int NOT NULL,
  `p11` int NOT NULL,
  `p12` int NOT NULL,
  `p20` int NOT NULL,
  `p21` int NOT NULL,
  `p22` int NOT NULL,
  `Game_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `MovesTic`
--

INSERT INTO `MovesTic` (`ID`, `p00`, `p01`, `p02`, `p10`, `p11`, `p12`, `p20`, `p21`, `p22`, `Game_id`) VALUES
(178, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4145767);

-- --------------------------------------------------------

--
-- Table structure for table `Scores`
--

CREATE TABLE `Scores` (
  `ID` int NOT NULL,
  `Pwin` int NOT NULL,
  `Ploose` int NOT NULL,
  `Pdraw` int NOT NULL,
  `Twin` int NOT NULL,
  `Tloose` int NOT NULL,
  `Tdraw` int NOT NULL,
  `TournamentsWin` int NOT NULL,
  `TournamentsNum` int NOT NULL,
  `User_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Scores`
--

INSERT INTO `Scores` (`ID`, `Pwin`, `Ploose`, `Pdraw`, `Twin`, `Tloose`, `Tdraw`, `TournamentsWin`, `TournamentsNum`, `User_id`) VALUES
(1, 0, 0, 0, 2, 1, 0, 1, 2, 8),
(2, 138, 59, 1, 4, 0, 0, 2, 2, 1),
(4, 64, 72, 1, 0, 2, 0, 0, 2, 3),
(5, 0, 0, 0, 2, 1, 0, 1, 1, 4),
(8, 0, 0, 0, 2, 0, 0, 1, 1, 9),
(9, 0, 0, 0, 0, 1, 0, 0, 0, 10),
(10, 0, 0, 0, 2, 0, 0, 0, 0, 11),
(11, 0, 0, 0, 0, 1, 0, 0, 1, 12),
(12, 0, 0, 0, 0, 0, 0, 0, 0, 13),
(13, 0, 0, 0, 0, 0, 0, 0, 0, 14),
(14, 0, 0, 0, 0, 0, 0, 0, 0, 15),
(15, 0, 0, 0, 0, 0, 0, 0, 0, 16),
(16, 2, 4, 0, 0, 0, 0, 0, 0, 17),
(17, 0, 15, 0, 0, 0, 0, 0, 0, 18),
(18, 0, 2, 0, 0, 0, 0, 0, 0, 19),
(19, 0, 2, 0, 0, 0, 0, 0, 0, 20),
(20, 0, 0, 0, 0, 0, 0, 0, 0, 21);

-- --------------------------------------------------------

--
-- Table structure for table `ScoresTic`
--

CREATE TABLE `ScoresTic` (
  `ID` int NOT NULL,
  `Pwin` int NOT NULL,
  `Plosse` int NOT NULL,
  `Pdraw` int NOT NULL,
  `Twin` int NOT NULL,
  `Tlosse` int NOT NULL,
  `Tour_wins` int NOT NULL,
  `Tour_nums` int NOT NULL,
  `User_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ScoresTic`
--

INSERT INTO `ScoresTic` (`ID`, `Pwin`, `Plosse`, `Pdraw`, `Twin`, `Tlosse`, `Tour_wins`, `Tour_nums`, `User_id`) VALUES
(2, 14, 8, 3, 8, 5, 2, 5, 1),
(3, 9, 15, 3, 4, 4, 1, 5, 3),
(4, 0, 0, 0, 2, 4, 0, 3, 4),
(5, 0, 0, 0, 3, 2, 0, 4, 8),
(6, 0, 0, 0, 5, 4, 1, 3, 9),
(7, 0, 0, 0, 0, 1, 0, 1, 10),
(8, 0, 0, 0, 4, 2, 0, 2, 11),
(9, 0, 0, 0, 0, 1, 0, 1, 12),
(10, 0, 0, 0, 0, 2, 0, 2, 13),
(11, 0, 0, 0, 0, 1, 0, 1, 14),
(12, 0, 0, 0, 0, 0, 0, 0, 15),
(13, 0, 0, 0, 0, 0, 0, 0, 16),
(14, 0, 0, 0, 0, 0, 0, 0, 17),
(15, 0, 0, 0, 0, 0, 0, 0, 18),
(16, 0, 0, 0, 0, 0, 0, 0, 19),
(17, 1, 1, 0, 0, 0, 0, 0, 20),
(18, 0, 0, 0, 0, 0, 0, 0, 21);

-- --------------------------------------------------------

--
-- Table structure for table `TourTic`
--

CREATE TABLE `TourTic` (
  `ID` int NOT NULL,
  `User_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TourTicRoom`
--

CREATE TABLE `TourTicRoom` (
  `ID` int NOT NULL,
  `OppID` int NOT NULL,
  `GameID` int NOT NULL,
  `Color` varchar(20) NOT NULL,
  `Turn` int NOT NULL,
  `Finish` int NOT NULL,
  `Round` int NOT NULL,
  `UserID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `ID` int NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `FIRSTNAME` varchar(50) NOT NULL,
  `LASTNAME` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `HASH` varchar(50) NOT NULL,
  `ROLE` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `USERNAME`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `HASH`, `ROLE`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@gmail.com', 'c6da359e1f35e84d360275685c6234b7', 'PRmWDTc540NtZUdpk3DJ1mwcJ3fmeqqy', 'Admin', '2020-04-12 01:11:28'),
(4, 'test', 'test', 'test', 'test@gmail.com', '0c18c0a7bc8def72f9c7ab85a80b4dc4', 'YMHtM0QcY0VSOjLDgnxbKTVdQ3s3jxSZ', 'Player', '2020-04-30 17:43:27'),
(8, 'test4', 'testt', 'test', 'testtest4@gmail.com', '0e48b4f79cf981422386980bfd53a28e', '58q4zXvpzweeQHGnCuGsZaZh5nBmgXlj', 'player', '2020-05-01 14:56:24'),
(9, 'test5', 'testtesttest', 'testtest', 'test5@gmail.com', '488682a20b126c01534ab89c615a1c70', 'FXJ40lkTg4SMvdRECFkuLrdFeOqb6KUK', 'player', '2020-05-02 11:09:16'),
(10, 'test6', 'testasd', 'testasd', 'test6@gmail.com', '77ad858ce9bfc57922457be2f5d65e9a', 'YZxOKrNPlfeTi6kCdCXsO7EKZclhyhkT', 'player', '2020-05-02 17:22:37'),
(11, 'test7', 'testeee', 'teseee', 'test7@gmail.com', '757399d0d5618e82b6be9b5db70faa74', 'BZb2JtOpmlB9nHDzqcLTtgGBW1yKRps9', 'player', '2020-05-03 17:47:12'),
(12, 'test8', 'testeeewqer', 'tesweqrweee', 'test8@gmail.com', '017a6b02228bc912814f9560cea60b58', '9JSBYvWXsVuz1WPfTBsLYWbNo47nRp4A', 'Admin', '2020-05-03 17:47:30'),
(13, 'test9', 'testeeewqerweqr', 'tesweqrweeewqer', 'test9@gmail.com', '3843253fc56db146850f26e1427c0231', 'UHujWQpUxuZw8GZud3T0sBUGhtyFwktN', 'player', '2020-05-03 17:47:42'),
(14, 'test10', 'testeeewqerwe', 'qwe', 'test10@gmail.com', 'a808b4cec4f71304bf43481984b3a505', 'yO080t9duafG5l8KzgQ1A7mrICGBT5vI', 'player', '2020-05-03 17:48:01'),
(15, 'test11', 'testasas', 'tesdddd', 'test11@gmail.com', 'c2e3c7862fbf11ba5818be9c9863cb57', 'T6JHKi2rjpSBhRl7a4zq5vvxByU1Vcdk', 'player', '2020-05-08 06:57:44'),
(16, 'test20', 'test', 'testtest', 'test20@gmail.com', '7333003347e703478c8fce6d563cda11', '7xGHQg49ywxBrby3DDVoCbzVQ2GWt3YA', 'player', '2020-05-29 08:56:18'),
(19, 'test23', 'test', 'test', 'test23@gmail.com', 'cf4a7f9689b30bb3910ac443d9bc7331', 'NNKJudX0qg4eBlyWMhJJZGKfo9tLSPzd', 'Official', '2020-05-29 12:28:19'),
(20, 'test24', 'test', 'test', 'test24@gmail.com', '7fa332158bcee226ad8b586617362b39', 'dS5F8ITnNw7Cfh7mE9VOpWFTvQBnRMNM', 'Official', '2020-05-29 12:34:25'),
(21, 'Aplaz123', 'apl', 'laz', 'aaa@gmail.com', 'ffb2e9baedd08dea242b6c9c70d0d6fd', 'vpSPBtVp38xwD02y9yFEYaHxoCI7pi0K', 'player', '2022-01-04 17:55:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ChessTour`
--
ALTER TABLE `ChessTour`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ChessTour_ibfk_1` (`User_id`);

--
-- Indexes for table `ChessTourRoom`
--
ALTER TABLE `ChessTourRoom`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `Game`
--
ALTER TABLE `Game`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `GameTic`
--
ALTER TABLE `GameTic`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `GameTic_ibfk_1` (`UserID`);

--
-- Indexes for table `MovesTic`
--
ALTER TABLE `MovesTic`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Scores`
--
ALTER TABLE `Scores`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ScoresTic`
--
ALTER TABLE `ScoresTic`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `TourTic`
--
ALTER TABLE `TourTic`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `User_id` (`User_id`);

--
-- Indexes for table `TourTicRoom`
--
ALTER TABLE `TourTicRoom`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ChessTour`
--
ALTER TABLE `ChessTour`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `ChessTourRoom`
--
ALTER TABLE `ChessTourRoom`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `Game`
--
ALTER TABLE `Game`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `GameTic`
--
ALTER TABLE `GameTic`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `MovesTic`
--
ALTER TABLE `MovesTic`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `Scores`
--
ALTER TABLE `Scores`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ScoresTic`
--
ALTER TABLE `ScoresTic`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `TourTic`
--
ALTER TABLE `TourTic`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `TourTicRoom`
--
ALTER TABLE `TourTicRoom`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ChessTourRoom`
--
ALTER TABLE `ChessTourRoom`
  ADD CONSTRAINT `ChessTourRoom_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `ChessTour` (`User_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Game`
--
ALTER TABLE `Game`
  ADD CONSTRAINT `Game_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `GameTic`
--
ALTER TABLE `GameTic`
  ADD CONSTRAINT `GameTic_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `TourTicRoom`
--
ALTER TABLE `TourTicRoom`
  ADD CONSTRAINT `TourTicRoom_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
