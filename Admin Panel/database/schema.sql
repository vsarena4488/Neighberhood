-- ============================================================
-- NeighborNest (NeighborHood) Master Database Schema
-- Compatible with MySQL 5.7+ / MariaDB 10.3+
-- Database: neighborhood_db
-- ============================================================

CREATE DATABASE IF NOT EXISTS `neighborhood_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `neighborhood_db`;

-- ------------------------------------------------------------
-- 1. USERS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `phone` VARCHAR(50) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'owner', 'user') NOT NULL DEFAULT 'user',
  `user_type` VARCHAR(50) DEFAULT 'student',
  `city` VARCHAR(100) DEFAULT 'Bangalore',
  `avatar` VARCHAR(255) DEFAULT 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
  `college` VARCHAR(200) DEFAULT NULL,
  `course` VARCHAR(200) DEFAULT NULL,
  `year` VARCHAR(50) DEFAULT NULL,
  `student_id` VARCHAR(100) DEFAULT NULL,
  `dob` DATE DEFAULT NULL,
  `gender` VARCHAR(20) DEFAULT 'Male',
  `emergency_contact` VARCHAR(100) DEFAULT NULL,
  `company_name` VARCHAR(200) DEFAULT NULL,
  `is_verified` TINYINT(1) DEFAULT 0,
  `status` ENUM('active', 'pending', 'blocked') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 2. PROPERTIES TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `properties` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `owner_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `type` ENUM('PG', 'Hostel', 'Apartment', 'Room', 'House') NOT NULL DEFAULT 'PG',
  `city` VARCHAR(100) NOT NULL,
  `area` VARCHAR(150) NOT NULL,
  `address` TEXT DEFAULT NULL,
  `rent` DECIMAL(10,2) NOT NULL,
  `deposit` DECIMAL(10,2) NOT NULL,
  `gender` ENUM('male_only', 'female_only', 'unisex') NOT NULL DEFAULT 'unisex',
  `status` ENUM('pending', 'approved', 'rejected', 'reported') DEFAULT 'approved',
  `rating` DECIMAL(2,1) DEFAULT 4.8,
  `reviews_count` INT DEFAULT 0,
  `views` INT DEFAULT 0,
  `available_beds` INT DEFAULT 1,
  `total_rooms` INT DEFAULT 1,
  `verified` TINYINT(1) DEFAULT 1,
  `image` VARCHAR(255) DEFAULT NULL,
  `gallery` TEXT DEFAULT NULL,
  `amenities` TEXT DEFAULT NULL,
  `rules` TEXT DEFAULT NULL,
  `nearby` TEXT DEFAULT NULL,
  `lat` DECIMAL(10,7) DEFAULT 12.9716000,
  `lng` DECIMAL(10,7) DEFAULT 77.5946000,
  `description` TEXT DEFAULT NULL,
  `rejection_reason` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX (`city`),
  INDEX (`type`),
  INDEX (`status`),
  INDEX (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 3. PROPERTY ROOMS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `property_rooms` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `property_id` INT NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `occupancy` VARCHAR(50) NOT NULL,
  `rent` DECIMAL(10,2) NOT NULL,
  `deposit` DECIMAL(10,2) NOT NULL,
  `available` INT DEFAULT 1,
  `total` INT DEFAULT 1,
  `status` VARCHAR(50) DEFAULT 'Available',
  INDEX (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 4. BOOKINGS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` VARCHAR(50) PRIMARY KEY,
  `user_id` INT NOT NULL,
  `property_id` INT NOT NULL,
  `room_id` INT DEFAULT NULL,
  `room_type` VARCHAR(150) DEFAULT NULL,
  `move_in_date` DATE NOT NULL,
  `duration` VARCHAR(50) NOT NULL,
  `rent` DECIMAL(10,2) NOT NULL,
  `deposit` DECIMAL(10,2) NOT NULL,
  `token_fee` DECIMAL(10,2) DEFAULT 500.00,
  `token_status` VARCHAR(50) DEFAULT 'Paid Online',
  `move_in_balance` DECIMAL(10,2) NOT NULL,
  `status` ENUM('Pending', 'Approved', 'Active', 'Completed', 'Cancelled', 'Rejected') DEFAULT 'Pending',
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX (`user_id`),
  INDEX (`property_id`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 5. MESSAGES TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `sender_id` INT NOT NULL,
  `receiver_id` INT NOT NULL,
  `property_id` INT DEFAULT NULL,
  `booking_id` VARCHAR(50) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `attachment` VARCHAR(255) DEFAULT NULL,
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (`sender_id`),
  INDEX (`receiver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 6. REVIEWS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `property_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `rating` INT NOT NULL CHECK(`rating` BETWEEN 1 AND 5),
  `comment` TEXT NOT NULL,
  `owner_reply` TEXT DEFAULT NULL,
  `owner_reply_date` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (`property_id`),
  INDEX (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 7. PAYMENTS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `payments` (
  `id` VARCHAR(50) PRIMARY KEY,
  `booking_id` VARCHAR(50) NOT NULL,
  `user_id` INT NOT NULL,
  `owner_id` INT NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `payment_type` VARCHAR(50) DEFAULT 'Token Deposit',
  `method` VARCHAR(50) DEFAULT 'UPI',
  `status` ENUM('Completed', 'Pending', 'Failed', 'Refunded') DEFAULT 'Completed',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (`booking_id`),
  INDEX (`user_id`),
  INDEX (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 8. NOTIFICATIONS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `desc` TEXT NOT NULL,
  `icon` VARCHAR(100) DEFAULT 'fa-bell',
  `color` VARCHAR(50) DEFAULT 'primary',
  `link` VARCHAR(255) DEFAULT '#',
  `unread` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 9. WISHLISTS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wishlists` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `property_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `user_property_wish` (`user_id`, `property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 10. COMPLAINTS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `complaints` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `property_id` INT DEFAULT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `priority` ENUM('Low', 'Medium', 'High', 'Critical') DEFAULT 'Medium',
  `status` ENUM('Open', 'Investigating', 'Resolved', 'Dismissed') DEFAULT 'Open',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 11. DISPUTES TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `disputes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` VARCHAR(50) NOT NULL,
  `user_id` INT NOT NULL,
  `owner_id` INT NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `reason` TEXT NOT NULL,
  `status` ENUM('Open', 'Reviewing', 'Resolved', 'Refunded') DEFAULT 'Open',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 12. ACTIVITY LOGS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT DEFAULT NULL,
  `action` VARCHAR(100) NOT NULL,
  `details` TEXT DEFAULT NULL,
  `ip_address` VARCHAR(50) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- SEED DATA
-- ------------------------------------------------------------

-- Seed Users
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `user_type`, `city`, `avatar`, `college`, `course`, `year`, `student_id`, `dob`, `gender`, `emergency_contact`, `company_name`, `is_verified`, `status`) VALUES
(1, 'System Administrator', 'admin@neighborhood.com', '+91 99000 11223', '$2y$10$Fec6.RRE1zOHMi9K9D2pW.wGxv4OiMGDaVsbCSxTYn/3EoMnYAYre', 'admin', 'admin', 'Bangalore', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=200&q=80', NULL, NULL, NULL, NULL, NULL, 'Male', NULL, 'NeighborNest Inc.', 1, 'active'),
(2, 'Vishal Patel', 'vishal.patel@example.com', '+91 98765 43210', '$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa', 'user', 'student', 'Bangalore', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80', 'Christ University, Bangalore', 'B.Tech Computer Science', '4th Year (Final Year)', 'CU-2022-CS-4891', '2001-08-15', 'Male', '+91 98765 00000 (Father)', NULL, 1, 'active'),
(3, 'Rajesh Sharma', 'rajesh.sharma@neighborhood.com', '+91 98765 43210', '$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa', 'owner', 'owner', 'Bangalore', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80', NULL, NULL, NULL, NULL, NULL, 'Male', NULL, 'St. Mark Accommodations & Living Solutions', 1, 'active'),
(4, 'Priya Sharma', 'priya.sharma@neighborhood.com', '+91 98450 11223', '$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa', 'owner', 'owner', 'Bangalore', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80', NULL, NULL, NULL, NULL, NULL, 'Female', NULL, 'Serenity Living Hostels', 1, 'active'),
(5, 'Sara Khan', 'sara.khan@neighborhood.com', '+91 97312 88990', '$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa', 'owner', 'owner', 'Bangalore', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80', NULL, NULL, NULL, NULL, NULL, 'Female', NULL, 'Greenwood Estates', 1, 'active'),
(6, 'Rahul Verma', 'rahul.verma@example.com', '+91 98111 22334', '$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa', 'user', 'student', 'Delhi', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80', 'Delhi University', 'B.Com Honours', '2nd Year', 'DU-2023-BC-112', '2003-02-10', 'Male', '+91 98111 00000', NULL, 1, 'active'),
(7, 'Ananya Sen', 'ananya.sen@example.com', '+91 98222 33445', '$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa', 'user', 'student', 'Mumbai', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80', 'NMIMS Mumbai', 'BBA Finance', '3rd Year', 'NM-2022-BB-903', '2002-11-20', 'Female', '+91 98222 00000', NULL, 1, 'active'),
(8, 'Vikram Singh', 'vikram.singh@neighborhood.com', '+91 98333 44556', '$2y$10$mBn0SCDhfcNCCtx7MRlsNuoFuUYJQazsfectK44P0WZbCF54WTeOa', 'owner', 'owner', 'Mumbai', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=200&q=80', NULL, NULL, NULL, NULL, NULL, 'Male', NULL, 'Metro Luxury Rentals', 1, 'active')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Seed Properties
INSERT INTO `properties` (`id`, `owner_id`, `title`, `type`, `city`, `area`, `rent`, `deposit`, `gender`, `status`, `rating`, `reviews_count`, `views`, `available_beds`, `total_rooms`, `verified`, `image`, `gallery`, `amenities`, `rules`, `nearby`, `lat`, `lng`, `description`) VALUES
(101, 3, "St. Mark's Executive PG for Men", 'PG', 'Bangalore', 'Koramangala 4th Block', 9500.00, 15000.00, 'male_only', 'approved', 4.9, 24, 1420, 2, 12, 1,
 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80',
 '["https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80", "https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80", "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80"]',
 '["High-Speed Wi-Fi", "3-Time Meals", "AC", "Daily Housekeeping", "Laundry", "CCTV Security", "Power Backup", "Geyser", "Study Table"]',
 '["Gate curfew: 10:30 PM (Digital intimation for late returns)", "Visitors allowed in ground-floor common lounge", "Strict non-smoking and peaceful study atmosphere"]',
 '["0.4 km to Forum Mall", "0.8 km to Christ University", "1.2 km to Sony World Signal", "1.5 km to Koramangala Metro"]',
 12.9352000, 77.6245000,
 'Premium executive PG located right in Koramangala 4th Block. Includes delicious home-cooked North and South Indian meals, 200Mbps fiber Wi-Fi, biometric security entry, and daily room cleaning.'),

(102, 4, "Serenity Women's Luxury Hostel & PG", 'PG', 'Bangalore', 'HSR Layout Sector 1', 11000.00, 18000.00, 'female_only', 'approved', 4.8, 19, 1210, 2, 10, 1,
 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80',
 '["https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80", "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80"]',
 '["High-Speed Wi-Fi", "North & South Meals", "24/7 Female Warden", "Biometric Lock", "Geyser", "Washing Machine", "Rooftop Lounge"]',
 '["Gate entry before 10:00 PM", "Male visitors strictly restricted to Reception", "ID verification required"]',
 '["0.5 km to NIFT Bangalore", "1.0 km to BDA Complex HSR", "0.3 km to 27th Main Food Street"]',
 12.9121000, 77.6446000,
 'Top-rated safe and secure luxury girls hostel & PG in HSR Layout. 24/7 CCTV surveillance, biometric access, nutritious hygienic meals, and serene study areas.'),

(103, 5, "Greenwood Independent 2BHK Apartment", 'Apartment', 'Bangalore', 'Indiranagar 100ft Road', 28000.00, 70000.00, 'unisex', 'approved', 4.7, 12, 890, 1, 3, 1,
 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80',
 '["https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80"]',
 '["Furnished Kitchen", "High-Speed Wi-Fi", "Covered Parking", "Washing Machine", "Balcony Garden", "Power Backup"]',
 '["No loud music post 10:30 PM", "Quiet residential society etiquette"]',
 '["0.3 km to CMH Road Metro", "0.6 km to 100ft Road High Street", "1.5 km to Manipal Hospital"]',
 12.9784000, 77.6408000,
 'Spacious, sunlit 2BHK flat available for students or working professionals. Zero brokerage, peaceful neighborhood, full modular kitchen, and modern wooden wardrobes.'),

(104, 3, "Whitefield Tech Scholars Co-Living", 'Hostel', 'Bangalore', 'Whitefield ITPL', 8500.00, 12000.00, 'unisex', 'approved', 4.5, 31, 1640, 4, 20, 1,
 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80',
 '["https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80"]',
 '["High-Speed Wi-Fi", "Daily Meals", "Gaming Room", "Study Pods", "Gym Access", "Laundry", "24/7 Security"]',
 '["24/7 RFID keycard entry", "Gym hours 6 AM to 10 PM"]',
 '["0.4 km to ITPL Main Gate", "0.6 km to Pattandur Agrahara Metro", "1.0 km to Inorbit Mall"]',
 12.9850000, 77.7289000,
 'Vibrant co-living hostel designed for techies and college interns near ITPL Whitefield. Community lounge, gym, and high-speed working desks.'),

(105, 3, "Koramangala Tech Residency Studio Flat", 'Apartment', 'Bangalore', 'Koramangala 5th Block', 22000.00, 50000.00, 'unisex', 'approved', 4.8, 11, 980, 1, 4, 1,
 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80',
 '["https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80"]',
 '["Covered Parking", "Power Backup", "Modular Kitchen", "Balcony", "Lift Backup"]',
 '["No loud music post 10 PM", "Society gate entry logs after 11 PM"]',
 '["0.2 km to Jyoti Nivas College", "0.4 km to Koramangala Club"]',
 12.9340000, 77.6180000,
 'Modern 1BHK studio apartment right next to popular cafes and college campuses in Koramangala 5th Block.'),

(201, 8, "Bandra Sea Breeze Private Single Room", 'Room', 'Mumbai', 'Bandra West', 18500.00, 35000.00, 'male_only', 'approved', 4.9, 16, 750, 1, 3, 1,
 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80',
 '["https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80"]',
 '["AC", "High-Speed Wi-Fi", "Attached Washroom", "Housekeeping", "Balcony", "Geyser"]',
 '["No smoking indoors", "Quiet residential society rules apply"]',
 '["0.4 km to Linking Road", "1.0 km to Bandra Station", "0.6 km to Carter Road Promenade"]',
 19.0596000, 72.8295000,
 'Fully furnished air-conditioned private bedroom in a premium Bandra West apartment. Attached modern bathroom and pleasant sea breeze.'),

(301, 8, "North Campus Scholars Co-Living Hostel", 'Hostel', 'Delhi', 'North Campus DU', 7500.00, 10000.00, 'unisex', 'approved', 4.6, 28, 1120, 5, 18, 1,
 'https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=800&q=80',
 '["https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=800&q=80"]',
 '["High-Speed Wi-Fi", "Study Library Desk", "3-Time Meals", "Power Backup", "CCTV", "RO Water"]',
 '["Study hours 8 PM - 11 PM", "Hygienic dining etiquette required"]',
 '["0.2 km to Vishwavidyalaya Metro", "0.5 km to Hindu College", "0.6 km to SRCC"]',
 28.6903000, 77.2134000,
 'Dedicated student hostel near Delhi University. Features quiet study library room, high-speed fiber internet, and nutritious student mess food.'),

(401, 3, "Sunrise Executive PG for Boys", 'PG', 'Bangalore', 'Electronic City Phase 1', 8000.00, 12000.00, 'male_only', 'pending', 4.5, 0, 110, 4, 8, 0,
 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&fit=crop',
 '["https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&fit=crop"]',
 '["Wi-Fi", "Meals", "Power Backup", "Geyser"]',
 '["Curfew: 10:00 PM"]',
 '["Near Infosys Gate 1"]',
 12.8399000, 77.6770000,
 'Brand new PG submitted for platform verification in Electronic City.'),

(402, 4, "Riverside Co-Living Residence", 'Hostel', 'Mumbai', 'Andheri West', 12500.00, 20000.00, 'unisex', 'pending', 4.7, 0, 95, 6, 12, 0,
 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&fit=crop',
 '["https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&fit=crop"]',
 '["Wi-Fi", "AC", "Housekeeping", "Security"]',
 '["ID check at gate"]',
 '["0.5 km to Andheri Metro"]',
 19.1197000, 72.8468000,
 'Newly listed modern hostel waiting for administrator verification.')
ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- Seed Property Rooms
INSERT INTO `property_rooms` (`id`, `property_id`, `name`, `occupancy`, `rent`, `deposit`, `available`, `total`, `status`) VALUES
(1, 101, 'Standard Single Room', 'Single', 9500.00, 15000.00, 1, 4, 'Available'),
(2, 101, 'Premium Single Room (with Balcony)', 'Single', 12000.00, 20000.00, 0, 2, 'Booked'),
(3, 101, 'Standard Double Sharing Room', 'Double', 7000.00, 12000.00, 1, 6, 'Available'),
(4, 102, 'Standard Single Occupancy', 'Single', 11000.00, 18000.00, 1, 4, 'Available'),
(5, 102, 'Double Sharing Deluxe', 'Double', 8500.00, 14000.00, 1, 6, 'Available'),
(6, 103, 'Complete 2BHK Apartment', 'Entire Flat', 28000.00, 70000.00, 1, 1, 'Available'),
(7, 104, 'Single Private Pod', 'Single', 10500.00, 15000.00, 2, 8, 'Available'),
(8, 104, '2-Sharing Studio Bed', 'Double', 8000.00, 12000.00, 2, 12, 'Available'),
(9, 105, 'Full 1BHK Studio Apartment', 'Entire Flat', 22000.00, 50000.00, 1, 4, 'Available'),
(10, 201, 'Master Bedroom with Balcony', 'Single', 18500.00, 35000.00, 1, 3, 'Available'),
(11, 301, '2-Sharing Student Desk Room', 'Double', 7500.00, 10000.00, 5, 18, 'Available')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Seed Bookings
INSERT INTO `bookings` (`id`, `user_id`, `property_id`, `room_id`, `room_type`, `move_in_date`, `duration`, `rent`, `deposit`, `token_fee`, `token_status`, `move_in_balance`, `status`, `notes`) VALUES
('B1024', 2, 101, 1, 'Standard Single Room', '2026-09-01', '3 Months', 9500.00, 15000.00, 500.00, 'Paid Online', 24000.00, 'Pending', 'Preferred ground or 1st floor if available.'),
('B1023', 2, 102, 4, 'Standard Single Occupancy', '2026-08-15', '6 Months', 11000.00, 18000.00, 500.00, 'Paid Online', 28500.00, 'Active', 'Biometric card registered.'),
('B1022', 2, 103, 6, 'Complete 2BHK Apartment', '2026-01-15', '5 Months', 28000.00, 70000.00, 500.00, 'Paid Online', 97500.00, 'Completed', 'Deposit refunded upon check-out.'),
('B1025', 6, 301, 11, '2-Sharing Student Desk Room', '2026-09-10', '12 Months', 7500.00, 10000.00, 500.00, 'Paid Online', 17000.00, 'Pending', 'Student ID verified.')
ON DUPLICATE KEY UPDATE `status`=VALUES(`status`);

-- Seed Messages
INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `property_id`, `booking_id`, `message`, `is_read`, `created_at`) VALUES
(1, 3, 2, 101, 'B1024', 'Hello Vishal, thanks for your booking inquiry on St. Marks Executive PG.', 1, '2026-08-29 10:30:00'),
(2, 2, 3, 101, 'B1024', 'Hi Rajesh ji! Is high-speed Wi-Fi included in the room rent?', 1, '2026-08-29 10:32:00'),
(3, 3, 2, 101, 'B1024', 'Yes, 200 Mbps fiber Wi-Fi with backup router is 100% free and included.', 1, '2026-08-29 10:34:00'),
(4, 2, 3, 101, 'B1024', 'Awesome! Can I visit for a quick physical inspection tomorrow afternoon?', 1, '2026-08-29 10:35:00'),
(5, 3, 2, 101, 'B1024', 'Yes, the single occupancy room is confirmed available from Sep 1. You can visit anytime between 2 PM and 6 PM.', 0, '2026-08-29 10:37:00'),
(6, 2, 4, 102, 'B1023', 'Hi Priya, I wanted to confirm biometric registration.', 1, '2026-08-14 14:00:00'),
(7, 4, 2, 102, 'B1023', 'I have scheduled your gate entry card pass. See you soon!', 0, '2026-08-14 14:30:00')
ON DUPLICATE KEY UPDATE `message`=VALUES(`message`);

-- Seed Reviews
INSERT INTO `reviews` (`id`, `property_id`, `user_id`, `rating`, `comment`, `owner_reply`, `owner_reply_date`, `created_at`) VALUES
(1, 101, 2, 5, 'Clean rooms, delicious and hygienic meals 3 times a day, and very quiet study environment. Owner Rajesh ji is helpful!', 'Thank you Vishal! Happy to have you at St. Marks.', '2026-06-20 11:00:00', '2026-06-19 18:30:00'),
(2, 102, 7, 5, 'Extremely safe for girls students with 24/7 female warden. Rooftop study area is amazing.', 'Thank you Ananya for your kind review!', '2026-07-15 10:15:00', '2026-07-14 16:40:00'),
(3, 103, 6, 4, 'Very spacious apartment in Indiranagar. Great connectivity to metro.', NULL, NULL, '2026-05-10 12:20:00')
ON DUPLICATE KEY UPDATE `comment`=VALUES(`comment`);

-- Seed Payments
INSERT INTO `payments` (`id`, `booking_id`, `user_id`, `owner_id`, `amount`, `payment_type`, `method`, `status`, `created_at`) VALUES
('TXN-78901', 'B1024', 2, 3, 500.00, 'Token Deposit', 'UPI / PhonePe', 'Completed', '2026-08-29 10:28:00'),
('TXN-78902', 'B1023', 2, 4, 500.00, 'Token Deposit', 'Google Pay', 'Completed', '2026-08-05 11:15:00'),
('TXN-78903', 'B1023', 2, 4, 28500.00, 'Move-in Balance', 'Net Banking', 'Completed', '2026-08-15 09:30:00'),
('TXN-78904', 'B1022', 2, 5, 500.00, 'Token Deposit', 'Card Payment', 'Completed', '2026-01-02 14:00:00'),
('TXN-78905', 'B1025', 6, 8, 500.00, 'Token Deposit', 'Paytm UPI', 'Completed', '2026-08-28 16:45:00')
ON DUPLICATE KEY UPDATE `amount`=VALUES(`amount`);

-- Seed Notifications
INSERT INTO `notifications` (`id`, `user_id`, `title`, `desc`, `icon`, `color`, `link`, `unread`, `created_at`) VALUES
(1, 2, 'Booking Application Submitted', 'Your request for St. Marks Executive PG (#B1024) was sent to landlord Rajesh Sharma.', 'fa-calendar-check', 'primary', 'booking-details.php?id=B1024', 1, '2026-08-29 10:29:00'),
(2, 2, 'New Chat Message Received', 'Rajesh Sharma: Yes, the single occupancy room is confirmed available from Sep 1...', 'fa-comment-dots', 'success', 'messages.php?chat=chat_1', 1, '2026-08-29 10:37:00'),
(3, 2, 'Token Fee Payment Successful', 'Payment of ₹500 received for booking #B1024. Transaction ID: TXN-78901.', 'fa-receipt', 'warning', 'booking-details.php?id=B1024', 0, '2026-08-29 10:28:00'),
(4, 3, 'New Booking Request #B1024', 'Vishal Patel has requested Standard Single Room from Sep 01, 2026.', 'fa-calendar-plus', 'primary', 'booking-details.php?id=B1024', 1, '2026-08-29 10:29:00'),
(5, 3, 'Token Deposit Credited', '₹500 token fee credited for booking #B1024.', 'fa-wallet', 'success', 'earnings.php', 1, '2026-08-29 10:28:00'),
(6, 1, 'New Property Awaiting Verification', 'Sunrise Executive PG for Boys submitted by Rajesh Sharma needs approval.', 'fa-building', 'warning', 'Property Management/pending_approval.php', 1, '2026-08-29 09:00:00')
ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- Seed Wishlists
INSERT INTO `wishlists` (`user_id`, `property_id`) VALUES
(2, 101), (2, 102), (2, 103), (2, 104), (2, 201), (2, 301)
ON DUPLICATE KEY UPDATE `property_id`=VALUES(`property_id`);

-- Seed Complaints
INSERT INTO `complaints` (`id`, `user_id`, `property_id`, `title`, `description`, `priority`, `status`) VALUES
(1, 2, 101, 'Wi-Fi Speed Fluctuations in Room 204', 'Intermittent disconnects during online college classes in the evening hours.', 'Medium', 'Resolved'),
(2, 6, 301, 'Hot Water Geyser Low Pressure', 'The 2nd-floor geyser has low pressure in the morning.', 'Low', 'Investigating')
ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- Seed Disputes
INSERT INTO `disputes` (`id`, `booking_id`, `user_id`, `owner_id`, `amount`, `reason`, `status`) VALUES
(1, 'B1022', 2, 5, 2000.00, 'Disputed cleaning fee deduction from deposit', 'Resolved')
ON DUPLICATE KEY UPDATE `amount`=VALUES(`amount`);

-- Seed Activity Logs
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `details`, `ip_address`) VALUES
(1, 1, 'Admin Login', 'Administrator logged into Admin Panel', '127.0.0.1'),
(2, 3, 'Property Listing Created', 'Owner created listing Sunrise Executive PG for Boys', '127.0.0.1'),
(3, 2, 'Booking Created', 'Student created booking #B1024 for property 101', '127.0.0.1'),
(4, 2, 'Token Payment', 'Paid ₹500 via UPI (TXN-78901)', '127.0.0.1')
ON DUPLICATE KEY UPDATE `action`=VALUES(`action`);
