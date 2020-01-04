-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 02, 2020 at 03:27 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--
CREATE DATABASE IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_cs;
USE `mydb`;

-- --------------------------------------------------------

--
-- Table structure for table `breakage`
--

DROP TABLE IF EXISTS `breakage`;
CREATE TABLE IF NOT EXISTS `breakage` (
  `break_id` int(11) NOT NULL AUTO_INCREMENT,
  `qty` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `break_by` int(11) NOT NULL,
  `rec_by` int(11) NOT NULL,
  PRIMARY KEY (`break_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `breakage`
--

INSERT INTO `breakage` (`break_id`, `qty`, `prod_id`, `type`, `date`, `break_by`, `rec_by`) VALUES
(3, 3, 1, 'Case', '2019-12-22 17:32:54', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category_line`
--

DROP TABLE IF EXISTS `category_line`;
CREATE TABLE IF NOT EXISTS `category_line` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

DROP TABLE IF EXISTS `credentials`;
CREATE TABLE IF NOT EXISTS `credentials` (
  `cred_id` int(11) NOT NULL AUTO_INCREMENT,
  `usrnm` varchar(255) DEFAULT NULL,
  `psswrd` varchar(255) DEFAULT NULL,
  `prof_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cred_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`cred_id`, `usrnm`, `psswrd`, `prof_id`) VALUES
(1, 'roleosala', 'Leosala99', 1),
(2, 'roleosala', 'Leosala09', 2);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `inv_id` int(11) NOT NULL AUTO_INCREMENT,
  `qtty` decimal(11,0) DEFAULT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `rm_btl` int(11) NOT NULL,
  `rm_shll` int(11) NOT NULL,
  `rm_cs` int(11) NOT NULL,
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inv_id`, `qtty`, `prod_id`, `rm_btl`, `rm_shll`, `rm_cs`) VALUES
(1, '38', 1, 0, 0, 0),
(2, '500', 2, 0, 0, 0),
(3, '70', 3, 0, 0, 0),
(4, '150', 4, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `prod_id` int(11) NOT NULL AUTO_INCREMENT,
  `dscrptn` varchar(45) DEFAULT NULL,
  `rtl_prc` int(11) DEFAULT NULL,
  `BTL_empty_prc` int(11) DEFAULT NULL,
  `CASE_empty_prc` int(11) DEFAULT NULL,
  `prof_id` int(11) NOT NULL,
  `avail` int(11) NOT NULL,
  `SHELL_empty_prc` int(11) NOT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `dscrptn`, `rtl_prc`, `BTL_empty_prc`, `CASE_empty_prc`, `prof_id`, `avail`, `SHELL_empty_prc`) VALUES
(1, 'Coke Litro', 340, 6, 124, 1, 1, 76),
(2, 'Grande', 224, 6, 111, 1, 1, 85),
(3, 'Red Horse', 234, 6, 111, 1, 1, 85),
(4, 'Pepsi Litro', 360, 8, 225, 1, 0, 129);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `prof_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(45) DEFAULT NULL,
  `mname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `cntctnmbr` varchar(45) DEFAULT NULL,
  `addres` varchar(255) DEFAULT NULL,
  `prof_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`prof_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`prof_id`, `fname`, `mname`, `lname`, `cntctnmbr`, `addres`, `prof_type`) VALUES
(1, 'Richard', 'Odjinar', 'Leosala', '09952831272', 'Picasales st. mangagoy bislig city', 1),
(2, 'Richie', 'Odjinar', 'Leosala', '09088116084', 'Narsala recreation center picasales st. mangagoy bislig city', 1);

-- --------------------------------------------------------

--
-- Table structure for table `refunds`
--

DROP TABLE IF EXISTS `refunds`;
CREATE TABLE IF NOT EXISTS `refunds` (
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `qntty` int(11) NOT NULL,
  `sil_id` int(11) NOT NULL,
  `prof_id` int(11) NOT NULL,
  PRIMARY KEY (`ref_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `refunds`
--

INSERT INTO `refunds` (`ref_id`, `date`, `qntty`, `sil_id`, `prof_id`) VALUES
(1, '2020-01-02 15:16:37', 1, 1, 1),
(2, '2020-01-02 15:17:06', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_order`
--

DROP TABLE IF EXISTS `sales_order`;
CREATE TABLE IF NOT EXISTS `sales_order` (
  `so_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `ttl_amnt` int(11) DEFAULT NULL,
  `ttl_dpst` varchar(45) DEFAULT NULL,
  `grndttl` int(11) NOT NULL,
  `prof_id` varchar(45) DEFAULT NULL,
  `unq_id` varchar(255) NOT NULL,
  PRIMARY KEY (`so_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_order`
--

INSERT INTO `sales_order` (`so_id`, `date`, `ttl_amnt`, `ttl_dpst`, `grndttl`, `prof_id`, `unq_id`) VALUES
(1, '2019-12-18 12:13:19', 680, '0', 680, '1', '20191218121319'),
(2, '2019-12-30 16:33:34', 1404, '0', 1404, '1', '20191230043334');

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_line`
--

DROP TABLE IF EXISTS `sales_order_line`;
CREATE TABLE IF NOT EXISTS `sales_order_line` (
  `sol_id` int(11) NOT NULL AUTO_INCREMENT,
  `qntty` int(11) DEFAULT NULL,
  `prc` int(11) DEFAULT NULL,
  `dpst` varchar(11) DEFAULT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `so_id` int(11) DEFAULT NULL,
  `refund` int(11) NOT NULL,
  `depqty` int(11) NOT NULL,
  `depprc` int(11) NOT NULL,
  PRIMARY KEY (`sol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_order_line`
--

INSERT INTO `sales_order_line` (`sol_id`, `qntty`, `prc`, `dpst`, `prod_id`, `so_id`, `refund`, `depqty`, `depprc`) VALUES
(1, 0, 340, 'N-A', 1, 1, 1, 0, 0),
(2, 0, 234, 'N-A', 3, 2, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock_in`
--

DROP TABLE IF EXISTS `stock_in`;
CREATE TABLE IF NOT EXISTS `stock_in` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `stck_dt` date DEFAULT NULL,
  PRIMARY KEY (`si_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock_in_line`
--

DROP TABLE IF EXISTS `stock_in_line`;
CREATE TABLE IF NOT EXISTS `stock_in_line` (
  `sil_id` int(11) NOT NULL AUTO_INCREMENT,
  `qntty` int(11) DEFAULT NULL,
  `unt_prc` int(11) DEFAULT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `prof_id` int(11) DEFAULT NULL,
  `btl_rls` int(11) NOT NULL,
  `shll_rls` int(11) NOT NULL,
  `cs_rls` int(11) NOT NULL,
  PRIMARY KEY (`sil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock_in_line`
--

INSERT INTO `stock_in_line` (`sil_id`, `qntty`, `unt_prc`, `prod_id`, `date`, `prof_id`, `btl_rls`, `shll_rls`, `cs_rls`) VALUES
(1, 36, 326, 1, '2019-12-18 12:13:04', 1, 0, 0, 0),
(2, 500, 212, 2, '2019-12-26 13:42:13', 1, 0, 0, 0),
(3, 70, 212, 3, '2019-12-26 13:43:04', 1, 0, 0, 0),
(4, 150, 324, 4, '2019-12-26 13:44:20', 1, 0, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
