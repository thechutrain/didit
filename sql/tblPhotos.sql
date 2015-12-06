-- phpMyAdmin SQL Dump
-- version 4.2.9
-- http://www.phpmyadmin.net
--
-- Host: webdb.uvm.edu
-- Generation Time: Dec 06, 2015 at 03:47 PM
-- Server version: 5.5.45-37.4-log
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `AYCHU_ACTIVITIES`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblPhotos`
--

CREATE TABLE IF NOT EXISTS `tblPhotos` (
`pmkPhotoId` int(11) NOT NULL,
  `fnkActivityId` int(11) NOT NULL,
  `fnkNetId` varchar(12) NOT NULL,
  `fldCaption` varchar(256) NOT NULL,
  `fldApproved` tinyint(1) NOT NULL,
  `fldFileName` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblPhotos`
--

INSERT INTO `tblPhotos` (`pmkPhotoId`, `fnkActivityId`, `fnkNetId`, `fldCaption`, `fldApproved`, `fldFileName`) VALUES
(17, 9, 'aychu', 'testing again', 0, '9_9.jpg'),
(18, 9, 'aychu', 'testing again', 0, '9_10.jpg'),
(19, 9, 'aychu', 'testing again', 0, '9_11.jpg'),
(21, 0, 'aychu', 'la', 0, '0_0.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblPhotos`
--
ALTER TABLE `tblPhotos`
 ADD PRIMARY KEY (`pmkPhotoId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblPhotos`
--
ALTER TABLE `tblPhotos`
MODIFY `pmkPhotoId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
