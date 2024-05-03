-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 10:45 AM
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
-- Database: `chatingapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(16) NOT NULL,
  `profile_image` varchar(500) NOT NULL
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
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_user` int(11) NOT NULL,
  `participant_user1` int(11) NOT NULL,
  `participant_user2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE `friend` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `friendId` int(11) NOT NULL,
  `isFriend` int(11) DEFAULT 0,
  `isBlocked` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friend`
--

INSERT INTO `friend` (`id`, `user`, `friendId`, `isFriend`, `isBlocked`) VALUES
(1, 11, 1, 1, 0),
(2, 1, 2, 1, 0),
(3, 2, 1, 1, 0),
(4, 1, 9, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `groupp`
--

CREATE TABLE `groupp` (
  `id` int(11) NOT NULL,
  `group_name` varchar(200) NOT NULL,
  `created_user` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `firstMember` int(11) NOT NULL,
  `profile_image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_message`
--

CREATE TABLE `group_message` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `image` varchar(500) DEFAULT NULL,
  `imageTwo` varchar(500) DEFAULT NULL,
  `imageTree` varchar(500) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `message_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_content` text NOT NULL,
  `image` varchar(500) DEFAULT NULL,
  `image_two` varchar(500) DEFAULT NULL,
  `image_three` varchar(500) DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT current_timestamp(),
  `seen` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` int(10) NOT NULL,
  `date_Joined` timestamp NULL DEFAULT current_timestamp(),
  `profile_image` varchar(500) DEFAULT NULL,
  `isOnline` int(11) DEFAULT 0,
  `isBanned` int(11) DEFAULT 0,
  `last_seen` timestamp NULL DEFAULT current_timestamp(),
  `bio` varchar(100) DEFAULT 'Bio',
  `password` varchar(255) NOT NULL,
  `Private` int(11) DEFAULT 0,
  `isDeleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `username`, `email`, `phone_number`, `date_Joined`, `profile_image`, `isOnline`, `isBanned`, `last_seen`, `bio`, `password`, `Private`, `isDeleted`) VALUES
(1, 'apiipakar mohamoud abdirahman', 'apiipakar', 'apiipakar@gmail.com', 7789485, '2024-04-18 00:54:24', 'IMG-6630a7f186700PicsArt_04-14-05.48.58.jpg', 1, 0, '2024-04-29 20:31:06', 'Bio', '$2y$10$R0hQADebaCsAvf.f4N1y6uFaeJGz3q0l5SHfhuKPmbwdFxksZQfaO', 0, 0),
(2, 'ahmed ali farah', 'ahmed', 'ahmed@gmail.com', 7787878, '2024-04-18 00:54:52', NULL, 0, 0, '2024-04-28 20:26:32', 'Bio', '$2y$10$b.7DD/z7qRkRyzgHx8Vx0.5xac0skSq0yZ938kr7034dMwp1A6Eda', 0, 0),
(9, 'farah awil farah', 'farahAw', 'farahAw@gmail.com', 7002323, '2024-04-21 20:41:31', NULL, 0, 0, '2024-04-21 20:41:31', 'Bio', '$2y$10$0f0mmXLjQoFqx/DMKlUx3OOnXJaov8aXOKH3Sg28uAXNPHIc6G9G.', 0, 0),
(10, 'jama aw ali', 'jama', 'jamaAw@gmail.com', 7505050, '2024-04-21 20:50:42', NULL, 0, 0, '2024-04-21 20:50:42', 'Bio', '$2y$10$axgV1Ycs5nEVGBKUrv98hOINk7KQFbPvQiOdNlLiaefLVhS.QwNfy', 0, 0),
(11, 'mohamed abdirahman jaylaani', 'mohamed', 'mohamedJaylaani@gmial.com', 7723737, '2024-04-22 01:52:00', NULL, 0, 0, '2024-04-29 20:32:27', 'Bio', '$2y$10$Wwi7otiLmKWBKueahAtWR.SWaRT3Au3wueNBxdHTMujoL/VZ6XQ8e', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_conversation`
--

CREATE TABLE `user_conversation` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `isDeleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD UNIQUE KEY `conversation_id` (`conversation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friend`
--
ALTER TABLE `friend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `groupp`
--
ALTER TABLE `groupp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_message`
--
ALTER TABLE `group_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_conversation`
--
ALTER TABLE `user_conversation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversation`
--
ALTER TABLE `conversation`
  ADD CONSTRAINT `createCovvUser` FOREIGN KEY (`created_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `participatUserFk` FOREIGN KEY (`participant_user1`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `particpateUserFk2` FOREIGN KEY (`participant_user2`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `freindIDFk` FOREIGN KEY (`friendId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `friendid` FOREIGN KEY (`friendId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fkConv1` FOREIGN KEY (`conversation_id`) REFERENCES `conversation` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fkUser1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `receiverfk` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_conversation`
--
ALTER TABLE `user_conversation`
  ADD CONSTRAINT `userConvId` FOREIGN KEY (`conversation_id`) REFERENCES `conversation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
