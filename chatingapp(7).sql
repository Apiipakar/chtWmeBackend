-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 03, 2024 at 08:27 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatingapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `profile_image` varchar(500) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `username`, `email`, `password`, `profile_image`) VALUES
(1, 'apiipakar mohamoud abdirahman', 'apiipakar', 'apiipakar@gmail.com', '1122', '');

-- --------------------------------------------------------

--
-- Table structure for table `conversation`
--

CREATE TABLE `conversation` (
  `id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_user` int NOT NULL,
  `participant_user1` int NOT NULL,
  `participant_user2` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversation`
--

INSERT INTO `conversation` (`id`, `created_at`, `created_user`, `participant_user1`, `participant_user2`) VALUES
(1, '2024-05-02 04:19:47', 1, 1, 11),
(2, '2024-05-02 15:00:15', 11, 11, 10),
(3, '2024-05-02 15:00:20', 11, 11, 10);

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE `friend` (
  `id` int NOT NULL,
  `user` int NOT NULL,
  `friendId` int NOT NULL,
  `isFriend` int DEFAULT '0',
  `isBlocked` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friend`
--

INSERT INTO `friend` (`id`, `user`, `friendId`, `isFriend`, `isBlocked`) VALUES
(1, 11, 1, 1, 0),
(2, 1, 2, 1, 0),
(3, 2, 1, 1, 0),
(4, 1, 9, 1, 0),
(5, 11, 10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `groupp`
--

CREATE TABLE `groupp` (
  `id` int NOT NULL,
  `group_name` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `created_user` int NOT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `firstMember` int NOT NULL,
  `profile_image` varchar(500) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_message`
--

CREATE TABLE `group_message` (
  `id` int NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imageTwo` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imageTree` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `group_id` int NOT NULL,
  `sender` int NOT NULL,
  `message_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int NOT NULL,
  `conversation_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message_content` text COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `seen` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `conversation_id`, `sender_id`, `receiver_id`, `message_content`, `image`, `sent_at`, `seen`) VALUES
(1, 1, 1, 11, 'Hi', NULL, '2024-05-02 04:19:47', 0),
(2, 1, 11, 1, 'Hi 2', NULL, '2024-05-02 12:25:06', 0),
(3, 1, 11, 1, 'iwrn shp', NULL, '2024-05-02 12:25:55', 0),
(4, 1, 1, 11, 'fcn', NULL, '2024-05-02 14:58:15', 0),
(5, 1, 1, 11, 'adiga sthy', NULL, '2024-05-02 14:59:30', 0),
(6, 2, 11, 10, 'hi', NULL, '2024-05-02 15:00:15', 0),
(7, 3, 11, 10, 'hi', NULL, '2024-05-02 15:00:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone_number` int NOT NULL,
  `date_Joined` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_image` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isOnline` int DEFAULT '0',
  `isBanned` int DEFAULT '0',
  `last_seen` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `bio` varchar(100) COLLATE utf8mb4_general_ci DEFAULT 'Bio',
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Private` int DEFAULT '0',
  `isDeleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `username`, `email`, `phone_number`, `date_Joined`, `profile_image`, `isOnline`, `isBanned`, `last_seen`, `bio`, `password`, `Private`, `isDeleted`) VALUES
(1, 'Apiipakar Mohamoud Abdirahman', 'Apiipakar', 'Apiipakar@gmail.com', 7789485, '2024-04-18 00:54:24', 'IMG-6630a7f186700PicsArt_04-14-05.48.58.jpg', 1, 0, '2024-05-03 20:07:17', 'Available', '$2y$10$R0hQADebaCsAvf.f4N1y6uFaeJGz3q0l5SHfhuKPmbwdFxksZQfaO', 0, 0),
(2, 'ahmed ali farah', 'ahmed', 'ahmed@gmail.com', 7787878, '2024-04-18 00:54:52', NULL, 1, 0, '2024-05-03 20:21:53', 'Bio', '$2y$10$/a4FUTcYO2/n2QpGC.6lMeKMj50muONet2Z/INOBHQf9Ee.vYlqBi', 0, 0),
(9, 'farah awil farah', 'farahAw', 'farahAw@gmail.com', 7002323, '2024-04-21 20:41:31', NULL, 0, 0, '2024-04-21 20:41:31', 'Bio', '$2y$10$0f0mmXLjQoFqx/DMKlUx3OOnXJaov8aXOKH3Sg28uAXNPHIc6G9G.', 0, 0),
(10, 'jama aw ali', 'jama', 'jamaAw@gmail.com', 7505050, '2024-04-21 20:50:42', 'IMG-6630b16a68ca0PicsArt_03-06-11.11.45.jpg', 0, 0, '2024-04-29 20:53:11', 'Bio', '$2y$10$j61VpvrCVrytlbKruWjR6.2RwEUIiGo9Yuukr3Mae0dwXy11zSN4G', 0, 0),
(11, 'mohamed abdirahman jaylaani', 'mohamed', 'mohamedJaylaani@gmial.com', 7723737, '2024-04-22 01:52:00', NULL, 0, 0, '2024-05-03 16:47:21', 'Bio', '$2y$10$Wwi7otiLmKWBKueahAtWR.SWaRT3Au3wueNBxdHTMujoL/VZ6XQ8e', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_conversation`
--

CREATE TABLE `user_conversation` (
  `id` int NOT NULL,
  `userId` int NOT NULL,
  `conversation_id` int NOT NULL,
  `isDeleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_conversation`
--

INSERT INTO `user_conversation` (`id`, `userId`, `conversation_id`, `isDeleted`) VALUES
(2, 1, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `createCovvUser` (`created_user`),
  ADD KEY `participatUserFk` (`participant_user1`),
  ADD KEY `particpateUserFk2` (`participant_user2`);

--
-- Indexes for table `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friendid` (`friendId`);

--
-- Indexes for table `groupp`
--
ALTER TABLE `groupp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `create_user_fk` (`created_user`),
  ADD KEY `firstMember_fk` (`firstMember`);

--
-- Indexes for table `group_message`
--
ALTER TABLE `group_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_fk` (`group_id`),
  ADD KEY `sender_gm_fk` (`sender`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkConv1` (`conversation_id`),
  ADD KEY `fkUser1` (`sender_id`),
  ADD KEY `receiverfk` (`receiver_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_conversation`
--
ALTER TABLE `user_conversation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conversation_id` (`conversation_id`),
  ADD KEY `CurrentUserConv` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `friend`
--
ALTER TABLE `friend`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `groupp`
--
ALTER TABLE `groupp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_message`
--
ALTER TABLE `group_message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_conversation`
--
ALTER TABLE `user_conversation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversation`
--
ALTER TABLE `conversation`
  ADD CONSTRAINT `createCovvUser` FOREIGN KEY (`created_user`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `participatUserFk` FOREIGN KEY (`participant_user1`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `particpateUserFk2` FOREIGN KEY (`participant_user2`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `freindIDFk` FOREIGN KEY (`friendId`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `friendid` FOREIGN KEY (`friendId`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `groupp`
--
ALTER TABLE `groupp`
  ADD CONSTRAINT `create_user_fk` FOREIGN KEY (`created_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `firstMember_fk` FOREIGN KEY (`firstMember`) REFERENCES `user` (`id`);

--
-- Constraints for table `group_message`
--
ALTER TABLE `group_message`
  ADD CONSTRAINT `group_fk` FOREIGN KEY (`group_id`) REFERENCES `groupp` (`id`),
  ADD CONSTRAINT `sender_gm_fk` FOREIGN KEY (`sender`) REFERENCES `user` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fkConv1` FOREIGN KEY (`conversation_id`) REFERENCES `conversation` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkUser1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `receiverfk` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_conversation`
--
ALTER TABLE `user_conversation`
  ADD CONSTRAINT `CurrentUserConv` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `userConvId` FOREIGN KEY (`conversation_id`) REFERENCES `conversation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
