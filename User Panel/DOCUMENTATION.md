# NeighborNest - User Panel Technical & Feature Documentation

Welcome to the technical and feature documentation for the **NeighborNest User & Student Accommodation Panel**. This guide covers the full architecture, available modules, data models, UI components, and end-to-end user workflows.

---

## 📌 Executive Overview

**NeighborNest** is a verified student and tenant accommodation discovery & booking platform designed to provide a zero-brokerage, transparent housing search experience.

### Key Highlights
- **Zero Brokerage Model**: Direct interaction with verified property hosts.
- **Two-Stage Safe Payment Protocol**: Token deposit to reserve + final move-in balance upon check-in.
- **Student Verification System**: Multi-field academic verification (College Name, Course, Student ID).
- **Responsive Layout**: Dual layout support featuring desktop sidebar navigation and a mobile app bottom bar (`< 992px`).

---

## 🏗️ Architecture & File Structure

All User Panel pages are contained inside `d:\laragon\www\Neighberhood\User Panel\`.

```text
User Panel/
├── includes/
│   ├── functions.php       # Mock session datasets & core helper functions
│   ├── header.php          # Meta tags, Google Fonts, FontAwesome, Bootstrap 5 & Master CSS
│   ├── top-navbar.php      # Sticky topbar with search, notifications, & user avatar
│   ├── sidebar.php         # Desktop fixed navigation sidebar
│   └── footer.php          # Page footer, mobile bottom nav, & JavaScript initializations
├── dashboard.php           # User home overview dashboard
├── search.php              # Accommodation catalog search with interactive Leaflet map & filters
├── property-details.php    # Single property detailed view & room options
├── compare.php             # Side-by-side accommodation comparison tool
├── wishlist.php            # Saved shortlist property cards
├── bookings.php            # My Bookings & Stay Requests management
├── booking-request.php     # Multi-step accommodation booking wizard
├── booking-details.php     # Detailed booking view, digital check-in pass, & timeline
├── messages.php            # Direct 2-column chat engine with landlords
├── reviews.php             # User stay reviews & rating modal
├── notifications.php       # Real-time alert notification center
├── profile.php             # Personal & college verification details
└── settings.php            # Account preferences, alerts, & Change Password modal
```

---

## 📊 Core Datasets (`includes/functions.php`)

All user session state is persistently stored in `$_SESSION` to allow seamless interaction without external database overhead.

### 1. `$_SESSION['user']`
Stores verified student profile info:
- `name`: Full Name (e.g., *Vishal Patel*)
- `email`: Student Email (*vishal.patel@example.com*)
- `phone`: Mobile Contact
- `college`: Educational Institution (*Christ University, Bangalore*)
- `course`: Major Degree (*B.Tech Computer Science*)
- `student_id`: Verification ID (*CU-2022-CS-4891*)

### 2. `getPropertiesData()`
Master array of available accommodations containing:
- `id`, `title`, `type` (*PG*, *Hostel*, *Apartment*, *Room*)
- `city`, `area`, `rent`, `deposit`
- `gender` (*male_only*, *female_only*, *unisex*)
- `rating`, `reviews_count`, `available_beds`, `verified`
- `amenities`, `nearby`, `room_options`, `owner` profile details

### 3. `$_SESSION['user_bookings']`
Tracks stay requests through 5 lifecycle stages:
1. `Booking Requested`
2. `Owner Reviewing`
3. `Booking Approved`
4. `Physical Move-in & Check-in`
5. `Completed`

---

## 💻 Detailed Page Breakdown

### 1. Dashboard (`dashboard.php`)
- **Purpose**: Central hub providing quick statistics and active lease alerts.
- **Key Features**:
  - Stat counter cards for *Saved Wishlists*, *Active Bookings*, *Unread Messages*, and *Reviews*.
  - Active stay banner with quick actions (*Contact Landlord*, *Check-in Pass*).
  - Recommended accommodations carousel/grid.

### 2. Accommodation Search (`search.php`)
- **Purpose**: Exploration catalog for verified PGs, hostels, and flats.
- **Key Features**:
  - Filter bar: City, Room Type (*PG*, *Hostel*, *Apartment*), Rent Range Slider, and Gender restrictions.
  - Interactive **Leaflet.js Map** displaying property pins.
  - Quick toggle between **Grid View** and **Map View**.

### 3. Property Details (`property-details.php`)
- **Purpose**: Complete overview of a selected property.
- **Key Features**:
  - Image gallery with lightroom modal preview.
  - Room occupancy options with pricing breakdown.
  - Amenities list (*Wi-Fi*, *Meals*, *AC*, *Power Backup*, *Geyser*).
  - House rules, nearby landmark distances, and direct **Request Booking** call-to-action button.

### 4. Property Comparison (`compare.php`)
- **Purpose**: Compare up to 3 shortlisted properties side-by-side.
- **Key Features**:
  - Table matrix comparing Monthly Rent, Deposit, Gender criteria, Distance, Amenities, and User Ratings.

### 5. Wishlist (`wishlist.php`)
- **Purpose**: Saved accommodations for quick access.
- **Key Features**:
  - Single-click remove item (`?remove=id`) and Clear All (`?clear=1`).
  - Direct links to compare or proceed to property details.

### 6. My Bookings (`bookings.php`)
- **Purpose**: Manage accommodation applications and active leases.
- **Key Features**:
  - Scrollable status tab navigation bar (*All*, *Pending*, *Approved*, *Active Stays*, *Completed*, *Cancelled*).
  - Warning banner when reaching the 3 active pending request limit.
  - Styled contextual action buttons:
    - *Pending*: `Cancel Request` (`.btn-danger-custom`)
    - *Approved*: `Confirm & Check-in Pass`, `Decline`
    - *Active*: `Extend Stay`
    - *Completed*: `Write Review` (`.btn-warning-custom`), `Receipt`

### 7. Booking Wizard (`booking-request.php`)
- **Purpose**: Step-by-step application submission.
- **Key Features**:
  - Step 1: Select Room Type & Occupancy.
  - Step 2: Choose Move-in Date & Lease Duration.
  - Step 3: Student Identity Verification preview.
  - Step 4: Rent & Token Fee (₹500) payment breakdown.
  - Step 5: Instant booking confirmation screen with reference ID (`#B1024`).

