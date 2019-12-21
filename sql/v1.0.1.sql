-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 14, 2019 at 02:33 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: mydb
--
CREATE DATABASE IF NOT EXISTS mydb DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE mydb;

-- --------------------------------------------------------

--
-- Table structure for table Categories
--

DROP TABLE IF EXISTS Categories;
CREATE TABLE IF NOT EXISTS Categories (
  cat_id varchar(255) NOT NULL,
  name varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table Categories
--

INSERT INTO Categories (cat_id, name) VALUES
('5de973125cfae', 'Pepsi Products');

-- --------------------------------------------------------

--
-- Table structure for table category_line
--

DROP TABLE IF EXISTS category_line;
CREATE TABLE IF NOT EXISTS category_line (
  cl_id int(11) NOT NULL AUTO_INCREMENT,
  prod_id int(11) NOT NULL,
  cat_id int(11) NOT NULL,
  added_by int(11) NOT NULL,
  PRIMARY KEY (cl_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table credentials
--

DROP TABLE IF EXISTS credentials;
CREATE TABLE IF NOT EXISTS credentials (
  cred_id int(11) NOT NULL AUTO_INCREMENT,
  usrnm varchar(255) DEFAULT NULL,
  psswrd varchar(255) DEFAULT NULL,
  prof_id int(11) DEFAULT NULL,
  PRIMARY KEY (cred_id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table credentials
--

INSERT INTO credentials (cred_id, usrnm, psswrd, prof_id) VALUES
(1, 'roleosala', 'Leosala99', 1),
(2, 'roleosala', 'Leosala09', 2);

-- --------------------------------------------------------

--
-- Table structure for table Inventory
--

DROP TABLE IF EXISTS Inventory;
CREATE TABLE IF NOT EXISTS Inventory (
  inv_id int(11) NOT NULL AUTO_INCREMENT,
  qtty decimal(11,0) DEFAULT NULL,
  prod_id int(11) DEFAULT NULL,
  PRIMARY KEY (inv_id)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table Inventory
--

INSERT INTO Inventory (inv_id, qtty, prod_id) VALUES
(1, '52', 2),
(2, '0', 3),
(3, '0', 4),
(4, '0', 5),
(5, '94', 6);

-- --------------------------------------------------------

--
-- Table structure for table Products
--

DROP TABLE IF EXISTS Products;
CREATE TABLE IF NOT EXISTS Products (
  prod_id int(11) NOT NULL AUTO_INCREMENT,
  dscrptn varchar(45) DEFAULT NULL,
  rtl_prc int(11) DEFAULT NULL,
  BTL_empty_prc int(11) DEFAULT NULL,
  CASE_empty_prc int(11) DEFAULT NULL,
  prof_id int(11) NOT NULL,
  avail int(11) NOT NULL,
  SHELL_empty_prc int(11) NOT NULL,
  PRIMARY KEY (prod_id)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table Products
--

INSERT INTO Products (prod_id, dscrptn, rtl_prc, BTL_empty_prc, CASE_empty_prc, prof_id, avail, SHELL_empty_prc) VALUES
(2, 'Pepsi 8oz', 165, 6, 90, 1, 0, 0),
(3, 'Coke 8oz', 224, 6, 150, 1, 0, 0),
(4, 'Pepsi litro', 224, 6, 175, 1, 0, 0),
(5, 'Pepsi litro', 224, 6, 175, 1, 0, 0),
(6, 'Litro coke', 340, 6, 124, 1, 1, 72);

-- --------------------------------------------------------

--
-- Table structure for table profiles
--

DROP TABLE IF EXISTS profiles;
CREATE TABLE IF NOT EXISTS profiles (
  prof_id int(11) NOT NULL AUTO_INCREMENT,
  fname varchar(45) DEFAULT NULL,
  mname varchar(45) DEFAULT NULL,
  lname varchar(45) DEFAULT NULL,
  cntctnmbr varchar(45) DEFAULT NULL,
  addres varchar(255) DEFAULT NULL,
  prof_type int(11) DEFAULT NULL,
  PRIMARY KEY (prof_id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table profiles
--

INSERT INTO profiles (prof_id, fname, mname, lname, cntctnmbr, addres, prof_type) VALUES
(1, 'Richard', 'Odjinar', 'Leosala', '09952831272', 'Picasales st. mangagoy bislig city', 1),
(2, 'Richie', 'Odjinar', 'Leosala', '09088116084', 'Narsala recreation center picasales st. mangagoy bislig city', 1);

-- --------------------------------------------------------

--
-- Table structure for table Sales_Order
--

DROP TABLE IF EXISTS Sales_Order;
CREATE TABLE IF NOT EXISTS Sales_Order (
  so_id int(11) NOT NULL AUTO_INCREMENT,
  date datetime DEFAULT NULL,
  ttl_amnt int(11) DEFAULT NULL,
  ttl_dpst varchar(45) DEFAULT NULL,
  grndttl int(11) NOT NULL,
  prof_id varchar(45) DEFAULT NULL,
  unq_id varchar(255) NOT NULL,
  PRIMARY KEY (so_id)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table Sales_Order
--

INSERT INTO Sales_Order (so_id, date, ttl_amnt, ttl_dpst, grndttl, prof_id, unq_id) VALUES
(1, '2019-12-11 15:19:42', 630, '30', 660, '', '0'),
(2, '2019-12-11 15:20:31', 882, '250', 1132, '', '0'),
(3, '2019-12-11 15:21:07', 882, '250', 1132, '', '0'),
(4, '2019-12-11 15:22:49', 630, '0', 630, '', '0'),
(5, '2019-12-11 15:23:11', 378, '0', 378, '', '0'),
(6, '2019-12-11 15:24:47', 378, '0', 378, '', '0'),
(7, '2019-12-11 15:24:56', 378, '0', 378, '', '0'),
(8, '2019-12-11 15:25:47', 378, '0', 378, '', '0'),
(9, '2019-12-11 15:26:52', 252, '0', 252, '', '0'),
(10, '2019-12-11 15:28:36', 378, '0', 378, '', '0'),
(11, '2019-12-11 15:30:30', 504, '0', 504, '', '0'),
(12, '2019-12-11 15:32:52', 504, '0', 528, '1', '0'),
(13, '2019-12-11 15:34:47', 1134, '0', 1134, '1', '0'),
(14, '2019-12-11 15:35:25', 1890, '0', 1890, '1', '0'),
(15, '2019-12-11 15:37:25', 504, '0', 504, '1', '0'),
(16, '2019-12-11 15:37:47', 252, '0', 252, '1', '0'),
(17, '2019-12-11 15:37:56', 378, '0', 378, '1', '0'),
(18, '2019-12-11 15:39:09', 882, '0', 882, '1', '0'),
(19, '2019-12-12 00:56:23', 0, '0', 0, '1', '0'),
(20, '2019-12-12 04:33:50', 378, '0', 378, '1', '20191212043350'),
(21, '2019-12-12 04:34:29', 1638, '0', 1638, '1', '20191212043429'),
(22, '2019-12-12 04:34:51', 630, '0', 630, '1', '20191212043451'),
(23, '2019-12-12 16:00:12', 315, '0', 447, '1', '20191212040012'),
(24, '2019-12-12 18:10:42', 495, '0', 567, '1', '20191212061042'),
(25, '2019-12-12 18:28:26', 1020, '0', 1020, '1', '20191212062826');

-- --------------------------------------------------------

--
-- Table structure for table Sales_order_line
--

DROP TABLE IF EXISTS Sales_order_line;
CREATE TABLE IF NOT EXISTS Sales_order_line (
  sol_id int(11) NOT NULL AUTO_INCREMENT,
  qntty int(11) DEFAULT NULL,
  prc int(11) DEFAULT NULL,
  dpst int(11) DEFAULT NULL,
  prod_id int(11) DEFAULT NULL,
  so_id int(11) DEFAULT NULL,
  refund int(11) NOT NULL,
  PRIMARY KEY (sol_id)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table Sales_order_line
--

INSERT INTO Sales_order_line (sol_id, qntty, prc, dpst, prod_id, so_id, refund) VALUES
(1, 3, 126, 0, 2, 10, 0),
(2, 4, 126, 0, 2, 11, 0),
(3, 2, 126, 24, 2, 12, 1),
(4, 2, 126, 0, 3, 12, 0),
(5, 3, 126, 0, 2, 13, 0),
(6, 6, 126, 0, 3, 13, 0),
(7, 10, 126, 0, 3, 14, 0),
(8, 5, 126, 0, 2, 14, 0),
(9, 4, 126, 0, 2, 15, 0),
(10, 2, 126, 0, 2, 16, 0),
(11, 3, 126, 0, 2, 17, 0),
(12, 3, 126, 0, 3, 18, 0),
(13, 4, 126, 0, 2, 18, 0),
(14, 3, 126, 0, 2, 20, 0),
(15, 13, 126, 0, 2, 21, 0),
(16, 2, 126, 0, 2, 22, 0),
(17, 3, 126, 0, 3, 22, 0),
(18, 2, 126, 60, 3, 23, 1),
(19, 1, 126, 72, 2, 23, 1),
(20, 3, 165, 72, 2, 24, 1),
(21, 3, 340, 0, 6, 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table Stock_In
--

DROP TABLE IF EXISTS Stock_In;
CREATE TABLE IF NOT EXISTS Stock_In (
  si_id int(11) NOT NULL AUTO_INCREMENT,
  stck_dt date DEFAULT NULL,
  PRIMARY KEY (si_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table Stock_In_Line
--

DROP TABLE IF EXISTS Stock_In_Line;
CREATE TABLE IF NOT EXISTS Stock_In_Line (
  sil_id int(11) NOT NULL AUTO_INCREMENT,
  qntty int(11) DEFAULT NULL,
  unt_prc int(11) DEFAULT NULL,
  prod_id int(11) DEFAULT NULL,
  date datetime DEFAULT NULL,
  prof_id int(11) DEFAULT NULL,
  PRIMARY KEY (sil_id)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table Stock_In_Line
--

INSERT INTO Stock_In_Line (sil_id, qntty, unt_prc, prod_id, date, prof_id) VALUES
(1, 30, 226, 2, '2019-12-02 15:42:23', 1),
(2, 32, 126, 2, '2019-12-02 15:46:40', 1),
(3, 35, 126, 2, '2019-12-02 15:47:55', 1),
(4, 31, 126, 2, '2019-12-02 15:48:18', 1),
(5, 65, 126, 2, '2019-12-02 15:49:03', 1),
(6, 32, 126, 2, '2019-12-02 15:51:13', 1),
(7, 3, 125, 2, '2019-12-02 15:52:12', 1),
(8, 26, 125, 3, '2019-12-10 07:42:56', 1),
(9, 97, 239, 6, '2019-12-12 18:27:46', 1);