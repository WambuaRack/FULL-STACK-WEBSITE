-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2024 at 08:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loginassignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `first_name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `phone_no` int(11) NOT NULL,
  `gender` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`first_name`, `surname`, `phone_no`, `gender`, `email`, `password`) VALUES
('Shedrack', 'Nthenya', 2147483647, 'male', 'shedrackwambua40@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `resetpassword`
--

CREATE TABLE `resetpassword` (
  `email` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `DATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resetpassword`
--

INSERT INTO `resetpassword` (`email`, `code`, `DATE`) VALUES
('shedrackwambua40@gmail.com', 'E0hgiQ', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'ZKNmGI', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', '1Z5hDV', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'FLUoVq', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'Vg8vgp', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'cAjFt4', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'UOOnv5', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'u4vjiW', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'Tvoe3w', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', '0vI2MV', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'id1TTl', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'zW009m', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'Zf4fP0', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'EEkKPM', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'Kmn2x9', '2024-03-02 07:23:01'),
('shedrackwambua40@gmail.com', 'PwnaPY', '2024-03-02 07:23:01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
