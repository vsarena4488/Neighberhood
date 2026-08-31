<?php
// includes/functions.php - All helper functions and data

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure default mock user session exists
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'name' => 'Vishal Patel',
        'email' => 'vishal.patel@example.com',
        'phone' => '+91 98765 43210',
        'city' => 'Bangalore',
        'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
        'user_type' => 'student',
        'college' => 'Christ University, Bangalore',
        'course' => 'B.Tech Computer Science',
        'year' => '4th Year (Final Year)',
        'student_id' => 'CU-2022-CS-4891',
        'dob' => '2001-08-15',
        'gender' => 'Male',
        'emergency_contact' => '+91 98765 00000 (Father)',
        'member_since' => 'January 2024'
    ];
}

// ============================================================
// MASTER PROPERTIES DATASET
// ============================================================
function getPropertiesData() {
    return [
        [
            'id' => 101,
            'title' => "St. Mark's Executive PG for Men",
            'type' => 'PG',
            'city' => 'Bangalore',
            'area' => 'Koramangala 4th Block',
            'rent' => 9500,
            'deposit' => 15000,
            'gender' => 'male_only',
            'rating' => 4.9,
            'reviews_count' => 24,
            'available_beds' => 2,
            'total_rooms' => 12,
            'verified' => true,
            'image' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80'
            ],
            'amenities' => ['High-Speed Wi-Fi', '3-Time Meals', 'AC', 'Daily Housekeeping', 'Laundry', 'CCTV Security', 'Power Backup', 'Geyser', 'Study Table'],
            'nearby' => ['0.4 km to Forum Mall', '0.8 km to Christ University', '1.2 km to Sony World Signal', '1.5 km to Koramangala Metro'],
            'owner' => [
                'name' => 'Rajesh Sharma',
                'phone' => '+91 98765 43210',
                'email' => 'rajesh.sharma@neighborhood.com',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80',
                'verified' => true,
                'rating' => 4.8,
                'properties_listed' => 15,
                'member_since' => '2023'
            ],
            'room_options' => [
                ['name' => 'Standard Single Room', 'occupancy' => 'Single', 'rent' => 9500, 'deposit' => 15000, 'status' => 'Available'],
                ['name' => 'Premium Single Room (with Balcony)', 'occupancy' => 'Single', 'rent' => 12000, 'deposit' => 20000, 'status' => 'Booked'],
                ['name' => 'Standard Double Sharing Room', 'occupancy' => 'Double', 'rent' => 7000, 'deposit' => 12000, 'status' => 'Available']
            ],
            'rules' => [
                'Gate curfew: 10:30 PM (Digital intimation for late returns)',
                'Visitors allowed in ground-floor common lounge',
                'Strict non-smoking and peaceful study atmosphere',
                'No loud music post 10:00 PM'
            ],
            'lat' => 12.9352,
            'lng' => 77.6245,
            'desc' => 'Premium executive PG located right in Koramangala 4th Block. Includes delicious home-cooked North and South Indian meals, 200Mbps fiber Wi-Fi, biometric security entry, and daily room cleaning.'
        ],
        [
            'id' => 102,
            'title' => "Serenity Women's Luxury Hostel & PG",
            'type' => 'PG',
            'city' => 'Bangalore',
            'area' => 'HSR Layout Sector 1',
            'rent' => 11000,
            'deposit' => 18000,
            'gender' => 'female_only',
            'rating' => 4.8,
            'reviews_count' => 19,
            'available_beds' => 2,
            'total_rooms' => 10,
            'verified' => true,
            'image' => 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80'
            ],
            'amenities' => ['High-Speed Wi-Fi', 'North & South Meals', '24/7 Female Warden', 'Biometric Lock', 'Geyser', 'Washing Machine', 'Rooftop Lounge'],
            'nearby' => ['0.6 km to NIFT College', '1.2 km to HSR BDA Complex', '1.5 km to Silk Board Junction'],
            'owner' => [
                'name' => 'Priya Sharma',
                'phone' => '+91 98450 11223',
                'email' => 'priya.sharma@neighborhood.com',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=120&q=80',
                'verified' => true,
                'rating' => 4.9,
                'properties_listed' => 8,
                'member_since' => '2022'
            ],
            'room_options' => [
                ['name' => 'Standard Single Occupancy', 'occupancy' => 'Single', 'rent' => 11000, 'deposit' => 18000, 'status' => 'Available'],
                ['name' => '2-Sharing Room', 'occupancy' => 'Double', 'rent' => 8000, 'deposit' => 14000, 'status' => 'Available']
            ],
            'rules' => [
                'Biometric entry closes at 10:00 PM',
                'Female visitors allowed in rooms with prior approval',
                'Strict cleanliness protocol in dining area'
            ],
            'lat' => 12.9121,
            'lng' => 77.6445,
            'desc' => 'Safe and ultra-hygienic women\'s PG in HSR Sector 1. Features 24/7 security warden, electronic access cards, spacious cupboards, and terrace garden.'
        ],
        [
            'id' => 103,
            'title' => "Greenwood Independent 2BHK Apartment",
            'type' => 'Apartment',
            'city' => 'Bangalore',
            'area' => 'Indiranagar 100ft Road',
            'rent' => 28000,
            'deposit' => 70000,
            'gender' => 'unisex',
            'rating' => 4.7,
            'reviews_count' => 14,
            'available_beds' => 'Entire Flat',
            'total_rooms' => 1,
            'verified' => true,
            'image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=800&q=80'
            ],
            'amenities' => ['Covered Parking', 'Power Backup', 'Modular Kitchen', 'Balcony', 'Pet Friendly', 'Lift Backup', '24/7 Water Supply'],
            'nearby' => ['0.3 km to 100ft Road Cafes', '0.5 km to Indiranagar Metro', '1.0 km to CMH Hospital'],
            'owner' => [
                'name' => 'Sara Khan',
                'phone' => '+91 97312 88990',
                'email' => 'sara.khan@neighborhood.com',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=120&q=80',
                'verified' => true,
                'rating' => 4.7,
                'properties_listed' => 4,
                'member_since' => '2023'
            ],
            'room_options' => [
                ['name' => 'Complete 2BHK Apartment (Semi-Furnished)', 'occupancy' => 'Entire Flat', 'rent' => 28000, 'deposit' => 70000, 'status' => 'Available']
            ],
            'rules' => [
                'Society gate entry logs after 11 PM',
                'Quiet hours: 10 PM - 6 AM',
                'Pet vaccination records required'
            ],
            'lat' => 12.9784,
            'lng' => 77.6408,
            'desc' => 'Spacious semi-furnished 2BHK flat ideal for working employees or small families. Prime Indiranagar location with reserved basement car parking.'
        ],
        [
            'id' => 104,
            'title' => "Silicon Tech Hub Co-Living Hostel",
            'type' => 'Hostel',
            'city' => 'Bangalore',
            'area' => 'Whitefield ITPL',
            'rent' => 8000,
            'deposit' => 12000,
            'gender' => 'unisex',
            'rating' => 4.6,
            'reviews_count' => 31,
            'available_beds' => 4,
            'total_rooms' => 20,
            'verified' => true,
            'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80'
            ],
            'amenities' => ['High-Speed Wi-Fi', 'Cafeteria', 'Gym', 'Gaming Lounge', 'Power Backup', 'Work Desks'],
            'nearby' => ['0.5 km to ITPL Main Gate', '0.8 km to Whitefield Metro', '1.2 km to Inorbit Mall'],
            'owner' => [
                'name' => 'Amit Verma',
                'phone' => '+91 99001 22334',
                'email' => 'amit.verma@neighborhood.com',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&q=80',
                'verified' => true,
                'rating' => 4.6,
                'properties_listed' => 6,
                'member_since' => '2021'
            ],
            'room_options' => [
                ['name' => 'Single Private Pod', 'occupancy' => 'Single', 'rent' => 10500, 'deposit' => 15000, 'status' => 'Available'],
                ['name' => '2-Sharing Studio Bed', 'occupancy' => 'Double', 'rent' => 8000, 'deposit' => 12000, 'status' => 'Available']
            ],
            'rules' => ['24/7 entry with RFID keycard', 'Gym hours: 6 AM - 10 PM'],
            'lat' => 12.9850,
            'lng' => 77.7289,
            'desc' => 'Vibrant co-living hostel designed for techies and interns near ITPL Whitefield. Community lounge, gym, and high-speed working desks.'
        ],
        [
            'id' => 201,
            'title' => "Bandra Sea Breeze Private Single Room",
            'type' => 'Room',
            'city' => 'Mumbai',
            'area' => 'Bandra West',
            'rent' => 18500,
            'deposit' => 35000,
            'gender' => 'male_only',
            'rating' => 4.9,
            'reviews_count' => 16,
            'available_beds' => 1,
            'total_rooms' => 3,
            'verified' => true,
            'image' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80'
            ],
            'amenities' => ['AC', 'High-Speed Wi-Fi', 'Attached Washroom', 'Housekeeping', 'Balcony', 'Geyser'],
            'nearby' => ['0.4 km to Linking Road', '1.0 km to Bandra Station', '0.6 km to Carter Road Promenade'],
            'owner' => [
                'name' => 'Farhan Merchant',
                'phone' => '+91 98200 44556',
                'email' => 'farhan@neighborhood.com',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=120&q=80',
                'verified' => true,
                'rating' => 4.9,
                'properties_listed' => 3,
                'member_since' => '2022'
            ],
            'room_options' => [
                ['name' => 'Master Bedroom with Balcony', 'occupancy' => 'Single', 'rent' => 18500, 'deposit' => 35000, 'status' => 'Available']
            ],
            'rules' => ['No smoking indoors', 'Quiet residential society rules apply'],
            'lat' => 19.0596,
            'lng' => 72.8295,
            'desc' => 'Fully furnished air-conditioned private bedroom in a premium Bandra West apartment. Attached modern bathroom and pleasant sea breeze.'
        ],
        [
            'id' => 301,
            'title' => "North Campus Scholars Co-Living Hostel",
            'type' => 'Hostel',
            'city' => 'Delhi',
            'area' => 'North Campus DU',
            'rent' => 7500,
            'deposit' => 10000,
            'gender' => 'unisex',
            'rating' => 4.6,
            'reviews_count' => 28,
            'available_beds' => 5,
            'total_rooms' => 18,
            'verified' => true,
            'image' => 'https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=800&q=80',
            'gallery' => ['https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=800&q=80'],
            'amenities' => ['High-Speed Wi-Fi', 'Study Library Desk', '3-Time Meals', 'Power Backup', 'CCTV', 'RO Water'],
            'nearby' => ['0.2 km to Vishwavidyalaya Metro', '0.5 km to Hindu College', '0.6 km to SRCC'],
            'owner' => [
                'name' => 'Harish Chandra',
                'phone' => '+91 98111 55667',
                'email' => 'harish@neighborhood.com',
                'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=120&q=80',
                'verified' => true,
                'rating' => 4.7,
                'properties_listed' => 7,
                'member_since' => '2020'
            ],
            'room_options' => [
                ['name' => '2-Sharing Student Desk Room', 'occupancy' => 'Double', 'rent' => 7500, 'deposit' => 10000, 'status' => 'Available']
            ],
            'rules' => ['Study hours 8 PM - 11 PM', 'Hygienic dining etiquette required'],
            'lat' => 28.6903,
            'lng' => 77.2134,
            'desc' => 'Dedicated student hostel near Delhi University. Features quiet study library room, high-speed fiber internet, and nutritious student mess food.'
        ]
    ];
}

