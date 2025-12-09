-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2025 at 03:41 PM
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
-- Database: `courty`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_court` int(11) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `duration_hours` varchar(50) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `link_qr` varchar(255) NOT NULL,
  `link_payment_prove` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `id_user`, `id_court`, `start_time`, `end_time`, `duration_hours`, `total_price`, `status`, `booking_date`, `link_qr`, `link_payment_prove`, `created_at`, `updated_at`) VALUES
(1, 4, 2, '12:00:00', '13:00:00', '1 Jam', 30000, 'Completed', '2025-11-26', 'assets/uploads/qrcodes/qr-1-1764162437.jpg', 'assets/uploads/payments/pay-1-1764162592.jpg', '2025-11-26 06:56:50', '2025-11-26 13:10:19'),
(2, 4, 1, '10:00:00', '11:00:00', '1 Jam', 60000, 'Ditolak: tanggal termasuk hari libur operasional', '2025-11-26', '', '', '2025-11-26 07:36:54', '2025-11-26 13:37:06'),
(3, 4, 1, '10:00:00', '11:00:00', '1 Jam', 60000, 'Ditolak: bukti pembayaran tidak valid/palsu', '2025-11-27', 'assets/uploads/qrcodes/qr-3-1764164270.jpg', 'assets/uploads/payments/pay-3-1764164285.jpg', '2025-11-26 07:37:32', '2025-11-26 13:38:25');

-- --------------------------------------------------------

--
-- Table structure for table `court`
--

CREATE TABLE `court` (
  `id_court` int(11) NOT NULL,
  `id_venue` int(11) DEFAULT NULL,
  `id_sport` int(11) DEFAULT NULL,
  `name` varchar(22) NOT NULL,
  `price_per_hour` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `court`
--

INSERT INTO `court` (`id_court`, `id_venue`, `id_sport`, `name`, `price_per_hour`, `description`, `profile_photo`) VALUES
(1, 1, 2, 'Lapangan A', '60000', 'ada mushola toilet dan ruang ganti yeah', 'assets/uploads/court_profiles/court-1-1763969200.jpg'),
(2, 1, 2, 'Lapangan B', '30000', 'Ada raket di langit', 'assets/uploads/court_profiles/court-1-1763969161.jpeg'),
(3, 2, 3, 'Lapangan', '50000', '1 hingga 2 meter, dengan luas 300 m^2', 'assets/uploads/court_profiles/court-2-1764064958.jpg'),
(4, 2, 2, 'lapangan', '60000', 'luas', 'assets/uploads/court_profiles/court-2-1764065027.jpeg'),
(5, 3, 5, 'lapangan', '100000', '40 x 70 m', 'assets/uploads/court_profiles/court-3-1764065341.jpg'),
(6, 4, 5, 'lapangan', '120000', '40 x 70 bonus 1 lt air mineral', 'assets/uploads/court_profiles/court-4-1764067561.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(11) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `id_court` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE `sport` (
  `id_sport` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sport`
--

INSERT INTO `sport` (`id_sport`, `name`) VALUES
(1, 'Futsal'),
(2, 'Badminton'),
(3, 'Renang'),
(4, 'Tennis'),
(5, 'Padel'),
(6, 'Basket'),
(7, 'Voli');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role` int(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `role`, `email`, `telp`, `password`) VALUES
(1, 'Admin', 1, 'admin@gmail.com', '0808832328', '$2y$10$f1T2UHjITtqG.FadqUfsL.Vvu5F6axHLSbJStaxMEJlvpJw6kTQVu'),
(2, 'furina', 0, 'furinaaaaaa@gmail.com', '0808832328', '$2y$10$198XnI6srErTJ2wU6a4eaeZahzCYYJ.395by01fip3Kd4gMpLxboO'),
(3, 'alif', 3, 'alif@gmail.com', '0808832328', '$2y$10$N2VIT2JqzETfQPSnDLhiw.Jx4ABHkOiTds8Fr6g.R3xwprMOfK5HS'),
(4, 'mahdi', 3, 'mahdi@gmail.com', '232342354', '$2y$10$hp2io6mYXD.RrPY1Vklfw.LD0gMRdX/DW4uMqTOtZfmxkyuR3kElC'),
(5, 'senoon', 3, 'senoon@gmail.com', '0808832328', '$2y$10$M/MiYZYlOwWH2R4sZZj7Oetw8C0mpKbQWjm5r0UIEk7TTcjDlk3xO'),
(6, 'Firman', 3, 'firman@gmail.com', '0808832328', '$2y$10$PYGpE1eywrr5Al.1yR4Au.x/6EhfVQfPhI7/IiH2hJGbNWH/w4QpO');

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `id_venue` int(11) NOT NULL,
  `link_profile_img` varchar(255) NOT NULL,
  `venue_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `bank_account` varchar(255) DEFAULT NULL,
  `maps_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `opening_time` varchar(50) DEFAULT NULL,
  `closing_time` varchar(50) DEFAULT NULL,
  `view_count` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`id_venue`, `link_profile_img`, `venue_name`, `address`, `bank_account`, `maps_url`, `description`, `opening_time`, `closing_time`, `view_count`, `id_user`) VALUES
(1, 'assets/uploads/venue_profiles/venue-3-1763887402.jpeg', 'GOR Bulan Sabit', 'jl. masa depan dia', '3.3232,103.242', 'https://maps.app.goo.gl/7HtDacazyS2B1hxGA', '5 lapangan badminton', '08:00', '20:00', 12, 3),
(2, 'assets/uploads/venue_profiles/venue-4-1763888300.jpeg', 'GOR YU AI', 'Jl. Imantaka', '3.3232,103.242', 'https://maps.app.goo.gl/7HtDacazyS2B1hxGA', 'buat renang gas kan', '08:00', '22:00', 4, 4),
(3, 'assets/uploads/venue_profiles/venue-5-1763969955.jpg', 'GOR Ye EnTe KTS', 'Jl. Raja Jawa Berkuasah', NULL, 'https://maps.app.goo.gl/7HtDacazyS2B1hxGA', 'Ada banyak lapangan padel', '08:00', '22:00', 4, 5),
(4, 'assets/uploads/venue_profiles/venue-6-1764067504.jpg', 'GOR Alam Sutra', 'Jl. Alam Sutra', NULL, 'https://maps.app.goo.gl/7HtDacazyS2B1hxGA', 'ada 2 lapangan padel dan kantin', '08:00', '22:00', 0, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_court` (`id_court`);

--
-- Indexes for table `court`
--
ALTER TABLE `court`
  ADD PRIMARY KEY (`id_court`),
  ADD KEY `id_venue` (`id_venue`);

--
-- Indexes for table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `id_court` (`id_court`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
  ADD PRIMARY KEY (`id_sport`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`id_venue`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `court`
--
ALTER TABLE `court`
  MODIFY `id_court` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sport`
--
ALTER TABLE `sport`
  MODIFY `id_sport` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `id_venue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`id_court`) REFERENCES `court` (`id_court`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `court`
--
ALTER TABLE `court`
  ADD CONSTRAINT `court_ibfk_1` FOREIGN KEY (`id_venue`) REFERENCES `venue` (`id_venue`);

--
-- Constraints for table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`id_court`) REFERENCES `court` (`id_court`);

--
-- Constraints for table `venue`
--
ALTER TABLE `venue`
  ADD CONSTRAINT `venue_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
