-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2021 at 04:21 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `openmvm`
--

-- --------------------------------------------------------

--
-- Table structure for table `omvm_administrator`
--

CREATE TABLE `omvm_administrator` (
  `administrator_id` int(11) NOT NULL,
  `administrator_group_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `code` varchar(40) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_administrator`
--

INSERT INTO `omvm_administrator` (`administrator_id`, `administrator_group_id`, `username`, `password`, `salt`, `firstname`, `lastname`, `email`, `avatar`, `code`, `ip`, `status`, `date_added`, `date_modified`) VALUES
(1, 1, 'openmvm', '6f14beff76f0e08c67a4c98de296e367cb69b7f6', '8603514956054e6cd8e04c2.82198451', 'John', 'Doe', 'admin1@openmvm.example.com', '', '', '', 1, '2021-02-19 03:41:16', '2021-03-24 10:40:26');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_administrator_group`
--

CREATE TABLE `omvm_administrator_group` (
  `administrator_group_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `permission` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_administrator_group`
--

INSERT INTO `omvm_administrator_group` (`administrator_group_id`, `name`, `permission`) VALUES
(1, 'Administrator', '{\"access\":[\"modules\\/Example\\/FrontendTheme\\/Controllers\\/BackEnd\\/Example\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Administrator\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/AdministratorGroup\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Dashboard\",\"modules\\/OpenMVM\\/Filemanager\\/Controllers\\/BackEnd\\/Filemanager\",\"modules\\/OpenMVM\\/FrontendTheme\\/Controllers\\/BackEnd\\/ThemeDefault\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/City\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/Country\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/Currency\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/District\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/Language\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/LengthClass\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/OrderStatus\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/State\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/WeightClass\",\"modules\\/OpenMVM\\/PaymentMethod\\/Controllers\\/BackEnd\\/PaymentMethod\",\"modules\\/OpenMVM\\/PaymentMethod\\/Controllers\\/BackEnd\\/PaymentMethod\\/BankTransfer\",\"modules\\/OpenMVM\\/PaymentMethod\\/Controllers\\/BackEnd\\/PaymentMethod\\/Cod\",\"modules\\/OpenMVM\\/Setting\\/Controllers\\/BackEnd\\/Setting\",\"modules\\/OpenMVM\\/ShippingMethod\\/Controllers\\/BackEnd\\/ShippingMethod\",\"modules\\/OpenMVM\\/ShippingMethod\\/Controllers\\/BackEnd\\/ShippingMethod\\/Flat\",\"modules\\/OpenMVM\\/ShippingMethod\\/Controllers\\/BackEnd\\/ShippingMethod\\/Weight\",\"modules\\/OpenMVM\\/Store\\/Controllers\\/BackEnd\\/Category\",\"modules\\/OpenMVM\\/Store\\/Controllers\\/BackEnd\\/FrontendWidgets\\/Category\",\"modules\\/OpenMVM\\/Store\\/Controllers\\/BackEnd\\/FrontendWidgets\\/Latest\",\"modules\\/OpenMVM\\/Theme\\/Controllers\\/BackEnd\\/FrontendLayout\",\"modules\\/OpenMVM\\/Theme\\/Controllers\\/BackEnd\\/FrontendTheme\",\"modules\\/OpenMVM\\/Theme\\/Controllers\\/BackEnd\\/FrontendWidget\",\"modules\\/OpenMVM\\/User\\/Controllers\\/BackEnd\\/User\",\"modules\\/OpenMVM\\/User\\/Controllers\\/BackEnd\\/UserGroup\"],\"modify\":[\"modules\\/Example\\/FrontendTheme\\/Controllers\\/BackEnd\\/Example\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Administrator\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/AdministratorGroup\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Dashboard\",\"modules\\/OpenMVM\\/Filemanager\\/Controllers\\/BackEnd\\/Filemanager\",\"modules\\/OpenMVM\\/FrontendTheme\\/Controllers\\/BackEnd\\/ThemeDefault\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/City\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/Country\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/Currency\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/District\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/Language\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/LengthClass\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/OrderStatus\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/State\",\"modules\\/OpenMVM\\/Localisation\\/Controllers\\/BackEnd\\/WeightClass\",\"modules\\/OpenMVM\\/PaymentMethod\\/Controllers\\/BackEnd\\/PaymentMethod\",\"modules\\/OpenMVM\\/PaymentMethod\\/Controllers\\/BackEnd\\/PaymentMethod\\/BankTransfer\",\"modules\\/OpenMVM\\/PaymentMethod\\/Controllers\\/BackEnd\\/PaymentMethod\\/Cod\",\"modules\\/OpenMVM\\/Setting\\/Controllers\\/BackEnd\\/Setting\",\"modules\\/OpenMVM\\/ShippingMethod\\/Controllers\\/BackEnd\\/ShippingMethod\",\"modules\\/OpenMVM\\/ShippingMethod\\/Controllers\\/BackEnd\\/ShippingMethod\\/Flat\",\"modules\\/OpenMVM\\/ShippingMethod\\/Controllers\\/BackEnd\\/ShippingMethod\\/Weight\",\"modules\\/OpenMVM\\/Store\\/Controllers\\/BackEnd\\/Category\",\"modules\\/OpenMVM\\/Store\\/Controllers\\/BackEnd\\/FrontendWidgets\\/Category\",\"modules\\/OpenMVM\\/Store\\/Controllers\\/BackEnd\\/FrontendWidgets\\/Latest\",\"modules\\/OpenMVM\\/Theme\\/Controllers\\/BackEnd\\/FrontendLayout\",\"modules\\/OpenMVM\\/Theme\\/Controllers\\/BackEnd\\/FrontendTheme\",\"modules\\/OpenMVM\\/Theme\\/Controllers\\/BackEnd\\/FrontendWidget\",\"modules\\/OpenMVM\\/User\\/Controllers\\/BackEnd\\/User\",\"modules\\/OpenMVM\\/User\\/Controllers\\/BackEnd\\/UserGroup\"]}'),
(4, 'Demonstration', '{\"access\":[\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Administrator\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/AdministratorGroup\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Dashboard\",\"modules\\/OpenMVM\\/Setting\\/Controllers\\/BackEnd\\/Setting\"],\"modify\":[\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Administrator\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/AdministratorGroup\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Dashboard\",\"modules\\/OpenMVM\\/Setting\\/Controllers\\/BackEnd\\/Setting\"]}'),
(5, 'Full Demonstration', '{\"access\":[\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Administrator\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/AdministratorGroup\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Dashboard\",\"modules\\/OpenMVM\\/Setting\\/Controllers\\/BackEnd\\/Setting\"],\"modify\":[\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Administrator\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/AdministratorGroup\",\"modules\\/OpenMVM\\/Administrator\\/Controllers\\/BackEnd\\/Dashboard\",\"modules\\/OpenMVM\\/Setting\\/Controllers\\/BackEnd\\/Setting\"]}');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_cart`
--

CREATE TABLE `omvm_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `cart_session_id` varchar(64) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_cart`
--

INSERT INTO `omvm_cart` (`cart_id`, `user_id`, `store_id`, `cart_session_id`, `product_id`, `option`, `quantity`, `date_added`) VALUES
(1, 0, 1, '605ae09909eb1', 1, '[]', 3, '2021-03-24 04:05:06'),
(3, 1, 1, '605b44d6374de', 1, '\"[]\"', 3, '2021-03-24 10:41:54'),
(4, 1, 2, '605b44d6374de', 3, '[]', 1, '2021-03-24 10:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_cart_product`
--

CREATE TABLE `omvm_cart_product` (
  `cart_product_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option` text NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_category`
--

CREATE TABLE `omvm_category` (
  `category_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `top` tinyint(1) NOT NULL DEFAULT 0,
  `column` int(3) NOT NULL DEFAULT 0,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_category`
--

INSERT INTO `omvm_category` (`category_id`, `image`, `parent_id`, `top`, `column`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(1, NULL, 0, 1, 0, 0, 1, '2021-03-22 19:51:10', '2021-03-22 20:13:07'),
(2, NULL, 0, 1, 0, 0, 1, '2021-03-22 19:52:06', '2021-03-22 19:52:06'),
(3, NULL, 0, 0, 0, 0, 1, '2021-03-22 19:53:15', '2021-03-22 20:10:04'),
(4, NULL, 0, 0, 0, 0, 1, '2021-03-22 19:53:59', '2021-03-22 20:10:11'),
(5, NULL, 0, 1, 0, 0, 1, '2021-03-22 19:54:29', '2021-03-22 19:54:29'),
(6, NULL, 0, 1, 0, 0, 1, '2021-03-22 19:54:56', '2021-03-22 19:54:56'),
(7, NULL, 0, 1, 0, 0, 1, '2021-03-22 19:55:24', '2021-03-22 19:55:24'),
(8, NULL, 0, 1, 0, 0, 1, '2021-03-22 19:55:54', '2021-03-22 19:55:54'),
(9, NULL, 0, 0, 0, 0, 1, '2021-03-22 19:56:26', '2021-03-22 20:10:21'),
(10, NULL, 0, 0, 0, 0, 1, '2021-03-22 19:56:57', '2021-03-22 20:10:32'),
(11, NULL, 0, 0, 0, 0, 1, '2021-03-22 19:57:28', '2021-03-22 20:10:41'),
(12, NULL, 0, 0, 0, 0, 1, '2021-03-22 19:57:58', '2021-03-22 20:13:00'),
(13, NULL, 0, 1, 0, 0, 1, '2021-03-22 19:58:32', '2021-03-22 19:58:32'),
(14, NULL, 0, 1, 0, 0, 1, '2021-03-22 19:59:12', '2021-03-22 19:59:12'),
(15, NULL, 0, 0, 0, 0, 1, '2021-03-22 19:59:47', '2021-03-24 04:50:02'),
(16, NULL, 0, 1, 0, 0, 1, '2021-03-22 20:00:22', '2021-03-22 20:00:22'),
(17, NULL, 0, 0, 0, 0, 1, '2021-03-22 20:00:50', '2021-03-22 20:12:19'),
(18, NULL, 0, 0, 0, 0, 1, '2021-03-22 20:01:23', '2021-03-22 20:11:59'),
(19, NULL, 0, 1, 0, 0, 1, '2021-03-22 20:02:13', '2021-03-22 20:02:13'),
(20, NULL, 0, 1, 0, 0, 1, '2021-03-22 20:02:42', '2021-03-22 20:02:42'),
(21, NULL, 6, 0, 0, 1, 1, '2021-03-24 04:23:28', '2021-03-24 04:23:28'),
(22, NULL, 6, 0, 0, 2, 1, '2021-03-24 04:23:58', '2021-03-24 04:23:58');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_category_description`
--

CREATE TABLE `omvm_category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_category_description`
--

INSERT INTO `omvm_category_description` (`category_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keywords`, `slug`) VALUES
(1, 1, 'Arts & Crafts', '<p>Arts &amp; Crafts</p>', 'Arts & Crafts', 'Arts & Crafts', 'arts,crafts', 'arts-crafts'),
(2, 1, 'Automotive', '<p>Automotive</p>', 'Automotive', 'Automotive', 'automotive', 'automotive'),
(3, 1, 'Baby', '<p>Baby</p>', 'Baby', 'Baby', 'baby', 'baby'),
(4, 1, 'Beauty & Personal Care', '<p>Beauty &amp; Personal Care</p>', 'Beauty & Personal Care', 'Beauty & Personal Care', 'beauty,personal,care', 'beauty-personal-care'),
(5, 1, 'Books', '<p>Books</p>', 'Books', 'Books', 'books', 'books'),
(6, 1, 'Computers', '<p>Computers</p>', 'Computers', 'Computers', 'computers', 'computers'),
(7, 1, 'Electronics', '<p>Electronics</p>', 'Electronics', 'Electronics', 'electronics', 'electronics'),
(8, 1, 'Fashion', '<p>Fashion</p>', 'Fashion', 'Fashion', 'fashion', 'fashion'),
(9, 1, 'Health & Household', '<p>Health &amp; Household</p>', 'Health & Household', 'Health & Household', 'health,household', 'health-household'),
(10, 1, 'Home & Kitchen', '<p>Home &amp; Kitchen</p>', 'Home & Kitchen', 'Home & Kitchen', 'home,kitchen', 'home-kitchen'),
(11, 1, 'Industrial & Scientific', '<p>Industrial &amp; Scientific</p>', 'Industrial & Scientific', 'Industrial & Scientific', 'industrial,scientific', 'industrial-scientific'),
(12, 1, 'Luggage', '<p>Luggage</p>', 'Luggage', 'Luggage', 'luggage', 'luggage'),
(13, 1, 'Movies & Television', '<p>Movies &amp; Television</p>', 'Movies & Television', 'Movies & Television', 'movies,television', 'movies-television'),
(14, 1, 'Music, CDs & Vinyl', '<p>Music, CDs &amp; Vinyl</p>', 'Music, CDs & Vinyl', 'Music, CDs & Vinyl', 'music,cds,vinyl', 'music-cds-vinyl'),
(15, 1, 'Pet Supplies', '<p>Pet Supplies</p>', 'Pet Supplies', 'Pet Supplies', 'pet,supplies', 'pet-supplies'),
(16, 1, 'Software', '<p>Software</p>', 'Software', 'Software', 'software', 'software'),
(17, 1, 'Sports & Outdoors', '<p>Sports &amp; Outdoors</p>', 'Sports & Outdoors', 'Sports & Outdoors', 'sports,outdoors', 'sports-outdoors'),
(18, 1, 'Tools & Home Improvement', '<p>Tools &amp; Home Improvement</p>', 'Tools & Home Improvement', 'Tools & Home Improvement', 'tools,home,improvement', 'tools-home-improvement'),
(19, 1, 'Toys & Games', '<p>Toys &amp; Games</p>', 'Toys & Games', 'Toys & Games', 'toys,games', 'toys-games'),
(20, 1, 'Video Games', '<p>Video Games</p>', 'Video Games', 'Video Games', 'video,games', 'video-games'),
(21, 1, 'Computers & Laptops', '', '', '', '', 'computers-laptops'),
(22, 1, 'Monitors', '', '', '', '', 'monitors');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_category_path`
--

CREATE TABLE `omvm_category_path` (
  `category_id` int(11) NOT NULL,
  `path_id` int(11) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_category_path`
--

INSERT INTO `omvm_category_path` (`category_id`, `path_id`, `level`) VALUES
(1, 1, 0),
(2, 2, 0),
(3, 3, 0),
(4, 4, 0),
(5, 5, 0),
(6, 6, 0),
(7, 7, 0),
(8, 8, 0),
(9, 9, 0),
(10, 10, 0),
(11, 11, 0),
(12, 12, 0),
(13, 13, 0),
(14, 14, 0),
(15, 15, 0),
(16, 16, 0),
(17, 17, 0),
(18, 18, 0),
(19, 19, 0),
(20, 20, 0),
(21, 6, 0),
(21, 21, 1),
(22, 6, 0),
(22, 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_city`
--

CREATE TABLE `omvm_city` (
  `city_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_city`
--

INSERT INTO `omvm_city` (`city_id`, `name`, `code`, `country_id`, `state_id`, `sort_order`, `status`) VALUES
(4, 'Bantul', 'BTL', 2, 3, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_country`
--

CREATE TABLE `omvm_country` (
  `country_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `iso_code_numeric` int(3) NOT NULL,
  `code_dial_in` int(3) NOT NULL,
  `state_input_type` varchar(12) NOT NULL,
  `city_input_type` varchar(12) NOT NULL,
  `district_input_type` varchar(12) NOT NULL,
  `address_format` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_country`
--

INSERT INTO `omvm_country` (`country_id`, `name`, `iso_code_2`, `iso_code_3`, `iso_code_numeric`, `code_dial_in`, `state_input_type`, `city_input_type`, `district_input_type`, `address_format`, `sort_order`, `status`) VALUES
(2, 'Indonesia', 'ID', 'IDN', 360, 62, '', '', '', '', 0, 1),
(3, 'United States', 'US', 'USA', 840, 1, '', '', '', '', 0, 1),
(4, 'Argentina', 'AR', 'ARG', 32, 54, '', '', '', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_currency`
--

CREATE TABLE `omvm_currency` (
  `currency_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `symbol_left` varchar(12) NOT NULL,
  `symbol_right` varchar(12) NOT NULL,
  `decimal_place` char(1) NOT NULL,
  `value` double(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_currency`
--

INSERT INTO `omvm_currency` (`currency_id`, `title`, `code`, `symbol_left`, `symbol_right`, `decimal_place`, `value`, `status`, `date_modified`) VALUES
(1, 'Pound Sterling', 'GBP', '£', '', '2', 0.61250001, 1, '2014-09-25 14:40:00'),
(2, 'US Dollar', 'USD', '$', '', '2', 1.00000000, 1, '0000-00-00 00:00:00'),
(3, 'Euro', 'EUR', '', '€', '2', 0.78460002, 1, '2014-09-25 14:40:00');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_district`
--

CREATE TABLE `omvm_district` (
  `district_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `zip` varchar(12) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_district`
--

INSERT INTO `omvm_district` (`district_id`, `name`, `code`, `zip`, `country_id`, `state_id`, `city_id`, `sort_order`, `status`) VALUES
(5, 'Imogiri', 'IMO', '', 2, 3, 4, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_extension`
--

CREATE TABLE `omvm_extension` (
  `extension_id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_language`
--

CREATE TABLE `omvm_language` (
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `image` varchar(64) NOT NULL,
  `directory` varchar(32) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_language`
--

INSERT INTO `omvm_language` (`language_id`, `name`, `code`, `locale`, `image`, `directory`, `sort_order`, `status`) VALUES
(1, 'English', 'en-US', 'english,en,en-US', 'gb.png', 'en-US', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_layout`
--

CREATE TABLE `omvm_layout` (
  `layout_id` int(11) NOT NULL,
  `location` varchar(12) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_layout`
--

INSERT INTO `omvm_layout` (`layout_id`, `location`, `name`) VALUES
(1, 'frontend', 'Homepage'),
(2, 'frontend', 'Account'),
(3, 'frontend', 'Category');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_layout_route`
--

CREATE TABLE `omvm_layout_route` (
  `layout_route_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `route` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_layout_route`
--

INSERT INTO `omvm_layout_route` (`layout_route_id`, `layout_id`, `route`) VALUES
(1, 1, '/'),
(2, 1, '/login'),
(3, 1, '/register'),
(4, 3, '/category'),
(5, 3, '/category');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_length_class`
--

CREATE TABLE `omvm_length_class` (
  `length_class_id` int(11) NOT NULL,
  `value` decimal(15,8) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_length_class`
--

INSERT INTO `omvm_length_class` (`length_class_id`, `value`, `sort_order`, `status`) VALUES
(1, '1.00000000', 0, 1),
(2, '10.00000000', 0, 1),
(3, '0.39370000', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_length_class_description`
--

CREATE TABLE `omvm_length_class_description` (
  `length_class_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `unit` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_length_class_description`
--

INSERT INTO `omvm_length_class_description` (`length_class_id`, `language_id`, `title`, `unit`) VALUES
(1, 1, 'Centimeter', 'cm'),
(2, 1, 'Millimeter', 'mm'),
(3, 1, 'Inch', 'in');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_order`
--

CREATE TABLE `omvm_order` (
  `order_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `invoice_no` int(11) NOT NULL DEFAULT 0,
  `invoice_prefix` varchar(26) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_group_id` int(11) NOT NULL DEFAULT 0,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `custom_field` text NOT NULL,
  `payment_firstname` varchar(32) NOT NULL,
  `payment_lastname` varchar(32) NOT NULL,
  `payment_company` varchar(60) NOT NULL,
  `payment_address_1` varchar(128) NOT NULL,
  `payment_address_2` varchar(128) NOT NULL,
  `payment_city` varchar(128) NOT NULL,
  `payment_postal_code` varchar(10) NOT NULL,
  `payment_country` varchar(128) NOT NULL,
  `payment_country_id` int(11) NOT NULL,
  `payment_state` varchar(128) NOT NULL,
  `payment_state_id` int(11) NOT NULL,
  `payment_address_format` text NOT NULL,
  `payment_custom_field` text NOT NULL,
  `payment_method` varchar(128) NOT NULL,
  `payment_code` varchar(128) NOT NULL,
  `comment` text NOT NULL,
  `total` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `order_status_id` int(11) NOT NULL DEFAULT 0,
  `affiliate_id` int(11) NOT NULL,
  `commission` decimal(15,4) NOT NULL,
  `marketing_id` int(11) NOT NULL,
  `tracking` varchar(64) NOT NULL,
  `language_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(3) NOT NULL,
  `currency_value` decimal(15,8) NOT NULL DEFAULT 1.00000000,
  `ip` varchar(40) NOT NULL,
  `forwarded_ip` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `accept_language` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_order_history`
--

CREATE TABLE `omvm_order_history` (
  `order_history_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_status_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT 0,
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_order_option`
--

CREATE TABLE `omvm_order_option` (
  `order_option_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL,
  `product_option_value_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_order_product`
--

CREATE TABLE `omvm_order_product` (
  `order_product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `model` varchar(64) NOT NULL,
  `quantity` int(4) NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `total` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `tax` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `reward` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_order_shipping`
--

CREATE TABLE `omvm_order_shipping` (
  `order_shipping_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `shipping_firstname` varchar(32) NOT NULL,
  `shipping_lastname` varchar(32) NOT NULL,
  `shipping_company` varchar(40) NOT NULL,
  `shipping_address_1` varchar(128) NOT NULL,
  `shipping_address_2` varchar(128) NOT NULL,
  `shipping_city` varchar(128) NOT NULL,
  `shipping_postal_code` varchar(10) NOT NULL,
  `shipping_country` varchar(128) NOT NULL,
  `shipping_country_id` int(11) NOT NULL,
  `shipping_state` varchar(128) NOT NULL,
  `shipping_state_id` int(11) NOT NULL,
  `shipping_address_format` text NOT NULL,
  `shipping_custom_field` text NOT NULL,
  `shipping_method` varchar(128) NOT NULL,
  `shipping_code` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_order_status`
--

CREATE TABLE `omvm_order_status` (
  `order_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_order_status`
--

INSERT INTO `omvm_order_status` (`order_status_id`, `language_id`, `name`) VALUES
(2, 1, 'Processing'),
(3, 1, 'Shipped'),
(7, 1, 'Canceled'),
(5, 1, 'Complete'),
(8, 1, 'Denied'),
(9, 1, 'Canceled Reversal'),
(10, 1, 'Failed'),
(11, 1, 'Refunded'),
(12, 1, 'Reversed'),
(13, 1, 'Chargeback'),
(1, 1, 'Pending'),
(16, 1, 'Voided'),
(15, 1, 'Processed'),
(14, 1, 'Expired');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_order_total`
--

CREATE TABLE `omvm_order_total` (
  `order_total_id` int(10) NOT NULL,
  `order_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_payment_method_install`
--

CREATE TABLE `omvm_payment_method_install` (
  `payment_method_install_id` int(11) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `code` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_product`
--

CREATE TABLE `omvm_product` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `model` varchar(255) NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `reward` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `shipping` tinyint(1) NOT NULL DEFAULT 1,
  `weight` decimal(15,8) NOT NULL DEFAULT 0.00000000,
  `weight_class_id` int(11) NOT NULL DEFAULT 0,
  `length` decimal(15,8) NOT NULL DEFAULT 0.00000000,
  `width` decimal(15,8) NOT NULL DEFAULT 0.00000000,
  `height` decimal(15,8) NOT NULL DEFAULT 0.00000000,
  `length_class_id` int(11) NOT NULL DEFAULT 0,
  `minimum` int(11) NOT NULL DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `wallpaper` varchar(255) DEFAULT NULL,
  `viewed` int(11) NOT NULL DEFAULT 0,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_product`
--

INSERT INTO `omvm_product` (`product_id`, `user_id`, `store_id`, `model`, `price`, `reward`, `quantity`, `shipping`, `weight`, `weight_class_id`, `length`, `width`, `height`, `length_class_id`, `minimum`, `image`, `wallpaper`, `viewed`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(1, 2, 1, '', '369.9900', 0, 1000, 1, '2.50000000', 1, '0.00000000', '0.00000000', '0.00000000', 0, 1, 'userfiles/2/computers/a514-54_backlit_keyboard_1_1.jpg', NULL, 0, 0, 1, '2021-03-23 00:05:59', '2021-03-23 00:05:59'),
(2, 2, 1, '', '991.1700', 0, 1000, 1, '1.70000000', 1, '0.00000000', '0.00000000', '0.00000000', 0, 1, 'userfiles/2/computers/Lenovo-Legion-5-01.jpg', NULL, 0, 0, 1, '2021-03-23 00:17:41', '2021-03-23 00:17:41'),
(3, 3, 2, '', '345.0000', 0, 1000, 1, '1450.00000000', 2, '0.00000000', '0.00000000', '0.00000000', 0, 1, 'userfiles/3/video_games/nintendo-switch-animal-crossing-new-horizon-image01.png', NULL, 0, 0, 1, '2021-03-23 00:31:27', '2021-03-23 00:31:27');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_product_description`
--

CREATE TABLE `omvm_product_description` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `tags` text NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_product_description`
--

INSERT INTO `omvm_product_description` (`product_id`, `user_id`, `language_id`, `name`, `description`, `short_description`, `meta_title`, `meta_description`, `meta_keywords`, `tags`, `slug`) VALUES
(1, 2, 1, 'Acer Aspire 5 Slim Laptop, 15.6 inches Full HD IPS Display, AMD Ryzen 3 3200U, Vega 3 Graphics, 4GB DDR4, 128GB SSD, Backlit Keyboard, Windows 10 in S Mode, A515-43-R19L, Silver', '<p>Acer Aspire 5 A515-43-R19L comes with these high level specs: AMD Ryzen 3 3200U Dual-Core Processor 2.6GHz with Precision Boost up to 3.5GHz (Up to 4MB L3 Cache), Windows 10 in S mode, 15.6\" Full HD (1920 x 1080) widescreen LED-backlit IPS Display, AMD Radeon Vega 3 Mobile Graphics, 4GB DDR4 Memory, 128GB PCIe NVMe SSD, True Harmony Technology, Two Built-in Stereo Speakers, Acer Purified. Voice Technology with Two Built-in Microphones, 802.11ac Wi-Fi featuring 2x2 MIMO technology (Dual-Band 2.4GHz and 5GHz), 10/100/1000 Gigabit Ethernet LAN (RJ-45 port), Bluetooth 4.0, Back-lit Keyboard, HD Webcam (1280 x 720), 1 - USB 3.1 Gen 1 Port, 2 - USB 2.0 Ports, 1 - HDMI Port with HDCP support, Lithium-Ion Battery, up to 7.5-hours Battery Life, 3.97 lbs. | 1.8 kg (system unit only) (NX.HG8AA.001).&nbsp;</p>', 'Acer Aspire 5 A515-43-R19L comes withhigh level specs', '', '', '', '', 'acer-aspire-5-slim-laptop-15-6-inches-full-hd-ips-display-amd-ryzen-3-3200u-vega-3-graphics-4gb-ddr4-128gb-ssd-backlit-keyboard-windows-10-in-s-mode-a515-43-r19l-silver'),
(2, 2, 1, 'Lenovo Legion 5 Gaming Laptop, 15.6\" FHD (1920x1080) IPS Screen, AMD Ryzen 7 4800H Processor, 16GB DDR4, 512GB SSD, NVIDIA GTX 1660Ti, Windows 10, 82B1000AUS, Phantom Black ', '<p>Thin and light, the Lenovo Legion 5 pairs unparalleled flexibility with incredible power, offering a plethora of performance options for any gamer in a clean, minimalist design. Featuring AMD Ryzen 7 processors with 8 ultra-responsive cores, NVIDIA&reg; GTX&trade; 1660Ti graphics, and 16 GB DDR4 supported memory, this uncompromising gaming laptop elevates your favorite AAA titles with breathtakingly immersive experiences via a high refresh screen. The crisp 1080p display delivers outstanding clarity and deep colors, with a 144 Hz refresh rate for full-fidelity gaming.</p>\r\n<p>The backlit Legion TrueStrike keyboard has soft-landing switches and hair-trigger inputs to help you dominate the competition and escalate your gameplay. You\'ll also enjoy excellent audio with 2 x 2W Harman Kardon&reg; speaker system with chamber Dolby Atmos&reg; headphone support. This Windows computer keeps you connected with Bluetooth&reg; 5.0 and 2x2 WiFi 6 (802.11 ax) built in, plus an HD 720p webcam with privacy shutter. The Legion 5 gaming laptop also offers a great selection of input/output ports, including four USB 3.1 Gen 1 ports, one USB-C port, HDMI, Ethernet, and an audio jack.&nbsp;</p>', 'Thin and light, the Lenovo Legion 5 pairs unparalleled flexibility with incredible power, offering a plethora of performance options for any gamer in a clean, minimalist design.', '', '', '', '', 'lenovo-legion-5-gaming-laptop-15-6-fhd-1920x1080-ips-screen-amd-ryzen-7-4800h-processor-16gb-ddr4-512gb-ssd-nvidia-gtx-1660ti-windows-10-82b1000aus-phantom-black'),
(3, 3, 1, 'Nintendo Switch - Animal Crossing™: New Horizons', '<p>This Nintendo Switch&trade; system takes design inspiration from the new Animal Crossing&trade;: New Horizons game, with lovely pastel green and blue Joy-Con&trade; controllers that are white on the back, white wrist straps and a white Nintendo Switch dock , adorned with images of recognizable characters Tom Nook and Nooklings Timmy and Tommy.</p>', 'This Nintendo Switch™ system takes design inspiration from the new Animal Crossing™: New Horizons game', '', '', '', '', 'nintendo-switch-animal-crossing-new-horizons');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_product_to_category`
--

CREATE TABLE `omvm_product_to_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_product_to_category`
--

INSERT INTO `omvm_product_to_category` (`product_id`, `category_id`) VALUES
(1, 6),
(2, 6),
(3, 20);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_setting`
--

CREATE TABLE `omvm_setting` (
  `setting_id` int(11) NOT NULL,
  `code` varchar(128) NOT NULL,
  `key` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_setting`
--

INSERT INTO `omvm_setting` (`setting_id`, `code`, `key`, `value`, `serialized`) VALUES
(697, 'shipping_weight', 'shipping_weight_rate', '500:3,1000:6,1500:9,2000:12,2500:15,3000:18', 0),
(698, 'shipping_weight', 'shipping_weight_sort_order', '2', 0),
(919, 'frontend_theme_openmvm_default', 'frontend_theme_openmvm_default_layout_widget_1', '{\"page_top\":[\"2\"]}', 1),
(937, 'frontend_theme_example_example', 'frontend_theme_example_example_name', 'Example Third Party Theme for OpenMVM', 0),
(917, 'frontend_theme_openmvm_default', 'frontend_theme_openmvm_default_name', 'OpenMVM Default Front-end Theme', 0),
(918, 'frontend_theme_openmvm_default', 'frontend_theme_openmvm_default_layout_widget_3', '{\"widget_start\":[\"3\"]}', 1),
(654, 'shipping_flat', 'shipping_flat_cost', '9', 0),
(655, 'shipping_flat', 'shipping_flat_sort_order', '1', 0),
(656, 'shipping_flat', 'shipping_flat_status', '1', 0),
(699, 'shipping_weight', 'shipping_weight_status', '1', 0),
(650, 'payment_cod', 'payment_cod_status', '1', 0),
(649, 'payment_cod', 'payment_cod_sort_order', '2', 0),
(648, 'payment_cod', 'payment_cod_order_status_id', '1', 0),
(647, 'payment_cod', 'payment_cod_total', '10', 0),
(638, 'payment_bank_transfer', 'payment_bank_transfer_status', '1', 0),
(636, 'payment_bank_transfer', 'payment_bank_transfer_order_status_id', '1', 0),
(637, 'payment_bank_transfer', 'payment_bank_transfer_sort_order', '1', 0),
(634, 'payment_bank_transfer', 'payment_bank_transfer_bank2', 'Nama Bank: BCA', 0),
(635, 'payment_bank_transfer', 'payment_bank_transfer_total', '2', 0),
(770, 'openmvm_frontend_theme_default', 'openmvm_frontend_theme_default_name', 'Theme Default for OpenMVM', 0),
(1005, 'setting', 'setting_logo', 'openmvm.png', 0),
(1004, 'setting', 'setting_backend_weight_class_id', '1', 0),
(1003, 'setting', 'setting_frontend_weight_class_id', '2', 0),
(1002, 'setting', 'setting_backend_currency', 'EUR', 0),
(1001, 'setting', 'setting_frontend_currency', 'USD', 0),
(1000, 'setting', 'setting_backend_language', 'en-US', 0),
(999, 'setting', 'setting_frontend_language', 'en-US', 0),
(998, 'setting', 'setting_frontend_items_per_page', '6', 0),
(997, 'setting', 'setting_backend_items_per_page', '50', 0),
(996, 'setting', 'setting_default_user_group_id', '1', 0),
(995, 'setting', 'setting_frontend_theme', 'frontend-theme-openmvm-default', 0),
(994, 'setting', 'setting_backend_theme', 'backend-theme-openmvm-default', 0),
(993, 'setting', 'setting_meta_keywords', 'openmvm,multi-vendor,multi vendor,marketplace', 0),
(992, 'setting', 'setting_meta_description', 'OpenMVM is an open-source multi-vendor e-commerce marketplace platform.', 0),
(991, 'setting', 'setting_meta_title', 'OpenMVM', 0),
(633, 'payment_bank_transfer', 'payment_bank_transfer_bank1', 'Bank Name: BCA', 0),
(990, 'setting', 'setting_description', '{\"1\":\"\\u003Cp\\u003EDescription in English\\u003C\\/p\\u003E\"}', 1),
(989, 'setting', 'setting_website_name', 'OpenMVM', 0);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_shipping_method_install`
--

CREATE TABLE `omvm_shipping_method_install` (
  `shipping_method_install_id` int(11) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `code` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_state`
--

CREATE TABLE `omvm_state` (
  `state_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `country_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_state`
--

INSERT INTO `omvm_state` (`state_id`, `name`, `code`, `country_id`, `sort_order`, `status`) VALUES
(3, 'Daerah Istimewa Yogyakarta', 'DIY', 2, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_store`
--

CREATE TABLE `omvm_store` (
  `store_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `wallpaper` varchar(255) NOT NULL,
  `viewed` int(11) NOT NULL DEFAULT 0,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_store`
--

INSERT INTO `omvm_store` (`store_id`, `user_id`, `name`, `logo`, `wallpaper`, `viewed`, `sort_order`, `status`, `date_added`, `date_modified`, `slug`) VALUES
(1, 2, 'Seller 1 Store', '', '', 0, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'seller-1-store'),
(2, 3, 'Seller 2 Store', '', '', 0, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'seller-2-store');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_store_description`
--

CREATE TABLE `omvm_store_description` (
  `store_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `tags` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_store_description`
--

INSERT INTO `omvm_store_description` (`store_id`, `user_id`, `language_id`, `description`, `short_description`, `meta_title`, `meta_description`, `meta_keywords`, `tags`) VALUES
(1, 2, 1, '<p>Seller 1 Store description</p>', 'Seller 1 Store description', 'Seller 1 Store', 'Seller 1 Store description', 'seller,1,store', 'seller,store'),
(2, 3, 1, '<p>Seller 2 Store description</p>', 'Seller 2 Store description', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_user`
--

CREATE TABLE `omvm_user` (
  `user_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `wallpaper` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `user_address_id` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `safe` tinyint(1) NOT NULL,
  `token` text NOT NULL,
  `code` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_user`
--

INSERT INTO `omvm_user` (`user_id`, `user_group_id`, `language_id`, `username`, `firstname`, `lastname`, `avatar`, `wallpaper`, `gender`, `email`, `telephone`, `fax`, `password`, `salt`, `user_address_id`, `ip`, `status`, `approved`, `safe`, `token`, `code`, `date_added`, `date_modified`) VALUES
(1, 1, 0, 'openmvm071cd8e09062', '', '', '', '', '', 'user1@openmvm.example.com', '', '', '6f9e94b3898d2585cbf3f51b46a693682d814187', '152829615060594e4a9eabe5.59361961', 0, '', 1, 0, 0, '', '648884058133d34a9e91d51137b4b5c429ac1bb9', '2021-03-22 21:11:22', '0000-00-00 00:00:00'),
(2, 1, 0, 'openmvm6695765d98d4', '', '', '', '', '', 'seller1@openmvm.example.com', '', '', '204889206c6e3dc55f9fb3d9454e8de3fa59b90d', '191889957060594e99bbde34.43498350', 0, '', 1, 0, 0, '', '9e96a43127e4f49202259fbe2cfa5da017c08e40', '2021-03-22 21:12:41', '0000-00-00 00:00:00'),
(3, 1, 0, 'openmvmc7a7a7494f95', '', '', '', '', '', 'seller2@openmvm.example.com', '', '', '24a7f44fdf07f068a1e5f569eb358e6425635e6f', '127162809260594eb64faa48.42591752', 0, '', 1, 0, 0, '', '9e0b4cff3b3f7bf43004aa12428d7c89d9112ff7', '2021-03-22 21:13:10', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_user_address`
--

CREATE TABLE `omvm_user_address` (
  `user_address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `address_format` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `postal_code` varchar(12) NOT NULL,
  `telephone` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_user_email_verification`
--

CREATE TABLE `omvm_user_email_verification` (
  `username` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `code` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_expired` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_user_group`
--

CREATE TABLE `omvm_user_group` (
  `user_group_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email_verification` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_user_group`
--

INSERT INTO `omvm_user_group` (`user_group_id`, `name`, `email_verification`) VALUES
(1, 'Default', 1);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_user_online`
--

CREATE TABLE `omvm_user_online` (
  `ip` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_user_password_recovery_request`
--

CREATE TABLE `omvm_user_password_recovery_request` (
  `username` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `code` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_expired` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `omvm_weight_class`
--

CREATE TABLE `omvm_weight_class` (
  `weight_class_id` int(11) NOT NULL,
  `value` decimal(15,8) NOT NULL DEFAULT 0.00000000,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_weight_class`
--

INSERT INTO `omvm_weight_class` (`weight_class_id`, `value`, `sort_order`, `status`) VALUES
(1, '1.00000000', 0, 1),
(2, '1000.00000000', 0, 1),
(5, '2.20460000', 0, 1),
(6, '35.27400000', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_weight_class_description`
--

CREATE TABLE `omvm_weight_class_description` (
  `weight_class_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `unit` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_weight_class_description`
--

INSERT INTO `omvm_weight_class_description` (`weight_class_id`, `language_id`, `title`, `unit`) VALUES
(1, 1, 'Kilogram', 'kg'),
(2, 1, 'Gram', 'g'),
(5, 1, 'Pound ', 'lb'),
(6, 1, 'Ounce', 'oz'),
(2, 2, 'Gram', 'g');

-- --------------------------------------------------------

--
-- Table structure for table `omvm_widget`
--

CREATE TABLE `omvm_widget` (
  `widget_id` int(11) NOT NULL,
  `location` varchar(12) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `dir` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(32) NOT NULL,
  `setting` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_widget`
--

INSERT INTO `omvm_widget` (`widget_id`, `location`, `provider`, `dir`, `name`, `code`, `setting`, `status`) VALUES
(3, 'frontend', 'OpenMVM', 'Store', 'Widget Category - Category', 'category', '{\"name\":\"Widget Category - Category\",\"orientation\":\"vertical\",\"status\":\"1\"}', 1),
(2, 'frontend', 'OpenMVM', 'Store', 'Widget Category - Homepage', 'category', '{\"name\":\"Widget Category - Homepage\",\"orientation\":\"horizontal\",\"status\":\"1\"}', 1),
(4, 'frontend', 'OpenMVM', 'Store', 'Widget Latest - Homepage', 'latest', '{\"name\":\"Widget Latest - Homepage\",\"limit\":\"2\",\"status\":\"1\"}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `omvm_widget_install`
--

CREATE TABLE `omvm_widget_install` (
  `widget_install_id` int(11) NOT NULL,
  `location` varchar(12) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `dir` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `omvm_widget_install`
--

INSERT INTO `omvm_widget_install` (`widget_install_id`, `location`, `provider`, `dir`, `code`) VALUES
(3, 'frontend', 'OpenMVM', 'Store', 'category'),
(4, 'frontend', 'OpenMVM', 'Store', 'latest');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `omvm_administrator`
--
ALTER TABLE `omvm_administrator`
  ADD PRIMARY KEY (`administrator_id`);

--
-- Indexes for table `omvm_administrator_group`
--
ALTER TABLE `omvm_administrator_group`
  ADD PRIMARY KEY (`administrator_group_id`);

--
-- Indexes for table `omvm_cart`
--
ALTER TABLE `omvm_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `omvm_cart_product`
--
ALTER TABLE `omvm_cart_product`
  ADD PRIMARY KEY (`cart_product_id`);

--
-- Indexes for table `omvm_category`
--
ALTER TABLE `omvm_category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `omvm_category_description`
--
ALTER TABLE `omvm_category_description`
  ADD PRIMARY KEY (`category_id`,`language_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `omvm_category_path`
--
ALTER TABLE `omvm_category_path`
  ADD PRIMARY KEY (`category_id`,`path_id`) USING BTREE;

--
-- Indexes for table `omvm_city`
--
ALTER TABLE `omvm_city`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `omvm_country`
--
ALTER TABLE `omvm_country`
  ADD PRIMARY KEY (`country_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `omvm_currency`
--
ALTER TABLE `omvm_currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `omvm_district`
--
ALTER TABLE `omvm_district`
  ADD PRIMARY KEY (`district_id`) USING BTREE,
  ADD KEY `name` (`name`);

--
-- Indexes for table `omvm_extension`
--
ALTER TABLE `omvm_extension`
  ADD PRIMARY KEY (`extension_id`);

--
-- Indexes for table `omvm_language`
--
ALTER TABLE `omvm_language`
  ADD PRIMARY KEY (`language_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `omvm_layout`
--
ALTER TABLE `omvm_layout`
  ADD PRIMARY KEY (`layout_id`);

--
-- Indexes for table `omvm_layout_route`
--
ALTER TABLE `omvm_layout_route`
  ADD PRIMARY KEY (`layout_route_id`);

--
-- Indexes for table `omvm_length_class`
--
ALTER TABLE `omvm_length_class`
  ADD PRIMARY KEY (`length_class_id`);

--
-- Indexes for table `omvm_length_class_description`
--
ALTER TABLE `omvm_length_class_description`
  ADD PRIMARY KEY (`length_class_id`,`language_id`);

--
-- Indexes for table `omvm_order`
--
ALTER TABLE `omvm_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `omvm_order_history`
--
ALTER TABLE `omvm_order_history`
  ADD PRIMARY KEY (`order_history_id`);

--
-- Indexes for table `omvm_order_option`
--
ALTER TABLE `omvm_order_option`
  ADD PRIMARY KEY (`order_option_id`);

--
-- Indexes for table `omvm_order_product`
--
ALTER TABLE `omvm_order_product`
  ADD PRIMARY KEY (`order_product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `omvm_order_shipping`
--
ALTER TABLE `omvm_order_shipping`
  ADD PRIMARY KEY (`order_shipping_id`);

--
-- Indexes for table `omvm_order_status`
--
ALTER TABLE `omvm_order_status`
  ADD PRIMARY KEY (`order_status_id`,`language_id`);

--
-- Indexes for table `omvm_order_total`
--
ALTER TABLE `omvm_order_total`
  ADD PRIMARY KEY (`order_total_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `omvm_payment_method_install`
--
ALTER TABLE `omvm_payment_method_install`
  ADD PRIMARY KEY (`payment_method_install_id`);

--
-- Indexes for table `omvm_product`
--
ALTER TABLE `omvm_product`
  ADD PRIMARY KEY (`product_id`) USING BTREE;

--
-- Indexes for table `omvm_product_description`
--
ALTER TABLE `omvm_product_description`
  ADD PRIMARY KEY (`product_id`,`language_id`) USING BTREE;

--
-- Indexes for table `omvm_product_to_category`
--
ALTER TABLE `omvm_product_to_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `omvm_setting`
--
ALTER TABLE `omvm_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `omvm_shipping_method_install`
--
ALTER TABLE `omvm_shipping_method_install`
  ADD PRIMARY KEY (`shipping_method_install_id`);

--
-- Indexes for table `omvm_state`
--
ALTER TABLE `omvm_state`
  ADD PRIMARY KEY (`state_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `omvm_store`
--
ALTER TABLE `omvm_store`
  ADD PRIMARY KEY (`store_id`) USING BTREE;

--
-- Indexes for table `omvm_store_description`
--
ALTER TABLE `omvm_store_description`
  ADD PRIMARY KEY (`store_id`,`language_id`) USING BTREE;

--
-- Indexes for table `omvm_user`
--
ALTER TABLE `omvm_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `omvm_user_address`
--
ALTER TABLE `omvm_user_address`
  ADD PRIMARY KEY (`user_address_id`) USING BTREE;

--
-- Indexes for table `omvm_user_email_verification`
--
ALTER TABLE `omvm_user_email_verification`
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `omvm_user_group`
--
ALTER TABLE `omvm_user_group`
  ADD PRIMARY KEY (`user_group_id`);

--
-- Indexes for table `omvm_user_online`
--
ALTER TABLE `omvm_user_online`
  ADD PRIMARY KEY (`ip`);

--
-- Indexes for table `omvm_user_password_recovery_request`
--
ALTER TABLE `omvm_user_password_recovery_request`
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `omvm_weight_class`
--
ALTER TABLE `omvm_weight_class`
  ADD PRIMARY KEY (`weight_class_id`);

--
-- Indexes for table `omvm_weight_class_description`
--
ALTER TABLE `omvm_weight_class_description`
  ADD PRIMARY KEY (`weight_class_id`,`language_id`);

--
-- Indexes for table `omvm_widget`
--
ALTER TABLE `omvm_widget`
  ADD PRIMARY KEY (`widget_id`) USING BTREE;

--
-- Indexes for table `omvm_widget_install`
--
ALTER TABLE `omvm_widget_install`
  ADD PRIMARY KEY (`widget_install_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `omvm_administrator`
--
ALTER TABLE `omvm_administrator`
  MODIFY `administrator_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `omvm_administrator_group`
--
ALTER TABLE `omvm_administrator_group`
  MODIFY `administrator_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `omvm_cart`
--
ALTER TABLE `omvm_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `omvm_cart_product`
--
ALTER TABLE `omvm_cart_product`
  MODIFY `cart_product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `omvm_category`
--
ALTER TABLE `omvm_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `omvm_city`
--
ALTER TABLE `omvm_city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `omvm_country`
--
ALTER TABLE `omvm_country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `omvm_currency`
--
ALTER TABLE `omvm_currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `omvm_district`
--
ALTER TABLE `omvm_district`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `omvm_extension`
--
ALTER TABLE `omvm_extension`
  MODIFY `extension_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `omvm_language`
--
ALTER TABLE `omvm_language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `omvm_layout`
--
ALTER TABLE `omvm_layout`
  MODIFY `layout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `omvm_layout_route`
--
ALTER TABLE `omvm_layout_route`
  MODIFY `layout_route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `omvm_length_class`
--
ALTER TABLE `omvm_length_class`
  MODIFY `length_class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `omvm_order`
--
ALTER TABLE `omvm_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `omvm_order_history`
--
ALTER TABLE `omvm_order_history`
  MODIFY `order_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `omvm_order_option`
--
ALTER TABLE `omvm_order_option`
  MODIFY `order_option_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `omvm_order_product`
--
ALTER TABLE `omvm_order_product`
  MODIFY `order_product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `omvm_order_shipping`
--
ALTER TABLE `omvm_order_shipping`
  MODIFY `order_shipping_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `omvm_order_status`
--
ALTER TABLE `omvm_order_status`
  MODIFY `order_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `omvm_order_total`
--
ALTER TABLE `omvm_order_total`
  MODIFY `order_total_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `omvm_payment_method_install`
--
ALTER TABLE `omvm_payment_method_install`
  MODIFY `payment_method_install_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `omvm_product`
--
ALTER TABLE `omvm_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `omvm_setting`
--
ALTER TABLE `omvm_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;

--
-- AUTO_INCREMENT for table `omvm_shipping_method_install`
--
ALTER TABLE `omvm_shipping_method_install`
  MODIFY `shipping_method_install_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `omvm_state`
--
ALTER TABLE `omvm_state`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `omvm_store`
--
ALTER TABLE `omvm_store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `omvm_user`
--
ALTER TABLE `omvm_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `omvm_user_address`
--
ALTER TABLE `omvm_user_address`
  MODIFY `user_address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `omvm_user_group`
--
ALTER TABLE `omvm_user_group`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `omvm_weight_class`
--
ALTER TABLE `omvm_weight_class`
  MODIFY `weight_class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `omvm_widget`
--
ALTER TABLE `omvm_widget`
  MODIFY `widget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `omvm_widget_install`
--
ALTER TABLE `omvm_widget_install`
  MODIFY `widget_install_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
