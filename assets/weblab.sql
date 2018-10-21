-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2018 at 02:48 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weblab`
--

-- --------------------------------------------------------

--
-- Table structure for table `friendrelations`
--

CREATE TABLE `friendrelations` (
  `user1` smallint(5) UNSIGNED NOT NULL,
  `user2` smallint(5) UNSIGNED NOT NULL,
  `areFriends` char(1) NOT NULL DEFAULT 'U' COMMENT 'This value will change from Y yes, U unconfirmed and N for no.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table to have all the users that are friends.';

--
-- Dumping data for table `friendrelations`
--

INSERT INTO `friendrelations` (`user1`, `user2`, `areFriends`) VALUES
(1, 2, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `useraccounts`
--

CREATE TABLE `useraccounts` (
  `userId` smallint(5) UNSIGNED NOT NULL COMMENT 'User Id given in increasing order to allow for relations between tables',
  `username` char(40) NOT NULL COMMENT 'Username for each user.',
  `userProfilePic` text COMMENT 'Path to the image in the filesystem',
  `userFiName` char(50) DEFAULT NULL,
  `userLaName` char(50) DEFAULT NULL,
  `userEmail` char(50) DEFAULT NULL,
  `userPwd` char(255) NOT NULL COMMENT 'We store the hashed password',
  `userSalt` char(255) NOT NULL COMMENT 'Here we store the salt of each password',
  `userGender` tinyint(1) NOT NULL DEFAULT '0',
  `userCountry` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table to keep data of all the registered users.';

--
-- Dumping data for table `useraccounts`
--

INSERT INTO `useraccounts` (`userId`, `username`, `userProfilePic`, `userFiName`, `userLaName`, `userEmail`, `userPwd`, `userSalt`, `userGender`, `userCountry`) VALUES
(1, 'H1', NULL, 'H', 'H', '1hectorhm1596@gmail.com', '1', '', 0, 'cos'),
(2, 'H2', NULL, 'H', 'H', '2hectorhm1596@gmail.com', '1', '', 0, 'cos'),
(3, 'H3', NULL, 'h', 'h', '3hectorhm1596@gmail.com', '1', '', 0, 'mon');

-- --------------------------------------------------------

--
-- Table structure for table `usercomments`
--

CREATE TABLE `usercomments` (
  `postPosterId` smallint(5) UNSIGNED NOT NULL,
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comentId` smallint(5) UNSIGNED NOT NULL COMMENT 'This value will be calculated via PHP so as to keep an order on every post, starting from 1 onwards, since 0 is the actual post. Making 1 top comments and 2 the children of 1 and so on.',
  `text` text NOT NULL COMMENT 'Comment text',
  `commentReplyLevel` tinyint(3) UNSIGNED NOT NULL COMMENT 'This value will be used to determine the style that must be used for the reply comment.',
  `commentReplyingTo` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Comment to which the current comment is acting as a reply.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table to keep record of replies.';

-- --------------------------------------------------------

--
-- Table structure for table `userposts`
--

CREATE TABLE `userposts` (
  `postPosterId` smallint(5) UNSIGNED NOT NULL COMMENT 'Id of the user who made the post',
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date on which the post was made',
  `postText` text COMMENT 'Text of the post',
  `postImage` text NOT NULL COMMENT 'Path to the image in the file system'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table to have the information of every post.';

--
-- Dumping data for table `userposts`
--

INSERT INTO `userposts` (`postPosterId`, `postDate`, `postText`, `postImage`) VALUES
(1, '2018-10-10 06:12:47', 'Hello there general.', ''),
(1, '2018-10-11 12:54:30', '', 'rwhertjnh'),
(1, '2018-10-11 12:54:34', '', 'rwhertjnh'),
(1, '2018-10-11 12:54:55', '', 'rwhertjnhaW43uhya3ewju4'),
(1, '2018-10-11 13:02:06', 'rwhertjnhaW43uhya3ewju4', ''),
(1, '2018-10-11 13:02:15', 'rwhertjnhaW43uhya3ewju4', ''),
(1, '2018-10-11 13:12:22', 'rwhertjnhaW43uhya3ewju4', ''),
(1, '2018-10-11 13:12:31', 'test1', ''),
(1, '2018-10-11 13:13:17', 'test2', ''),
(1, '2018-10-11 13:14:07', 'test2', ''),
(1, '2018-10-11 13:14:14', 'test3', ''),
(1, '2018-10-11 13:14:25', 'test3', 'test3'),
(1, '2018-10-11 14:02:59', 'test9', ''),
(1, '2018-10-13 14:05:14', 'jhbnrleinlrebnpep;', ''),
(1, '2018-10-13 14:05:32', 'Hello everyone How are3 you doing?', ''),
(2, '2018-10-09 07:00:00', 'Here I am everyone. Come get me.', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friendrelations`
--
ALTER TABLE `friendrelations`
  ADD PRIMARY KEY (`user1`,`user2`),
  ADD KEY `user2` (`user2`),
  ADD KEY `user1` (`user1`);

--
-- Indexes for table `useraccounts`
--
ALTER TABLE `useraccounts`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `userId` (`userId`);

--
-- Indexes for table `usercomments`
--
ALTER TABLE `usercomments`
  ADD PRIMARY KEY (`comentId`),
  ADD KEY `postPosterId` (`postPosterId`),
  ADD KEY `postDate` (`postDate`),
  ADD KEY `commentReplyingTo` (`commentReplyingTo`);

--
-- Indexes for table `userposts`
--
ALTER TABLE `userposts`
  ADD PRIMARY KEY (`postPosterId`,`postDate`),
  ADD KEY `postPosterId` (`postPosterId`),
  ADD KEY `postDate` (`postDate`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `useraccounts`
--
ALTER TABLE `useraccounts`
  MODIFY `userId` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User Id given in increasing order to allow for relations between tables', AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friendrelations`
--
ALTER TABLE `friendrelations`
  ADD CONSTRAINT `friendrelations_ibfk_1` FOREIGN KEY (`user1`) REFERENCES `useraccounts` (`userId`),
  ADD CONSTRAINT `friendrelations_ibfk_2` FOREIGN KEY (`user2`) REFERENCES `useraccounts` (`userId`);

--
-- Constraints for table `usercomments`
--
ALTER TABLE `usercomments`
  ADD CONSTRAINT `usercomments_ibfk_1` FOREIGN KEY (`postPosterId`) REFERENCES `userposts` (`postPosterId`),
  ADD CONSTRAINT `usercomments_ibfk_2` FOREIGN KEY (`commentReplyingTo`) REFERENCES `usercomments` (`comentId`);

--
-- Constraints for table `userposts`
--
ALTER TABLE `userposts`
  ADD CONSTRAINT `userposts_ibfk_1` FOREIGN KEY (`postPosterId`) REFERENCES `useraccounts` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
