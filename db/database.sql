-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 27, 2019 at 11:56 PM
-- Server version: 5.6.38
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `client`
--

-- --------------------------------------------------------

--
-- Table structure for table `databaseclient`
--

CREATE TABLE `databaseclient` (
  `ID` int(10) UNSIGNED NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `phoneNumber1` varchar(12) DEFAULT NULL,
  `phoneNumber2` varchar(12) DEFAULT NULL,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `databaseclient`
--
ALTER TABLE `databaseclient`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `databaseclient`
--
ALTER TABLE `databaseclient`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
