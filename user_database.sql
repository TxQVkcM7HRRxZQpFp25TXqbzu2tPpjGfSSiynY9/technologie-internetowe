-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2024 at 11:49 PM
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
-- Database: `user_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `recommended` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `price`, `image_url`, `recommended`) VALUES
(1, 'Hiszpania', 499.00, 'https://wallpapers.com/images/featured/spain-j1g26le08m3c8fks.jpg', 1),
(2, 'Anglia', 1499.00, 'https://i.pinimg.com/originals/49/61/01/496101941c1ed4883e26c102a240fc9e.jpg', 1),
(3, 'Indie', 799.00, 'https://s1.1zoom.me/b5150/718/India_Temples_Fountains_Taj_Mahal_550854_1920x1080.jpg', 1),
(4, 'Francja', 1199.00, 'https://s1.1zoom.me/b8048/487/Sky_Evening_France_Eiffel_Tower_Paris_From_above_520603_1920x1080.jpg', 1),
(5, 'Grecja', 1999.00, 'https://wallpapers.com/images/featured/greece-uvj3x2nkk7sy1b84.jpg', 0),
(6, 'Malediwy', 1699.00, 'https://i.redd.it/m7fwb4orp0f11.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL DEFAULT current_timestamp(),
  `end_date` date NOT NULL DEFAULT current_timestamp(),
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `departure` varchar(255) NOT NULL,
  `inclusive` varchar(255) NOT NULL,
  `people` int(11) DEFAULT 1,
  `is_reserved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `country_id`, `name`, `start_date`, `end_date`, `price`, `image_url`, `location`, `duration`, `departure`, `inclusive`, `people`, `is_reserved`) VALUES
(11, 6, 'Hotel SBH Royal Monica', '2024-06-05', '2024-06-12', 2599.00, 'https://cdn.boutiquehotel.me/file/hotcdn/hotel/cover/6382919_1633010292.jpg', 'Malediwy, Maale', 7, 'Lotnisko Katowice, godz. 12.30', 'All inclusive', 3, 0),
(12, 5, 'Hotel Petra Mare', '2024-06-02', '2024-06-09', 2749.00, 'https://karolinka-karpacz.pl/wp-content/uploads/2016/12/11-1-1000x1000.jpg', 'Grecja, Kreta', 7, 'Lotnisko Poznań, godz. 13.00', 'All inclusive', 3, 0),
(14, 4, 'Hotel Paris Center', '2024-06-15', '2024-06-22', 3499.00, 'https://m.media-amazon.com/images/I/61v0sCjCwFL._AC_UF1000,1000_QL80_.jpg', 'Francja, Paryż', 7, 'Lotnisko Kraków, godz. 14.00', 'Tylko śniadania', 2, 0),
(15, 2, 'Hotel London Palace', '2024-06-20', '2024-06-27', 1899.00, 'https://cf.bstatic.com/xdata/images/hotel/max1280x900/276437729.jpg?k=5eff7727ccb925850bd6d8ffb848d1f195ab475e270b82e8d9d550e2773d2c8b&o=&hp=1', 'Anglia, Londyn', 7, 'Lotnisko Gdańsk, godz. 16.00', 'All inclusive', 1, 0),
(16, 3, 'Hotel Green Valley', '2024-06-25', '2024-07-02', 1599.00, 'https://warszawa.intercontinental.com/wp-content/uploads/2022/06/Standard-Room-1000x1000.jpg', 'Indie, Goa', 7, 'Lotnisko Katowice, godz. 13.30', 'All inclusive', 2, 1),
(19, 1, 'Hotel Costa del Sol', '2024-06-03', '2024-06-10', 2099.00, 'https://i.pinimg.com/736x/82/4e/4a/824e4aaae0a008c38decc49f9ad51596.jpg', 'Hiszpania, Costa del Sol', 7, 'Lotnisko Poznań, godz 18.00', 'All inclusive', 1, 0),
(20, 4, 'Hotel Eiffel Tower', '2024-06-12', '2024-06-19', 3999.00, 'https://hotelstyl70.pl/wp-content/uploads/2021/07/Hotel-Styl-70-Pszczyna-pokoj-jednoosobowy-deluxe-7-1-1000x1000.jpg', 'Francja, Paryż', 7, 'Lotnisko Katowice, godz 16.30', 'Tylko śniadania', 1, 0),
(21, 2, 'Hotel Buckingham', '2024-06-18', '2024-06-25', 2199.00, 'https://cf.bstatic.com/xdata/images/hotel/max1280x900/319432651.jpg?k=9b77b5c291b23932d30adcdf56e7818203f41de39cdade7a36cfccd01b1d04e6&o=&hp=1', 'Anglia, Londyn', 7, 'Lotnisko Wrocław, godz. 20.00', 'All inclusive', 2, 1),
(22, 3, 'Hotel Taj Mahal', '2024-06-22', '2024-06-29', 2899.00, 'https://hotelbas.pl/images/wyposazenie-pokoju-hotelowego-8754.jpg', 'Indie, Agra', 7, 'Lotnisko Gdańsk, godz 13.00', 'All inclusive', 2, 0),
(23, 5, 'Hotel Grecian Bay', '2024-06-15', '2024-06-22', 2899.00, 'https://karolinka-karpacz.pl/wp-content/uploads/2016/11/pokoj-studio-21-1000x1000.jpg', 'Grecja, Ateny', 7, 'Lotnisko Kraków, godz 15.30', '', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `hotel_id`, `reservation_date`) VALUES
(33, 12, 21, '2024-06-02 21:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `PASSWORD`, `created_at`, `first_name`, `last_name`) VALUES
(12, 'email@email.com', '$2y$10$EUX4iVNEspgAzhqQAR0iK.mUfBPAQMMJlifIxCRO2nTGO9OV21n8O', '2024-06-02 21:09:55', 'Imie', 'Nazwisko');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
