-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2018 at 01:19 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verzcom2_dollar`
--

-- --------------------------------------------------------

--
-- Table structure for table `promotion_products`
--

CREATE TABLE `promotion_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_name` int(11) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `promotion_type_id` int(11) DEFAULT NULL,
  `formula_id` int(11) NOT NULL,
  `product_range` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `promotion_start` timestamp NULL DEFAULT NULL,
  `promotion_end` timestamp NULL DEFAULT NULL,
  `product_footer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ads_placement` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) DEFAULT NULL,
  `featured` tinyint(4) DEFAULT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotion_products`
--

INSERT INTO `promotion_products` (`id`, `product_name`, `bank_id`, `promotion_type_id`, `formula_id`, `product_range`, `promotion_start`, `promotion_end`, `product_footer`, `ads_placement`, `status`, `featured`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 2, 2, '[{\"min_range\":100,\"max_range\":200,\"bonus_rate\":1,\"board_rate\":2,\"total_interest\":1,\"prevailing_interest\":1},{\"min_range\":500,\"max_range\":1000,\"bonus_rate\":2,\"board_rate\":2,\"total_interest\":3,\"prevailing_interest\":1}]', '2018-04-30 18:30:00', '2018-06-29 18:30:00', '', NULL, 1, 0, 0, '2018-05-20 18:30:00', '2018-05-28 11:06:36'),
(2, 0, 6, 2, 3, '[{\"min_range\":100,\"max_range\":200,\"tenor\":3,\"bonus_rate\":1,\"board_rate\":2,\"total_interest\":1,\"prevailing_interest\":1},{\"min_range\":500,\"max_range\":1000,\"tenor\":3,\"bonus_rate\":2,\"board_rate\":2,\"total_interest\":3,\"prevailing_interest\":1}]', '2018-03-31 18:30:00', '2018-06-29 18:30:00', '', NULL, 1, 0, 0, '2018-05-20 18:30:00', '2018-05-28 11:00:33'),
(3, 0, 6, 2, 4, '{\"base_rate\":0.4,\"counter\":[0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1,1.1,1.2],\"average_bonus_interest\":2,\"sibor_rate\":2,\"min_placement\":100,\"max_placement\":50000}', '2018-04-30 18:30:00', '2018-07-19 18:30:00', '', NULL, 1, 0, 0, '2018-05-20 18:30:00', '2018-05-28 11:10:39'),
(4, 0, 6, 2, 5, '[{\"account_balance\":10000,\"base_interest\":0.5,\"bonus_interest\":0.55,\"total_interest\":0.6},{\"account_balance\":20000,\"base_interest\":0.8,\"bonus_interest\":0.72,\"total_interest\":0.8},{\"account_balance\":50000,\"base_interest\":0.9,\"bonus_interest\":0.8,\"total_interest\":0.89}]', '2018-04-30 18:30:00', '2018-06-14 18:30:00', '', NULL, 1, 0, 0, '2018-05-20 18:30:00', '2018-05-28 11:11:04'),
(5, 0, 4, 2, 6, '[{\"base_interest\":0.05,\"bonus_interest\":2,\"placement_month\":24,\"display_month\":[1,6,12,24],\"min_average_monthly_placement\":100,\"max_average_monthly_placement\":3000}]', '2018-04-30 18:30:00', '2018-06-29 18:30:00', '', NULL, 1, 0, 0, '2018-05-20 18:30:00', '2018-05-28 11:11:58'),
(6, 0, 7, 1, 6, '[{\"base_interest\":0.05,\"bonus_interest\":2,\"placement_month\":24,\"display_month\":[1,6,12,24],\"min_average_monthly_placement\":100,\"max_average_monthly_placement\":3000}]', '2018-05-09 18:30:00', '2018-06-24 18:30:00', '', '[{\"ad_image_horizontal\":\"uploads\\/products\\/feature-1.jpg\",\"ad_link_horizontal\":\"#\"},{\"ad_image_vertical\":\"uploads\\/products\\/feature-2.jpg\",\"ad_link_vertical\":\"#\"}]', 1, 0, 0, '2018-05-20 18:30:00', '2018-05-28 11:14:45'),
(7, 0, 7, 1, 1, '[{\"min_range\":100,\"max_range\":200,\"tenure_type\":2,\"tenure\":3,\"bonus_interest\":[1]}]', '2018-05-07 18:30:00', '2018-06-09 18:30:00', '', '[{\"ad_image_horizontal\":\"uploads\\/products\\/feature-1.jpg\",\"ad_link_horizontal\":\"#\"},{\"ad_image_vertical\":\"uploads\\/products\\/feature-2.jpg\",\"ad_link_vertical\":\"#\"}]', 1, 0, 0, '2018-05-20 18:30:00', '2018-05-28 11:15:20'),
(8, 0, 7, 1, 4, '{\"base_rate\":0.4,\"counter\":[0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1,1.1,1.2],\"average_bonus_interest\":2,\"sibor_rate\":2,\"min_placement\":100,\"max_placement\":10000}', '2018-04-30 18:30:00', '2018-07-30 18:30:00', '', NULL, 1, 0, 0, '2018-05-20 18:30:00', '2018-05-28 11:15:39'),
(9, 0, 7, 1, 1, '[{\"min_range\":100,\"max_range\":200,\"tenure_type\":2,\"tenure\":3,\"bonus_interest\":[1]}]', '2018-04-30 18:30:00', '2018-06-14 18:30:00', '', '[{\"ad_image_horizontal\":\"\",\"ad_link_horizontal\":\"#\"},{\"ad_image_vertical\":\"uploads\\/products\\/feature-2.jpg\",\"ad_link_vertical\":\"#\"}]', 1, 0, 0, '2018-05-20 18:30:00', '2018-05-28 11:32:48'),
(10, 0, 7, 1, 1, '[{\"min_range\":100,\"max_range\":200,\"tenure_type\":2,\"tenure\":3,\"bonus_interest\":[1,3,4]},{\"min_range\":201,\"max_range\":300,\"tenure_type\":2,\"tenure\":6,\"bonus_interest\":[2,2,3]},{\"min_range\":401,\"max_range\":500,\"tenure_type\":2,\"tenure\":9,\"bonus_interest\":[2,2,5]}]', '2018-04-30 18:30:00', '2018-06-29 18:30:00', '', NULL, 1, 0, 0, '2018-05-20 18:30:00', '2018-05-28 11:18:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `promotion_products`
--
ALTER TABLE `promotion_products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `promotion_products`
--
ALTER TABLE `promotion_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
