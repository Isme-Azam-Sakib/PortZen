-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 12:24 PM
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
-- Table structure for table `certifications`
--

CREATE TABLE `certifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `portfolio_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `completion_year` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `freelance_projects`
--

CREATE TABLE `freelance_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `portfolio_id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `portfolio_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `caption` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `portfolio_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'gallery/sjVZJHguqLxFfRSmSib5RHTjMCs5LpUy0WDLkJP3.jpg', NULL, 0, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(2, 1, 'gallery/LAPrOeFO3FTWIgodj9IRhteRkvJ8x4qY0abUNSqd.jpg', NULL, 1, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(3, 1, 'gallery/zo3rXoE7SKTOdKqUrgVa0VBZ8Wi7LrB9fu1vB3op.jpg', NULL, 2, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(4, 1, 'gallery/PkSaYkHtkkDyrVbQLtFRH9BVTUsYYbKLgRqJ7VfN.jpg', NULL, 3, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(5, 1, 'gallery/aGg3vW9edpyafH0ZG4o1AG9tCtsNi7r9IB5yvmYB.jpg', NULL, 4, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(6, 1, 'gallery/0h7grxDu7UuO80RUybAGOAJcYrMdzfdQcwOqtev0.jpg', NULL, 5, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(7, 1, 'gallery/silkbgttpZFjlzocGvvLY3JzHb2WLLePq1MlJ5A0.jpg', NULL, 6, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(8, 1, 'gallery/9fCtxQUpnbimdsxfvZXWOMBjGX5GOVqSK99VAtyv.jpg', NULL, 7, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(9, 1, 'gallery/1nBviQUjPWXtPfyc8ECy7KDXVE4YScT4KVJ67uDG.jpg', NULL, 8, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(10, 1, 'gallery/fzZdtDcke0TIldWO8Dh3bWrvlBLiTdViLdUM7Phn.jpg', NULL, 9, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(11, 1, 'gallery/PUyudc76M6izeJYl09Qp5rjGFrQTNmV6IWOiii33.jpg', NULL, 10, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(12, 1, 'gallery/vIdziK7vyb5EQGEaM9wdV9IbFubw84qj8qbwwKRe.jpg', NULL, 11, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(13, 1, 'gallery/lUyDB14tJdzHzoF048gLq7VNkyW67s0SxqF5XnNj.jpg', NULL, 12, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(14, 1, 'gallery/fh5v2vEGL1h9DlQnlcSZLAHhBq2fbp4AGW3ncU8z.jpg', NULL, 13, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(15, 1, 'gallery/2ayr4DtdgFoqYor8QyAVonltTkhnqdTNLaqRRHku.jpg', NULL, 14, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(16, 1, 'gallery/3tCb7pgMaRAJu1TMUtvrktt71x9fRawN4jICblr4.jpg', NULL, 15, '2025-05-18 02:53:43', '2025-05-18 02:53:43'),
(17, 1, 'gallery/44QgVH4CxIRn8CBOhRYlACH9up3auXTAtCQXx7BV.jpg', NULL, 17, '2025-05-18 02:53:43', '2025-05-18 02:54:22'),
(18, 1, 'gallery/eWedte9ebGV6BHaV4UtRiP1D377m5fZaapPdz5iI.jpg', NULL, 18, '2025-05-18 02:53:43', '2025-05-18 02:54:22'),
(19, 1, 'gallery/x4Y1FLKp2Yh9piSinQrroiia24PhTm6aG2cAFBs2.jpg', NULL, 19, '2025-05-18 02:53:43', '2025-05-18 02:54:22'),
(20, 1, 'gallery/5PobMlkqN14xLMKTgKoOBeSzjKT5nlab8LpJSiSh.jpg', NULL, 20, '2025-05-18 02:53:43', '2025-05-18 02:54:22'),
(21, 1, 'gallery/qEi8aMGWDJny5Jaa7Omsf465ZNIOpl9xH4NI8OgL.jpg', NULL, 21, '2025-05-18 02:53:55', '2025-05-18 02:54:19'),
(22, 1, 'gallery/eGcLt90xRD3he3udLYtjXlKpIwM6ebanjBRPwIcn.jpg', NULL, 22, '2025-05-18 02:53:55', '2025-05-18 02:54:19'),
(23, 1, 'gallery/NZrTp4JvNpUgBU6RBMjA2Uh6rADlblbIkHvIATnC.jpg', NULL, 23, '2025-05-18 02:53:55', '2025-05-18 02:54:19'),
(24, 1, 'gallery/pkzJeqiExrqjLTLLCDA1pBPnTnhj7Ir2V1rBnAZt.jpg', NULL, 24, '2025-05-18 02:53:55', '2025-05-18 02:54:19'),
(25, 1, 'gallery/73tTy5Jeg9bWB9GB5jXZe3LEJh1fO4KTa6nwIZHw.jpg', NULL, 25, '2025-05-18 02:53:55', '2025-05-18 02:54:19'),
(26, 1, 'gallery/6kqsvuZvB2wqgJaBLe8x7bAasICREPMerNpC01VL.jpg', NULL, 16, '2025-05-18 02:54:14', '2025-05-18 02:54:22'),
(27, 1, 'gallery/Lfp8PWNItAit0jqiWsLqwpgNwGgrGTBUL8ViZe1e.jpg', NULL, 26, '2025-05-18 02:54:14', '2025-05-18 02:54:14'),
(28, 1, 'gallery/jk3fEXi20Bq5Aq7zQ9GotQeqQ52gqIelLcTl1X87.jpg', NULL, 27, '2025-05-18 02:54:14', '2025-05-18 02:54:14'),
(29, 1, 'gallery/AN3Il4pUYPCQIVBAq4zpjYYf60X8ZX7LmcUo6cPm.jpg', NULL, 28, '2025-05-18 04:15:16', '2025-05-18 04:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_22_053324_create_templates_table', 1),
(6, '2024_02_22_053325_create_portfolios_table', 1),
(7, '2024_02_22_083116_create_work_experiences_table', 1),
(8, '2024_02_22_083126_create_freelance_projects_table', 1),
(9, '2024_02_22_083130_create_certifications_table', 1),
(10, '2024_02_22_083135_create_portfolio_projects_table', 1),
(11, '2024_02_22_083139_create_testimonials_table', 1),
(12, '2024_02_23_000001_create_gallery_images_table', 1),
(13, '2024_05_18_074745_add_heading_color_to_portfolios_table', 1),
(14, '2025_04_14_185805_add_banner_image_to_portfolios_table', 1),
(15, '2025_05_18_080454_rename_order_to_sort_order_in_gallery_images', 1),
(16, '2025_05_18_082421_create_gallery_images_table', 1),
(17, '2025_05_18_090332_add_show_work_experience_to_portfolios_table', 2),
(18, '2025_05_18_092949_update_work_experiences_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 1, 3, 'Sakib\'s portfolio', 'Isme Azam Sakibb', 'Graphics Designer sasds', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nulla', 'profile-images/TRTeoAnSl4N1XdO44VOBh5RopTc7owe9KXtrIJ5F.png', NULL, '[\"Graphics designnn\",\"UI\\/UX\",\"Photoshop\",\"Illustrator\"]', '[\"Photoshop\"]', 'intermediate', 'sakib@gmail.com', '01711387474', 'https://www.facebook.com/', '[{\"platform\":\"twitter\",\"url\":\"https:\\/\\/www.facebook.com\\/\"}]', 1, '2025-05-18 02:49:01', '2025-05-18 04:21:41', '#000000');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_projects`
--

CREATE TABLE `portfolio_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `portfolio_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `project_url` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `technologies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`technologies`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `description`, `thumbnail`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'Modern Portfolio', 'A clean, modern portfolio template.', 'images/templates/ellesi1.png', 1, '2025-05-18 02:43:52', '2025-05-18 02:43:52');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `portfolio_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Isme Azam Sakib', 'sakib@gmail.com', NULL, '$2y$10$hltglMS8BkP5WMU7d.vt8OKEDy7e2Rpe7zfoBwCQNqSAu3wdyGI.W', NULL, '2025-05-18 02:44:50', '2025-05-18 02:44:50');

-- --------------------------------------------------------

--
-- Table structure for table `work_experiences`
--

CREATE TABLE `work_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `portfolio_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `responsibilities` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_experiences`
--

INSERT INTO `work_experiences` (`id`, `portfolio_id`, `company_name`, `job_title`, `start_date`, `end_date`, `is_current`, `responsibilities`, `location`, `created_at`, `updated_at`) VALUES
(1, 1, 'PiaraBazar', 'Graphics Designer', '2023-02-01', '2023-05-01', 0, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.', NULL, '2025-05-18 03:34:08', '2025-05-18 03:34:08'),
(2, 1, 'Mentors\'', 'UI/UX Designer', '2023-11-11', NULL, 1, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.', NULL, '2025-05-18 03:48:15', '2025-05-18 03:48:15'),
(4, 1, 'sdfsdf', 'UI/UX Designer', '2025-01-11', '2025-05-18', 0, NULL, NULL, '2025-05-18 04:15:30', '2025-05-18 04:15:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certifications`
--
ALTER TABLE `certifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certifications_portfolio_id_foreign` (`portfolio_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `freelance_projects`
--
ALTER TABLE `freelance_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freelance_projects_portfolio_id_foreign` (`portfolio_id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_images_portfolio_id_foreign` (`portfolio_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolios_user_id_foreign` (`user_id`),
  ADD KEY `portfolios_template_id_foreign` (`template_id`);

--
-- Indexes for table `portfolio_projects`
--
ALTER TABLE `portfolio_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolio_projects_portfolio_id_foreign` (`portfolio_id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testimonials_portfolio_id_foreign` (`portfolio_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `work_experiences`
--
ALTER TABLE `work_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_experiences_portfolio_id_foreign` (`portfolio_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certifications`
--
ALTER TABLE `certifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `freelance_projects`
--
ALTER TABLE `freelance_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `portfolio_projects`
--
ALTER TABLE `portfolio_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `work_experiences`
--
ALTER TABLE `work_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certifications`
--
ALTER TABLE `certifications`
  ADD CONSTRAINT `certifications_portfolio_id_foreign` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freelance_projects`
--
ALTER TABLE `freelance_projects`
  ADD CONSTRAINT `freelance_projects_portfolio_id_foreign` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `gallery_images_portfolio_id_foreign` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolios_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`),
  ADD CONSTRAINT `portfolios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `portfolio_projects`
--
ALTER TABLE `portfolio_projects`
  ADD CONSTRAINT `portfolio_projects_portfolio_id_foreign` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_portfolio_id_foreign` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_experiences`
--
ALTER TABLE `work_experiences`
  ADD CONSTRAINT `work_experiences_portfolio_id_foreign` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
