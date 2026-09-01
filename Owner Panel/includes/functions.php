<?php
// Owner Panel includes/functions.php - Helper functions and session mock data for Owner Panel

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure default mock owner session exists
if (!isset($_SESSION['owner'])) {
    $_SESSION['owner'] = [
        'name' => 'Rajesh Sharma',
        'email' => 'rajesh.sharma@neighborhood.com',
        'phone' => '+91 98765 43210',
        'city' => 'Bangalore',
        'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
        'user_type' => 'owner',
        'company_name' => 'St. Mark Accommodations & Living Solutions',
        'verified' => true,
        'rating' => 4.9,
        'properties_listed' => 4,
        'member_since' => 'March 2023',
        'identity_verified' => true,
        'email_verified' => true,
        'phone_verified' => true,
        'documents_verified' => true,
        'aadhaar_no' => 'XXXX-XXXX-4891',
        'pan_no' => 'ABCDE1234F'
    ];
}

// Master Properties Dataset for Owner
if (!isset($_SESSION['owner_properties'])) {
    $_SESSION['owner_properties'] = [
        [
            'id' => 101,
            'title' => "St. Mark's Executive PG for Men",
            'type' => 'PG',
            'city' => 'Bangalore',
            'area' => 'Koramangala 4th Block',
            'rent' => 9500,
            'deposit' => 15000,
            'gender' => 'male_only',
            'status' => 'Active',
            'rating' => 4.9,
            'reviews_count' => 24,
            'views' => 1420,
            'wishlist_count' => 86,
            'available_beds' => 2,
            'total_rooms' => 12,
            'verified' => true,
            'image' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80'
            ],
            'amenities' => ['High-Speed Wi-Fi', '3-Time Meals', 'AC', 'Daily Housekeeping', 'Laundry', 'CCTV Security', 'Power Backup', 'Geyser', 'Study Table'],
            'rules' => ['Gate curfew: 10:30 PM', 'Visitors allowed in ground-floor lounge', 'Strict non-smoking policy'],
            'room_options' => [
                ['name' => 'Standard Single Room', 'occupancy' => 'Single', 'rent' => 9500, 'deposit' => 15000, 'available' => 1, 'total' => 4],
                ['name' => 'Premium Single Room (with Balcony)', 'occupancy' => 'Single', 'rent' => 12000, 'deposit' => 20000, 'available' => 0, 'total' => 2],
                ['name' => 'Standard Double Sharing Room', 'occupancy' => 'Double', 'rent' => 7000, 'deposit' => 12000, 'available' => 1, 'total' => 6]
            ]
        ],
        [
            'id' => 105,
            'title' => "Koramangala Tech Residency Studio Flat",
            'type' => 'Apartment',
            'city' => 'Bangalore',
            'area' => 'Koramangala 5th Block',
            'rent' => 22000,
            'deposit' => 50000,
            'gender' => 'unisex',
            'status' => 'Active',
            'rating' => 4.8,
            'reviews_count' => 11,
            'views' => 980,
            'wishlist_count' => 52,
            'available_beds' => 1,
            'total_rooms' => 4,
            'verified' => true,
            'image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80'
            ],
            'amenities' => ['Covered Parking', 'Power Backup', 'Modular Kitchen', 'Balcony', 'Lift Backup'],
            'rules' => ['No loud music post 10 PM', 'Society gate entry logs after 11 PM'],
            'room_options' => [
                ['name' => 'Full 1BHK Studio Apartment', 'occupancy' => 'Entire Flat', 'rent' => 22000, 'deposit' => 50000, 'available' => 1, 'total' => 4]
            ]
        ],
        [
            'id' => 106,
            'title' => "Indiranagar Student PG & Co-Living",
            'type' => 'PG',
            'city' => 'Bangalore',
            'area' => 'Indiranagar 100ft Road',
            'rent' => 10500,
            'deposit' => 18000,
            'gender' => 'male_only',
            'status' => 'Pending Verification',
            'rating' => 4.6,
            'reviews_count' => 6,
            'views' => 450,
            'wishlist_count' => 31,
            'available_beds' => 3,
            'total_rooms' => 8,
            'verified' => false,
            'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80'
            ],
            'amenities' => ['Wi-Fi', 'South Indian Meals', 'Geyser', 'Washing Machine'],
            'rules' => ['Curfew 10:00 PM'],
            'room_options' => [
                ['name' => '2-Sharing Twin Bed', 'occupancy' => 'Double', 'rent' => 10500, 'deposit' => 18000, 'available' => 3, 'total' => 8]
            ]
        ],
        [
            'id' => 107,
            'title' => "HSR Sector 2 Executive Mens PG",
            'type' => 'PG',
            'city' => 'Bangalore',
            'area' => 'HSR Layout Sector 2',
            'rent' => 8800,
            'deposit' => 14000,
            'gender' => 'male_only',
            'status' => 'Draft',
            'rating' => 0.0,
            'reviews_count' => 0,
            'views' => 12,
            'wishlist_count' => 2,
            'available_beds' => 5,
            'total_rooms' => 10,
            'verified' => false,
            'image' => 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80',
            'gallery' => [],
            'amenities' => ['Wi-Fi', 'Geyser', 'CCTV'],
            'rules' => ['No smoking indoors'],
            'room_options' => [
                ['name' => 'Single Occupancy', 'occupancy' => 'Single', 'rent' => 8800, 'deposit' => 14000, 'available' => 5, 'total' => 10]
            ]
        ]
    ];
}

