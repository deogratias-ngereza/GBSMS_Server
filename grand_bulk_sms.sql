-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2019 at 12:30 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grand_bulk_sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_accounts`
--

CREATE TABLE `customer_accounts` (
  `id` int(11) NOT NULL,
  `code` varchar(45) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone_no` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `password` varchar(120) DEFAULT '$2a$10$OQ3xEhwgXdtO8/ucDNUTpeAwvtuMHQ6v/.qIRX0vxUt0odFXhIrrC',
  `profile_pic` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `api_key` varchar(300) NOT NULL,
  `sms_quota` int(11) NOT NULL DEFAULT '100',
  `sms_gqaccount_no` varchar(45) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `suspended` int(11) NOT NULL DEFAULT '0',
  `sms_chunk_capacity` int(11) NOT NULL DEFAULT '50'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_accounts`
--

INSERT INTO `customer_accounts` (`id`, `code`, `username`, `email`, `phone_no`, `address`, `password`, `profile_pic`, `created_at`, `api_key`, `sms_quota`, `sms_gqaccount_no`, `deleted`, `suspended`, `sms_chunk_capacity`) VALUES
(1, 'x', 'Benjamin', 'komba.benjamin313@gmail.com', '+255684983533', 'Mbezi Beach', '$2a$10$OQ3xEhwgXdtO8/ucDNUTpeAwvtuMHQ6v/.qIRX0vxUt0odFXhIrrC', 'ben.jpg', '2019-01-22 21:00:00', '', 100, '', 0, 0, 50),
(2, '1001', 'Grand Master', 'grand123grand1@gmail.com', '255688059688', 'Mbezi Beach', '$2a$10$OQ3xEhwgXdtO8/ucDNUTpeAwvtuMHQ6v/.qIRX0vxUt0odFXhIrrC', NULL, '2019-01-22 21:00:00', '$2a$10$OQ3xEhwgXdtO8/ucDNUTpeAwvtuMHQ6v/.qIRX0vxUt0odFXhIrrC', 100, '', 0, 0, 50),
(3, '100001', 'Hassan', 'hassan@gmail.com', '255000000', 'HASSAN', '$2a$10$OQ3xEhwgXdtO8/ucDNUTpeAwvtuMHQ6v/.qIRX0vxUt0odFXhIrrC', NULL, '2019-09-07 13:22:07', '$2a$10$OQ3xEhwgXdtO8/ucDNUTpeAwvtuMHQ6v/.qIRX0vxUt0odFXhIrrC', 6, 'GMANDR01', 0, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sms_contacts_has_groups`
--