// ============================================================
// USER BOOKINGS DATASET
// ============================================================
if (!isset($_SESSION['user_bookings'])) {
    $_SESSION['user_bookings'] = [
        [
            'id' => 'B1024',
            'property_id' => 101,
            'property_title' => "St. Mark's Executive PG for Men",
            'property_type' => 'PG',
            'location' => 'Koramangala 4th Block, Bangalore',
            'room_type' => 'Standard Single Room',
            'owner_name' => 'Rajesh Sharma',
            'owner_phone' => '+91 98765 43210',
            'move_in_date' => 'Sep 01, 2026',
            'duration' => '3 Months',
            'rent' => 9500,
            'deposit' => 15000,
            'token_fee' => 500,
            'token_status' => 'Paid Online',
            'move_in_balance' => 24000,
            'status' => 'Pending',
            'created_at' => '2 days ago',
            'timeline' => [
                ['step' => 'Booking Requested', 'date' => 'Aug 29, 2026', 'done' => true],
                ['step' => 'Owner Reviewing', 'date' => 'In Progress', 'done' => true, 'current' => true],
                ['step' => 'Booking Approved', 'date' => 'Pending', 'done' => false],
                ['step' => 'Physical Move-in & Check-in', 'date' => 'Sep 01, 2026', 'done' => false],
                ['step' => 'Completed', 'date' => 'Nov 30, 2026', 'done' => false]
            ]
        ],
        [
            'id' => 'B1023',
            'property_id' => 102,
            'property_title' => "Serenity Women's Luxury Hostel & PG",
            'property_type' => 'PG',
            'location' => 'HSR Layout Sector 1, Bangalore',
            'room_type' => 'Standard Single Occupancy',
            'owner_name' => 'Priya Sharma',
            'owner_phone' => '+91 98450 11223',
            'move_in_date' => 'Aug 15, 2026',
            'duration' => '6 Months',
            'rent' => 11000,
            'deposit' => 18000,
            'token_fee' => 500,
            'token_status' => 'Paid Online',
            'move_in_balance' => 28500,
            'status' => 'Active',
            'created_at' => '15 days ago',
            'timeline' => [
                ['step' => 'Booking Requested', 'date' => 'Aug 05, 2026', 'done' => true],
                ['step' => 'Owner Reviewing', 'date' => 'Aug 06, 2026', 'done' => true],
                ['step' => 'Booking Approved', 'date' => 'Aug 07, 2026', 'done' => true],
                ['step' => 'Physical Move-in & Check-in', 'date' => 'Aug 15, 2026', 'done' => true, 'current' => true],
                ['step' => 'Completed', 'date' => 'Feb 15, 2027', 'done' => false]
            ]
        ],
        [
            'id' => 'B1022',
            'property_id' => 103,
            'property_title' => "Greenwood Independent 2BHK Apartment",
            'property_type' => 'Apartment',
            'location' => 'Indiranagar 100ft Road, Bangalore',
            'room_type' => 'Complete 2BHK Apartment',
            'owner_name' => 'Sara Khan',
            'owner_phone' => '+91 97312 88990',
            'move_in_date' => 'Jan 15, 2026',
            'duration' => '5 Months',
            'rent' => 28000,
            'deposit' => 70000,
            'token_fee' => 500,
            'token_status' => 'Paid Online',
            'move_in_balance' => 97500,
            'status' => 'Completed',
            'created_at' => '2 months ago',
            'timeline' => [
                ['step' => 'Booking Requested', 'date' => 'Jan 02, 2026', 'done' => true],
                ['step' => 'Owner Reviewing', 'date' => 'Jan 03, 2026', 'done' => true],
                ['step' => 'Booking Approved', 'date' => 'Jan 04, 2026', 'done' => true],
                ['step' => 'Physical Move-in & Check-in', 'date' => 'Jan 15, 2026', 'done' => true],
                ['step' => 'Completed', 'date' => 'Jun 15, 2026', 'done' => true]
            ]
        ]
    ];
}