// Master Bookings Dataset for Owner
if (!isset($_SESSION['owner_bookings'])) {
    $_SESSION['owner_bookings'] = [
        [
            'id' => 'B1024',
            'property_id' => 101,
            'property_title' => "St. Mark's Executive PG for Men",
            'room_type' => 'Standard Single Room',
            'tenant' => [
                'name' => 'Vishal Patel',
                'email' => 'vishal.patel@example.com',
                'phone' => '+91 98765 43210',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80',
                'college' => 'Christ University, Bangalore',
                'course' => 'B.Tech Computer Science',
                'student_id' => 'CU-2022-CS-4891',
                'verified_student' => true
            ],
            'move_in_date' => 'Sep 01, 2026',
            'duration' => '3 Months',
            'rent' => 9500,
            'deposit' => 15000,
            'token_fee' => 500,
            'token_status' => 'Paid (Online UPI)',
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
            'id' => 'B1021',
            'property_id' => 101,
            'property_title' => "St. Mark's Executive PG for Men",
            'room_type' => 'Standard Double Sharing Room',
            'tenant' => [
                'name' => 'Rohan Sharma',
                'email' => 'rohan.s@example.com',
                'phone' => '+91 98111 22334',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&q=80',
                'college' => 'Jain University, Bangalore',
                'course' => 'BBA Finance',
                'student_id' => 'JU-2023-BB-1120',
                'verified_student' => true
            ],
            'move_in_date' => 'Aug 20, 2026',
            'duration' => '6 Months',
            'rent' => 7000,
            'deposit' => 12000,
            'token_fee' => 500,
            'token_status' => 'Paid (UPI)',
            'move_in_balance' => 18500,
            'status' => 'Approved',
            'created_at' => '5 days ago',
            'timeline' => [
                ['step' => 'Booking Requested', 'date' => 'Aug 25, 2026', 'done' => true],
                ['step' => 'Owner Reviewing', 'date' => 'Aug 26, 2026', 'done' => true],
                ['step' => 'Booking Approved', 'date' => 'Aug 26, 2026', 'done' => true, 'current' => true],
                ['step' => 'Physical Move-in & Check-in', 'date' => 'Aug 20, 2026', 'done' => false],
                ['step' => 'Completed', 'date' => 'Feb 20, 2027', 'done' => false]
            ]
        ],
        [
            'id' => 'B1019',
            'property_id' => 105,
            'property_title' => "Koramangala Tech Residency Studio Flat",
            'room_type' => 'Full 1BHK Studio Apartment',
            'tenant' => [
                'name' => 'Ananya Roy',
                'email' => 'ananya.roy@techcorp.com',
                'phone' => '+91 97400 99887',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=120&q=80',
                'college' => 'Working Professional (Wipro)',
                'course' => 'Software Engineer',
                'student_id' => 'EMP-WP-9812',
                'verified_student' => true
            ],
            'move_in_date' => 'Jul 01, 2026',
            'duration' => '12 Months',
            'rent' => 22000,
            'deposit' => 50000,
            'token_fee' => 500,
            'token_status' => 'Paid (NetBanking)',
            'move_in_balance' => 71500,
            'status' => 'Active',
            'created_at' => '2 months ago',
            'timeline' => [
                ['step' => 'Booking Requested', 'date' => 'Jun 20, 2026', 'done' => true],
                ['step' => 'Owner Reviewing', 'date' => 'Jun 21, 2026', 'done' => true],
                ['step' => 'Booking Approved', 'date' => 'Jun 22, 2026', 'done' => true],
                ['step' => 'Physical Move-in & Check-in', 'date' => 'Jul 01, 2026', 'done' => true, 'current' => true],
                ['step' => 'Completed', 'date' => 'Jun 30, 2027', 'done' => false]
            ]
        ],
        [
            'id' => 'B1012',
            'property_id' => 101,
            'property_title' => "St. Mark's Executive PG for Men",
            'room_type' => 'Standard Single Room',
            'tenant' => [
                'name' => 'Karan Malhotra',
                'email' => 'karan.m@example.com',
                'phone' => '+91 99000 11223',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80',
                'college' => 'St. Joseph\'s College, Bangalore',
                'course' => 'B.Com Honours',
                'student_id' => 'SJC-2023-BC-4410',
                'verified_student' => true
            ],
            'move_in_date' => 'Jan 10, 2026',
            'duration' => '6 Months',
            'rent' => 9500,
            'deposit' => 15000,
            'token_fee' => 500,
            'token_status' => 'Paid',
            'move_in_balance' => 24000,
            'status' => 'Completed',
            'created_at' => '8 months ago',
            'timeline' => [
                ['step' => 'Booking Requested', 'date' => 'Jan 02, 2026', 'done' => true],
                ['step' => 'Owner Reviewing', 'date' => 'Jan 03, 2026', 'done' => true],
                ['step' => 'Booking Approved', 'date' => 'Jan 04, 2026', 'done' => true],
                ['step' => 'Physical Move-in & Check-in', 'date' => 'Jan 10, 2026', 'done' => true],
                ['step' => 'Completed', 'date' => 'Jul 10, 2026', 'done' => true]
            ]
        ]
    ];
}