CREATE TABLE `sms_contacts_has_groups` (
  `id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_contacts_has_groups`
--

INSERT INTO `sms_contacts_has_groups` (`id`, `contact_id`, `group_id`, `created_at`) VALUES
(1, 1, 1, '2019-09-01 18:36:23'),
(2, 1, 2, '2019-09-01 18:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `sms_contacts_list`
--

CREATE TABLE `sms_contacts_list` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `phone_no` varchar(45) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_contacts_list`
--

INSERT INTO `sms_contacts_list` (`id`, `customer_id`, `phone_no`, `name`, `email`, `created_date`, `deleted`) VALUES
(1, 2, '+255684983533', 'Benjamin', NULL, '2019-01-22 21:00:00', 0),
(2, 2, '255788449030', 'Grand 2', NULL, '2019-01-22 21:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sms_drafts`
--

CREATE TABLE `sms_drafts` (
  `id` int(11) NOT NULL,
  `sms_body` varchar(320) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `is_contact_saved` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sms_groups`
--

CREATE TABLE `sms_groups` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `group_name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `color` varchar(45) NOT NULL DEFAULT 'gray'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_groups`
--

INSERT INTO `sms_groups` (`id`, `customer_id`, `group_name`, `created_at`, `deleted`, `color`) VALUES
(1, 2, 'GEEKS', '2019-01-22 21:00:00', 0, '#0000ff'),
(2, 2, 'ADMINS', NULL, 0, '#ff8040'),
(3, 2, 'T1', NULL, 0, 'gray'),
(4, 2, 'T2', NULL, 0, '#00ff00'),
(5, 2, 't3', NULL, 0, '#eb94d2');

-- --------------------------------------------------------

--
-- Table structure for table `sms_histories`
--

CREATE TABLE `sms_histories` (
  `id` int(11) NOT NULL,
  `sms_inc_id` int(11) NOT NULL,
  `sms_out_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_histories`
--

INSERT INTO `sms_histories` (`id`, `sms_inc_id`, `sms_out_id`, `created_at`) VALUES
(1, 5, 0, '2019-01-23 15:50:39'),
(2, 6, 0, '2019-01-23 15:57:49'),
(3, 7, 0, '2019-01-23 19:26:53'),
(4, 8, 0, '2019-01-24 11:21:00'),
(5, 9, 0, '2019-01-24 11:26:13');

-- --------------------------------------------------------

--
-- Table structure for table `sms_incomings`
--

CREATE TABLE `sms_incomings` (
  `id` int(11) NOT NULL,
  `sms_body` varchar(320) DEFAULT NULL,
  `received_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `received_time` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT 'RECEIVED',
  `contact_phone` varchar(45) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `is_contact_saved` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_incomings`
--

INSERT INTO `sms_incomings` (`id`, `sms_body`, `received_at`, `received_time`, `status`, `contact_phone`, `contact_id`, `is_contact_saved`, `customer_id`) VALUES
(1, 'hello there', '2019-01-23 15:36:14', '1548257774042', 'RECEIVED', '255788449030', -1, 0, 2),
(2, 'hello there', '2019-01-23 15:38:27', '1548257907633', 'RECEIVED', '255788449030', 2, 1, 2),
(3, 'hello there', '2019-01-23 15:45:57', '1548258357644', 'RECEIVED', '255788449030', 2, 1, 2),
(4, 'hello there', '2019-01-23 15:47:04', '1548258424144', 'RECEIVED', '255788449030', 2, 1, 2),
(5, 'hello there', '2019-01-23 15:50:39', '1548258639832', 'RECEIVED', '255788449030', 2, 1, 2),
(6, 'hello benjamin', '2019-01-23 15:57:49', '1548259069332', 'RECEIVED', '255788449030', 2, 1, 2),
(7, 'Hey', '2019-01-23 19:26:53', '1548271613099', 'RECEIVED', '255788449030', 2, 1, 2),
(8, 'GrandMaster', '2019-01-24 11:21:00', '1548328859982', 'RECEIVED', '255788449030', 2, 1, 2),
(9, 'Hello there', '2019-01-24 11:26:13', '1548329173126', 'RECEIVED', '255788449030', 2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sms_outgoings`
--

CREATE TABLE `sms_outgoings` (
  `id` int(11) NOT NULL,
  `sms_body` varchar(320) DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `sent_date` date NOT NULL,
  `sent_time` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT 'DELIVERY_QUEUE',
  `contact_phone` varchar(45) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `is_contact_saved` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT NULL,
  `sys_ref` varchar(120) NOT NULL,
  `app_ref` varchar(120) NOT NULL,
  `api_ref` varchar(120) NOT NULL,
  `created_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gq_sms_acc_no` varchar(45) NOT NULL,
  `batch_id` varchar(120) NOT NULL,
  `sms_text_length` int(11) NOT NULL DEFAULT '0',
  `sender_name` varchar(45) NOT NULL,
  `sms_units` int(11) NOT NULL DEFAULT '1',
  `response_type` varchar(45) NOT NULL,
  `response_info` varchar(320) NOT NULL,
  `error_info` varchar(320) NOT NULL,
  `queued_date` date NOT NULL,
  `queued_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_outgoings`
--

INSERT INTO `sms_outgoings` (`id`, `sms_body`, `sent_at`, `sent_date`, `sent_time`, `status`, `contact_phone`, `contact_id`, `is_contact_saved`, `customer_id`, `sys_ref`, `app_ref`, `api_ref`, `created_date`, `created_at`, `gq_sms_acc_no`, `batch_id`, `sms_text_length`, `sender_name`, `sms_units`, `response_type`, `response_info`, `error_info`, `queued_date`, `queued_at`) VALUES
(1, 'Hellow there \nhow are you doing.\nThanks ', NULL, '0000-00-00', NULL, 'DELIVERY_QUEUE', '+255788449030', NULL, 0, 3, '07092019172933306', '', '', '2019-09-07', '2019-09-07 14:29:33', 'HASSANBL01', '', 1, '', 1, '', '', '', '2019-09-07', '2019-09-07 14:29:33'),
(2, 'Hellow there \nhow are you doing.\nThanks ', NULL, '0000-00-00', NULL, 'DELIVERY_QUEUE', '+255688059688', NULL, 0, 3, '07092019173011880', '', '', '2019-09-07', '2019-09-07 14:30:11', 'HASSANBL01', '', 1, '', 1, '', '', '', '2019-09-07', '2019-09-07 14:30:11'),
(3, 'GMTech Test sms ', '2019-09-07 18:11:39', '2019-09-07', '18:11:39', 'SENT', '+255688059688', NULL, 0, 3, '07092019180548456', '', '', '2019-09-07', '2019-09-07 15:05:48', 'HASSANBL01', '', 1, '', 1, 'SENT', 'Successful - Msg Sent', '', '2019-09-07', '2019-09-07 15:05:48'),
(4, 'GMTech Test sms ', '2019-09-07 18:13:30', '2019-09-07', '18:13:30', 'SENT', '+255688059688', NULL, 0, 3, '07092019181326553', '', '', '2019-09-07', '2019-09-07 15:13:27', 'HASSANBL01', '', 1, '', 1, 'SENT', 'Successful - Msg Sent', '', '2019-09-07', '2019-09-07 15:13:27'),
(5, 'Awesome moments ', '2019-09-07 18:28:59', '2019-09-07', '18:28:59', 'SENT', '+255688059688', NULL, 0, 3, '07092019182855157', '', '', '2019-09-07', '2019-09-07 15:28:55', 'HASSANBL01', '', 1, '', 1, 'SENT', 'Successful - Msg Sent', '', '2019-09-07', '2019-09-07 15:28:55'),
(6, 'Awesome moments ', '2019-09-07 18:30:27', '2019-09-07', '18:30:27', NULL, '+255688059688', NULL, 0, 3, '07092019183027762', '', '', '2019-09-07', '2019-09-07 15:30:27', 'HASSANBL01x', '', 1, '', 1, '', '', '', '2019-09-07', '2019-09-07 15:30:27'),
(7, 'Awesome moments ', '2019-09-07 17:38:00', '2019-09-07', '17:38:00', 'ERROR', '+255688059688', NULL, 0, 3, '07092019183759227', '', '', '2019-09-07', '2019-09-07 15:37:59', 'HASSANBL01x', '', 1, '', 1, 'ERROR', 'ACC-ERROR:INVALID-ACCOUNT', 'ACC-ERROR:INVALID-ACCOUNT', '2019-09-07', '2019-09-07 15:37:59'),
(8, 'Awesome ', '2019-09-07 18:40:27', '2019-09-07', '18:40:27', 'SENT', '+255688059688', NULL, 0, 3, '07092019184025314', '', '', '2019-09-07', '2019-09-07 15:40:25', 'HASSANBL01', '', 1, '', 1, 'SENT', 'Successful - Msg Sent', '', '2019-09-07', '2019-09-07 15:40:25'),
(9, 'Awesome ', '2019-09-07 18:41:33', '2019-09-07', '18:41:33', 'SENT', '+255688059688', NULL, 0, 3, '07092019184132758', '', '', '2019-09-07', '2019-09-07 15:41:32', 'HASSANBL01', '', 1, '', 1, 'SENT', 'Successful - Msg Sent', '', '2019-09-07', '2019-09-07 15:41:32'),
(16, 'Hi GmTech Bulky', '2019-09-08 02:25:35', '2019-09-08', '02:25:35', 'SENT', 'BULKY', NULL, 0, 3, '12180108092019WMQ2612', '', '', '2019-09-08', '2019-09-07 22:18:12', 'HASSANBL01', '12180108092019WMQ2612', 15, 'info', 3, 'SENT', 'SENT', '', '2019-09-08', '2019-09-07 22:18:12'),
(17, 'Hi GmTech Bulky', '2019-09-08 02:25:36', '2019-09-08', '02:25:36', 'SENT', 'BULKY', NULL, 0, 3, '382303080920194IE6MD2', '', '', '2019-09-08', '2019-09-08 00:23:38', 'HASSANBL01', '382303080920194IE6MD2', 15, 'info', 3, 'SENT', 'SENT', '', '2019-09-08', '2019-09-08 00:23:38'),
(18, 'Hi GmTech Bulky', '2019-09-08 15:21:08', '2019-09-08', '15:21:08', 'BULKY', 'BULKY', NULL, 0, 3, '19410308092019QNH34G1', '', '', '2019-09-08', '2019-09-08 00:41:19', 'HASSANBL01', '19410308092019QNH34G1', 15, 'info', 3, 'BULKY', 'BULKY', 'BULKY', '2019-09-08', '2019-09-08 00:41:19'),
(19, 'Goodnight Master ', '2019-09-08 03:44:16', '2019-09-08', '03:44:16', 'ERROR', '+2557449030', NULL, 0, 3, '08092019034413379', '', '', '2019-09-08', '2019-09-08 00:44:14', 'HASSANBL01', '', 17, '', 1, 'ERROR', 'Destination Mobile number missing / Invalid format', 'Destination Mobile number missing / Invalid format', '2019-09-08', '2019-09-08 00:44:14'),
(20, 'Goodnight Master ', '2019-09-08 03:45:08', '2019-09-08', '03:45:08', 'SENT', '+255788449030', NULL, 0, 3, '08092019034505272', '', '', '2019-09-08', '2019-09-08 00:45:06', 'HASSANBL01', '', 17, '', 1, 'SENT', 'Successful - Msg Sent', '', '2019-09-08', '2019-09-08 00:45:06'),
(21, 'Goodnight Master ', '2019-09-08 03:46:09', '2019-09-08', '03:46:09', 'SENT', '+255688059688', NULL, 0, 3, '08092019034608838', '', '', '2019-09-08', '2019-09-08 00:46:08', 'HASSANBL01', '', 17, '', 1, 'SENT', 'Successful - Msg Sent', '', '2019-09-08', '2019-09-08 00:46:08'),
(22, 'GMTech Afternoon', '2019-09-08 15:27:44', '2019-09-08', '15:27:44', 'BULKY', 'BULKY', NULL, 0, 3, '07261508092019C28VVE3', '', '', '2019-09-08', '2019-09-08 12:26:07', 'HASSANBL01', '07261508092019C28VVE3', 16, 'info', 2, 'BULKY', 'BULKY', 'BULKY', '2019-09-08', '2019-09-08 12:26:07'),
(23, 'SMS YES Body', '2019-09-08 16:33:18', '2019-09-08', '16:33:18', 'SENT', '+255714363727', NULL, 0, 3, '08092019163309752', '', '', '2019-09-08', '2019-09-08 13:33:10', 'HASSANBL01', '', 12, 'INFO', 1, 'SENT', 'Successful - Msg Sent', '', '2019-09-08', '2019-09-08 13:33:10'),
(24, 'HELLO, from Malysia', '2019-09-08 17:22:13', '2019-09-08', '17:22:13', 'BULKY', 'BULKY', NULL, 0, 3, '29171708092019YMSSDI8', '', '', '2019-09-08', '2019-09-08 14:17:29', 'HASSANBL01', '29171708092019YMSSDI8', 19, 'INFO', 2, 'BULKY', 'BULKY', 'BULKY', '2019-09-08', '2019-09-08 14:17:29'),
(25, 'Oy Am on ma way brother ,just 5mins to your location.\nDeogratias Ngereza', '2019-09-08 17:55:52', '2019-09-08', '17:55:52', 'BULKY', 'BULKY', NULL, 0, 3, '35551708092019HQ2SROJ', '', '', '2019-09-08', '2019-09-08 14:55:36', 'HASSANBL01', '35551708092019HQ2SROJ', 72, 'info', 1, 'BULKY', 'BULKY', 'BULKY', '2019-09-08', '2019-09-08 14:55:36'),
(26, 'GMTest Master', '2019-09-14 12:36:54', '2019-09-14', '12:36:54', 'ERROR', '+255688059688', NULL, 0, 3, '14092019133653462', '', '', '2019-09-14', '2019-09-14 10:36:54', 'GMANDR01', '', 13, '', 1, 'ERROR', 'ERROR', 'ERROR', '2019-09-14', '2019-09-14 10:36:54'),
(27, 'GMTest Master', '2019-09-14 12:41:02', '2019-09-14', '12:41:02', 'ERROR', '+255688059688', NULL, 0, 3, '14092019134102071', '', '', '2019-09-14', '2019-09-14 10:41:02', 'GMANDR01', '', 13, '', 1, 'ERROR', 'ERROR', 'ERROR', '2019-09-14', '2019-09-14 10:41:02'),
(28, 'GMTest Master', '2019-09-14 12:41:36', '2019-09-14', '12:41:36', 'ERROR', '+255688059688', NULL, 0, 3, '14092019134136520', '', '', '2019-09-14', '2019-09-14 10:41:36', 'GMANDR01', '', 13, '', 1, 'ERROR', 'ERROR', 'ERROR', '2019-09-14', '2019-09-14 10:41:36'),
(29, 'GMTest Master', '2019-09-14 12:42:33', '2019-09-14', '12:42:33', 'ERROR', '+255788449030', NULL, 0, 3, '14092019134232876', '', '', '2019-09-14', '2019-09-14 10:42:32', 'GMANDR01', '', 13, '', 1, 'ERROR', 'ERROR', 'ERROR', '2019-09-14', '2019-09-14 10:42:32'),
(30, 'GMTest Master', '2019-09-14 12:43:46', '2019-09-14', '12:43:46', 'ERROR', '255788449030', NULL, 0, 3, '14092019134345354', '', '', '2019-09-14', '2019-09-14 10:43:45', 'GMANDR01', '', 13, '', 1, 'ERROR', 'ERROR', 'ERROR', '2019-09-14', '2019-09-14 10:43:45'),
(31, 'GMTest', '2019-09-14 12:47:05', '2019-09-14', '12:47:05', 'SENT', '255684983533', NULL, 0, 3, '14092019134705465', '', '', '2019-09-14', '2019-09-14 10:47:05', 'GMANDR01', '', 6, '', 1, 'SENT', 'OK', '', '2019-09-14', '2019-09-14 10:47:05'),
(32, 'GMTest-SMS', '2019-09-14 12:48:22', '2019-09-14', '12:48:22', 'SENT', '255684983533', NULL, 0, 3, '14092019134822335', '', '', '2019-09-14', '2019-09-14 10:48:22', 'GMANDR01', '', 10, '', 1, 'SENT', 'OK', '', '2019-09-14', '2019-09-14 10:48:22'),
(33, 'GMTest-SMS', '2019-09-14 12:50:12', '2019-09-14', '12:50:12', 'SENT', '255688059688', NULL, 0, 3, '14092019135012516', '', '', '2019-09-14', '2019-09-14 10:50:12', 'GMANDR01', '', 10, '', 1, 'SENT', 'OK', '', '2019-09-14', '2019-09-14 10:50:12'),
(34, 'Awesome', '2019-09-14 12:50:52', '2019-09-14', '12:50:52', 'SENT', '255688059688', NULL, 0, 3, '14092019135052109', '', '', '2019-09-14', '2019-09-14 10:50:52', 'GMANDR01', '', 7, '', 1, 'SENT', 'OK', '', '2019-09-14', '2019-09-14 10:50:52'),
(35, 'AwesomeGame', '2019-09-14 12:51:05', '2019-09-14', '12:51:05', 'SENT', '255688059688', NULL, 0, 3, '14092019135105213', '', '', '2019-09-14', '2019-09-14 10:51:05', 'GMANDR01', '', 11, '', 1, 'SENT', 'OK', '', '2019-09-14', '2019-09-14 10:51:05');

-- --------------------------------------------------------

--
-- Table structure for table `sms_sch_batches`
--

CREATE TABLE `sms_sch_batches` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `recepients_json` text NOT NULL,
  `created_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msg` int(11) NOT NULL,
  `total_recepients` int(11) NOT NULL,
  `total_units` int(11) NOT NULL,
  `sent_units` int(11) NOT NULL DEFAULT '0',
  `msg_length` int(11) NOT NULL,
  `response_type` varchar(45) NOT NULL,
  `response_info` varchar(45) NOT NULL,
  `error_info` varchar(360) NOT NULL,
  `exec_at` datetime NOT NULL,
  `sent_at` datetime NOT NULL,
  `trial_counts` int(11) NOT NULL DEFAULT '0',
  `on_lock` int(11) NOT NULL DEFAULT '0',
  `on_lock_since` datetime NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sms_gqaccount_no` varchar(45) NOT NULL,
  `sender_name` varchar(45) NOT NULL DEFAULT 'INFO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_accounts`
--
ALTER TABLE `customer_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `sms_contacts_has_groups`
--
ALTER TABLE `sms_contacts_has_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_contacts_list`
--
ALTER TABLE `sms_contacts_list`
  ADD PRIMARY KEY (`id`,`customer_id`),
  ADD KEY `fk_sms_receivers_list_customer_accounts1_idx` (`customer_id`);

--
-- Indexes for table `sms_drafts`
--
ALTER TABLE `sms_drafts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_groups`
--
ALTER TABLE `sms_groups`
  ADD PRIMARY KEY (`id`,`customer_id`),
  ADD KEY `fk_sms_groups_customers1_idx` (`customer_id`);

--
-- Indexes for table `sms_histories`
--
ALTER TABLE `sms_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_incomings`
--
ALTER TABLE `sms_incomings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_outgoings`
--
ALTER TABLE `sms_outgoings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_sch_batches`
--
ALTER TABLE `sms_sch_batches`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_accounts`
--
ALTER TABLE `customer_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms_contacts_has_groups`
--
ALTER TABLE `sms_contacts_has_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sms_contacts_list`
--
ALTER TABLE `sms_contacts_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sms_drafts`
--
ALTER TABLE `sms_drafts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_groups`
--
ALTER TABLE `sms_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sms_histories`
--
ALTER TABLE `sms_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sms_incomings`
--
ALTER TABLE `sms_incomings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sms_outgoings`
--
ALTER TABLE `sms_outgoings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `sms_sch_batches`
--
ALTER TABLE `sms_sch_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sms_groups`
--
ALTER TABLE `sms_groups`
  ADD CONSTRAINT `fk_sms_groups_customers1` FOREIGN KEY (`customer_id`) REFERENCES `customer_accounts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
