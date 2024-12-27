-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2024 at 04:43 AM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `wpk4_backend_travel_booking_pax`
--

CREATE TABLE `wpk4_backend_travel_booking_pax` (
  `auto_id` int(11) NOT NULL,
  `traceId` varchar(250) DEFAULT NULL,
  `purchaseid` varchar(250) DEFAULT NULL,
  `booking_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `salutation` varchar(50) DEFAULT NULL,
  `fname` varchar(200) DEFAULT NULL,
  `lname` varchar(200) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `paxType` varchar(100) DEFAULT NULL,
  `mobile_no` bigint(20) DEFAULT NULL,
  `passportNumber` varchar(100) DEFAULT NULL,
  `passportDOI` varchar(100) DEFAULT NULL,
  `passportDOE` varchar(100) DEFAULT NULL,
  `passportIssuedCountry` varchar(100) DEFAULT NULL,
  `seatPref` varchar(100) DEFAULT NULL,
  `addressName` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `AddresState` varchar(100) DEFAULT NULL,
  `postalCode` varchar(100) DEFAULT NULL,
  `countryName` varchar(100) DEFAULT NULL,
  `countryCode` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `passengerNationality` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wpk4_backend_travel_booking_pax`
--

INSERT INTO `wpk4_backend_travel_booking_pax` (`auto_id`, `traceId`, `purchaseid`, `booking_status`, `salutation`, `fname`, `lname`, `email`, `gender`, `dob`, `paxType`, `mobile_no`, `passportNumber`, `passportDOI`, `passportDOE`, `passportIssuedCountry`, `seatPref`, `addressName`, `street`, `AddresState`, `postalCode`, `countryName`, `countryCode`, `city`, `passengerNationality`) VALUES
(1, '70366faa-9ced-4c63-8719-365d2b8e3577', '638550447113665983', '[CONFIRMED]', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '2018-05-06', 'Adult', 8097972852, '12015', '2015-08-15', '2031-07-12', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'Barbados', 'Thane', 'MH'),
(2, 'ed1f5ba5-5a70-4234-9cb9-f6734399a0fb', '638550450584541119', '[CONFIRMED]', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '2019-05-07', 'Adult', 8097972852, '4664646', '2011-03-16', '2037-06-15', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'Bahrain', 'Thane', 'MH'),
(3, 'da0d092d-0812-4454-a293-54c67e64f1a2', '638550467687659298', '[CONFIRMED]', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1967-03-10', 'Adult', 8097972852, '4664646', '2015-04-17', '2034-04-06', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'MH'),
(4, 'db95e48e-fb5e-40aa-96aa-9092f7843eb2', '638550471723774553', '[CONFIRMED]', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-06-09', 'Adult', 8097972852, '12105', '2020-08-13', '2040-05-14', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'MH'),
(5, '0f35acca-4596-4a8e-a829-fa4195e826b3', '638550484566610245', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-05', 'Adult', 8097972852, '12105', '2020-05-14', '2040-07-12', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(6, '0f35acca-4596-4a8e-a829-fa4195e826b3', '638550484566610245', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-05-08', 'Adult', 8097972852, '4664646', '2015-07-15', '2035-04-20', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(7, '6911dfb5-7e1a-40ec-9ee6-1e0b8639c9de', '638550490549113809', '[CONFIRMED]', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-07-10', 'Adult', 8097972852, '12105', '2021-04-19', '2037-04-13', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(8, '90ca7f28-8baa-458b-af29-ff3ce504d885', '638550638664639239', '[CONFIRMED]', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-06-06', 'Adult', 8097972852, '12105', '2016-04-14', '2038-06-13', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(9, '1fcbdbfc-58d3-4fd1-9e09-cba025781b8b', '638550644299742005', '[CONFIRMED]', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1991-03-12', 'Adult', 8097972852, '12105425432', '2020-03-15', '2040-06-12', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(10, '309c233b-b9f1-4f27-9029-d4f812a4ad77', '638552157195712132', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-12', 'Adult', 8097972852, '12105425432', '2020-04-12', '2040-05-12', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(11, '50f4b4d1-664c-4e25-b686-c80155a7c386', '638563465684051890', 'Processing', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-06-04', 'Adult', 8097972852, '12105', '2015-04-16', '2042-04-13', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(12, '43032ebb-0baf-4e84-af72-6c9e0b8adb3b', '638563511751427600', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-05', 'Adult', 8097972852, '12105', '2010-03-12', '2040-03-12', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(13, '6a0141cd-3293-40d3-a363-791b35b27807', '638563513992564673', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-12', 'Adult', 8097972852, '12105', '2010-02-16', '2040-03-12', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(14, 'ce54f0fb-6732-4fe7-b8aa-a9f1d210c17d', '638563516348957458', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-03', 'Adult', 8097972852, '12105', '2010-03-01', '2040-03-11', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(15, 'b96bc2c3-1cd6-4613-b04d-0015f4e17dd8', '638566214762529848', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-04-11', 'Adult', 8097972852, '12105', '2013-03-14', '2040-07-14', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(16, 'dfd95e4c-1a64-40f6-bbf4-c005adb8532f', '638566218619635711', 'Processing', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-05', 'Adult', 8097972852, '12105', '2010-04-11', '2040-04-11', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(17, 'dfd95e4c-1a64-40f6-bbf4-c005adb8532f', '638566218619635711', 'Processing', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-12', 'Adult', 8097972852, '12105', '2020-03-10', '2040-03-11', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(18, 'e213110f-ea99-4348-bc91-944e32d3a06e', '638566265456112876', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-11', 'Adult', 8097972852, '4664646', '2010-03-15', '2040-04-15', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(19, 'c46dd065-76fb-47fb-86bf-f970d92b0181', '638566813507042903', 'Processing', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-12', 'Adult', 8097972852, '4664646', '2016-03-15', '2042-04-14', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(20, 'c46dd065-76fb-47fb-86bf-f970d92b0181', '638566813507042903', 'Processing', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-12', 'Adult', 8097972852, '4664646', '2011-03-12', '2040-04-15', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(21, '2977e36c-f1bf-4be8-a40c-f44fd956ed59', '638568815855901427', 'Processing', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-12', 'Adult', 8097972852, '4664646', '2017-05-12', '2039-06-12', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(22, '0bc5edad-d5bf-49e6-b16f-fe1cf7e2a1a3', '638568821870560664', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1996-04-12', 'Adult', 8097972852, '4664646', '2015-05-12', '2040-08-08', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(23, '9e8c8125-75a4-488e-b1e1-9ce6ad422960', '638572190402781438', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-12', 'Adult', 8097972852, '4664646', '2020-06-11', '2040-08-11', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(24, 'e76fd03e-00bc-430e-b586-dcc94ce5971a', '638573871512869224', 'CONFIRMED', 'Mrs', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '1999-03-12', 'Adult', 8097972852, '4664646', '2022-03-12', '2032-05-10', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(25, 'e76fd03e-00bc-430e-b586-dcc94ce5971a', '638573871512869224', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '2019-04-05', 'Child', 8097972852, '4664646', '2020-04-07', '2033-07-08', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(26, 'e76fd03e-00bc-430e-b586-dcc94ce5971a', '638573871512869224', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran88@gmail.com', 'M', '2020-05-07', 'Child', 8097972852, '4664646', '2020-06-05', '2036-06-05', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN'),
(27, 'cc37a34d-832b-4f8d-8a2b-4f2cdbdc6c37', '638604095065161140', 'CONFIRMED', 'Mr', 'Kiran', 'dhoke', 'dhokekiran98@gmail.com', 'M', '1995-03-12', 'Adult', 8097972852, '4664646', '2015-09-13', '2039-10-16', 'IN', 'N', 'shastri nagar', 'vaman bhaskar koli chawl r', 'Maharashtra', '400606', 'IN', 'India', 'Thane', 'IN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wpk4_backend_travel_booking_pax`
--
ALTER TABLE `wpk4_backend_travel_booking_pax`
  ADD PRIMARY KEY (`auto_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wpk4_backend_travel_booking_pax`
--
ALTER TABLE `wpk4_backend_travel_booking_pax`
  MODIFY `auto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
