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
  `topic` varchar(100) NOT NULL,
  `status` varchar(20) DEFAULT 'Open' NOT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP
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
  FOREIGN KEY (`topic_id`) REFERENCES topics(`id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

create table users (
  id int primary key auto_increment not null,
  username varchar(50) unique not null,
  email varchar(60) unique not null,
  pswd varchar(255) not null,
  date_joined datetime default current_timestamp
);

