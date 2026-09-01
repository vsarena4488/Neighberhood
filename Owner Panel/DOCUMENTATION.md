# NeighborNest - Owner Panel Technical & Feature Documentation

Welcome to the official technical and feature documentation for the **NeighborNest Owner & Host Accommodation Panel**. This guide documents all modules, datasets, workflows, and layout structures inside `d:\laragon\www\Neighberhood\Owner Panel\`.

---

## 📌 Executive Overview

The **NeighborNest Owner Panel** empowers verified property owners, PGs, hostels, and flat landlords to manage their accommodation listings, review student booking applications, track revenue payouts, converse directly with tenants, and maintain high guest ratings.

---

## 🏗️ Architecture & File Breakdown

```text
Owner Panel/
├── includes/
│   ├── functions.php       # Mock session datasets ($_SESSION['owner'], $_SESSION['owner_properties'], etc.)
│   ├── header.php          # Meta tags, Google Fonts, FontAwesome 6, Bootstrap 5 & Master CSS Design Tokens
│   ├── top-navbar.php      # Sticky topbar with search, quick "+ Add Property" action, and notification badge
│   ├── sidebar.php         # Clean 10-link desktop navigation sidebar
│   └── footer.php          # In-page footer, mobile bottom app bar (< 992px), & JavaScript controllers
├── dashboard.php           # Host overview dashboard (Welcome banner, 4 stats, Today's Schedule widget)
├── properties.php          # My Properties management grid with status tabs & bulk actions
├── add-property.php        # 7-Step Multi-Step Add Property creation wizard with "Save Draft"
├── bookings.php            # Bookings hub with Occupancy Calendar Widget & decision buttons
├── booking-details.php     # Student identity verification badge, booking timeline & financial breakdown
├── messages.php            # 2-Column responsive chat engine with Quick Reply templates
├── reviews.php             # Overall rating analytics, tenant reviews, & Owner Reply modal
├── earnings.php            # Lifetime & monthly revenue stats, transaction logs, & Withdrawal Request modal
├── analytics.php           # Page views, wishlist saves, inquiry conversion rates, & property comparison matrix
├── notifications.php       # Urgency color-coded alert notification center
├── profile.php             # Host verification checklist (Identity, Email/Phone, Property Deeds)
└── settings.php            # Alert toggles, WhatsApp notifications, & Change Password modal popup
```

---

## 📋 Core Modules & Page Summary

| Module | Route | Purpose | Key Features |
| :--- | :--- | :--- | :--- |
| **Dashboard** | `dashboard.php` | Overview Hub | 4 stat counters, Today's Schedule (Check-ins/out), Recent bookings, Quick CTAs |
| **My Properties** | `properties.php` | Property Catalog | Status pills (*Active, Pending, Draft*), availability counts, delete/deactivate |
| **Add Property** | `add-property.php` | 7-Step Wizard | Basic Info, Location map, Rooms & Pricing, Amenities grid, House Rules, Photos, Save Draft |
| **Bookings** | `bookings.php` | Applications | Status pills, **Occupancy Calendar Widget**, Accept/Reject actions |
| **Booking Details** | `booking-details.php` | Application View | Student Verified ID badge (College, Course, Student ID), timeline, counter-offer |
| **Messages** | `messages.php` | Chat Engine | 2-column layout, **Quick Reply Templates** (*Wi-Fi*, *Meals*, *Curfew*), attachment simulation |
| **Reviews** | `reviews.php` | Reputation | Overall rating (4.9/5.0), star distribution, **Owner Reply Modal** |
| **Earnings** | `earnings.php` | Financials | Lifetime revenue, withdrawable balance, transaction history table, Withdrawal Modal |
| **Analytics** | `analytics.php` | Performance | Page views, wishlist count, inquiry conversion rate %, comparison matrix |
| **Notifications** | `notifications.php` | Alert Center | Urgency-coded alerts (Booking, Chat, Payout, Review), Mark All Read, Clear |
| **Profile** | `profile.php` | Verification | Verification Checklist (*Aadhaar/PAN, Email/Phone, Property Deeds*), Host Preview Card |
| **Settings** | `settings.php` | Preferences | WhatsApp/Email/SMS switches, **Change Password Modal Popup**, Danger Zone |

---

## 🔄 User ↔ Owner Panel Integration Matrix

```text
  User Panel Action                       Owner Panel Response
  ─────────────────                       ────────────────────
  1. Searches Accommodations       ──►   Property appears in search catalog
  2. Views Property Details        ──►   Property page view counter increases (+1)
  3. Saves to Wishlist             ──►   Wishlist save counter updates
  4. Submits Booking Request       ──►   🔔 New Booking Request notification & #B1024 entry
  5. Pays ₹500 Token Fee           ──►   💰 Token Fee status updates to "Paid"
  6. Landlord Accepts Application  ──►   ✅ Booking status -> Approved, Digital Pass generated
  7. Student Physical Move-in      ──►   🟢 Booking status -> Active, Occupancy Calendar updated
  8. Posts Stay Review             ──►   ⭐ Rating posted, Owner Reply modal unlocked
```

---
*Documented for NeighborNest Owner Panel Application.*