// ============================================================
// USER WISHLIST DATASET
// ============================================================
if (!isset($_SESSION['user_wishlist'])) {
    $_SESSION['user_wishlist'] = [101, 102, 103, 104, 201, 301];
}

// ============================================================
// USER COMPARE DATASET
// ============================================================
if (!isset($_SESSION['user_compare'])) {
    $_SESSION['user_compare'] = [101, 102];
}

// ============================================================
// USER CHATS DATASET
// ============================================================
if (!isset($_SESSION['user_chats'])) {
    $_SESSION['user_chats'] = [
        [
            'id' => 'chat_1',
            'owner_name' => 'Rajesh Sharma',
            'owner_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80',
            'property_title' => "St. Mark's Executive PG",
            'property_id' => 101,
            'booking_id' => 'B1024',
            'last_message' => 'Yes, the single occupancy room is confirmed available from Sep 1.',
            'last_time' => '2 mins ago',
            'unread' => 2,
            'online' => true,
            'messages' => [
                ['sender' => 'owner', 'text' => 'Hello Vishal, thanks for booking inquiry on St. Mark\'s Executive PG.', 'time' => '10:30 AM'],
                ['sender' => 'user', 'text' => 'Hi Rajesh ji! Is high-speed Wi-Fi included in the room rent?', 'time' => '10:32 AM'],
                ['sender' => 'owner', 'text' => 'Yes, 200 Mbps fiber Wi-Fi with backup router is 100% free and included.', 'time' => '10:34 AM'],
                ['sender' => 'user', 'text' => 'Awesome! Can I visit for a quick physical inspection tomorrow afternoon?', 'time' => '10:35 AM'],
                ['sender' => 'owner', 'text' => 'Yes, the single occupancy room is confirmed available from Sep 1. You can visit anytime between 2 PM and 6 PM.', 'time' => '10:37 AM']
            ]
        ],
        [
            'id' => 'chat_2',
            'owner_name' => 'Priya Sharma',
            'owner_avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=120&q=80',
            'property_title' => "Serenity Luxury Hostel",
            'property_id' => 102,
            'booking_id' => 'B1023',
            'last_message' => 'I have scheduled your gate entry card pass.',
            'last_time' => '1 hour ago',
            'unread' => 1,
            'online' => false,
            'messages' => [
                ['sender' => 'user', 'text' => 'Hi Priya, I wanted to confirm biometric registration.', 'time' => 'Yesterday'],
                ['sender' => 'owner', 'text' => 'I have scheduled your gate entry card pass. See you soon!', 'time' => '1 hour ago']
            ]
        ],
        [
            'id' => 'chat_3',
            'owner_name' => 'Sara Khan',
            'owner_avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=120&q=80',
            'property_title' => "Greenwood 2BHK Apartment",
            'property_id' => 103,
            'booking_id' => 'B1022',
            'last_message' => 'Your security deposit refund receipt has been issued.',
            'last_time' => '2 days ago',
            'unread' => 0,
            'online' => false,
            'messages' => [
                ['sender' => 'user', 'text' => 'Thanks for the great stay Sara!', 'time' => 'Jun 15'],
                ['sender' => 'owner', 'text' => 'Your security deposit refund receipt has been issued. All the best for your graduation!', 'time' => 'Jun 16']
            ]
        ]
    ];
}

