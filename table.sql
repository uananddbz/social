-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2014 at 05:20 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `usay`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `f_list` varchar(255) NOT NULL,
  `r_list` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `country` varchar(25) NOT NULL,
  `address` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `about` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `fname`, `lname`, `f_list`, `r_list`, `dob`, `email`, `gender`, `country`, `address`, `occupation`, `about`) VALUES
(1, 'uananddbz', '123', 'utkarsh', 'anand', ',2,9,10', ',4,6', '1993-08-01', '', 'male', 'india', '', '', 'aab'),
(2, 'utkarshanand93', '123', 'sunny', 'anand', ',1', '', '2014-06-12', '', 'male', 'fdgdfgdf', 'gfdgfd', 'gfdg', 'dfgdfgfg'),
(3, 'test', '123', 'test first', 'test last', '', ',1', '0000-00-00', '', '', '', '', '', ''),
(4, 'test1', '123', 'test first', 'test last', '', '', '0000-00-00', '', '', '', '', '', ''),
(5, 'test2', '123', 'test first', 'test last', '', '', '0000-00-00', '', '', '', '', '', ''),
(6, 'amitkpr98', 'amitkapoor', 'Amit', 'Kapoor', '', ',1', '0000-00-00', '', '', '', '', '', ''),
(7, 'aa', '123', 'ff', 'll', '', '', '0000-00-00', '', '', '', '', '', ''),
(8, 'bb', 'aa', 'f', 'l', '', '', '0000-00-00', '', '', '', '', '', ''),
(9, 'Manas', 'anand', 'Manas', 'Anand', ',1', '', '0000-00-00', '', 'male', 'india', '', '', ''),
(10, 'hritik', '124124124', 'hrithik ', 'kapoor', ',1', '', '0000-00-00', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `uid`, `title`, `content`, `time`) VALUES
(2, 2, 'test 3', 'dfsdsf', '2014-05-26 13:59:58'),
(3, 9, 'hello', 'fdgdfgdfgfdg', '2014-06-02 07:22:14'),
(5, 10, 'fghfgh', 'fghfgh', '2014-06-15 11:07:22');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(255) NOT NULL,
  `lid` varchar(255) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `uid`, `lid`, `content`, `time`) VALUES
(6, 6, ',6,1', 'tyfgeherer', '2014-05-22 16:38:55'),
(21, 2, '', '1', '2014-05-26 20:10:13'),
(22, 2, ',1', '2', '2014-05-26 20:10:17'),
(23, 2, ',1', '3', '2014-05-26 20:10:22'),
(24, 2, ',1', '4', '2014-05-26 20:10:26'),
(25, 2, '', '5', '2014-05-26 20:10:31'),
(26, 2, '', '6', '2014-05-26 20:10:36'),
(27, 2, '', '7', '2014-05-26 20:10:41'),
(28, 2, ',2', '8', '2014-05-26 20:10:45'),
(29, 2, '', '9', '2014-05-26 20:10:49'),
(30, 2, ',1', '10', '2014-05-26 20:10:53'),
(31, 8, '', 'dfgfdgfg', '2014-05-27 09:56:05'),
(36, 2, '', 'new1', '2014-05-27 20:40:04'),
(37, 2, '', '1', '2014-05-27 20:45:30'),
(38, 2, '', '2', '2014-05-27 20:45:34'),
(39, 2, '', 'aa', '2014-05-27 20:46:22'),
(40, 2, ',1', 'asfsdfdsf', '2014-05-27 20:51:42'),
(41, 2, '', 'sdfdsf', '2014-05-27 20:51:45'),
(44, 2, '', 'sdsad', '2014-05-27 21:24:12'),
(45, 2, ',1', 'dsfdsf', '2014-05-27 21:24:17'),
(46, 2, '', 'dsfds', '2014-05-27 21:24:22'),
(47, 2, '', 'dsfdsfdsf', '2014-05-27 21:24:27'),
(48, 1, ',1', 'dsffdf', '2014-06-01 11:55:07'),
(49, 1, ',9', 'sdfsdf', '2014-06-01 11:55:12'),
(50, 2, ',2', 'sdfdf', '2014-06-01 16:30:15'),
(51, 9, ',1', 'jkjk', '2014-06-02 12:48:06'),
(52, 1, '', 'aaaa', '2014-06-05 20:03:16'),
(53, 1, ',1', 'bbb', '2014-06-05 20:32:11'),
(54, 1, ',1', 'ccc', '2014-06-05 20:32:41'),
(55, 1, '', 'ddd', '2014-06-05 20:35:20'),
(56, 1, ',1', 'eeee', '2014-06-05 20:37:34'),
(58, 10, ',10,1', 'helow guys\r\n', '2014-06-15 16:35:47');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