// Master Chats Dataset for Owner
if (!isset($_SESSION['owner_chats'])) {
    $_SESSION['owner_chats'] = [
        [
            'id' => 'chat_1',
            'user_name' => 'Vishal Patel',
            'user_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80',
            'property_title' => "St. Mark's Executive PG",
            'property_id' => 101,
            'booking_id' => 'B1024',
            'last_message' => 'Yes, the single occupancy room is confirmed available from Sep 1.',
            'last_time' => '2 mins ago',
            'unread' => 1,
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
            'user_name' => 'Rohan Sharma',
            'user_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&q=80',
            'property_title' => "St. Mark's Executive PG",
            'property_id' => 101,
            'booking_id' => 'B1021',
            'last_message' => 'Thank you Rajesh ji, digital check-in pass received!',
            'last_time' => '1 hour ago',
            'unread' => 0,
            'online' => false,
            'messages' => [
                ['sender' => 'owner', 'text' => 'Hi Rohan, your booking #B1021 has been approved.', 'time' => '09:15 AM'],
                ['sender' => 'user', 'text' => 'Thank you Rajesh ji, digital check-in pass received!', 'time' => '09:20 AM']
            ]
        ]
    ];
}

// Master Reviews Dataset for Owner
if (!isset($_SESSION['owner_reviews'])) {
    $_SESSION['owner_reviews'] = [
        [
            'id' => 'rev_1',
            'property_id' => 101,
            'property_title' => "St. Mark's Executive PG for Men",
            'user_name' => 'Karan Malhotra',
            'user_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80',
            'rating' => 5,
            'stay_period' => 'Jan 2026 - Jul 2026 (6 Months)',
            'comment' => 'Excellently managed PG! Rajesh ji is very helpful and North/South Indian meals were delicious and hygienic. High speed 200Mbps Wi-Fi helped me work smoothly. Highly recommended!',
            'posted_at' => 'Jul 15, 2026',
            'owner_reply' => 'Thank you Karan! Wish you all the best for your future career.'
        ],
        [
            'id' => 'rev_2',
            'property_id' => 105,
            'property_title' => "Koramangala Tech Residency Studio Flat",
            'user_name' => 'Ananya Roy',
            'user_avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=120&q=80',
            'rating' => 4,
            'stay_period' => 'Recent Resident (2026)',
            'comment' => 'Spacious and well ventilated flat in prime 5th block Koramangala. Peaceful neighborhood with great parking space.',
            'posted_at' => 'Aug 02, 2026',
            'owner_reply' => null
        ]
    ];
}

