-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2022 at 08:50 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(5) NOT NULL DEFAULT 1,
  `androidToken` varchar(1000) DEFAULT NULL,
  `webToken` varchar(1000) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `image`, `position`, `status`, `androidToken`, `webToken`, `timestamp`) VALUES
(2, 'medical diary', 'akshay.matre19@vit.edu', '$2y$10$mj40jM/kQRLg2Y5scscBouzna/e5I2RxyJSeRhbWjdAMm5vhg.h86', '', 1, 1, 'dH4Eet0hSkuKJockoWpyFd:APA91bFb4gfziC8L4cfFTajtDcl2fvzcM3ZYgZAdrW4iZ035QjKvFlHo0HNWJlucfWInnp20M4FW0FNzzBc_BiUBsPGGQW3bfaUtoFwmgDXfclCaDgGxgmjk0SFjzPgU9N8znp-K2xEW', 'fhRFxVSRZNUxRF7YtU8WpM:APA91bHni2PfGObvP0oJrLKz4gGfTlft-DzKcimUj_EyaS9A-jfAKNDXFux0KSRAQG63BQstKZvmlDo-NN7D_I1XpEV3VHZDME6DnSuuw0NhbramlFbmM0sQPFRdRczYqEA-nJvbWtNy', '2022-05-30 01:23:11'),
(194, 'Samiksha Dhumal', 'samikshadhumal@gmail.com', '$2y$10$YaPKOJzmWfik7nh6VqteQ.JYBgTgCHjrMT7BdHMuYP1VFZdKoOIvG', '', 1, 1, 'fuH0llQAS7aC5D3Nf7Q_op:APA91bFFXJNQBR7hBOOgkkUnDV3-9qS0AF5AdpgtJv6De2fROwN9RJvCxJ0jHRYgBj-NZMDD6rh5CWgr3TLjL7APptX59iMBtzEX84COfabgOMVonPc2uTymDdIJAZMWO3MpS83-DLth', 'fhRFxVSRZNUxRF7YtU8WpM:APA91bELidEfQDJoGdGsQtPDL9UaX1Zmumjf64kX1B_iAxie6x870XUKvw9Um51HjowlaCPWhb_q6c2Ie50WFLHnIeEy_C75TIj-HDEZAfMqngp-8_I81acTqPPTqQbydU77mgbQol1d', '2022-05-30 01:23:59'),
(217, 'Akshay Matre', 'akshaymatre08@gmail.com', '$2y$10$hfxmwdCbmQG8Snwn8tUXaO5rQ2Sa.dBjJIJB3RetjqRsDs/mkTAhi', '', 3, 1, NULL, NULL, '2022-05-30 01:37:55'),
(218, 'Akshay Gade', 'akshaygade20@gmail.com', '$2y$10$SKQ2UwKZXIQe3E8x7qQdJuyVkABm7V3lG/KJnt9iMsCnY4PuRZqtW', '', 2, 1, NULL, NULL, '2022-05-30 01:35:52'),
(219, 'Bhagyashri Bagul', 'bhagyashri.bagul20@vit.edu', '$2y$10$ndV7K487X6M4EvyX/tjCneS7HgGGS4FKJ5KCjY.oJTHwaerffGDZm', '', 2, 1, NULL, NULL, '2022-05-30 01:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `created_at`) VALUES
(6, 'GlaxoSmithKline', '2022-03-19 21:15:39'),
(7, 'ciPLA', '2022-03-19 21:18:20'),
(8, 'LUPIN', '2022-03-19 21:18:27'),
(9, 'EMCURE', '2022-03-19 21:18:36'),
(10, 'CIPLA', '2022-03-19 21:20:59'),
(11, 'CIPLA', '2022-03-19 21:21:05');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `created_at`) VALUES
(6, 'HEALTHCARE', '2022-03-19 21:19:02'),
(7, 'DIABETES', '2022-03-19 21:19:07'),
(8, 'PERSONAL CARE', '2022-03-19 21:19:19');

-- --------------------------------------------------------

--
-- Table structure for table `creditors`
--

