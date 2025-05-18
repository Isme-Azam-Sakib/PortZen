-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 04:37 PM
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
-- Database: `portzen`
--

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `template_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skills`)),
  `tools` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tools`)),
  `experience_level` enum('beginner','intermediate','expert') NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `heading_color` varchar(255) DEFAULT '#ffffff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`id`, `user_id`, `template_id`, `title`, `full_name`, `tagline`, `bio`, `profile_image`, `banner_image`, `skills`, `tools`, `experience_level`, `email`, `phone`, `website_url`, `social_links`, `is_public`, `created_at`, `updated_at`, `heading_color`) VALUES
(1, 1, 3, 'Sakib\'s portfolio', 'Isme Azam Sakib', 'Graphics Designer', 'Lorem ipsum dolor sit Bmet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nulla', 'profile-images/TRTeoAnSl4N1XdO44VOBh5RopTc7owe9KXtrIJ5F.png', 'banner-images/6erdNAOw0CLiylzx0lTerD7gbcrm82UdqDQrW3mO.jpg', '[\"Graphics design\",\"UI\\/UX\",\"Photoshop\",\"Illustrator\",\"jmmn\"]', '[\"Photoshop\",\"Illustrator\",\"Canva\"]', 'intermediate', 'sakib@gmail.com', '01711387474', 'https://www.facebook.com/', '[{\"platform\":\"twitter\",\"url\":\"https:\\/\\/www.facebook.com\\/\"},{\"platform\":\"behance\",\"url\":\"https:\\/\\/www.facebook.com\\/\"},{\"platform\":\"dribbble\",\"url\":\"https:\\/\\/www.facebook.com\\/\"},{\"platform\":\"linkedin\",\"url\":\"https:\\/\\/www.facebook.com\\/\"},{\"platform\":\"instagram\",\"url\":\"https:\\/\\/www.facebook.com\\/\"}]', 1, '2025-05-18 02:49:01', '2025-05-18 08:06:16', '#000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolios_user_id_foreign` (`user_id`),
  ADD KEY `portfolios_template_id_foreign` (`template_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolios_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`),
  ADD CONSTRAINT `portfolios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