// ============================================================
// USER NOTIFICATIONS DATASET
// ============================================================
if (!isset($_SESSION['user_notifications'])) {
    $_SESSION['user_notifications'] = [
        [
            'id' => 'notif_1',
            'title' => 'Booking Request Submitted',
            'desc' => 'Your booking request #B1024 for St. Mark\'s Executive PG is under owner review.',
            'time' => '2 mins ago',
            'type' => 'booking',
            'icon' => 'fa-calendar-check',
            'color' => 'primary',
            'unread' => true,
            'link' => 'booking-details.php?id=B1024'
        ],
        [
            'id' => 'notif_2',
            'title' => 'New Chat Message from Rajesh Sharma',
            'desc' => 'Owner replied: "Yes, the single occupancy room is confirmed available from Sep 1."',
            'time' => '5 mins ago',
            'type' => 'message',
            'icon' => 'fa-comment-dots',
            'color' => 'danger',
            'unread' => true,
            'link' => 'messages.php?chat=chat_1'
        ],
        [
            'id' => 'notif_3',
            'title' => 'Token Booking Fee Paid (₹500)',
            'desc' => 'Your payment receipt for #B1024 is ready. Zero brokerage applied.',
            'time' => '2 hours ago',
            'type' => 'payment',
            'icon' => 'fa-receipt',
            'color' => 'success',
            'unread' => true,
            'link' => 'booking-details.php?id=B1024'
        ],
        [
            'id' => 'notif_4',
            'title' => 'Review Reminder for Greenwood 2BHK',
            'desc' => 'Share your accommodation experience with student community!',
            'time' => '1 day ago',
            'type' => 'review',
            'icon' => 'fa-star',
            'color' => 'warning',
            'unread' => false,
            'link' => 'reviews.php'
        ]
    ];
}