CREATE TABLE `creditors` (
  `creditorId` int(11) NOT NULL,
  `creditorName` varchar(50) NOT NULL,
  `creditorMobile` varchar(15) NOT NULL,
  `creditorAddress` varchar(700) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `creditpayments`
--

CREATE TABLE `creditpayments` (
  `paymentId` int(11) NOT NULL,
  `paymentMode` varchar(100) NOT NULL,
  `paymentDate` datetime NOT NULL,
  `paymentAmount` int(100) NOT NULL,
  `paymentReciever` int(200) NOT NULL,
  `creditId` int(100) NOT NULL,
  `creditorId` int(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `credits`
--

CREATE TABLE `credits` (
  `creditId` int(11) NOT NULL,
  `creditorId` int(44) NOT NULL,
  `salesId` varchar(500) NOT NULL,
  `creditDescription` varchar(1000) NOT NULL,
  `creditTime` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `seller_id` int(100) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_url` varchar(600) NOT NULL DEFAULT '',
  `total_amount` int(100) NOT NULL DEFAULT 0,
  `paid_amount` int(100) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `invoice_number`, `seller_id`, `invoice_date`, `invoice_url`, `total_amount`, `paid_amount`, `created_at`) VALUES
(10, 'STM10001', 5, '2022-03-20', '', 0, 0, '2022-03-19 21:50:57'),
(11, 'STM10002', 5, '2022-03-20', '', 0, 0, '2022-03-19 21:52:43'),
(12, 'STM10003', 5, '2022-03-20', '', 0, 0, '2022-03-20 10:50:29');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemId` int(11) NOT NULL,
  `itemName` varchar(60) NOT NULL,
  `itemDescription` varchar(1000) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemId`, `itemName`, `itemDescription`, `created_at`, `updated_at`) VALUES
(9, 'Augmentin 625 Duo Tablet', 'Amoxycillin (500mg) + Clavulanic Acid (125mg)', '2022-03-20 02:55:30', '2022-03-19 21:25:30'),
(10, 'Azithral 500 Tablet', 'Azithromycin (500mg)', '2022-03-20 02:56:07', '2022-03-19 21:26:07'),
(11, 'detol Handwash', '', '2022-05-29 15:03:11', '2022-05-29 09:33:11');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`, `created_at`) VALUES
(6, 'ALM1', '2022-03-19 21:19:50'),
(7, 'ALM2', '2022-03-19 21:19:58'),
(8, 'ALM3', '2022-03-19 21:20:02');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_amount` int(100) NOT NULL,
  `payment_receiver` int(200) NOT NULL,
  `invoice_number` varchar(200) NOT NULL,
  `seller_id` int(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(200) NOT NULL,
  `item_id` int(200) NOT NULL,
  `size_id` int(200) NOT NULL,
  `brand_id` int(200) NOT NULL,
  `product_price` int(200) NOT NULL,
  `product_quantity` int(200) NOT NULL,
  `location_id` int(200) NOT NULL,
  `product_manufacture` date NOT NULL,
  `product_expire` date NOT NULL,
  `barCode` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `item_id`, `size_id`, `brand_id`, `product_price`, `product_quantity`, `location_id`, `product_manufacture`, `product_expire`, `barCode`, `created_at`) VALUES
(9, 7, 10, 7, 10, 149, 10, 6, '2019-01-01', '2024-01-01', '12312532', '2022-03-19 21:26:16'),
(10, 7, 9, 7, 11, 149, 15, 6, '2019-01-01', '2022-06-01', '12312536', '2022-03-19 21:48:48'),
(11, 6, 10, 8, 9, 500, 10, 7, '2019-03-01', '2024-04-01', '12312567', '2022-03-19 21:27:19'),
(12, 8, 10, 7, 6, 100, 10, 8, '2019-04-01', '2024-02-01', '12312568', '2022-03-19 21:27:41'),
(13, 7, 9, 8, 10, 100, 20, 7, '2022-01-01', '2022-02-01', '', '2022-03-21 19:04:58'),
(14, 6, 10, 8, 9, 25, 10, 8, '2021-03-01', '2025-06-01', '12345678', '2022-05-29 09:10:41'),
(15, 8, 10, 9, 8, 100, 40, 8, '2021-01-01', '2022-06-01', '', '2022-05-29 09:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `products_record`
--

CREATE TABLE `products_record` (
  `product_id` int(11) NOT NULL,
  `category_id` int(200) NOT NULL,
  `item_id` int(200) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `size_id` int(200) NOT NULL,
  `brand_id` int(200) NOT NULL,
  `product_price` int(200) NOT NULL,
  `product_quantity` int(200) NOT NULL,
  `location_id` int(200) NOT NULL,
  `product_manufacture` date NOT NULL,
  `product_expire` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_record`
--

INSERT INTO `products_record` (`product_id`, `category_id`, `item_id`, `product_name`, `size_id`, `brand_id`, `product_price`, `product_quantity`, `location_id`, `product_manufacture`, `product_expire`, `created_at`) VALUES
(9, 7, 10, '', 7, 10, 149, 10, 6, '2019-01-01', '2024-01-01', '2022-03-19 21:26:16'),
(10, 7, 9, '', 7, 10, 149, 15, 6, '2019-01-01', '2024-01-01', '2022-03-19 21:26:50'),
(11, 6, 10, '', 8, 9, 500, 10, 7, '2019-03-01', '2024-04-01', '2022-03-19 21:27:19'),
(12, 8, 10, '', 7, 6, 100, 10, 8, '2019-04-01', '2024-02-01', '2022-03-19 21:27:41'),
(13, 7, 9, '', 8, 10, 100, 20, 7, '2022-01-01', '2022-02-01', '2022-03-21 19:04:58'),
(14, 6, 10, '', 8, 9, 25, 10, 8, '2021-03-01', '2025-06-01', '2022-05-29 09:10:41'),
(15, 8, 10, '', 9, 8, 100, 40, 8, '2021-01-01', '2022-06-01', '2022-05-29 09:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `quantities`
--

CREATE TABLE `quantities` (
  `quantity_id` int(11) NOT NULL,
  `quantity` int(200) NOT NULL,
  `product_id` int(200) NOT NULL,
  `size_id` int(200) NOT NULL,
  `brand_id` int(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `sellerId` int(11) NOT NULL,
  `sellerName` varchar(50) NOT NULL,
  `sellerEmail` varchar(50) NOT NULL,
  `sellerContact` varchar(12) NOT NULL,
  `sellerContact1` varchar(12) NOT NULL,
  `sellerImage` varchar(100) NOT NULL,
  `sellerAddress` varchar(1000) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`sellerId`, `sellerName`, `sellerEmail`, `sellerContact`, `sellerContact1`, `sellerImage`, `sellerAddress`, `createdAt`) VALUES
(5, 'akshay', 'akshaymatre0808@gmail.com', '7666739452', '', '', 'pune', '2022-03-19 21:50:44');

-- --------------------------------------------------------

--
-- Table structure for table `sellers_sells`
--

CREATE TABLE `sellers_sells` (
  `sellers_sell_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `product_id` int(200) NOT NULL,
  `sell_quantity` int(200) NOT NULL,
  `sell_discount` float NOT NULL DEFAULT 0,
  `sell_price` int(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sellers_sells`
--

INSERT INTO `sellers_sells` (`sellers_sell_id`, `seller_id`, `invoice_number`, `product_id`, `sell_quantity`, `sell_discount`, `sell_price`, `created_at`, `updated_at`) VALUES
(31, 5, 'STM10001', 9, 4, 30, 417, '2022-03-19 21:51:12', NULL),
(32, 5, 'STM10002', 12, 2, 10, 180, '2022-03-19 21:52:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sells`
--

CREATE TABLE `sells` (
  `sell_id` int(11) NOT NULL,
  `product_id` int(200) NOT NULL,
  `sell_quantity` int(200) NOT NULL,
  `sell_discount` int(200) NOT NULL DEFAULT 0,
  `sell_price` int(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sells`
--

INSERT INTO `sells` (`sell_id`, `product_id`, `sell_quantity`, `sell_discount`, `sell_price`, `created_at`, `updated_at`) VALUES
(134, 10, 5, 10, 671, '2022-03-19 21:28:44', NULL),
(135, 10, 1, 0, 149, '2022-03-19 21:45:44', NULL),
(136, 12, 1, 0, 100, '2022-03-19 21:46:13', NULL),
(137, 11, 1, 10, 450, '2022-03-20 11:06:12', NULL),
(138, 11, 2, 10, 900, '2022-03-21 13:52:30', NULL),
(140, 9, 1, 0, 149, '2022-03-21 19:02:39', NULL),
(141, 10, 1, 0, 149, '2022-03-27 13:45:03', NULL),
(143, 10, 1, 0, 149, '2022-04-06 12:11:56', NULL),
(144, 10, 1, 0, 149, '2022-04-06 12:33:42', NULL),
(145, 10, 1, 0, 149, '2022-04-06 12:39:13', NULL),
(146, 10, 1, 0, 149, '2022-04-26 11:53:39', NULL),
(147, 10, 1, 0, 149, '2022-04-27 15:37:48', NULL),
(148, 10, 1, 0, 149, '2022-04-30 03:50:38', NULL),
(149, 13, 1, 0, 100, '2022-04-30 03:51:35', NULL),
(150, 11, 1, 0, 500, '2022-04-30 03:52:32', NULL),
(151, 9, 1, 0, 149, '2022-05-01 15:26:13', NULL),
(152, 13, 1, 0, 100, '2022-05-02 07:11:40', NULL),
(153, 12, 1, 0, 100, '2022-05-02 07:14:35', NULL),
(154, 10, 1, 0, 149, '2022-05-23 07:22:52', NULL),
(155, 10, 1, 0, 149, '2022-05-29 09:06:22', NULL),
(156, 9, 1, 0, 149, '2022-05-29 09:07:26', NULL),
(157, 14, 1, 0, 25, '2022-05-29 09:18:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settingId` int(11) NOT NULL,
  `productNoticeCount` int(55) NOT NULL DEFAULT 8
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settingId`, `productNoticeCount`) VALUES
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(200) NOT NULL,
  `size_type` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_name`, `size_type`, `created_at`) VALUES
(7, '10 ML', 0, '2022-03-19 21:19:29'),
(8, '100 MG', 0, '2022-03-19 21:19:34'),
(9, '100 ML', 0, '2022-03-19 21:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `updateId` int(11) NOT NULL,
  `updateTitle` varchar(200) NOT NULL,
  `updateDescription` varchar(2000) NOT NULL,
  `updateVersion` float NOT NULL,
  `updateUrl` varchar(200) NOT NULL,
  `updateTimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`updateId`, `updateTitle`, `updateDescription`, `updateVersion`, `updateUrl`, `updateTimestamp`) VALUES
(1, 'Updated Released 1.3', 'Fixed Bugs', 1.3, 'https://www.youtube.com/channel/UCPCmuZrfxit5HyLFU6f6_nw/', '2021-07-18 20:09:45'),
(2, 'Updated Released 1.4', 'Fixed Bugs, And Improved User Interface', 1.4, 'https://www.youtube.com/channel/UCPCmuZrfxit5HyLFU6f6_nw/', '2021-07-18 20:09:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `creditors`
--
ALTER TABLE `creditors`
  ADD PRIMARY KEY (`creditorId`);

--
-- Indexes for table `creditpayments`
--
ALTER TABLE `creditpayments`
  ADD PRIMARY KEY (`paymentId`);

--
-- Indexes for table `credits`
--
ALTER TABLE `credits`
  ADD PRIMARY KEY (`creditId`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `products_record`
--
ALTER TABLE `products_record`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `quantities`
--
ALTER TABLE `quantities`
  ADD PRIMARY KEY (`quantity_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`sellerId`);

--
-- Indexes for table `sellers_sells`
--
ALTER TABLE `sellers_sells`
  ADD PRIMARY KEY (`sellers_sell_id`);

--
-- Indexes for table `sells`
--
ALTER TABLE `sells`
  ADD PRIMARY KEY (`sell_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settingId`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`updateId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `creditors`
--
ALTER TABLE `creditors`
  MODIFY `creditorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `creditpayments`
--
ALTER TABLE `creditpayments`
  MODIFY `paymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `credits`
--
ALTER TABLE `credits`
  MODIFY `creditId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products_record`
--
ALTER TABLE `products_record`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `quantities`
--
ALTER TABLE `quantities`
  MODIFY `quantity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `sellerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sellers_sells`
--
ALTER TABLE `sellers_sells`
  MODIFY `sellers_sell_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sells`
--
ALTER TABLE `sells`
  MODIFY `sell_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `updateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
