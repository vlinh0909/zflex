-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 22, 2018 lúc 03:36 PM
-- Phiên bản máy phục vụ: 10.1.22-MariaDB
-- Phiên bản PHP: 7.0.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `zflex`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_banned`
--

CREATE TABLE `zflex_banned` (
  `id` int(11) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_categories`
--

CREATE TABLE `zflex_categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `order_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_comment_shop`
--

CREATE TABLE `zflex_comment_shop` (
  `id` int(11) UNSIGNED NOT NULL,
  `customer` int(11) NOT NULL,
  `shop` int(11) NOT NULL,
  `rep_comment` int(11) NOT NULL,
  `content` text NOT NULL,
  `score` int(11) NOT NULL,
  `time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_customers`
--

CREATE TABLE `zflex_customers` (
  `id` int(11) UNSIGNED NOT NULL,
  `fb_id` varchar(100) NOT NULL,
  `fb_name` varchar(255) NOT NULL,
  `money` int(60) NOT NULL,
  `open_shop` int(1) NOT NULL,
  `is_block` int(1) NOT NULL,
  `time_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_history_rent`
--

CREATE TABLE `zflex_history_rent` (
  `id` int(11) UNSIGNED NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `boss` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `price` int(90) NOT NULL,
  `time` int(30) NOT NULL,
  `time_end` datetime NOT NULL,
  `rent_id` int(11) NOT NULL,
  `giahan_times` int(11) NOT NULL,
  `time_rent` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_members`
--

CREATE TABLE `zflex_members` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `permission` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `time_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `zflex_members`
--

INSERT INTO `zflex_members` (`id`, `email`, `username`, `password`, `fullname`, `permission`, `status`, `image`, `time_created`) VALUES
(1, 'vlinh12300@gmail.com', 'admin', '$2y$10$GV05awBuARtL3qD4Pe8/a.797I.YKYJQyrwswnYCyC3814wMOluFi', 'Admin', 6, 1, 'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg', '2017-12-16 14:50:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_menus`
--

CREATE TABLE `zflex_menus` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `data` longtext NOT NULL,
  `status` int(1) NOT NULL,
  `time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `zflex_menus`
--

INSERT INTO `zflex_menus` (`id`, `name`, `code`, `data`, `status`, `time_created`) VALUES
(1, 'Main Menu', 'main_menu', 'a:3:{i:0;O:8:\"stdClass\":5:{s:5:\"title\";s:11:\"Trang Chủ\";s:2:\"id\";s:4:\"home\";s:4:\"icon\";s:0:\"\";s:4:\"type\";s:10:\"categories\";s:6:\"target\";s:5:\"_self\";}i:1;O:8:\"stdClass\":5:{s:5:\"title\";s:10:\"Nạp Card\";s:2:\"id\";s:4:\"card\";s:4:\"icon\";s:0:\"\";s:4:\"type\";s:10:\"categories\";s:6:\"target\";s:5:\"_self\";}i:2;O:8:\"stdClass\":6:{s:5:\"title\";s:8:\"Facebook\";s:2:\"id\";i:0;s:3:\"url\";s:34:\"https://www.facebook.com/vulinh007\";s:4:\"icon\";s:0:\"\";s:4:\"type\";s:6:\"custom\";s:6:\"target\";s:6:\"_blank\";}}', 1, '2018-01-21 13:21:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_permissions`
--

CREATE TABLE `zflex_permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `zflex_permissions`
--

INSERT INTO `zflex_permissions` (`id`, `name`, `slug`, `role_id`) VALUES
(6, 'Super Administrator', 'super_adminstrator', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_rents`
--

CREATE TABLE `zflex_rents` (
  `id` int(11) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `description` text,
  `category` int(11) NOT NULL,
  `rent_times` int(11) NOT NULL,
  `sum_money` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `is_giahan` int(1) NOT NULL,
  `rent_time` text NOT NULL,
  `time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_report_rent`
--

CREATE TABLE `zflex_report_rent` (
  `id` int(11) UNSIGNED NOT NULL,
  `rent` int(11) NOT NULL,
  `shop` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `msg` text NOT NULL,
  `is_show` int(1) NOT NULL,
  `time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_report_shop`
--

CREATE TABLE `zflex_report_shop` (
  `id` int(11) UNSIGNED NOT NULL,
  `customer` int(11) NOT NULL,
  `shop` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` int(1) NOT NULL,
  `time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_roles`
--

CREATE TABLE `zflex_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `access` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `zflex_roles`
--

INSERT INTO `zflex_roles` (`id`, `name`, `slug`, `access`) VALUES
(1, 'Default', 'default', 'N;');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_shop`
--

CREATE TABLE `zflex_shop` (
  `id` int(11) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `url_facebook` varchar(255) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `stk_bank` varchar(100) DEFAULT NULL,
  `ctk_bank` varchar(100) DEFAULT NULL,
  `time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zflex_withdraw`
--

CREATE TABLE `zflex_withdraw` (
  `id` int(11) UNSIGNED NOT NULL,
  `customer` int(11) NOT NULL,
  `note` text,
  `is_send` int(1) NOT NULL,
  `money` int(100) NOT NULL,
  `time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `zflex_banned`
--
ALTER TABLE `zflex_banned`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_categories`
--
ALTER TABLE `zflex_categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_comment_shop`
--
ALTER TABLE `zflex_comment_shop`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_customers`
--
ALTER TABLE `zflex_customers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_history_rent`
--
ALTER TABLE `zflex_history_rent`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_members`
--
ALTER TABLE `zflex_members`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_menus`
--
ALTER TABLE `zflex_menus`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_permissions`
--
ALTER TABLE `zflex_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_rents`
--
ALTER TABLE `zflex_rents`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_report_rent`
--
ALTER TABLE `zflex_report_rent`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_report_shop`
--
ALTER TABLE `zflex_report_shop`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_roles`
--
ALTER TABLE `zflex_roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_shop`
--
ALTER TABLE `zflex_shop`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zflex_withdraw`
--
ALTER TABLE `zflex_withdraw`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `zflex_banned`
--
ALTER TABLE `zflex_banned`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT cho bảng `zflex_categories`
--
ALTER TABLE `zflex_categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT cho bảng `zflex_comment_shop`
--
ALTER TABLE `zflex_comment_shop`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT cho bảng `zflex_customers`
--
ALTER TABLE `zflex_customers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT cho bảng `zflex_history_rent`
--
ALTER TABLE `zflex_history_rent`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT cho bảng `zflex_members`
--
ALTER TABLE `zflex_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT cho bảng `zflex_menus`
--
ALTER TABLE `zflex_menus`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT cho bảng `zflex_permissions`
--
ALTER TABLE `zflex_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT cho bảng `zflex_rents`
--
ALTER TABLE `zflex_rents`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT cho bảng `zflex_report_rent`
--
ALTER TABLE `zflex_report_rent`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT cho bảng `zflex_report_shop`
--
ALTER TABLE `zflex_report_shop`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT cho bảng `zflex_roles`
--
ALTER TABLE `zflex_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT cho bảng `zflex_shop`
--
ALTER TABLE `zflex_shop`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT cho bảng `zflex_withdraw`
--
ALTER TABLE `zflex_withdraw`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
