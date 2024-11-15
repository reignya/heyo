SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `parkingz`

-- --------------------------------------------------------
-- Table structure for table `tblregusers`
--
CREATE TABLE `tblregusers` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(250) DEFAULT NULL,
  `LastName` varchar(250) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(250) DEFAULT NULL,
  `Password` varchar(250) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `user_type` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `LicenseNumber` varchar(50) DEFAULT NULL,
  `registration_status` varchar(25) NOT NULL,
  `or_image` varchar(255) DEFAULT NULL,
  `cr_image` varchar(255) DEFAULT NULL,
  `nv_image` varchar(255) DEFAULT NULL,
  `QRCode` varchar(250) DEFAULT NULL,
  `verification_status` enum('pending','verified') DEFAULT 'pending',
  `profile_pictures` varchar(75) DEFAULT NULL,
  `validity` tinyint(4) NOT NULL DEFAULT -2,
  `status` enum('active','inactive','pending') DEFAULT 'inactive',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Email` (`Email`),
  KEY `MobileNumber` (`MobileNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------
-- Table structure for table `tblvehicle`
--
CREATE TABLE `tblvehicle` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ParkingNumber` varchar(120) DEFAULT NULL,
  `VehicleCategory` varchar(120) NOT NULL,
  `VehicleCompanyname` varchar(120) DEFAULT NULL,
  `RegistrationNumber` varchar(120) DEFAULT NULL,
  `OwnerName` varchar(120) DEFAULT NULL,
  `OwnerContactNumber` bigint(10) DEFAULT NULL,
  `InTime` timestamp NULL DEFAULT current_timestamp(),
  `OutTime` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ParkingCharge` varchar(120) NOT NULL,
  `Remark` mediumtext NOT NULL,
  `Status` varchar(5) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------
-- Table structure for table `tbladmin`
--
CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------
-- Table structure for table `tblcategory`
--
CREATE TABLE `tblcategory` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `VehicleCat` varchar(120) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`),
  KEY `VehicleCat` (`VehicleCat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------
-- Table structure for table `tblparkingslots`
--
CREATE TABLE `tblparkingslots` (
  `SlotNumber` varchar(50) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'Vacant',
  UNIQUE KEY `unique_slot_number` (`SlotNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------
-- Table structure for table `tblqr_login`
--
CREATE TABLE `tblqr_login` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `ContactNumber` varchar(11) DEFAULT NULL,
  `VehicleType` varchar(50) NOT NULL,
  `VehiclePlateNumber` varchar(20) NOT NULL,
  `ParkingSlot` varchar(25) NOT NULL,
  `TIMEIN` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `tblqr_logout`
--
CREATE TABLE `tblqr_logout` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `ContactNumber` varchar(11) DEFAULT NULL,
  `VehicleType` varchar(50) NOT NULL,
  `VehiclePlateNumber` varchar(20) NOT NULL,
  `ParkingSlot` varchar(25) NOT NULL,
  `TIMEOUT` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `tblmanual_login`
--
CREATE TABLE `tblmanual_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OwnerName` varchar(50) NOT NULL,
  `OwnerContactNumber` varchar(11) NOT NULL,
  `VehicleCategory` varchar(25) NOT NULL,
  `RegistrationNumber` varchar(25) NOT NULL,
  `ParkingSlot` varchar(10) NOT NULL,
  `TimeIn` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `tblmanual_logout`
--
CREATE TABLE `tblmanual_logout` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `OwnerName` varchar(50) DEFAULT NULL,
  `OwnerContactNumber` varchar(11) DEFAULT NULL,
  `VehicleCategory` varchar(25) DEFAULT NULL,
  `RegistrationNumber` varchar(25) DEFAULT NULL,
  `ParkingSlot` varchar(10) DEFAULT NULL,
  `TimeOut` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `uploads`
--
CREATE TABLE `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(25) NOT NULL,
  `file_size` int(11) NOT NULL CHECK (`file_size` > 0),
  `file_type` varchar(50) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `email` varchar(250) DEFAULT NULL,
  `validity` int(11) DEFAULT 0,
  `expiration_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `messages`
--
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `isSupport` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `feedbacks`
--
CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT 'Anonymous',
  `feedback` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `comments`
--
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `table_attendance`
--
CREATE TABLE `table_attendance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `STUDENTID` varchar(250) NOT NULL,
  `TIMEIN` varchar(250) NOT NULL,
  `TIMEOUT` varchar(250) NOT NULL,
  `LOGDATE` varchar(250) NOT NULL,
  `AM` varchar(250) NOT NULL,
  `PM` varchar(250) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
