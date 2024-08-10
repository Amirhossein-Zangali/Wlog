-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 11, 2024 at 10:08 AM
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
-- Database: `wlog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcat_id` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `subcat_id`, `created_at`, `updated_at`) VALUES
(1, 'تکنولوژی', 0, '2024-08-07 07:08:45', '2024-08-07 07:08:45'),
(2, 'سفر', 0, '2024-08-07 07:09:08', '2024-08-07 07:09:08'),
(3, 'ورزش', 0, '2024-08-07 07:09:20', '2024-08-07 07:09:20'),
(4, 'غذا و سلامت', 0, '2024-08-07 07:09:44', '2024-08-07 07:09:44'),
(5, 'آسیا', 2, '2024-08-07 07:11:02', '2024-08-07 07:11:02'),
(7, 'فوتبال', 3, '2024-08-07 07:11:34', '2024-08-11 12:15:00'),
(8, 'والیبال', 3, '2024-08-07 07:11:44', '2024-08-07 07:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `content`, `reply`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است', 0, 1, '2024-08-08 12:04:30', '2024-08-08 12:04:30'),
(2, 1, 1, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است', 1, 1, '2024-08-08 12:04:30', '2024-08-08 12:04:30'),
(3, 1, 5, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ', 0, 1, '2024-08-08 12:04:30', '2024-08-08 12:04:30'),
(12, 1, 7, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون', 0, 1, '2024-08-09 12:06:55', '2024-08-09 12:06:55'),
(13, 1, 6, 'لورم ایپسوم متن ساختگی', 2, 1, '2024-08-11 12:44:52', '2024-08-11 12:44:52'),
(14, 1, 7, 'لورم ایپسوم متن ساختگی و مجله در ستون و سطرآنچنان که لازم است', 3, 1, '2024-08-11 12:45:28', '2024-08-11 12:45:28'),
(15, 1, 8, 'با استفاده از طراحان گرافیک است', 14, 1, '2024-08-11 12:48:24', '2024-08-11 12:48:24'),
(16, 1, 5, 'ممنون', 12, 1, '2024-08-11 13:18:29', '2024-08-11 13:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comment_likes`
--

INSERT INTO `comment_likes` (`id`, `user_id`, `comment_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-08-08 12:18:04', '2024-08-08 12:18:04'),
(2, 5, 1, '2024-08-08 12:18:14', '2024-08-08 12:18:14'),
(12, 3, 1, '2024-08-08 22:36:49', '2024-08-08 22:36:49'),
(16, 3, 2, '2024-08-08 22:37:07', '2024-08-08 22:37:07'),
(19, 7, 8, '2024-08-09 12:04:29', '2024-08-09 12:04:29');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `des` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int NOT NULL,
  `view` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `thumbnail`, `des`, `category_id`, `view`, `created_at`, `updated_at`) VALUES
(1, 5, 'پیشرفت‌های جدید در هوش مصنوعی: از یادگیری عمیق تا کاربردهای عملی', 'ai_tech_1723364015.png', 'هوش مصنوعی (AI) با سرعتی شگفت‌انگیز در حال پیشرفت است و این تکنولوژی روز به روز بیشتر در زندگی روزمره ما نقش ایفا می‌کند. از یادگیری عمیق (Deep Learning) گرفته تا کاربردهای عملی در پزشکی، خودروسازی، و حتی هنر، AI قابلیت‌های بی‌پایانی دارد. اخیراً، پیشرفت‌های جدیدی در زمینه هوش مصنوعی صورت گرفته که شامل بهبود الگوریتم‌های یادگیری عمیق و توسعه سیستم‌های هوش مصنوعی است که می‌توانند وظایف پیچیده‌تری را با دقت بیشتری انجام دهند. این پیشرفت‌ها نه تنها به بهبود کیفیت زندگی کمک می‌کنند، بلکه فرصت‌های شغلی جدیدی نیز ایجاد می‌کنند و صنایع مختلف را متحول می‌سازند.', 1, 82, '2024-08-07 09:26:16', '2024-08-11 13:18:36'),
(2, 5, 'رشد گردشگری پایدار: راهکارهایی برای محافظت از منابع طبیعی در سفر', 'env_travel_1723364002.png', 'با افزایش آگاهی جهانی درباره تغییرات اقلیمی و اثرات منفی گردشگری بر محیط زیست، مفهوم گردشگری پایدار به یکی از مهم‌ترین موضوعات در صنعت سفر تبدیل شده است. هدف گردشگری پایدار این است که اثرات منفی گردشگری بر محیط زیست و فرهنگ‌های محلی را کاهش داده و در عین حال از منابع طبیعی و جوامع محلی حمایت کند.', 2, 3, '2024-08-07 09:30:29', '2024-08-11 11:45:26'),
(3, 5, 'موفقیت‌های درخشان تیم ملی والیبال ایران در مسابقات جهانی', 'walball_sport_1723363982.png', 'تیم ملی والیبال ایران در مسابقات جهانی امسال توانست با عملکردی چشمگیر و انگیزه‌ای بالا، به موفقیت‌های بزرگی دست یابد. این تیم با ترکیبی از بازیکنان جوان و باتجربه، و با هدایت مربیان حرفه‌ای، توانست رقبا را یکی پس از دیگری پشت سر بگذارد. عملکرد برجسته بازیکنان در حمله، دفاع، و هماهنگی تیمی، همگی نقش مهمی در دستیابی به این موفقیت‌ها داشتند. این پیروزی‌ها نه تنها برای تیم و کشور افتخارآمیز است، بلکه انگیزه‌ای برای نسل‌های جوان‌تر و ورزشکاران آینده نیز خواهد بود.', 8, 2, '2024-08-07 09:35:54', '2024-08-11 11:43:02'),
(4, 5, 'تغذیه سالم: راهی برای بهبود کیفیت زندگی', 'hel_food_1723363974.png', 'تغذیه سالم و متعادل نه تنها به بهبود سلامت جسمانی کمک می‌کند، بلکه می‌تواند کیفیت زندگی را بهبود بخشد و از بیماری‌های مزمن پیشگیری کند. متخصصان تغذیه توصیه می‌کنند که رژیم غذایی حاوی مقادیر مناسبی از میوه‌ها، سبزیجات، غلات کامل، پروتئین‌های سالم و چربی‌های مفید باشد. یکی از راه‌های ساده برای بهبود تغذیه، کاهش مصرف غذاهای فرآوری‌شده و افزایش مصرف غذاهای طبیعی و تازه است. همچنین، توجه به اندازه وعده‌ها و هیدراته نگه داشتن بدن با مصرف کافی آب نیز از اهمیت بالایی برخوردار است. با انتخاب‌های غذایی هوشمندانه، می‌توان انرژی و روحیه را بهبود بخشید و از زندگی سالم‌تری لذت برد.', 4, 4, '2024-08-07 09:39:37', '2024-08-11 11:42:54');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `user_id`, `post_id`, `created_at`, `updated_at`) VALUES
(1, 5, 4, '2024-08-07 10:29:18', '2024-08-07 10:29:18'),
(2, 3, 4, '2024-08-07 10:29:36', '2024-08-07 10:29:36'),
(3, 1, 4, '2024-08-07 10:29:39', '2024-08-07 10:29:39'),
(18, 9, 1, '2024-08-08 17:24:20', '2024-08-08 17:24:20'),
(20, 7, 3, '2024-08-09 12:14:31', '2024-08-09 12:14:31');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `created_at`, `updated_at`) VALUES
(1, 'ali@gmail.com', '2024-08-08 21:52:47', '2024-08-08 21:52:47'),
(4, 'reza@gmail.com', '2024-08-08 22:01:41', '2024-08-08 22:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'profile.png',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','writer','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `acc_lvl` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `avatar`, `username`, `password`, `email`, `role`, `acc_lvl`, `created_at`, `updated_at`) VALUES
(1, 'علی', 'profile.png', 'ali', '$2y$10$buxmmJV4S9H2DJt6MuCOdORJ1mxnJpm3tKsdB1w/tf9zi.G6fZRJa', 'ali@gmail.com', 'writer', 0, '2024-08-06 18:16:37', '2024-08-06 18:16:37'),
(3, 'رضا', 'profile.png', 'reza', '$2y$10$CahsndkF/U7WC7Vuzh.usOpbnaRX0czzhY3igJqcscI5G//NBihLa', 'reza@gmail.com', 'user', 0, '2024-08-06 18:18:35', '2024-08-06 18:18:35'),
(5, 'امیر', 'profile.png', 'amir', '$2y$10$W2N3XiZPZ9M.KUMOzA9LR.xumveMrtBK5muIHNSxeybYJfT8FZtIO', 'amir@gmail.com', 'admin', 0, '2024-08-06 18:27:03', '2024-08-11 13:36:19'),
(6, 'محمد', 'profile.png', 'mohammad', '$2y$10$eZziBSw0GaU2cR9JT2ZrVuMY/qyvy2jO22H9Gkqtv1et53cfp2JW.', 'mohammad@gmail.com', 'user', 0, '2024-08-08 09:49:40', '2024-08-08 09:49:40'),
(7, 'امید', 'profile.png', 'omid', '$2y$10$A0ixdqQIt8bQq8.n5nbGUOQ8V/nYZW9.ZGxexWgnttfdoU8MHp28C', 'omid@gmail.com', 'writer', 0, '2024-08-08 09:59:48', '2024-08-08 09:59:48'),
(8, 'حامد', 'profile.png', 'hamed', '$2y$10$BC.d7E.ER6zewjw0QlsH4e4Bwi1BloSiX.F2OXtRZrnUiL49fgqJq', 'hamed@gmail.com', 'user', 0, '2024-08-08 10:06:36', '2024-08-08 10:06:36'),
(9, 'حمید', 'profile.png', 'hamid', '$2y$10$EKCos34BtA2TBmGo3NtMNut1iq1lXsSeh8y/LOr7r71UfblWxSJU6', 'hamid@gmail.com', 'user', 0, '2024-08-08 10:22:30', '2024-08-11 13:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `post_id`, `user_ip`, `created_at`, `updated_at`) VALUES
(19, 1, '127.0.0.1', '2024-08-08 16:56:13', '2024-08-11 13:18:36'),
(20, 4, '127.0.0.1', '2024-08-08 17:01:46', '2024-08-09 21:17:39'),
(21, 3, '127.0.0.1', '2024-08-08 20:35:28', '2024-08-09 16:51:27'),
(22, 2, '127.0.0.1', '2024-08-08 20:52:42', '2024-08-09 16:51:33'),
(23, 1, '::1', '2024-08-09 11:03:48', '2024-08-09 11:07:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mobile` (`email`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