// Master Earnings Dataset for Owner
if (!isset($_SESSION['owner_earnings'])) {
    $_SESSION['owner_earnings'] = [
        'total_lifetime' => 425000,
        'this_month' => 485000,
        'pending_escrow' => 24500,
        'withdrawable' => 65000,
        'transactions' => [
            ['id' => 'TXN-9021', 'date' => 'Aug 29, 2026', 'tenant' => 'Vishal Patel', 'property' => "St. Mark's Executive PG", 'type' => 'Token Fee Deposit', 'status' => 'Completed', 'amount' => 500],
            ['id' => 'TXN-9018', 'date' => 'Aug 25, 2026', 'tenant' => 'Rohan Sharma', 'property' => "St. Mark's Executive PG", 'type' => 'Token Fee Deposit', 'status' => 'Completed', 'amount' => 500],
            ['id' => 'TXN-8990', 'date' => 'Jul 01, 2026', 'tenant' => 'Ananya Roy', 'property' => 'Koramangala Tech Residency', 'type' => 'Monthly Rent + Deposit', 'status' => 'Completed', 'amount' => 72000],
            ['id' => 'TXN-8840', 'date' => 'Jun 15, 2026', 'tenant' => 'Karan Malhotra', 'property' => "St. Mark's Executive PG", 'type' => 'Monthly Rent Payout', 'status' => 'Completed', 'amount' => 9500]
        ]
    ];
}

// Master Notifications Dataset for Owner
if (!isset($_SESSION['owner_notifications'])) {
    $_SESSION['owner_notifications'] = [
        [
            'id' => 'notif_o1',
            'title' => 'New Booking Request Received (#B1024)',
            'desc' => 'Vishal Patel (Christ University) placed a stay request for St. Mark\'s Executive PG.',
            'time' => '2 days ago',
            'type' => 'booking',
            'icon' => 'fa-calendar-plus',
            'color' => 'warning',
            'unread' => true,
            'link' => 'booking-details.php?id=B1024'
        ],
        [
            'id' => 'notif_o2',
            'title' => 'New Chat Message from Vishal Patel',
            'desc' => 'Tenant asked: "Can I visit for a quick physical inspection tomorrow afternoon?"',
            'time' => '2 mins ago',
            'type' => 'message',
            'icon' => 'fa-comment-dots',
            'color' => 'primary',
            'unread' => true,
            'link' => 'messages.php?chat=chat_1'
        ],
        [
            'id' => 'notif_o3',
            'title' => 'Token Fee Received (₹500)',
            'desc' => 'Token deposit for booking #B1024 paid online by student.',
            'time' => '2 hours ago',
            'type' => 'payment',
            'icon' => 'fa-receipt',
            'color' => 'success',
            'unread' => false,
            'link' => 'earnings.php'
        ]
    ];
}

// Helper Functions
function getUnreadOwnerMessagesCount() {
    $count = 0;
    if (isset($_SESSION['owner_chats'])) {
        foreach ($_SESSION['owner_chats'] as $chat) {
            $count += $chat['unread'];
        }
    }
    return $count;
}

function getPendingOwnerBookingsCount() {
    $count = 0;
    if (isset($_SESSION['owner_bookings'])) {
        foreach ($_SESSION['owner_bookings'] as $b) {
            if ($b['status'] === 'Pending') {
                $count++;
            }
        }
    }
    return $count;
}

function getUnreadOwnerNotificationsCount() {
    $count = 0;
    if (isset($_SESSION['owner_notifications'])) {
        foreach ($_SESSION['owner_notifications'] as $n) {
            if (!empty($n['unread'])) {
                $count++;
            }
        }
    }
    return $count;
}