### 8. Booking Details (`booking-details.php`)
- **Purpose**: Individual booking hub and move-in pass.
- **Key Features**:
  - Step-by-step interactive status timeline.
  - Printable **Digital Check-in Pass** with QR code.
  - Landlord contact card and payment receipt summary.

### 9. Messages & Inquiries (`messages.php`)
- **Purpose**: Real-time 2-column chat engine with property owners.
- **Key Features**:
  - Search conversation bar in the left panel.
  - Verified host badge and property reference links in the header.
  - Auto-scrolling chat history with user bubbles (primary indigo gradient) and host bubbles (white border card).
  - Attachment button simulation and instant message post handler.

### 10. Reviews (`reviews.php`)
- **Purpose**: Rate and review completed stay accommodations.
- **Key Features**:
  - Rating breakdown display with star badges.
  - **Write Review Modal** with star rating selector and comment box.

### 11. Notification Center (`notifications.php`)
- **Purpose**: Real-time system updates.
- **Key Features**:
  - `Mark All as Read` and `Clear All` action controls.
  - Distinct alert icons for booking updates, chat messages, and payment receipts.

### 12. User Profile (`profile.php`)
- **Purpose**: Tenant personal details and academic credentials.
- **Key Features**:
  - Avatar image view & upload dialog trigger.
  - Form fields for Legal Name, Email, Phone, Emergency Contact, College Name, Course Degree, and Student ID upload.

### 13. Settings (`settings.php`)
- **Purpose**: Account preferences and security.
- **Key Features**:
  - Notification toggle switches for SMS, WhatsApp, & Email alerts.
  - Profile visibility & phone privacy settings.
  - **Change Account Password Modal** popup with show/hide password visibility toggles.
  - Account deletion trigger in the Danger Zone.

---

## 🎨 Global Styling System

The application utilizes a custom design system defined in `includes/header.php`:

| Token Name | Hex Code | Usage |
| :--- | :--- | :--- |
| `--nh-royal-blue` | `#4338CA` | Brand text, headers, and accents |
| `--nh-bright-indigo` | `#4F46E5` | Buttons, active navigation, focus rings |
| `--nh-soft-lavender` | `#EEF2FF` | Soft backgrounds, active tab pills |
| `--nh-bg-light` | `#F8FAFC` | Page body background |
| `--nh-gradient-primary` | `linear-gradient(135deg, #4F46E5, #4338CA)` | Primary action buttons & user chat bubbles |

---

## 🔄 Common User Workflow

```text
  Explore Accommodations (search.php)
       │
       ▼
  View Details & Gallery (property-details.php)
       │
       ├──► Save to Wishlist (wishlist.php) or Compare (compare.php)
       │
       ▼
  Submit Booking Request (booking-request.php)
       │
       ▼
  Track Application Status (bookings.php)
       │
       ├──► Chat with Landlord (messages.php)
       ├──► View Digital Check-in Pass (booking-details.php)
       └──► Write Accommodation Review (reviews.php)
```

---
*Documented for NeighborNest User Panel Application.*