// ============================================================
// USER REVIEWS DATASET
// ============================================================
if (!isset($_SESSION['user_reviews'])) {
    $_SESSION['user_reviews'] = [
        [
            'id' => 'rev_1',
            'property_id' => 103,
            'property_title' => "Greenwood Independent 2BHK Apartment",
            'location' => 'Indiranagar 100ft Road, Bangalore',
            'rating' => 5,
            'stay_period' => 'Jan 15, 2026 - Jun 15, 2026 (5 Months)',
            'comment' => 'Fantastic apartment with great ventilation and very polite landlord. Close to Indiranagar metro station and reliable 24/7 power backup. Highly recommended for students or young employees!',
            'posted_at' => 'Jun 20, 2026',
            'photos' => ['https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=400&q=80']
        ]
    ];
}

// ============================================================
// HELPER FUNCTIONS
// ============================================================

function getUnreadMessagesCount() {
    $count = 0;
    if (isset($_SESSION['user_chats'])) {
        foreach ($_SESSION['user_chats'] as $chat) {
            $count += $chat['unread'];
        }
    }
    return $count;
}

function getUnreadNotificationsCount() {
    $count = 0;
    if (isset($_SESSION['user_notifications'])) {
        foreach ($_SESSION['user_notifications'] as $n) {
            if (!empty($n['unread'])) {
                $count++;
            }
        }
    }
    return $count;
}

function getActivePendingBookingsCount() {
    $count = 0;
    if (isset($_SESSION['user_bookings'])) {
        foreach ($_SESSION['user_bookings'] as $b) {
            if ($b['status'] === 'Pending') {
                $count++;
            }
        }
    }
    return $count;
}
