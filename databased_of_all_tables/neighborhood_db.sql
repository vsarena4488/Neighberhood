-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: neighborhood_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `neighborhood_db`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `neighborhood_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `neighborhood_db`;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,1,'Admin Login','Administrator logged into Admin Panel','127.0.0.1','2026-10-19 03:56:33'),(2,3,'Property Listing Created','Owner created listing Sunrise Executive PG for Boys','127.0.0.1','2026-10-19 03:56:33'),(3,2,'Booking Created','Student created booking #B1024 for property 101','127.0.0.1','2026-10-19 03:56:33'),(4,2,'Token Payment','Paid ₹500 via UPI (TXN-78901)','127.0.0.1','2026-10-19 03:56:33');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `room_type` varchar(150) DEFAULT NULL,
  `move_in_date` date NOT NULL,
  `duration` varchar(50) NOT NULL,
  `rent` decimal(10,2) NOT NULL,
  `deposit` decimal(10,2) NOT NULL,
  `token_fee` decimal(10,2) DEFAULT 500.00,
  `token_status` varchar(50) DEFAULT 'Paid Online',
  `move_in_balance` decimal(10,2) NOT NULL,
  `status` enum('Pending','Approved','Active','Completed','Cancelled','Rejected') DEFAULT 'Pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `property_id` (`property_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES ('B1022',2,103,6,'Complete 2BHK Apartment','2026-01-15','5 Months',28000.00,70000.00,500.00,'Paid Online',97500.00,'Completed','Deposit refunded upon check-out.','2026-10-19 03:56:33','2026-10-19 03:56:33'),('B1023',2,102,4,'Standard Single Occupancy','2026-08-15','6 Months',11000.00,18000.00,500.00,'Paid Online',28500.00,'Active','Biometric card registered.','2026-10-19 03:56:33','2026-10-19 03:56:33'),('B1024',2,101,1,'Standard Single Room','2026-09-01','3 Months',9500.00,15000.00,500.00,'Paid Online',24000.00,'Pending','Preferred ground or 1st floor if available.','2026-10-19 03:56:33','2026-10-19 03:56:33'),('B1025',6,301,11,'2-Sharing Student Desk Room','2026-09-10','12 Months',7500.00,10000.00,500.00,'Paid Online',17000.00,'Pending','Student ID verified.','2026-10-19 03:56:33','2026-10-19 03:56:33');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `priority` enum('Low','Medium','High','Critical') DEFAULT 'Medium',
  `status` enum('Open','Investigating','Resolved','Dismissed') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaints`
--

LOCK TABLES `complaints` WRITE;
/*!40000 ALTER TABLE `complaints` DISABLE KEYS */;
INSERT INTO `complaints` VALUES (1,2,101,'Wi-Fi Speed Fluctuations in Room 204','Intermittent disconnects during online college classes in the evening hours.','Medium','Resolved','2026-10-19 03:56:33'),(2,6,301,'Hot Water Geyser Low Pressure','The 2nd-floor geyser has low pressure in the morning.','Low','Investigating','2026-10-19 03:56:33');
/*!40000 ALTER TABLE `complaints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disputes`
--

DROP TABLE IF EXISTS `disputes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disputes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('Open','Reviewing','Resolved','Refunded') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disputes`
--

LOCK TABLES `disputes` WRITE;
/*!40000 ALTER TABLE `disputes` DISABLE KEYS */;
INSERT INTO `disputes` VALUES (1,'B1022',2,5,2000.00,'Disputed cleaning fee deduction from deposit','Resolved','2026-10-19 03:56:33');
/*!40000 ALTER TABLE `disputes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `booking_id` varchar(50) DEFAULT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,3,2,101,'B1024','Hello Vishal, thanks for your booking inquiry on St. Marks Executive PG.',NULL,1,'2026-08-29 05:00:00'),(2,2,3,101,'B1024','Hi Rajesh ji! Is high-speed Wi-Fi included in the room rent?',NULL,1,'2026-08-29 05:02:00'),(3,3,2,101,'B1024','Yes, 200 Mbps fiber Wi-Fi with backup router is 100% free and included.',NULL,1,'2026-08-29 05:04:00'),(4,2,3,101,'B1024','Awesome! Can I visit for a quick physical inspection tomorrow afternoon?',NULL,1,'2026-08-29 05:05:00'),(5,3,2,101,'B1024','Yes, the single occupancy room is confirmed available from Sep 1. You can visit anytime between 2 PM and 6 PM.',NULL,0,'2026-08-29 05:07:00'),(6,2,4,102,'B1023','Hi Priya, I wanted to confirm biometric registration.',NULL,1,'2026-08-14 08:30:00'),(7,4,2,102,'B1023','I have scheduled your gate entry card pass. See you soon!',NULL,0,'2026-08-14 09:00:00');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `icon` varchar(100) DEFAULT 'fa-bell',
  `color` varchar(50) DEFAULT 'primary',
  `link` varchar(255) DEFAULT '#',
  `unread` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,2,'Booking Application Submitted','Your request for St. Marks Executive PG (#B1024) was sent to landlord Rajesh Sharma.','fa-calendar-check','primary','booking-details.php?id=B1024',1,'2026-08-29 04:59:00'),(2,2,'New Chat Message Received','Rajesh Sharma: Yes, the single occupancy room is confirmed available from Sep 1...','fa-comment-dots','success','messages.php?chat=chat_1',1,'2026-08-29 05:07:00'),(3,2,'Token Fee Payment Successful','Payment of ₹500 received for booking #B1024. Transaction ID: TXN-78901.','fa-receipt','warning','booking-details.php?id=B1024',0,'2026-08-29 04:58:00'),(4,3,'New Booking Request #B1024','Vishal Patel has requested Standard Single Room from Sep 01, 2026.','fa-calendar-plus','primary','booking-details.php?id=B1024',1,'2026-08-29 04:59:00'),(5,3,'Token Deposit Credited','₹500 token fee credited for booking #B1024.','fa-wallet','success','earnings.php',1,'2026-08-29 04:58:00'),(6,1,'New Property Awaiting Verification','Sunrise Executive PG for Boys submitted by Rajesh Sharma needs approval.','fa-building','warning','Property Management/pending_approval.php',1,'2026-08-29 03:30:00');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` varchar(50) NOT NULL,
  `booking_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_type` varchar(50) DEFAULT 'Token Deposit',
  `method` varchar(50) DEFAULT 'UPI',
  `status` enum('Completed','Pending','Failed','Refunded') DEFAULT 'Completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `booking_id` (`booking_id`),
  KEY `user_id` (`user_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES ('TXN-78901','B1024',2,3,500.00,'Token Deposit','UPI / PhonePe','Completed','2026-08-29 04:58:00'),('TXN-78902','B1023',2,4,500.00,'Token Deposit','Google Pay','Completed','2026-08-05 05:45:00'),('TXN-78903','B1023',2,4,28500.00,'Move-in Balance','Net Banking','Completed','2026-08-15 04:00:00'),('TXN-78904','B1022',2,5,500.00,'Token Deposit','Card Payment','Completed','2026-01-02 08:30:00'),('TXN-78905','B1025',6,8,500.00,'Token Deposit','Paytm UPI','Completed','2026-08-28 11:15:00');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('PG','Hostel','Apartment','Room','House') NOT NULL DEFAULT 'PG',
  `city` varchar(100) NOT NULL,
  `area` varchar(150) NOT NULL,
  `address` text DEFAULT NULL,
  `rent` decimal(10,2) NOT NULL,
  `deposit` decimal(10,2) NOT NULL,
  `gender` enum('male_only','female_only','unisex') NOT NULL DEFAULT 'unisex',
  `status` enum('pending','approved','rejected','reported') DEFAULT 'approved',
  `rating` decimal(2,1) DEFAULT 4.8,
  `reviews_count` int(11) DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `available_beds` int(11) DEFAULT 1,
  `total_rooms` int(11) DEFAULT 1,
  `verified` tinyint(1) DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `gallery` text DEFAULT NULL,
  `amenities` text DEFAULT NULL,
  `rules` text DEFAULT NULL,
  `nearby` text DEFAULT NULL,
  `lat` decimal(10,7) DEFAULT 12.9716000,
  `lng` decimal(10,7) DEFAULT 77.5946000,
  `description` text DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `city` (`city`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=403 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `properties`
--

LOCK TABLES `properties` WRITE;
/*!40000 ALTER TABLE `properties` DISABLE KEYS */;
INSERT INTO `properties` VALUES (101,3,'St. Mark\'s Executive PG for Men','PG','Bangalore','Koramangala 4th Block',NULL,9500.00,15000.00,'male_only','approved',4.9,24,1420,2,12,1,'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80','[\"https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80\", \"https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80\", \"https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80\"]','[\"High-Speed Wi-Fi\", \"3-Time Meals\", \"AC\", \"Daily Housekeeping\", \"Laundry\", \"CCTV Security\", \"Power Backup\", \"Geyser\", \"Study Table\"]','[\"Gate curfew: 10:30 PM (Digital intimation for late returns)\", \"Visitors allowed in ground-floor common lounge\", \"Strict non-smoking and peaceful study atmosphere\"]','[\"0.4 km to Forum Mall\", \"0.8 km to Christ University\", \"1.2 km to Sony World Signal\", \"1.5 km to Koramangala Metro\"]',12.9352000,77.6245000,'Premium executive PG located right in Koramangala 4th Block. Includes delicious home-cooked North and South Indian meals, 200Mbps fiber Wi-Fi, biometric security entry, and daily room cleaning.',NULL,'2026-10-19 03:56:33','2026-10-19 03:56:33'),(102,4,'Serenity Women\'s Luxury Hostel & PG','PG','Bangalore','HSR Layout Sector 1',NULL,11000.00,18000.00,'female_only','approved',4.8,19,1210,2,10,1,'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80','[\"https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80\", \"https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80\"]','[\"High-Speed Wi-Fi\", \"North & South Meals\", \"24/7 Female Warden\", \"Biometric Lock\", \"Geyser\", \"Washing Machine\", \"Rooftop Lounge\"]','[\"Gate entry before 10:00 PM\", \"Male visitors strictly restricted to Reception\", \"ID verification required\"]','[\"0.5 km to NIFT Bangalore\", \"1.0 km to BDA Complex HSR\", \"0.3 km to 27th Main Food Street\"]',12.9121000,77.6446000,'Top-rated safe and secure luxury girls hostel & PG in HSR Layout. 24/7 CCTV surveillance, biometric access, nutritious hygienic meals, and serene study areas.',NULL,'2026-10-19 03:56:33','2026-10-19 03:56:33'),(103,5,'Greenwood Independent 2BHK Apartment','Apartment','Bangalore','Indiranagar 100ft Road',NULL,28000.00,70000.00,'unisex','approved',4.7,12,890,1,3,1,'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80','[\"https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80\"]','[\"Furnished Kitchen\", \"High-Speed Wi-Fi\", \"Covered Parking\", \"Washing Machine\", \"Balcony Garden\", \"Power Backup\"]','[\"No loud music post 10:30 PM\", \"Quiet residential society etiquette\"]','[\"0.3 km to CMH Road Metro\", \"0.6 km to 100ft Road High Street\", \"1.5 km to Manipal Hospital\"]',12.9784000,77.6408000,'Spacious, sunlit 2BHK flat available for students or working professionals. Zero brokerage, peaceful neighborhood, full modular kitchen, and modern wooden wardrobes.',NULL,'2026-10-19 03:56:33','2026-10-19 03:56:33'),(104,3,'Whitefield Tech Scholars Co-Living','Hostel','Bangalore','Whitefield ITPL',NULL,8500.00,12000.00,'unisex','approved',4.5,31,1640,4,20,1,'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80','[\"https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80\"]','[\"High-Speed Wi-Fi\", \"Daily Meals\", \"Gaming Room\", \"Study Pods\", \"Gym Access\", \"Laundry\", \"24/7 Security\"]','[\"24/7 RFID keycard entry\", \"Gym hours 6 AM to 10 PM\"]','[\"0.4 km to ITPL Main Gate\", \"0.6 km to Pattandur Agrahara Metro\", \"1.0 km to Inorbit Mall\"]',12.9850000,77.7289000,'Vibrant co-living hostel designed for techies and college interns near ITPL Whitefield. Community lounge, gym, and high-speed working desks.',NULL,'2026-10-19 03:56:33','2026-10-19 03:56:33'),(105,3,'Koramangala Tech Residency Studio Flat','Apartment','Bangalore','Koramangala 5th Block',NULL,22000.00,50000.00,'unisex','approved',4.8,11,980,1,4,1,'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80','[\"https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80\"]','[\"Covered Parking\", \"Power Backup\", \"Modular Kitchen\", \"Balcony\", \"Lift Backup\"]','[\"No loud music post 10 PM\", \"Society gate entry logs after 11 PM\"]','[\"0.2 km to Jyoti Nivas College\", \"0.4 km to Koramangala Club\"]',12.9340000,77.6180000,'Modern 1BHK studio apartment right next to popular cafes and college campuses in Koramangala 5th Block.',NULL,'2026-10-19 03:56:33','2026-10-19 03:56:33'),(201,8,'Bandra Sea Breeze Private Single Room','Room','Mumbai','Bandra West',NULL,18500.00,35000.00,'male_only','approved',4.9,16,750,1,3,1,'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80','[\"https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80\"]','[\"AC\", \"High-Speed Wi-Fi\", \"Attached Washroom\", \"Housekeeping\", \"Balcony\", \"Geyser\"]','[\"No smoking indoors\", \"Quiet residential society rules apply\"]','[\"0.4 km to Linking Road\", \"1.0 km to Bandra Station\", \"0.6 km to Carter Road Promenade\"]',19.0596000,72.8295000,'Fully furnished air-conditioned private bedroom in a premium Bandra West apartment. Attached modern bathroom and pleasant sea breeze.',NULL,'2026-10-19 03:56:33','2026-10-19 03:56:33'),(301,8,'North Campus Scholars Co-Living Hostel','Hostel','Delhi','North Campus DU',NULL,7500.00,10000.00,'unisex','approved',4.6,28,1120,5,18,1,'https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=800&q=80','[\"https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=800&q=80\"]','[\"High-Speed Wi-Fi\", \"Study Library Desk\", \"3-Time Meals\", \"Power Backup\", \"CCTV\", \"RO Water\"]','[\"Study hours 8 PM - 11 PM\", \"Hygienic dining etiquette required\"]','[\"0.2 km to Vishwavidyalaya Metro\", \"0.5 km to Hindu College\", \"0.6 km to SRCC\"]',28.6903000,77.2134000,'Dedicated student hostel near Delhi University. Features quiet study library room, high-speed fiber internet, and nutritious student mess food.',NULL,'2026-10-19 03:56:33','2026-10-19 03:56:33'),(401,3,'Sunrise Executive PG for Boys','PG','Bangalore','Electronic City Phase 1',NULL,8000.00,12000.00,'male_only','pending',4.5,0,110,4,8,0,'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&fit=crop','[\"https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&fit=crop\"]','[\"Wi-Fi\", \"Meals\", \"Power Backup\", \"Geyser\"]','[\"Curfew: 10:00 PM\"]','[\"Near Infosys Gate 1\"]',12.8399000,77.6770000,'Brand new PG submitted for platform verification in Electronic City.',NULL,'2026-10-19 03:56:33','2026-10-19 03:56:33'),(402,4,'Riverside Co-Living Residence','Hostel','Mumbai','Andheri West',NULL,12500.00,20000.00,'unisex','pending',4.7,0,95,6,12,0,'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&fit=crop','[\"https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&fit=crop\"]','[\"Wi-Fi\", \"AC\", \"Housekeeping\", \"Security\"]','[\"ID check at gate\"]','[\"0.5 km to Andheri Metro\"]',19.1197000,72.8468000,'Newly listed modern hostel waiting for administrator verification.',NULL,'2026-10-19 03:56:33','2026-10-19 03:56:33');
/*!40000 ALTER TABLE `properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_rooms`
--

DROP TABLE IF EXISTS `property_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `occupancy` varchar(50) NOT NULL,
  `rent` decimal(10,2) NOT NULL,
  `deposit` decimal(10,2) NOT NULL,
  `available` int(11) DEFAULT 1,
  `total` int(11) DEFAULT 1,
  `status` varchar(50) DEFAULT 'Available',
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_rooms`
--

LOCK TABLES `property_rooms` WRITE;
/*!40000 ALTER TABLE `property_rooms` DISABLE KEYS */;
INSERT INTO `property_rooms` VALUES (1,101,'Standard Single Room','Single',9500.00,15000.00,1,4,'Available'),(2,101,'Premium Single Room (with Balcony)','Single',12000.00,20000.00,0,2,'Booked'),(3,101,'Standard Double Sharing Room','Double',7000.00,12000.00,1,6,'Available'),(4,102,'Standard Single Occupancy','Single',11000.00,18000.00,1,4,'Available'),(5,102,'Double Sharing Deluxe','Double',8500.00,14000.00,1,6,'Available'),(6,103,'Complete 2BHK Apartment','Entire Flat',28000.00,70000.00,1,1,'Available'),(7,104,'Single Private Pod','Single',10500.00,15000.00,2,8,'Available'),(8,104,'2-Sharing Studio Bed','Double',8000.00,12000.00,2,12,'Available'),(9,105,'Full 1BHK Studio Apartment','Entire Flat',22000.00,50000.00,1,4,'Available'),(10,201,'Master Bedroom with Balcony','Single',18500.00,35000.00,1,3,'Available'),(11,301,'2-Sharing Student Desk Room','Double',7500.00,10000.00,5,18,'Available');
/*!40000 ALTER TABLE `property_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text NOT NULL,
  `owner_reply` text DEFAULT NULL,
  `owner_reply_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,101,2,5,'Clean rooms, delicious and hygienic meals 3 times a day, and very quiet study environment. Owner Rajesh ji is helpful!','Thank you Vishal! Happy to have you at St. Marks.','2026-06-20 11:00:00','2026-06-19 13:00:00'),(2,102,7,5,'Extremely safe for girls students with 24/7 female warden. Rooftop study area is amazing.','Thank you Ananya for your kind review!','2026-07-15 10:15:00','2026-07-14 11:10:00'),(3,103,6,4,'Very spacious apartment in Indiranagar. Great connectivity to metro.',NULL,NULL,'2026-05-10 06:50:00');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','owner','user') NOT NULL DEFAULT 'user',
  `user_type` varchar(50) DEFAULT 'student',
  `city` varchar(100) DEFAULT 'Bangalore',
  `avatar` varchar(255) DEFAULT 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
  `college` varchar(200) DEFAULT NULL,
  `course` varchar(200) DEFAULT NULL,
  `year` varchar(50) DEFAULT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT 'Male',
  `emergency_contact` varchar(100) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `status` enum('active','pending','blocked') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'System Administrator','admin@neighborhood.com','+91 99000 11223','$2y$10$Fec6.RRE1zOHMi9K9D2pW.wGxv4OiMGDaVsbCSxTYn/3EoMnYAYre','admin','admin','Bangalore','https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=200&q=80',NULL,NULL,NULL,NULL,NULL,'Male',NULL,'NeighborNest Inc.',1,'active','2026-10-19 03:56:33','2026-10-19 03:56:33'),(2,'Vishal Patel','vishal.patel@example.com','+91 98765 43210','$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa','user','student','Bangalore','https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80','Christ University, Bangalore','B.Tech Computer Science','4th Year (Final Year)','CU-2022-CS-4891','2001-08-15','Male','+91 98765 00000 (Father)',NULL,1,'active','2026-10-19 03:56:33','2026-10-19 03:56:33'),(3,'Rajesh Sharma','rajesh.sharma@neighborhood.com','+91 98765 43210','$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa','owner','owner','Bangalore','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',NULL,NULL,NULL,NULL,NULL,'Male',NULL,'St. Mark Accommodations & Living Solutions',1,'active','2026-10-19 03:56:33','2026-10-19 03:56:33'),(4,'Priya Sharma','priya.sharma@neighborhood.com','+91 98450 11223','$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa','owner','owner','Bangalore','https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80',NULL,NULL,NULL,NULL,NULL,'Female',NULL,'Serenity Living Hostels',1,'active','2026-10-19 03:56:33','2026-10-19 03:56:33'),(5,'Sara Khan','sara.khan@neighborhood.com','+91 97312 88990','$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa','owner','owner','Bangalore','https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80',NULL,NULL,NULL,NULL,NULL,'Female',NULL,'Greenwood Estates',1,'active','2026-10-19 03:56:33','2026-10-19 03:56:33'),(6,'Rahul Verma','rahul.verma@example.com','+91 98111 22334','$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa','user','student','Delhi','https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80','Delhi University','B.Com Honours','2nd Year','DU-2023-BC-112','2003-02-10','Male','+91 98111 00000',NULL,1,'active','2026-10-19 03:56:33','2026-10-19 03:56:33'),(7,'Ananya Sen','ananya.sen@example.com','+91 98222 33445','$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa','user','student','Mumbai','https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80','NMIMS Mumbai','BBA Finance','3rd Year','NM-2022-BB-903','2002-11-20','Female','+91 98222 00000',NULL,1,'active','2026-10-19 03:56:33','2026-10-19 03:56:33'),(8,'Vikram Singh','vikram.singh@neighborhood.com','+91 98333 44556','$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa','owner','owner','Mumbai','https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=200&q=80',NULL,NULL,NULL,NULL,NULL,'Male',NULL,'Metro Luxury Rentals',1,'active','2026-10-19 03:56:33','2026-10-19 03:56:33');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_property_wish` (`user_id`,`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
INSERT INTO `wishlists` VALUES (1,2,101,'2026-10-19 03:56:33'),(2,2,102,'2026-10-19 03:56:33'),(3,2,103,'2026-10-19 03:56:33'),(4,2,104,'2026-10-19 03:56:33'),(5,2,201,'2026-10-19 03:56:33'),(6,2,301,'2026-10-19 03:56:33');
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'neighborhood_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-19 10:01:21
