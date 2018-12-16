-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2018 at 10:58 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(9, 'Hand Made', 'Hand Made items', 0, 1, 1, 1, 1),
(10, 'Computers', 'Computers items', 0, 2, 0, 0, 0),
(11, 'Cell Phones', 'Cell Phones', 0, 3, 0, 0, 0),
(12, 'Clothing', 'Clothing And Fashion', 0, 4, 0, 0, 0),
(13, 'Tools', 'Home Tools', 0, 5, 0, 0, 0),
(16, 'wood stick', 'wood stick tool', 13, 3, 0, 0, 0),
(17, 'BlackBerry', 'BlackBerry phones', 11, 3, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `Comment_Date` date NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `status`, `Comment_Date`, `Item_ID`, `User_ID`) VALUES
(1, 'very nice ', 1, '2018-09-02', 16, 18),
(2, 'Good item', 1, '2018-08-10', 18, 18),
(3, 'Cooool', 1, '2018-09-02', 17, 18),
(4, 'sherif', 1, '2018-09-25', 17, 18),
(7, 'My Comment By Ahmed', 1, '2018-09-25', 17, 18),
(8, 'Very Nice This is last test Comment', 1, '2018-09-25', 17, 18),
(9, 'this is My Comment ', 1, '2018-09-25', 17, 19),
(10, 'This is amazing Phone', 1, '2018-09-25', 16, 19);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`, `tags`) VALUES
(14, 'speaker', 'Very Good Speaker', '10', '2018-09-11', 'China', '', '1', 0, 0, 10, 12, ''),
(15, 'Yeti Blue Mic', 'Very Good Microphone', '108', '2018-09-11', 'USA', '', '1', 0, 0, 10, 11, ''),
(16, 'iPhone 6s', 'Apple Phone ', '300', '2018-09-11', 'USA', '', '2', 0, 0, 11, 15, ''),
(17, 'LED Pc Monitor', 'monitor for Pc', '500', '2018-09-13', 'USA', '', '2', 0, 1, 10, 18, ''),
(18, 'Hard Drive', 'Hard Drive for Pc ', '105', '2018-09-13', 'china', '', '1', 0, 1, 10, 18, ''),
(20, 'Hammer', 'big hammer', '150', '2018-09-26', 'china', '', '1', 0, 1, 13, 18, ''),
(21, 'Moues', 'gaming Moues', '50', '2018-09-26', 'US', '', '1', 0, 1, 10, 18, ''),
(22, 'keyboard', 'lighting keyboard', '70', '2018-09-26', 'china', '', '2', 0, 1, 10, 18, ''),
(23, 'HTC ', 'Mobile Phone', '220', '2018-09-26', 'us', '', '1', 0, 1, 11, 18, ''),
(24, 'samasung A7', 'mobile phone', '100', '2018-09-26', 'china', '', '2', 0, 1, 11, 18, ''),
(25, 'jacket', 'winter jacket', '15', '2018-09-26', 'us', '', '1', 0, 0, 12, 18, ''),
(26, 'toy boat', ' child toy boat', '5', '2018-09-27', 'Egypt', '', '1', 0, 1, 9, 18, 'test,handmade,Hand,Discount'),
(27, 'wooden Game', 'Hand made game', '8', '2018-09-29', 'Egypt', '', '1', 0, 1, 9, 19, 'handmade,Hand,Discount'),
(28, 'Devil May cry5', 'a nice Pc Game', '80', '2018-09-29', 'Japan', '', '1', 0, 1, 10, 18, 'game,pc,games,crash'),
(29, 'Age of Mythology', 'good stratige Game', '30', '2018-09-29', 'us', '', '1', 0, 1, 10, 13, 'game,games,discount,test');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To identify User',
  `Username` varchar(255) NOT NULL COMMENT 'UserName To Login',
  `Password` varchar(255) NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) NOT NULL COMMENT 'Email To Login',
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0' COMMENT 'identify user Role',
  `TrustStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'Seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'User Approval',
  `Date` date NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `avatar`) VALUES
(1, 'sherif', '601f1889667efaebb33b8c12572835da3f027f78', 'sherif@gmail.com', 'sherif mohammed', 1, 0, 1, '2017-12-15', ''),
(2, 'Mahmoud', 'f1afff478c72dd0b282a73599fb9d298322aa030', 'mmmahsmoud@gmail.com', 'mahmoud ibrahem', 0, 0, 1, '2018-01-19', ''),
(4, 'Youssef', 'f27301db0c6aa0cbc1ef00190c98eab4d078e5b7', 'youssef@aa.info', 'Youssef Emad', 0, 0, 1, '2018-07-16', ''),
(11, 'Taha', 'aa7dd60c6d939fd178e54f8e4513da334731d324', 'Taha@Mail.info', 'Taha mahmoud ', 0, 0, 1, '2018-07-19', ''),
(12, 'Ramadan', 'bd78a4fb92f0036cfc24d826a4ea1eb7008b6ab5', 'RamadanKarim@mail.com', 'Ramadan Monaem', 0, 0, 1, '2018-07-19', ''),
(13, 'asmaa', 'e923d4c97355e4e6f9c90403b0d9ab009b0c74de', 'asmaa22@gmail.com', 'Asmaa Ali', 0, 0, 1, '2018-07-20', ''),
(14, 'rodina', '774f2dce6c08445939f0e09c9d93278f29db604f', 'rodina@mail.info', 'rodina mohie', 0, 0, 1, '2018-07-20', ''),
(15, 'Rody', 'ccbe91b1f19bd31a1365363870c0eec2296a61c1', 'Rody111@mail.com', 'Rody Khaled', 0, 0, 1, '2018-07-20', ''),
(16, 'Ali', 'e697ef18d3fa82e0fcd427a989a86c694b547c64', 'ali@info.com', 'Ali Soliman', 0, 0, 1, '2018-09-09', ''),
(17, 'App', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'app@P.com', 'Application', 0, 0, 1, '2018-09-19', ''),
(18, 'Ahmed', '601f1889667efaebb33b8c12572835da3f027f78', 'Ahmed22@gmail.com', 'Ahmed mohamed', 0, 0, 1, '2018-09-22', ''),
(19, 'Bassma', '601f1889667efaebb33b8c12572835da3f027f78', 'Basoma@mail.com', '', 0, 0, 1, '2018-09-24', ''),
(20, 'Qais', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'qais@mail.com', 'Qais Joseph', 0, 0, 1, '2018-10-01', '75856750_787370e61c34dfbfb798ce08ac75a610.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `Items_Comment` (`Item_ID`),
  ADD KEY `Comment_User` (`User_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To identify User', AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Comment_User` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Items_Comment` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
