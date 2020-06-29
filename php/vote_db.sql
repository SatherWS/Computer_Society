-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 28, 2020 at 08:36 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.11


--
-- Database: `vote_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `admin` varchar(30) NOT NULL,
  `topic` varchar(100) NOT NULL
);


-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `vote` varchar(8) NOT NULL,
  `client` varchar(35) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'Open' NOT NULL,
  FOREIGN KEY (`topic_id`) REFERENCES topics(`id`)
);


