<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NeighborHood · Find PGs, Hostels, Rooms & Rental Houses</title>
  <meta name="description" content="Centralized Neighborhood Rental & Accommodation Platform. Easily find, compare, and book verified PGs, hostels, rooms, apartments, and rental houses across top cities." />

  <!-- Google Fonts: Inter & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Leaflet CSS for Interactive Property Map -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <style>
    /* ===================================================
       MASTER DESIGN SYSTEM - PADDING, MARGINS & THEME
       =================================================== */
    :root {
      --nh-royal-blue: #4338CA;
      --nh-bright-indigo: #4F46E5;
      --nh-indigo-hover: #3730A3;
      --nh-soft-lavender: #EEF2FF;
      --nh-lavender-border: #C7D2FE;
      --nh-white: #FFFFFF;
      --nh-bg-light: #F8FAFC;
      --nh-dark-text: #0F172A;
      --nh-secondary-text: #64748B;
      --nh-border: #E2E8F0;
      --nh-border-focus: #818CF8;
      --nh-success: #10B981;
      --nh-amber: #F59E0B;
      --nh-rose: #F43F5E;

      --nh-gradient-primary: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
      --nh-gradient-hero: linear-gradient(180deg, #EEF2FF 0%, #F8FAFC 100%);
      --nh-gradient-card: linear-gradient(180deg, rgba(255, 255, 255, 0.95) 0%, #FFFFFF 100%);

      --nh-radius-xl: 24px;
      --nh-radius-lg: 18px;
      --nh-radius-md: 12px;
      --nh-radius-sm: 8px;
      --nh-radius-pill: 50px;

      --nh-shadow-subtle: 0 4px 15px rgba(67, 56, 202, 0.04);
      --nh-shadow-card: 0 8px 25px -4px rgba(67, 56, 202, 0.08), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
      --nh-shadow-hover: 0 20px 35px -8px rgba(67, 56, 202, 0.16);
      --nh-transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background-color: var(--nh-bg-light);
      color: var(--nh-dark-text);
      line-height: 1.6;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }

    html {
      scroll-behavior: smooth;
    }

    section[id] {
      scroll-margin-top: 85px;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .heading-font {
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
      font-weight: 700;
      color: var(--nh-dark-text);
      letter-spacing: -0.02em;
    }

    /* Standardized Section Spacing */
    .section-spacing {
      padding: 4.75rem 0;
    }

    .section-header {
      margin-bottom: 2.75rem;
    }

    .section-tag {
      display: inline-block;
      color: var(--nh-bright-indigo);
      font-weight: 700;
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      margin-bottom: 0.4rem;
    }

    .extra-small {
      font-size: 0.78rem;
    }

    .fs-xs {
      font-size: 0.72rem;
    }

    /* Custom Utilities */
    .bg-soft-lavender {
      background-color: var(--nh-soft-lavender) !important;
    }

    .bg-slate-canvas {
      background-color: var(--nh-bg-light) !important;
    }

    .text-royal-blue {
      color: var(--nh-royal-blue) !important;
    }

    .text-bright-indigo {
      color: var(--nh-bright-indigo) !important;
    }

    .text-secondary-custom {
      color: var(--nh-secondary-text) !important;
    }

    .text-success-custom {
      color: var(--nh-success) !important;
    }

    .max-w-xl {
      max-width: 720px;
    }

    .max-w-md {
      max-width: 540px;
    }

    .object-fit-cover {
      object-fit: cover;
    }

    .leading-relaxed {
      line-height: 1.7;
    }

    /* Buttons */
    .btn-nh-primary {
      background: var(--nh-gradient-primary);
      color: #FFFFFF !important;
      border: none;
      padding: 0.7rem 1.6rem;
      border-radius: var(--nh-radius-pill);
      font-weight: 600;
      font-size: 0.92rem;
      box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
      transition: var(--nh-transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      cursor: pointer;
      text-decoration: none;
    }

    .btn-nh-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(79, 70, 229, 0.45);
      color: #FFFFFF !important;
    }

    .btn-nh-outline {
      background: transparent;
      color: var(--nh-royal-blue) !important;
      border: 1.5px solid var(--nh-bright-indigo);
      padding: 0.65rem 1.4rem;
      border-radius: var(--nh-radius-pill);
      font-weight: 600;
      font-size: 0.92rem;
      transition: var(--nh-transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      cursor: pointer;
      text-decoration: none;
    }

    .btn-nh-outline:hover {
      background: var(--nh-soft-lavender);
      transform: translateY(-2px);
      color: var(--nh-royal-blue) !important;
    }

    .btn-nh-secondary {
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue) !important;
      border: 1px solid var(--nh-lavender-border);
      padding: 0.6rem 1.25rem;
      border-radius: var(--nh-radius-md);
      font-weight: 600;
      font-size: 0.88rem;
      transition: var(--nh-transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.4rem;
      cursor: pointer;
      text-decoration: none;
    }

    .btn-nh-secondary:hover {
      background: var(--nh-bright-indigo);
      color: #FFFFFF !important;
      border-color: var(--nh-bright-indigo);
    }

    .btn-sm {
      padding: 0.4rem 1rem;
      font-size: 0.8rem;
    }

    /* Navbar */
    .navbar-nh {
      background: rgba(255, 255, 255, 0.94);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--nh-border);
      padding: 0.75rem 0;
      position: sticky;
      top: 0;
      z-index: 1040;
      transition: var(--nh-transition);
    }

    .navbar-nh .navbar-brand {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.45rem;
      color: var(--nh-royal-blue);
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }

    .navbar-nh .brand-icon {
      width: 38px;
      height: 38px;
      background: var(--nh-gradient-primary);
      color: #fff;
      border-radius: var(--nh-radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
      box-shadow: 0 4px 12px rgba(67, 56, 202, 0.25);
      flex-shrink: 0;
    }

    .navbar-nh .nav-link {
      font-weight: 500;
      color: var(--nh-dark-text);
      padding: 0.5rem 0.85rem;
      font-size: 0.92rem;
      border-radius: var(--nh-radius-pill);
      transition: var(--nh-transition);
    }

    .navbar-nh .nav-link:hover,
    .navbar-nh .nav-link.active {
      color: var(--nh-bright-indigo);
      background: var(--nh-soft-lavender);
    }

    .city-select-pill {
      background: var(--nh-soft-lavender);
      border: 1px solid var(--nh-lavender-border);
      border-radius: var(--nh-radius-pill);
      padding: 0.45rem 1.1rem;
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--nh-royal-blue);
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      cursor: pointer;
      transition: var(--nh-transition);
    }

    .city-select-pill:hover {
      background: #E0E7FF;
      border-color: var(--nh-bright-indigo);
    }

    /* Hero Section */
    .hero-section {
      background: var(--nh-gradient-hero);
      padding: 4.5rem 0 5rem 0;
      position: relative;
      overflow: hidden;
    }

    .hero-section::before {
      content: '';
      position: absolute;
      top: -120px;
      right: -120px;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(79, 70, 229, 0.12) 0%, rgba(238, 242, 255, 0) 70%);
      border-radius: 50%;
      pointer-events: none;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: var(--nh-soft-lavender);
      border: 1px solid var(--nh-lavender-border);
      color: var(--nh-royal-blue);
      padding: 0.45rem 1.2rem;
      border-radius: var(--nh-radius-pill);
      font-size: 0.85rem;
      font-weight: 700;
      margin-bottom: 1.25rem;
    }

    /* Master Search Bar Card */
    .search-box-card {
      background: var(--nh-white);
      border-radius: var(--nh-radius-xl);
      padding: 1.75rem 2rem;
      box-shadow: 0 16px 40px -10px rgba(67, 56, 202, 0.12), 0 2px 10px rgba(0, 0, 0, 0.02);
      border: 1px solid var(--nh-border);
    }

    .search-tab-btn {
      background: transparent;
      border: 1px solid transparent;
      padding: 0.55rem 1.25rem;
      font-weight: 600;
      font-size: 0.88rem;
      color: var(--nh-secondary-text);
      border-radius: var(--nh-radius-pill);
      transition: var(--nh-transition);
      cursor: pointer;
    }

    .search-tab-btn:hover {
      color: var(--nh-royal-blue);
      background: #F1F5F9;
    }

    .search-tab-btn.active {
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
      border-color: var(--nh-lavender-border);
      box-shadow: 0 2px 8px rgba(79, 70, 229, 0.12);
    }

    /* Property Card System */
    .property-card {
      background: var(--nh-white);
      border-radius: var(--nh-radius-lg);
      border: 1px solid var(--nh-border);
      box-shadow: var(--nh-shadow-card);
      overflow: hidden;
      transition: var(--nh-transition);
      height: 100%;
      display: flex;
      flex-direction: column;
      position: relative;
    }

    .property-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--nh-shadow-hover);
      border-color: var(--nh-lavender-border);
    }

    .card-img-wrapper {
      position: relative;
      height: 220px;
      overflow: hidden;
      background: #e2e8f0;
      flex-shrink: 0;
    }

    .card-img-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .property-card:hover .card-img-wrapper img {
      transform: scale(1.06);
    }

    .card-badge-top {
      position: absolute;
      top: 12px;
      left: 12px;
      z-index: 2;
      display: flex;
      flex-direction: column;
      gap: 6px;
      align-items: flex-start;
    }

    .badge-tag {
      padding: 0.35rem 0.75rem;
      border-radius: var(--nh-radius-pill);
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .badge-verified {
      background: rgba(16, 185, 129, 0.95);
      color: #fff;
      backdrop-filter: blur(4px);
    }

    .badge-type {
      background: rgba(67, 56, 202, 0.92);
      color: #fff;
      backdrop-filter: blur(4px);
    }

    .badge-gender {
      background: rgba(15, 23, 42, 0.85);
      color: #fff;
      backdrop-filter: blur(4px);
    }

    .btn-favorite-card {
      position: absolute;
      top: 12px;
      right: 12px;
      z-index: 2;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(4px);
      border: none;
      color: var(--nh-secondary-text);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--nh-transition);
    }

    .btn-favorite-card:hover,
    .btn-favorite-card.active {
      background: #fff;
      color: var(--nh-rose);
      transform: scale(1.1);
    }

    .card-body-custom {
      padding: 1.4rem;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }

    .amenity-pill {
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
      font-size: 0.75rem;
      font-weight: 600;
      padding: 0.28rem 0.65rem;
      border-radius: var(--nh-radius-sm);
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
    }

    .rent-price-display {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--nh-royal-blue);
      line-height: 1.2;
    }

    /* Category Pill Grid */
    .category-box {
      background: var(--nh-white);
      border: 1.5px solid var(--nh-border);
      border-radius: var(--nh-radius-lg);
      padding: 1.5rem 1.1rem;
      text-align: center;
      transition: var(--nh-transition);
      cursor: pointer;
      box-shadow: var(--nh-shadow-subtle);
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .category-box:hover,
    .category-box.active {
      border-color: var(--nh-bright-indigo);
      background: var(--nh-soft-lavender);
      transform: translateY(-4px);
      box-shadow: var(--nh-shadow-card);
    }

    .category-icon {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      background: var(--nh-soft-lavender);
      color: var(--nh-bright-indigo);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.35rem;
      margin-bottom: 0.85rem;
      transition: var(--nh-transition);
      flex-shrink: 0;
    }

    .category-box:hover .category-icon,
    .category-box.active .category-icon {
      background: var(--nh-bright-indigo);
      color: #fff;
    }

    /* City Card Grid */
    .city-card {
      position: relative;
      border-radius: var(--nh-radius-lg);
      overflow: hidden;
      height: 190px;
      cursor: pointer;
      box-shadow: var(--nh-shadow-card);
      border: 1px solid var(--nh-border);
    }

    .city-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .city-card:hover img {
      transform: scale(1.08);
    }

    .city-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(15, 23, 42, 0.05) 0%, rgba(15, 23, 42, 0.88) 100%);
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 1.25rem;
      color: #fff;
    }

    .city-card.active-city {
      border: 2px solid var(--nh-bright-indigo);
      box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.25);
    }

    /* How It Works Steps */
    .step-number-circle {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      background: var(--nh-gradient-primary);
      color: #fff;
      font-weight: 800;
      font-size: 1.3rem;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.25rem;
      box-shadow: 0 8px 20px rgba(67, 56, 202, 0.25);
      flex-shrink: 0;
    }

    /* Interactive Map Container */
    #property-leaflet-map {
      height: 480px;
      border-radius: var(--nh-radius-lg);
      border: 1px solid var(--nh-border);
      box-shadow: var(--nh-shadow-card);
      z-index: 10;
      width: 100%;
    }

    /* Compare Drawer & Floating Trigger */
    .compare-float-bar {
      position: fixed;
      bottom: 24px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 1050;
      background: #0F172A;
      color: #fff;
      border-radius: var(--nh-radius-pill);
      padding: 0.75rem 1.6rem;
      box-shadow: 0 16px 40px rgba(0, 0, 0, 0.35);
      display: flex;
      align-items: center;
      gap: 1.2rem;
      border: 1px solid rgba(255, 255, 255, 0.15);
      animation: slideUpFloat 0.3s ease-out;
    }

    @keyframes slideUpFloat {
      from {
        transform: translate(-50%, 40px);
        opacity: 0;
      }

      to {
        transform: translate(-50%, 0);
        opacity: 1;
      }
    }

    /* Modal Styling */
    .modal-content-custom {
      border-radius: var(--nh-radius-xl);
      border: none;
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.22);
      overflow: hidden;
    }

    /* Accordion FAQ Styling */
    .accordion-nh .accordion-item {
      border: 1px solid var(--nh-border);
      border-radius: var(--nh-radius-md) !important;
      margin-bottom: 0.85rem;
      overflow: hidden;
    }

    .accordion-nh .accordion-button {
      font-weight: 600;
      color: var(--nh-dark-text);
      background-color: var(--nh-white);
      padding: 1.1rem 1.25rem;
      box-shadow: none !important;
    }

    .accordion-nh .accordion-button:not(.collapsed) {
      color: var(--nh-royal-blue);
      background-color: var(--nh-soft-lavender);
    }

    .accordion-nh .accordion-body {
      color: var(--nh-secondary-text);
      font-size: 0.92rem;
      line-height: 1.65;
      padding: 1.1rem 1.25rem;
      background: var(--nh-white);
    }

    /* Footer */
    footer {
      background: #0B1120;
      color: #94A3B8;
      padding: 5rem 0 2rem 0;
    }

    footer h5,
    footer h6 {
      color: #FFFFFF;
    }

    footer a {
      color: #94A3B8;
      text-decoration: none;
      transition: var(--nh-transition);
      display: block;
      margin-bottom: 0.6rem;
      font-size: 0.9rem;
    }

    footer a:hover {
      color: #FFFFFF;
      transform: translateX(3px);
    }

    /* Form Controls Alignment Fix */
    .form-control,
    .form-select {
      border-radius: var(--nh-radius-sm);
      border-color: var(--nh-border);
    }

    .form-control:focus,
    .form-select:focus {
      border-color: var(--nh-border-focus);
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.08);
    }

    .form-range::-webkit-slider-thumb {
      background: var(--nh-bright-indigo);
    }

    .form-range::-moz-range-thumb {
      background: var(--nh-bright-indigo);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .section-spacing {
        padding: 3rem 0;
      }

      .section-header {
        margin-bottom: 2rem;
      }

      .hero-section {
        padding: 2.75rem 0 3.5rem 0;
      }

      .search-box-card {
        padding: 1.25rem;
      }

      .compare-float-bar {
        width: 92%;
        justify-content: space-between;
        padding: 0.65rem 1.2rem;
        gap: 0.5rem;
        flex-wrap: wrap;
      }

      .hero-section .display-4 {
        font-size: 2.2rem;
      }

      .city-card {
        height: 150px;
      }

      .card-img-wrapper {
        height: 180px;
      }
    }

    @media (max-width: 576px) {
      .hero-section .display-4 {
        font-size: 1.8rem;
      }

      .search-box-card {
        padding: 1rem;
      }

      .search-tab-btn {
        font-size: 0.75rem;
        padding: 0.35rem 0.8rem;
      }

      .category-box {
        padding: 1rem 0.75rem;
      }

      .category-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
      }

      .city-card {
        height: 120px;
      }

      .card-img-wrapper {
        height: 160px;
      }

      .rent-price-display {
        font-size: 1.1rem;
      }
    }
  </style>
</head>

<body>

  <!-- ============================================================
       SECTION 1: GLOBAL HEADER & NAVBAR
       ============================================================ -->
  <nav class="navbar navbar-expand-lg navbar-nh">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <div class="brand-icon"><i class="fas fa-home"></i></div>
        <span>NeighborHood</span>
      </a>

      <!-- City Selector Dropdown in Navbar (Desktop) -->
      <div class="ms-lg-3 me-auto d-none d-sm-flex align-items-center">
        <div class="dropdown">
          <button class="city-select-pill dropdown-toggle" type="button" id="navCityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-location-dot text-bright-indigo"></i>
            <span id="selected-nav-city">Bangalore</span>
          </button>
          <ul class="dropdown-menu shadow-lg border-0 rounded-4 mt-2" aria-labelledby="navCityDropdown" id="navbar-city-menu">
            <li>
              <h6 class="dropdown-header text-uppercase fs-xs">Select City Hub</h6>
            </li>
            <li><a class="dropdown-item city-option-btn active" href="javascript:void(0)" data-city="Bangalore"><i class="fas fa-city me-2 text-primary"></i> Bangalore</a></li>
            <li><a class="dropdown-item city-option-btn" href="javascript:void(0)" data-city="Mumbai"><i class="fas fa-city me-2 text-primary"></i> Mumbai</a></li>
            <li><a class="dropdown-item city-option-btn" href="javascript:void(0)" data-city="Delhi"><i class="fas fa-city me-2 text-primary"></i> Delhi / NCR</a></li>
            <li><a class="dropdown-item city-option-btn" href="javascript:void(0)" data-city="Pune"><i class="fas fa-city me-2 text-primary"></i> Pune</a></li>
            <li><a class="dropdown-item city-option-btn" href="javascript:void(0)" data-city="Hyderabad"><i class="fas fa-city me-2 text-primary"></i> Hyderabad</a></li>
            <li><a class="dropdown-item city-option-btn" href="javascript:void(0)" data-city="Chennai"><i class="fas fa-city me-2 text-primary"></i> Chennai</a></li>
            <li><a class="dropdown-item city-option-btn" href="javascript:void(0)" data-city="Noida"><i class="fas fa-city me-2 text-primary"></i> Noida / Gurgaon</a></li>
          </ul>
        </div>
      </div>

      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <!-- Mobile City Selector -->
        <div class="d-sm-none my-3 pt-2 border-top">
          <label class="form-label small fw-bold text-secondary-custom mb-1"><i class="fas fa-location-dot text-bright-indigo me-1"></i> Current City:</label>
          <select id="mobile-nav-city-select" class="form-select rounded-3 py-2 fw-medium">
            <option value="Bangalore" selected>Bangalore</option>
            <option value="Mumbai">Mumbai</option>
            <option value="Delhi">Delhi / NCR</option>
            <option value="Pune">Pune</option>
            <option value="Hyderabad">Hyderabad</option>
            <option value="Chennai">Chennai</option>
            <option value="Noida">Noida / Gurgaon</option>
          </select>
        </div>

        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-1">
          <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#categories">Categories</a></li>
          <li class="nav-item"><a class="nav-link" href="#properties">Explore Places</a></li>
          <li class="nav-item"><a class="nav-link" href="#how-it-works">How It Works</a></li>
          <li class="nav-item"><a class="nav-link" href="#verified-section">Trust & Safety</a></li>
          <li class="nav-item"><a class="nav-link" href="#testimonials">Reviews</a></li>
          <li class="nav-item"><a class="nav-link" href="#faq-section">FAQ</a></li>
        </ul>

        <div class="d-flex align-items-center gap-2 ms-lg-3 mt-3 mt-lg-0">
          <a href="login.php" class="btn btn-nh-outline btn-sm">Log In</a>
          <a href="register.php" class="btn btn-nh-primary btn-sm">List Property Free</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- ============================================================
       SECTION 2: HERO BANNER & MASTER SEARCH
       ============================================================ -->
  <section id="home" class="hero-section">
    <div class="container">
      <div class="row align-items-center gy-5">
        <div class="col-lg-7">
          <div class="hero-badge">
            <i class="fas fa-shield-halved text-success-custom"></i>
            100% Verified PGs, Hostels & Rental Homes
          </div>
          <h1 class="display-4 fw-extrabold mb-3">
            Find Your Perfect <br />
            <span class="text-bright-indigo">Place to Stay</span> in Any City
          </h1>
          <p class="lead text-secondary-custom mb-4 pe-lg-4">
            Discover verified PGs, hostels, rooms, apartments, and rental houses near your college or workplace. Compare options, inspect distance to transit, and book with complete confidence.
          </p>

          <!-- Key Quick Stats -->
          <div class="d-flex flex-wrap gap-4 mb-4 pt-2">
            <div>
              <h3 class="fw-bold mb-0 text-royal-blue">15,000+</h3>
              <span class="text-secondary-custom extra-small">Active Properties</span>
            </div>
            <div class="border-end d-none d-sm-block"></div>
            <div>
              <h3 class="fw-bold mb-0 text-royal-blue">7+ Top Cities</h3>
              <span class="text-secondary-custom extra-small">Nationwide Hubs</span>
            </div>
            <div class="border-end d-none d-sm-block"></div>
            <div>
              <h3 class="fw-bold mb-0 text-royal-blue">98%</h3>
              <span class="text-secondary-custom extra-small">Physically Audited</span>
            </div>
            <div class="border-end d-none d-sm-block"></div>
            <div>
              <h3 class="fw-bold mb-0 text-success-custom">₹0 Brokerage</h3>
              <span class="text-secondary-custom extra-small">Direct Landlords</span>
            </div>
          </div>
        </div>

        <div class="col-lg-5">
          <!-- Hero Illustration Card -->
          <div class="position-relative">
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
              <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80" alt="Modern PG Room" class="img-fluid" style="height: 390px; object-fit: cover; width: 100%;" />
              <div class="card-img-overlay d-flex flex-column justify-content-end p-4" style="background: linear-gradient(180deg, transparent 35%, rgba(15,23,42,0.9) 100%); color: #fff;">
                <span class="badge bg-success w-auto align-self-start mb-2"><i class="fas fa-check-circle me-1"></i> Verified Property</span>
                <h5 class="fw-bold text-white mb-1">St. Mark's Executive PG for Men</h5>
                <p class="small text-white-50 mb-0"><i class="fas fa-map-marker-alt me-1 text-danger"></i> Koramangala, Bangalore • 0.4km to Forum Mall</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ============================================================
           SECTION 4: MASTER SEARCH ENGINE BAR
           ============================================================ -->
      <div class="row mt-5">
        <div class="col-12">
          <div class="search-box-card">
            <!-- Search Type Tabs -->
            <div class="d-flex flex-wrap gap-2 mb-3 pb-3 border-bottom" id="search-tabs-container">
              <button type="button" class="search-tab-btn active" data-type="all"><i class="fas fa-border-all me-1"></i> All Types</button>
              <button type="button" class="search-tab-btn" data-type="PG"><i class="fas fa-bed me-1"></i> PG / Paying Guest</button>
              <button type="button" class="search-tab-btn" data-type="Hostel"><i class="fas fa-building-user me-1"></i> Hostels</button>
              <button type="button" class="search-tab-btn" data-type="Room"><i class="fas fa-door-open me-1"></i> Private Rooms</button>
              <button type="button" class="search-tab-btn" data-type="Apartment"><i class="fas fa-building me-1"></i> Apartments & Flats</button>
              <button type="button" class="search-tab-btn" data-type="House"><i class="fas fa-house me-1"></i> Rental Houses</button>
            </div>

            <form id="hero-search-form" onsubmit="event.preventDefault(); filterProperties();">
              <div class="row g-3 align-items-center">
                <!-- City Selector -->
                <div class="col-md-3">
                  <label class="form-label small fw-bold text-secondary-custom mb-1"><i class="fas fa-city me-1 text-bright-indigo"></i> City</label>
                  <select id="search-city" class="form-select border-1 rounded-3 py-2 fw-medium">
                    <option value="Bangalore" selected>Bangalore</option>
                    <option value="Mumbai">Mumbai</option>
                    <option value="Delhi">Delhi / NCR</option>
                    <option value="Pune">Pune</option>
                    <option value="Hyderabad">Hyderabad</option>
                    <option value="Chennai">Chennai</option>
                    <option value="Noida">Noida / Gurgaon</option>
                  </select>
                </div>

                <!-- Area / Landmark Keyword Search -->
                <div class="col-md-3">
                  <label class="form-label small fw-bold text-secondary-custom mb-1"><i class="fas fa-compass me-1 text-bright-indigo"></i> Area / College / Tech Park</label>
                  <input type="text" id="search-keyword" class="form-control border-1 rounded-3 py-2" placeholder="e.g. Koramangala, Bandra, Hitec City..." />
                </div>

                <!-- Budget Range -->
                <div class="col-md-3">
                  <label class="form-label small fw-bold text-secondary-custom mb-1 d-flex justify-content-between">
                    <span><i class="fas fa-indian-rupee-sign me-1 text-bright-indigo"></i> Max Rent:</span>
                    <span id="budget-val" class="text-royal-blue fw-bold">₹35,000</span>
                  </label>
                  <input type="range" class="form-range" id="search-budget" min="4000" max="40000" step="1000" value="35000" />
                </div>

                <!-- Search Button CTA -->
                <div class="col-md-3">
                  <label class="form-label d-none d-md-block mb-1">&nbsp;</label>
                  <button type="submit" class="btn btn-nh-primary w-100 py-2">
                    <i class="fas fa-search me-1"></i> Search Places
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 3 & 6: POPULAR CITIES & CITY QUICK SEARCH
       ============================================================ -->
  <section class="section-spacing bg-white">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-end section-header gap-2">
        <div>
          <span class="section-tag">City Discovery</span>
          <h2 class="h3 fw-bold mb-0">Explore Top Accommodation Hubs</h2>
        </div>
        <span class="text-secondary-custom small">Click any city to view local properties</span>
      </div>

      <div class="row g-3 g-lg-4" id="city-cards-container">
        <div class="col-6 col-md-4 col-lg-3">
          <div class="city-card active-city" id="city-card-Bangalore">
            <img src="https://images.unsplash.com/photo-1596176530529-78163a4f7af2?auto=format&fit=crop&w=400&q=80" alt="Bangalore" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0 text-white">Bangalore</h6>
              <span class="small opacity-75">4,200+ PGs & Rooms</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="city-card" id="city-card-Mumbai">
            <img src="https://images.unsplash.com/photo-1570168007204-dfb528c6958f?auto=format&fit=crop&w=400&q=80" alt="Mumbai" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0 text-white">Mumbai</h6>
              <span class="small opacity-75">3,100+ Listings</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="city-card" id="city-card-Delhi">
            <img src="https://images.unsplash.com/photo-1587474260584-136574528ed5?auto=format&fit=crop&w=400&q=80" alt="Delhi" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0 text-white">Delhi / NCR</h6>
              <span class="small opacity-75">3,800+ Listings</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="city-card" id="city-card-Pune">
            <img src="https://images.unsplash.com/photo-1605649487212-47bdab064df7?auto=format&fit=crop&w=400&q=80" alt="Pune" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0 text-white">Pune</h6>
              <span class="small opacity-75">2,400+ PGs & Rooms</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="city-card" id="city-card-Hyderabad">
            <img src="https://images.unsplash.com/photo-1605146769289-440113cc3d00?auto=format&fit=crop&w=400&q=80" alt="Hyderabad" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0 text-white">Hyderabad</h6>
              <span class="small opacity-75">2,900+ Listings</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="city-card" id="city-card-Chennai">
            <img src="https://images.unsplash.com/photo-1582510003544-4d00b7f74220?auto=format&fit=crop&w=400&q=80" alt="Chennai" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0 text-white">Chennai</h6>
              <span class="small opacity-75">1,800+ Listings</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="city-card" id="city-card-Noida">
            <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=400&q=80" alt="Noida Gurgaon" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0 text-white">Noida / Gurgaon</h6>
              <span class="small opacity-75">2,100+ Listings</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="city-card d-flex align-items-center justify-content-center bg-soft-lavender p-3 text-center" style="border: 1.5px solid var(--nh-border);">
            <div>
              <div class="category-icon mx-auto mb-2"><i class="fas fa-map-location-dot"></i></div>
              <h6 class="fw-bold text-royal-blue mb-1">More Cities</h6>
              <span class="extra-small text-secondary-custom">Expanding Nationwide</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 5: PROPERTY TYPE CATEGORIES
       ============================================================ -->
  <section id="categories" class="section-spacing bg-soft-lavender">
    <div class="container">
      <div class="text-center max-w-xl mx-auto section-header">
        <span class="section-tag">Tailored Accommodations</span>
        <h2 class="h3 fw-bold">Browse by Property Type</h2>
        <p class="text-secondary-custom small mb-0">Whether you need a full apartment for your family or a budget sharing PG near your college, we have you covered.</p>
      </div>

      <div class="row g-3 g-md-4">
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" id="cat-box-PG">
            <div class="category-icon"><i class="fas fa-bed"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">Paying Guest</h6>
            <span class="text-secondary-custom extra-small">Food & Cleaning</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" id="cat-box-Hostel">
            <div class="category-icon"><i class="fas fa-building-user"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">Student Hostels</h6>
            <span class="text-secondary-custom extra-small">Youth Co-Living</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" id="cat-box-Room">
            <div class="category-icon"><i class="fas fa-door-open"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">Private Rooms</h6>
            <span class="text-secondary-custom extra-small">Quiet Personal Space</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" id="cat-box-Apartment">
            <div class="category-icon"><i class="fas fa-building"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">Flats & Apartments</h6>
            <span class="text-secondary-custom extra-small">1BHK, 2BHK, 3BHK</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" id="cat-box-House">
            <div class="category-icon"><i class="fas fa-house"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">Rental Houses</h6>
            <span class="text-secondary-custom extra-small">Independent Living</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" id="cat-box-all">
            <div class="category-icon"><i class="fas fa-sliders"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">All Options</h6>
            <span class="text-secondary-custom extra-small">Complete Catalog</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 7 & 12: FEATURED & LATEST PROPERTY LISTINGS
       ============================================================ -->
  <section id="properties" class="section-spacing bg-white">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-center section-header gap-3">
        <div>
          <span class="section-tag">Live Listings</span>
          <h2 class="h3 fw-bold mb-1">Discover Verified Accommodations</h2>
          <span class="text-secondary-custom small" id="listing-count-label">Showing places in Bangalore</span>
        </div>

        <!-- Filter Controls & View Switchers -->
        <div class="d-flex flex-wrap align-items-center gap-2">
          <!-- Gender Filter -->
          <select id="gender-filter" class="form-select form-select-sm rounded-pill px-3 py-2 fw-medium" style="width: auto;">
            <option value="all">All Gender Rules</option>
            <option value="male_only">Boys / Men Only</option>
            <option value="female_only">Girls / Women Only</option>
            <option value="unisex">Unisex / Family</option>
          </select>

          <!-- Sorting -->
          <select id="sort-by" class="form-select form-select-sm rounded-pill px-3 py-2 fw-medium" style="width: auto;">
            <option value="featured">Featured First</option>
            <option value="rent_asc">Lowest Rent</option>
            <option value="rent_desc">Highest Rent</option>
            <option value="rating_desc">Highest Rated</option>
          </select>

          <!-- View Mode Toggle -->
          <div class="btn-group btn-group-sm" role="group">
            <button id="btn-view-grid" class="btn btn-outline-primary active px-3 py-2 fw-semibold"><i class="fas fa-th-large me-1"></i> Grid</button>
            <button id="btn-view-map" class="btn btn-outline-primary px-3 py-2 fw-semibold"><i class="fas fa-map-marked-alt me-1"></i> Map</button>
          </div>
        </div>
      </div>

      <!-- MAP VIEW CONTAINER (Hidden by default) -->
      <div id="map-view-container" class="mb-4" style="display: none;">
        <div id="property-leaflet-map"></div>
      </div>

      <!-- PROPERTY GRID CONTAINER -->
      <div id="property-grid-container" class="row g-4">
        <!-- Rendered dynamically via JavaScript -->
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 8: HOW IT WORKS (4 STEPS)
       ============================================================ -->
  <section id="how-it-works" class="section-spacing bg-soft-lavender">
    <div class="container">
      <div class="text-center max-w-xl mx-auto section-header">
        <span class="section-tag">Seamless Process</span>
        <h2 class="h3 fw-bold">How NeighborHood Works</h2>
        <p class="text-secondary-custom small mb-0">From searching in a new city to moving into your verified room in 4 simple steps.</p>
      </div>

      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-white">
            <div class="step-number-circle mx-auto">1</div>
            <h5 class="fw-bold mb-2">Search & Filter</h5>
            <p class="text-secondary-custom small mb-0">Select your target city and accommodation type (PG, hostel, room, flat) matching your budget.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-white">
            <div class="step-number-circle mx-auto">2</div>
            <h5 class="fw-bold mb-2">Compare & Inspect</h5>
            <p class="text-secondary-custom small mb-0">Compare rents, security deposits, amenities, food inclusions, and college/metro distance.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-white">
            <div class="step-number-circle mx-auto">3</div>
            <h5 class="fw-bold mb-2">Connect with Landlord</h5>
            <p class="text-secondary-custom small mb-0">Send direct booking inquiries and schedule property visits with verified landlords.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-white">
            <div class="step-number-circle mx-auto">4</div>
            <h5 class="fw-bold mb-2">Move-In & Stay</h5>
            <p class="text-secondary-custom small mb-0">Confirm your bed or apartment securely with a transparent digital receipt and zero brokerage.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 9 & 10: VERIFIED PROPERTIES & PLATFORM BENEFITS
       ============================================================ -->
  <section id="verified-section" class="section-spacing bg-white">
    <div class="container">
      <div class="row align-items-center gy-5">
        <div class="col-lg-6">
          <span class="section-tag">Trust & Safety First</span>
          <h2 class="h2 fw-bold mb-3">Why 100,000+ Tenants Trust NeighborHood</h2>
          <p class="text-secondary-custom mb-4">
            We physically audit properties and verify owner identity documents before awarding our Verified Badge. No fake photos, no surprise brokerage fees, and clear deposit refund policies.
          </p>

          <div class="row g-4">
            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-3">
                <div class="p-2 rounded-circle bg-soft-lavender text-bright-indigo fs-5" style="flex-shrink: 0;"><i class="fas fa-shield-check"></i></div>
                <div>
                  <h6 class="fw-bold mb-1">Verified Owners</h6>
                  <p class="extra-small text-secondary-custom mb-0">Govt ID & property ownership verified by admin.</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-3">
                <div class="p-2 rounded-circle bg-soft-lavender text-bright-indigo fs-5" style="flex-shrink: 0;"><i class="fas fa-tag"></i></div>
                <div>
                  <h6 class="fw-bold mb-1">Zero Hidden Charges</h6>
                  <p class="extra-small text-secondary-custom mb-0">Clear rent & deposit refund policies upfront.</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-3">
                <div class="p-2 rounded-circle bg-soft-lavender text-bright-indigo fs-5" style="flex-shrink: 0;"><i class="fas fa-location-crosshairs"></i></div>
                <div>
                  <h6 class="fw-bold mb-1">Proximity Intelligence</h6>
                  <p class="extra-small text-secondary-custom mb-0">Filter PGs near your specific college or office.</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-3">
                <div class="p-2 rounded-circle bg-soft-lavender text-bright-indigo fs-5" style="flex-shrink: 0;"><i class="fas fa-headset"></i></div>
                <div>
                  <h6 class="fw-bold mb-1">Tenant Assistance</h6>
                  <p class="extra-small text-secondary-custom mb-0">24/7 dedicated support for any stay issue.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="p-4 p-md-5 bg-soft-lavender rounded-5 border border-primary-subtle shadow-sm">
            <div class="d-flex align-items-center justify-content-between mb-4">
              <h5 class="fw-bold mb-0 text-royal-blue"><i class="fas fa-certificate text-success me-2"></i> Verified PG Audit Checklist</h5>
              <span class="badge bg-success px-3 py-2 rounded-pill">100% Inspected</span>
            </div>
            <ul class="list-unstyled mb-0 d-flex flex-column gap-3 small">
              <li class="d-flex align-items-start gap-3">
                <i class="fas fa-check-circle text-success fs-5 mt-1" style="flex-shrink: 0;"></i>
                <div>
                  <strong class="text-dark d-block">Wi-Fi & Dedicated Study Desk</strong>
                  <span class="text-secondary-custom">High-speed fiber connection tested for seamless study and remote work.</span>
                </div>
              </li>
              <li class="d-flex align-items-start gap-3">
                <i class="fas fa-check-circle text-success fs-5 mt-1" style="flex-shrink: 0;"></i>
                <div>
                  <strong class="text-dark d-block">Hygienic 3-Time Meals & RO Water Filter</strong>
                  <span class="text-secondary-custom">Kitchen hygiene and drinking water filtration certified on-site.</span>
                </div>
              </li>
              <li class="d-flex align-items-start gap-3">
                <i class="fas fa-check-circle text-success fs-5 mt-1" style="flex-shrink: 0;"></i>
                <div>
                  <strong class="text-dark d-block">24/7 CCTV & Gated Security Guard Entry</strong>
                  <span class="text-secondary-custom">Biometric locks, visitor logs, and secure residential neighborhood.</span>
                </div>
              </li>
              <li class="d-flex align-items-start gap-3">
                <i class="fas fa-check-circle text-success fs-5 mt-1" style="flex-shrink: 0;"></i>
                <div>
                  <strong class="text-dark d-block">Power Backup & Daily Housekeeping</strong>
                  <span class="text-secondary-custom">Uninterrupted electricity during outages and regularly sanitized bathrooms.</span>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 11: TESTIMONIALS (STUDENTS & EMPLOYEES)
       ============================================================ -->
  <section id="testimonials" class="section-spacing bg-slate-canvas">
    <div class="container">
      <div class="text-center max-w-xl mx-auto section-header">
        <span class="section-tag">Community Feedback</span>
        <h2 class="h3 fw-bold">Trusted by Thousands Relocating Across India</h2>
        <p class="text-secondary-custom small mb-0">Hear from real tenants who found their comfort zone with NeighborHood.</p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex align-items-center gap-1 text-warning mb-3">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="small text-secondary-custom mb-4">"Moving to Bangalore for my software engineer role was overwhelming until I found NeighborHood. Found an executive PG in Koramangala only 10 mins from my office with great meals!"</p>
            <div class="d-flex align-items-center gap-3 mt-auto">
              <div class="bg-soft-lavender rounded-circle p-2 text-royal-blue fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; flex-shrink: 0;">AR</div>
              <div>
                <h6 class="fw-bold mb-0 small">Ananya Rao</h6>
                <span class="extra-small text-secondary-custom">Software Engineer • Bangalore</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex align-items-center gap-1 text-warning mb-3">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="small text-secondary-custom mb-4">"As a student at Delhi University, finding an affordable sharing hostel with good food was my main concern. NeighborHood filtered student-only co-living easily!"</p>
            <div class="d-flex align-items-center gap-3 mt-auto">
              <div class="bg-soft-lavender rounded-circle p-2 text-royal-blue fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; flex-shrink: 0;">KS</div>
              <div>
                <h6 class="fw-bold mb-0 small">Karan Sharma</h6>
                <span class="extra-small text-secondary-custom">DU Student • North Campus Delhi</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex align-items-center gap-1 text-warning mb-3">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="small text-secondary-custom mb-4">"We relocated our family to Pune and booked a 2BHK flat directly from a verified owner without paying any middleman brokerage fee. Highly recommended!"</p>
            <div class="d-flex align-items-center gap-3 mt-auto">
              <div class="bg-soft-lavender rounded-circle p-2 text-royal-blue fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; flex-shrink: 0;">VD</div>
              <div>
                <h6 class="fw-bold mb-0 small">Vikram & Deepa</h6>
                <span class="extra-small text-secondary-custom">Family Renter • Wakad Pune</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION: INTERACTIVE TENANT FAQ
       ============================================================ -->
  <section id="faq-section" class="section-spacing bg-white">
    <div class="container">
      <div class="text-center max-w-xl mx-auto section-header">
        <span class="section-tag">Frequently Asked Questions</span>
        <h2 class="h3 fw-bold">Everything You Need to Know</h2>
        <p class="text-secondary-custom small mb-0">Answers to common questions from tenants and property owners.</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="accordion accordion-nh" id="faqAccordion">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  <i class="fas fa-circle-question text-bright-indigo me-2"></i> Is there any brokerage fee for tenants?
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  No! NeighborHood connects tenants directly with verified property owners and PG managers. There are zero brokerage charges and zero hidden service fees for booking accommodations.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <i class="fas fa-shield-check text-bright-indigo me-2"></i> How does NeighborHood verify properties?
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Our ground team audits the property premises, verifies Wi-Fi speed, kitchen hygiene, water purifier quality, security locks, and validates the owner's government ID and property documents before giving the Verified badge.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  <i class="fas fa-calendar-check text-bright-indigo me-2"></i> Can I schedule a physical visit before booking?
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Yes, absolutely. Once you create a free account, you can contact the landlord directly to schedule a convenient time for a room tour or request a video walkthrough.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  <i class="fas fa-coins text-bright-indigo me-2"></i> What is the security deposit refund policy?
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Security deposit amounts and notice period terms (usually 1 month notice) are clearly listed on each property card. When vacating according to the agreed notice period, the deposit is refunded promptly.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  <i class="fas fa-home-user text-bright-indigo me-2"></i> How can property owners list their accommodation?
                </button>
              </h2>
              <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Landlords and PG managers can click the "List Property Free" button, register an owner account, upload photos, list amenities, and get their listing verified by our team.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 13: DUAL CALL TO ACTION
       ============================================================ -->
  <section class="section-spacing" style="background: var(--nh-gradient-primary); color: #fff;">
    <div class="container text-center">
      <h2 class="display-6 fw-bold text-white mb-3">Ready to Find Your Next Comfortable Home?</h2>
      <p class="lead text-white-50 max-w-xl mx-auto mb-4">Join thousands of students and working professionals who found their ideal accommodation seamlessly.</p>
      <div class="d-flex justify-content-center flex-wrap gap-3">
        <a href="#properties" class="btn btn-light rounded-pill px-4 py-2 fw-bold text-royal-blue shadow">Explore Live Listings</a>
        <a href="register.php" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold">List Your Property Free</a>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 14: GLOBAL FOOTER
       ============================================================ -->
  <footer>
    <div class="container">
      <div class="row g-4 mb-5">
        <div class="col-lg-4">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div class="brand-icon" style="width:36px;height:36px;background:var(--nh-bright-indigo);color:#fff;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-home"></i></div>
            <h5 class="fw-bold mb-0 text-white">NeighborHood</h5>
          </div>
          <p class="small text-secondary-custom mb-3 pe-lg-4">
            Centralized Neighborhood Rental & Accommodation Platform helping students, working professionals, and families easily find, compare, and book suitable places to stay across India.
          </p>
          <div class="d-flex gap-3">
            <a href="javascript:void(0)" class="text-white-50 fs-5"><i class="fab fa-facebook-f"></i></a>
            <a href="javascript:void(0)" class="text-white-50 fs-5"><i class="fab fa-instagram"></i></a>
            <a href="javascript:void(0)" class="text-white-50 fs-5"><i class="fab fa-twitter"></i></a>
            <a href="javascript:void(0)" class="text-white-50 fs-5"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>

        <div class="col-6 col-md-3 col-lg-2">
          <h6 class="fw-bold text-white mb-3">Top Cities</h6>
          <a href="javascript:void(0)" onclick="setCityAndScroll('Bangalore')">Bangalore PGs</a>
          <a href="javascript:void(0)" onclick="setCityAndScroll('Mumbai')">Mumbai Rooms</a>
          <a href="javascript:void(0)" onclick="setCityAndScroll('Delhi')">Delhi Hostels</a>
          <a href="javascript:void(0)" onclick="setCityAndScroll('Pune')">Pune Flats</a>
          <a href="javascript:void(0)" onclick="setCityAndScroll('Hyderabad')">Hyderabad PGs</a>
          <a href="javascript:void(0)" onclick="setCityAndScroll('Chennai')">Chennai Rooms</a>
          <a href="javascript:void(0)" onclick="setCityAndScroll('Noida')">Noida Flats</a>
        </div>

        <div class="col-6 col-md-3 col-lg-2">
          <h6 class="fw-bold text-white mb-3">Categories</h6>
          <a href="#categories" onclick="filterCategory('PG')">Paying Guest (PG)</a>
          <a href="#categories" onclick="filterCategory('Hostel')">Student Hostels</a>
          <a href="#categories" onclick="filterCategory('Room')">Individual Rooms</a>
          <a href="#categories" onclick="filterCategory('Apartment')">Rental Apartments</a>
          <a href="#categories" onclick="filterCategory('House')">Independent Houses</a>
        </div>

        <div class="col-6 col-md-3 col-lg-2">
          <h6 class="fw-bold text-white mb-3">Quick Links</h6>
          <a href="login.php">User Login</a>
          <a href="register.php">Owner Registration</a>
          <a href="#how-it-works">How It Works</a>
          <a href="#verified-section">Verification Process</a>
          <a href="#faq-section">Help & FAQs</a>
        </div>

        <div class="col-6 col-md-3 col-lg-2">
          <h6 class="fw-bold text-white mb-3">Support</h6>
          <a href="mailto:support@neighborhood.com"><i class="fas fa-envelope me-1"></i> Support Desk</a>
          <a href="tel:+919876543210"><i class="fas fa-phone me-1"></i> 1800-NEIGHBOR</a>
          <a href="javascript:void(0)">Privacy Policy</a>
          <a href="javascript:void(0)">Terms of Service</a>
        </div>
      </div>

      <hr class="border-secondary opacity-25" />
      <div class="d-flex flex-wrap justify-content-between align-items-center small py-2 text-white-50">
        <span>© 2026 NeighborHood Accommodation Inc. All rights reserved.</span>
        <span>Zero Brokerage • 100% Verified Neighborhood Portal</span>
      </div>
    </div>
  </footer>

  <!-- ============================================================
       MODAL 1: PROPERTY DETAILS MODAL (FULL PREVIEW FOR GUESTS)
       ============================================================ -->
  <div class="modal fade" id="propertyDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content modal-content-custom">
        <div class="modal-header border-0 pb-0 pt-4 px-4">
          <div>
            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
              <span id="md-type-badge" class="badge bg-primary">PG</span>
              <span id="md-gender-badge" class="badge bg-dark">Boys Only</span>
              <span id="md-verified-badge" class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Verified Property</span>
            </div>
            <h4 id="md-title" class="fw-bold mb-1">Property Name</h4>
            <p id="md-location" class="text-secondary-custom small mb-0"><i class="fas fa-map-marker-alt text-danger me-1"></i> Location</p>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">
          <div class="row g-4">
            <!-- Gallery & Media Column -->
            <div class="col-lg-7">
              <div id="modal-gallery" class="rounded-4 overflow-hidden mb-3 position-relative" style="height: 340px;">
                <img id="md-main-img" src="" class="w-100 h-100 object-fit-cover" alt="Property Preview" />
              </div>

              <!-- Quick Highlights Grid -->
              <div class="row g-2 text-center mb-4">
                <div class="col-4">
                  <div class="p-3 bg-soft-lavender rounded-3 border border-primary-subtle">
                    <span class="extra-small text-secondary-custom d-block">Starting Monthly Rent</span>
                    <strong id="md-rent" class="text-royal-blue fs-5">₹0</strong>
                  </div>
                </div>
                <div class="col-4">
                  <div class="p-3 bg-soft-lavender rounded-3 border border-primary-subtle">
                    <span class="extra-small text-secondary-custom d-block">Security Deposit</span>
                    <strong id="md-deposit" class="text-dark fs-5">₹0</strong>
                  </div>
                </div>
                <div class="col-4">
                  <div class="p-3 bg-soft-lavender rounded-3 border border-primary-subtle">
                    <span class="extra-small text-secondary-custom d-block">Availability</span>
                    <strong id="md-available" class="text-success fs-5">Immediate</strong>
                  </div>
                </div>
              </div>

              <h6 class="fw-bold mb-2"><i class="fas fa-align-left text-bright-indigo me-2"></i> About This Accommodation</h6>
              <p id="md-desc" class="small text-secondary-custom mb-4 leading-relaxed">Description text...</p>

              <h6 class="fw-bold mb-2"><i class="fas fa-circle-check text-bright-indigo me-2"></i> Amenities & Facilities Included</h6>
              <div id="md-amenities" class="d-flex flex-wrap gap-2 mb-4">
                <!-- Dynamic amenity pills -->
              </div>

              <h6 class="fw-bold mb-2"><i class="fas fa-clipboard-list text-bright-indigo me-2"></i> House Rules & Policies</h6>
              <ul class="list-unstyled small text-secondary-custom d-flex flex-column gap-1 mb-0">
                <li><i class="fas fa-circle-check text-success me-2"></i> Gate curfew: 10:30 PM (Flexible with prior digital intimation)</li>
                <li><i class="fas fa-circle-check text-success me-2"></i> Visitors permitted in common lounge area</li>
                <li><i class="fas fa-circle-check text-success me-2"></i> Strict non-smoking & peaceful study environment</li>
              </ul>
            </div>

            <!-- Booking Sidebar & Proximity Column -->
            <div class="col-lg-5">
              <div class="card border rounded-4 p-4 mb-3 bg-slate-canvas shadow-sm">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                  <div>
                    <span class="extra-small text-secondary-custom d-block">Rent Starts From</span>
                    <h3 id="md-side-rent" class="fw-bold text-royal-blue mb-0">₹0 <span class="fs-xs fw-normal text-secondary-custom">/mo</span></h3>
                  </div>
                  <span id="md-rating-pill" class="badge bg-warning text-dark px-3 py-2 fs-6"><i class="fas fa-star me-1"></i> 4.8</span>
                </div>

                <div class="mb-3">
                  <label class="form-label extra-small fw-bold text-secondary-custom">Select Occupancy Type</label>
                  <select class="form-select form-select-sm py-2 rounded-3" id="md-occupancy-select">
                    <option value="single">Single Occupancy (Private Room)</option>
                    <option value="double" selected>2-Sharing (Double Occupancy)</option>
                    <option value="triple">3-Sharing (Budget Sharing)</option>
                  </select>
                </div>

                <div class="p-3 bg-white rounded-3 border mb-3 small">
                  <div class="d-flex justify-content-between mb-1">
                    <span class="text-secondary-custom">Monthly Rent:</span>
                    <strong id="md-calc-rent" class="text-dark">₹0</strong>
                  </div>
                  <div class="d-flex justify-content-between mb-1">
                    <span class="text-secondary-custom">Maintenance & Wi-Fi:</span>
                    <strong class="text-success">FREE / Included</strong>
                  </div>
                  <div class="d-flex justify-content-between mb-1">
                    <span class="text-secondary-custom">Brokerage Fee:</span>
                    <strong class="text-success">₹0 (Zero Brokerage)</strong>
                  </div>
                  <hr class="my-2">
                  <div class="d-flex justify-content-between fw-bold">
                    <span>Move-in Total:</span>
                    <span id="md-calc-total" class="text-royal-blue">₹0</span>
                  </div>
                </div>

                <!-- Gated Action CTAs -->
                <div class="d-grid gap-2">
                  <button class="btn btn-nh-primary py-2" onclick="triggerAuthGate('Book Property')"><i class="fas fa-bolt me-1"></i> Request to Book</button>
                  <button class="btn btn-nh-outline py-2" onclick="triggerAuthGate('Contact Owner')"><i class="fas fa-phone me-1"></i> Contact Landlord</button>
                  <button class="btn btn-nh-secondary py-2" onclick="triggerAuthGate('Save Favorite')"><i class="far fa-heart me-1"></i> Add to Wishlist</button>
                </div>
              </div>

              <!-- Nearby Distances -->
              <div class="card border rounded-4 p-3 shadow-sm bg-white">
                <h6 class="fw-bold mb-2"><i class="fas fa-route text-bright-indigo me-1"></i> Key Proximity Markers</h6>
                <ul id="md-nearby-list" class="list-unstyled extra-small text-secondary-custom mb-0 d-flex flex-column gap-2">
                  <!-- Dynamic distance markers -->
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ============================================================
       MODAL 2: GUEST AUTH GATE MODAL (TRIGGERS WHEN GUEST CLICKS RESTRICTED CTAS)
       ============================================================ -->
  <div class="modal fade" id="authGateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-custom text-center p-4">
        <div class="mb-3">
          <div class="mx-auto bg-soft-lavender text-bright-indigo rounded-circle d-flex align-items-center justify-content-center" style="width: 68px; height: 68px; font-size: 1.9rem;">
            <i class="fas fa-lock"></i>
          </div>
        </div>
        <h4 class="fw-bold mb-2">Account Required</h4>
        <p class="text-secondary-custom small mb-4">
          To <strong id="auth-action-name" class="text-royal-blue">Book this Property</strong>, save favorites, or message property owners directly, please log in or create a quick free account.
        </p>

        <div class="d-grid gap-2">
          <a href="login.php" class="btn btn-nh-primary py-2"><i class="fas fa-sign-in-alt me-1"></i> Log In to Account</a>
          <a href="register.php" class="btn btn-nh-outline py-2"><i class="fas fa-user-plus me-1"></i> Register Free Tenant Account</a>
          <button type="button" class="btn btn-link text-secondary-custom extra-small text-decoration-none mt-2" data-bs-dismiss="modal">Continue Browsing as Guest</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ============================================================
       MODAL 3: PROPERTY COMPARISON MATRIX MODAL
       ============================================================ -->
  <div class="modal fade" id="compareModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-custom">
        <div class="modal-header border-bottom px-4 pt-4 pb-3">
          <h5 class="modal-title fw-bold"><i class="fas fa-scale-balanced text-bright-indigo me-2"></i> Compare Selected Properties</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div id="compare-table-wrapper" class="table-responsive">
            <!-- Dynamic comparison table rendered via JS -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- FLOATING COMPARE BAR TRIGGER -->
  <div id="compare-float-bar" class="compare-float-bar d-none">
    <span class="small"><i class="fas fa-layer-group text-warning me-1"></i> <strong id="compare-count">0</strong> Properties Selected</span>
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-royal-blue shadow-sm" onclick="showCompareModal()">Compare Now</button>
      <button class="btn btn-sm btn-link text-white-50 text-decoration-none p-1" onclick="clearCompare()" title="Clear Comparison"><i class="fas fa-times"></i></button>
    </div>
  </div>

  <!-- ============================================================
       JAVASCRIPT & INTERACTIVE DATA ENGINE
       ============================================================ -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
  </script>

  <script>
    // Master Comprehensive Property Dataset Covering All 7 Cities
    const PROPERTIES_DATA = [
      // BANGALORE
      {
        id: 101,
        title: "St. Mark's Executive PG for Men",
        type: "PG",
        city: "Bangalore",
        area: "Koramangala",
        rent: 9500,
        deposit: 15000,
        gender: "male_only",
        rating: 4.9,
        available_beds: "3 Beds Left",
        verified: true,
        image: "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80",
        amenities: ["High-Speed Wi-Fi", "3-Time Meals", "AC", "Daily Housekeeping", "Laundry", "CCTV Security"],
        nearby: ["0.4 km to Forum Mall", "1.2 km to Christ University", "0.8 km to Metro Station"],
        lat: 12.9352,
        lng: 77.6245,
        desc: "Premium executive PG located in Koramangala 4th Block. Includes delicious home-cooked meals, 200Mbps fiber Wi-Fi, biometric security entry, and daily room cleaning."
      },
      {
        id: 102,
        title: "Serenity Women's Luxury Hostel & PG",
        type: "PG",
        city: "Bangalore",
        area: "HSR Layout",
        rent: 11000,
        deposit: 18000,
        gender: "female_only",
        rating: 4.8,
        available_beds: "2 Rooms Left",
        verified: true,
        image: "https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=600&q=80",
        amenities: ["High-Speed Wi-Fi", "North & South Meals", "24/7 Security", "Biometric Lock", "Geyser"],
        nearby: ["0.6 km to NIFT College", "1.5 km to Silk Board Junction", "0.9 km to HSR Club"],
        lat: 12.9121,
        lng: 77.6445,
        desc: "Safe and ultra-hygienic women's PG in HSR Sector 1. Gated security guard, electronic access cards, spacious cupboards, and terrace garden."
      },
      {
        id: 103,
        title: "Greenwood Independent 2BHK Apartment",
        type: "Apartment",
        city: "Bangalore",
        area: "Indiranagar",
        rent: 28000,
        deposit: 70000,
        gender: "unisex",
        rating: 4.7,
        available_beds: "Entire Flat",
        verified: true,
        image: "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=600&q=80",
        amenities: ["Covered Parking", "Power Backup", "Modular Kitchen", "Balcony", "Pet Friendly"],
        nearby: ["0.3 km to 100ft Road", "0.5 km to Indiranagar Metro", "1.0 km to CMH Hospital"],
        lat: 12.9784,
        lng: 77.6408,
        desc: "Spacious semi-furnished 2BHK flat ideal for working employees or small families. Prime Indiranagar location with reserved basement car parking."
      },
      {
        id: 104,
        title: "Silicon Tech Hub Co-Living Hostel",
        type: "Hostel",
        city: "Bangalore",
        area: "Whitefield",
        rent: 8000,
        deposit: 12000,
        gender: "unisex",
        rating: 4.6,
        available_beds: "4 Beds Left",
        verified: true,
        image: "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=600&q=80",
        amenities: ["High-Speed Wi-Fi", "Cafeteria", "Gym", "Gaming Lounge", "Power Backup"],
        nearby: ["0.5 km to ITPL Main Gate", "0.8 km to Whitefield Metro"],
        lat: 12.9850,
        lng: 77.7289,
        desc: "Vibrant co-living hostel designed for techies and interns near ITPL Whitefield. Community lounge, gym, and high-speed working desks."
      },
      {
        id: 105,
        title: "Palm Grove Independent Rental Villa",
        type: "House",
        city: "Bangalore",
        area: "Jayanagar",
        rent: 32000,
        deposit: 80000,
        gender: "unisex",
        rating: 4.8,
        available_beds: "Full House",
        verified: true,
        image: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=600&q=80",
        amenities: ["Private Garden", "Car Parking", "Solar Water Heater", "Gated Security"],
        nearby: ["0.4 km to Jayanagar 4th Block Complex", "0.7 km to South End Circle Metro"],
        lat: 12.9299,
        lng: 77.5824,
        desc: "Beautiful 3BHK independent ground floor house with private courtyard, peaceful tree-lined avenue, and quick metro connectivity."
      },

      // MUMBAI
      {
        id: 201,
        title: "Bandra Sea View Private Single Room",
        type: "Room",
        city: "Mumbai",
        area: "Bandra West",
        rent: 18500,
        deposit: 35000,
        gender: "male_only",
        rating: 4.9,
        available_beds: "1 Room Left",
        verified: true,
        image: "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=600&q=80",
        amenities: ["AC", "High-Speed Wi-Fi", "Attached Washroom", "Housekeeping", "Balcony"],
        nearby: ["0.4 km to Linking Road", "1.0 km to Bandra Station", "0.6 km to Carter Road Promenade"],
        lat: 19.0596,
        lng: 72.8295,
        desc: "Fully furnished air-conditioned private bedroom in a premium Bandra West apartment. Attached modern bathroom and pleasant sea breeze."
      },
      {
        id: 202,
        title: "Andheri Corporate Executive PG",
        type: "PG",
        city: "Mumbai",
        area: "Andheri East",
        rent: 12500,
        deposit: 20000,
        gender: "unisex",
        rating: 4.7,
        available_beds: "3 Beds Left",
        verified: true,
        image: "https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=600&q=80",
        amenities: ["Breakfast & Dinner", "AC", "Wi-Fi", "Daily Cleaning", "Biometric Entry"],
        nearby: ["0.5 km to Chakala Metro", "2.0 km to International Airport"],
        lat: 19.1136,
        lng: 72.8697,
        desc: "Strategic PG near MIDC and SEEPZ tech hub. Walkable distance to metro station, wholesome food, and AC backup."
      },
      {
        id: 203,
        title: "Powai Lake View 2BHK Apartment",
        type: "Apartment",
        city: "Mumbai",
        area: "Powai",
        rent: 36000,
        deposit: 90000,
        gender: "unisex",
        rating: 4.8,
        available_beds: "Entire Apartment",
        verified: true,
        image: "https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=600&q=80",
        amenities: ["Swimming Pool", "Clubhouse", "Gym", "Gated Security", "Reserved Parking"],
        nearby: ["1.0 km to IIT Bombay", "0.8 km to Hiranandani Hospital"],
        lat: 19.1176,
        lng: 72.9060,
        desc: "High-rise modern flat in Hiranandani Powai. Access to clubhouse amenities, landscaped gardens, and IIT Bombay vicinity."
      },

      // DELHI / NCR
      {
        id: 301,
        title: "Metro Student Co-Living Hostel",
        type: "Hostel",
        city: "Delhi",
        area: "North Campus",
        rent: 7500,
        deposit: 10000,
        gender: "unisex",
        rating: 4.6,
        available_beds: "5 Beds Available",
        verified: true,
        image: "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=600&q=80",
        amenities: ["High-Speed Wi-Fi", "Library Desk", "Meals Included", "Power Backup", "CCTV"],
        nearby: ["0.2 km to Vishwavidyalaya Metro", "0.5 km to Hindu College", "0.6 km to SRCC"],
        lat: 28.6903,
        lng: 77.2134,
        desc: "Dedicated student hostel near Delhi University. Features quiet study library room, high-speed fiber internet, and nutritious student mess food."
      },
      {
        id: 302,
        title: "South Ex Luxury Girls PG",
        type: "PG",
        city: "Delhi",
        area: "South Extension",
        rent: 13500,
        deposit: 20000,
        gender: "female_only",
        rating: 4.9,
        available_beds: "2 Beds Left",
        verified: true,
        image: "https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=600&q=80",
        amenities: ["AC", "3-Time Meals", "Attached Bathroom", "24/7 Female Warden", "Wi-Fi"],
        nearby: ["0.3 km to South Extension Metro", "1.5 km to AIIMS"],
        lat: 28.5684,
        lng: 77.2207,
        desc: "Ultra-safe boutique PG for female students and doctors. Fully furnished rooms with attached modern bathrooms and biometric access."
      },
      {
        id: 303,
        title: "Cyber City Executive 1BHK Studio",
        type: "Room",
        city: "Delhi",
        area: "Saket",
        rent: 19000,
        deposit: 38000,
        gender: "unisex",
        rating: 4.7,
        available_beds: "Private Studio",
        verified: true,
        image: "https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=600&q=80",
        amenities: ["Kitchenette", "AC", "Smart TV", "Wi-Fi", "Terrace Access"],
        nearby: ["0.4 km to Select CITYWALK Mall", "0.6 km to Saket Metro"],
        lat: 28.5244,
        lng: 77.2167,
        desc: "Chic studio apartment with private kitchenette, high-speed Wi-Fi, and terrace view. Perfect for young corporate professionals."
      },

      // PUNE
      {
        id: 401,
        title: "Viman Nagar Executive Boys PG",
        type: "PG",
        city: "Pune",
        area: "Viman Nagar",
        rent: 8500,
        deposit: 12000,
        gender: "male_only",
        rating: 4.8,
        available_beds: "4 Beds Left",
        verified: true,
        image: "https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=600&q=80",
        amenities: ["High-Speed Wi-Fi", "Homestyle Food", "Laundry", "Parking", "TV Lounge"],
        nearby: ["0.8 km to Symbiosis College", "1.2 km to Phoenix Marketcity Mall"],
        lat: 18.5679,
        lng: 73.9143,
        desc: "Ideal PG accommodation for Symbiosis students and IT employees working in Viman Nagar tech parks."
      },
      {
        id: 402,
        title: "Hinjewadi Tech Co-Living Suite",
        type: "PG",
        city: "Pune",
        area: "Hinjewadi",
        rent: 9200,
        deposit: 15000,
        gender: "unisex",
        rating: 4.7,
        available_beds: "3 Rooms Left",
        verified: true,
        image: "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80",
        amenities: ["AC", "Wi-Fi", "Meal Service", "Shuttle Service to IT Parks"],
        nearby: ["0.5 km to Hinjewadi Phase 1 Circle", "1.0 km to Infosys Campus"],
        lat: 18.5913,
        lng: 73.7389,
        desc: "Modern co-living space with shuttle connectivity to Hinjewadi Phase 1, 2, and 3 IT parks. Unlimited Wi-Fi and buffet dining."
      },
      {
        id: 403,
        title: "Wakad Sunshine 2BHK Family Flat",
        type: "Apartment",
        city: "Pune",
        area: "Wakad",
        rent: 22000,
        deposit: 50000,
        gender: "unisex",
        rating: 4.8,
        available_beds: "Full 2BHK",
        verified: true,
        image: "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=600&q=80",
        amenities: ["Children Play Area", "Gated Security", "Covered Parking", "Lift Backup"],
        nearby: ["0.5 km to Mumbai-Pune Highway", "1.5 km to D-Mart Wakad"],
        lat: 18.5987,
        lng: 73.7663,
        desc: "Semi-furnished 2BHK in a family-friendly society with 24/7 security, garden, and quick expressway access."
      },

      // HYDERABAD
      {
        id: 501,
        title: "Hitec City Elite Co-Living PG",
        type: "PG",
        city: "Hyderabad",
        area: "Gachibowli",
        rent: 10500,
        deposit: 16000,
        gender: "unisex",
        rating: 4.9,
        available_beds: "3 Beds Left",
        verified: true,
        image: "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=600&q=80",
        amenities: ["AC", "3-Time South & North Food", "Gym", "Wi-Fi", "Housekeeping"],
        nearby: ["1.0 km to Cyber Towers", "1.2 km to DLF Cybercity", "0.8 km to Raidurg Metro"],
        lat: 17.4401,
        lng: 78.3489,
        desc: "State-of-the-art co-living facility 5 minutes from Cyber Towers and DLF. High-speed networking, gym, and healthy meal plans."
      },
      {
        id: 502,
        title: "Madhapur Modern 2BHK Apartment",
        type: "Apartment",
        city: "Hyderabad",
        area: "Madhapur",
        rent: 26000,
        deposit: 60000,
        gender: "unisex",
        rating: 4.7,
        available_beds: "Entire Apartment",
        verified: true,
        image: "https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=600&q=80",
        amenities: ["Covered Parking", "Power Backup", "Modular Kitchen", "Lift", "Security"],
        nearby: ["0.4 km to Durgam Cheruvu Cable Bridge", "0.8 km to Madhapur Metro"],
        lat: 17.4483,
        lng: 78.3915,
        desc: "Prime Madhapur location flat with great views of the Durgam Cheruvu bridge, high ceilings, and 24/7 security guard."
      },
      {
        id: 503,
        title: "Kondapur Women's Executive Residency",
        type: "PG",
        city: "Hyderabad",
        area: "Kondapur",
        rent: 9800,
        deposit: 14000,
        gender: "female_only",
        rating: 4.8,
        available_beds: "2 Rooms Left",
        verified: true,
        image: "https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=600&q=80",
        amenities: ["Wi-Fi", "3-Time Meals", "Biometric Lock", "CCTV", "Washing Machine"],
        nearby: ["0.6 km to Botanical Garden", "1.2 km to KIMS Hospital"],
        lat: 17.4699,
        lng: 78.3578,
        desc: "Peaceful and secure women's PG right next to Kondapur Botanical Garden. Fresh hygienic food and study tables."
      },

      // CHENNAI
      {
        id: 601,
        title: "OMR IT Corridor Co-Living PG",
        type: "PG",
        city: "Chennai",
        area: "Thoraipakkam",
        rent: 8500,
        deposit: 12000,
        gender: "unisex",
        rating: 4.7,
        available_beds: "4 Beds Available",
        verified: true,
        image: "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80",
        amenities: ["High-Speed Wi-Fi", "South Indian Meals", "AC", "Laundry", "Power Backup"],
        nearby: ["0.5 km to TCS & Infosys OMR", "1.0 km to BSR Mall"],
        lat: 12.9382,
        lng: 80.2312,
        desc: "Ideal accommodation for IT employees on Old Mahabalipuram Road (OMR). Full AC backup, delicious South Indian meals, and Wi-Fi."
      },
      {
        id: 602,
        title: "Anna Nagar Independent 2BHK Flat",
        type: "Apartment",
        city: "Chennai",
        area: "Anna Nagar",
        rent: 24000,
        deposit: 60000,
        gender: "unisex",
        rating: 4.8,
        available_beds: "Full 2BHK",
        verified: true,
        image: "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=600&q=80",
        amenities: ["Car Parking", "Metro Connectivity", "Balcony", "24/7 Water Supply"],
        nearby: ["0.3 km to Anna Nagar Tower Park", "0.5 km to Anna Nagar East Metro"],
        lat: 13.0850,
        lng: 80.2101,
        desc: "Well-ventilated residential flat in prime Anna Nagar. Surrounded by top cafes, schools, parks, and metro station."
      },

      // NOIDA / GURGAON
      {
        id: 701,
        title: "Sector 62 Tech Park PG for Men",
        type: "PG",
        city: "Noida",
        area: "Sector 62",
        rent: 8800,
        deposit: 12000,
        gender: "male_only",
        rating: 4.7,
        available_beds: "3 Beds Left",
        verified: true,
        image: "https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=600&q=80",
        amenities: ["AC", "3-Time Meals", "High-Speed Wi-Fi", "Laundry", "CCTV"],
        nearby: ["0.4 km to Electronic City Metro", "0.6 km to Jaypee Institute (JIIT)"],
        lat: 28.6280,
        lng: 77.3649,
        desc: "Comfortable and budget-friendly PG near JIIT college and Sector 62 tech institutions. Walking distance to metro."
      },
      {
        id: 702,
        title: "Golf Course Road Premium 2BHK",
        type: "Apartment",
        city: "Noida",
        area: "Gurgaon Golf Course",
        rent: 34000,
        deposit: 80000,
        gender: "unisex",
        rating: 4.9,
        available_beds: "Entire Flat",
        verified: true,
        image: "https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=600&q=80",
        amenities: ["Gym", "Clubhouse", "Underground Parking", "Power Backup", "Concierge"],
        nearby: ["0.5 km to Rapid Metro Station", "1.0 km to One Horizon Center"],
        lat: 28.4595,
        lng: 77.0266,
        desc: "Luxury apartment on Golf Course Road with top-grade amenities, security, and immediate access to Cyber City corporate offices."
      }
    ];

    let currentCity = "Bangalore";
    let activeCategory = "all";
    let activeView = "grid";
    let compareList = [];
    let leafletMap = null;
    let mapMarkers = [];
    let currentSelectedProperty = null;

    document.addEventListener("DOMContentLoaded", function() {
      initEventListeners();
      filterProperties();
    });

    // Initialize all event listeners for city selection, search tabs, categories
    function initEventListeners() {
      // Navbar city options click
      document.querySelectorAll(".city-option-btn").forEach(btn => {
        btn.addEventListener("click", function(e) {
          e.preventDefault();
          const city = this.getAttribute("data-city");
          setCityAndScroll(city);
        });
      });

      // Search type tab buttons click
      document.querySelectorAll(".search-tab-btn").forEach(btn => {
        btn.addEventListener("click", function(e) {
          e.preventDefault();
          const type = this.getAttribute("data-type");
          setActiveCategory(type);
        });
      });

      // Budget range slider
      const budgetSlider = document.getElementById("search-budget");
      if (budgetSlider) {
        budgetSlider.addEventListener("input", function() {
          document.getElementById("budget-val").innerText = "₹" + parseInt(this.value).toLocaleString();
          filterProperties();
        });
      }

      // City select change
      const citySelect = document.getElementById("search-city");
      if (citySelect) {
        citySelect.addEventListener("change", function() {
          setCityAndScroll(this.value);
        });
      }

      // Keyword search input
      const keywordInput = document.getElementById("search-keyword");
      if (keywordInput) {
        keywordInput.addEventListener("input", function() {
          filterProperties();
        });
      }

      // Gender filter
      const genderFilter = document.getElementById("gender-filter");
      if (genderFilter) {
        genderFilter.addEventListener("change", function() {
          filterProperties();
        });
      }

      // Sort by
      const sortBy = document.getElementById("sort-by");
      if (sortBy) {
        sortBy.addEventListener("change", function() {
          filterProperties();
        });
      }

      // Mobile city select
      const mobileCity = document.getElementById("mobile-nav-city-select");
      if (mobileCity) {
        mobileCity.addEventListener("change", function() {
          setCityAndScroll(this.value);
        });
      }

      // View toggle buttons
      document.getElementById("btn-view-grid").addEventListener("click", function() {
        toggleView("grid");
      });
      document.getElementById("btn-view-map").addEventListener("click", function() {
        toggleView("map");
      });

      // City cards click
      document.querySelectorAll(".city-card").forEach(card => {
        card.addEventListener("click", function() {
          const id = this.id;
          if (id && id.startsWith("city-card-")) {
            const city = id.replace("city-card-", "");
            setCityAndScroll(city);
          }
        });
      });

      // Category boxes click
      document.querySelectorAll(".category-box").forEach(box => {
        box.addEventListener("click", function() {
          const id = this.id;
          if (id && id.startsWith("cat-box-")) {
            const cat = id.replace("cat-box-", "");
            filterCategory(cat);
          }
        });
      });

      // Modal occupancy select
      const occupancySelect = document.getElementById("md-occupancy-select");
      if (occupancySelect) {
        occupancySelect.addEventListener("change", function() {
          updateModalPrice(this.value);
        });
      }
    }

    // Set Active Category from Search Tabs or Category Boxes
    function setActiveCategory(cat) {
      activeCategory = cat;

      // Update Search Tab styling
      document.querySelectorAll(".search-tab-btn").forEach(btn => {
        if (btn.getAttribute("data-type") === cat) {
          btn.classList.add("active");
        } else {
          btn.classList.remove("active");
        }
      });

      // Update Category Box styling
      document.querySelectorAll(".category-box").forEach(box => {
        box.classList.remove("active");
      });
      const catBox = document.getElementById("cat-box-" + cat);
      if (catBox) catBox.classList.add("active");

      filterProperties();
    }

    function filterCategory(cat) {
      setActiveCategory(cat);
      document.getElementById("properties").scrollIntoView({
        behavior: "smooth"
      });
    }

    // City Selection Helper
    function setCityAndScroll(cityName) {
      currentCity = cityName;

      // Update dropdowns & navbar badges
      const searchCityEl = document.getElementById("search-city");
      if (searchCityEl) searchCityEl.value = cityName;

      const navCitySpan = document.getElementById("selected-nav-city");
      if (navCitySpan) navCitySpan.innerText = cityName;

      const mobileCityEl = document.getElementById("mobile-nav-city-select");
      if (mobileCityEl) mobileCityEl.value = cityName;

      // Update navbar dropdown active class
      document.querySelectorAll(".city-option-btn").forEach(item => {
        if (item.getAttribute("data-city") === cityName) {
          item.classList.add("active");
        } else {
          item.classList.remove("active");
        }
      });

      // Highlight active city card
      document.querySelectorAll(".city-card").forEach(c => c.classList.remove("active-city"));
      const activeCard = document.getElementById("city-card-" + cityName);
      if (activeCard) activeCard.classList.add("active-city");

      filterProperties();
      document.getElementById("properties").scrollIntoView({
        behavior: "smooth"
      });
    }

    // Master Filtering Engine
    function filterProperties() {
      const citySelect = document.getElementById("search-city").value;
      const keyword = (document.getElementById("search-keyword").value || "").trim().toLowerCase();
      const maxBudget = parseInt(document.getElementById("search-budget").value, 10);
      const genderFilter = document.getElementById("gender-filter").value;
      const sortBy = document.getElementById("sort-by").value;

      currentCity = citySelect;

      // Sync navbar city title
      document.getElementById("selected-nav-city").innerText = citySelect;
      const listingLabel = document.getElementById("listing-count-label");

      let filtered = PROPERTIES_DATA.filter(p => {
        const matchCity = (p.city.toLowerCase() === currentCity.toLowerCase());
        const matchType = (activeCategory === "all" || p.type === activeCategory);
        const matchBudget = (p.rent <= maxBudget);
        const matchGender = (genderFilter === "all" || p.gender === genderFilter || p.gender === "unisex");
        const matchKeyword = (keyword === "" ||
          p.title.toLowerCase().includes(keyword) ||
          p.area.toLowerCase().includes(keyword) ||
          p.type.toLowerCase().includes(keyword) ||
          p.nearby.some(n => n.toLowerCase().includes(keyword)) ||
          p.amenities.some(a => a.toLowerCase().includes(keyword)));

        return matchCity && matchType && matchBudget && matchGender && matchKeyword;
      });

      // Sort logic
      if (sortBy === "rent_asc") {
        filtered.sort((a, b) => a.rent - b.rent);
      } else if (sortBy === "rent_desc") {
        filtered.sort((a, b) => b.rent - a.rent);
      } else if (sortBy === "rating_desc") {
        filtered.sort((a, b) => b.rating - a.rating);
      }

      if (listingLabel) {
        listingLabel.innerText = `Showing ${filtered.length} verified accommodation${filtered.length === 1 ? '' : 's'} in ${currentCity}`;
      }

      renderPropertyGrid(filtered);

      if (activeView === "map") {
        renderMapMarkers(filtered);
      }
    }

    // Render Cards in Grid
    function renderPropertyGrid(list) {
      const container = document.getElementById("property-grid-container");
      container.innerHTML = "";

      if (list.length === 0) {
        container.innerHTML = `
          <div class="col-12 text-center py-5">
            <div class="p-5 max-w-md mx-auto bg-soft-lavender rounded-4 border border-primary-subtle shadow-sm" style="max-width: 540px;">
              <i class="fas fa-magnifying-glass-location text-bright-indigo display-5 mb-3"></i>
              <h5 class="fw-bold mb-2">No Matching Accommodations Found</h5>
              <p class="text-secondary-custom small mb-4">We couldn't find listings matching your current filter in ${currentCity}. Try widening your budget slider, resetting gender filter, or searching for all accommodation types.</p>
              <button class="btn btn-nh-primary btn-sm px-4" onclick="resetFilters()"><i class="fas fa-rotate-left me-1"></i> Reset All Filters</button>
            </div>
          </div>
        `;
        return;
      }

      list.forEach(item => {
        const isCompared = compareList.some(c => c.id === item.id);
        const genderLabel = item.gender === 'male_only' ? 'Boys Only' : (item.gender === 'female_only' ?
          'Girls Only' : 'Unisex / Family');

        const cardHtml = `
          <div class="col-md-6 col-lg-4">
            <div class="property-card">
              <div class="card-img-wrapper">
                <img src="${item.image}" alt="${item.title}" loading="lazy" />
                <div class="card-badge-top">
                  ${item.verified ? '<span class="badge-tag badge-verified"><i class="fas fa-check-circle me-1"></i> Verified</span>' : ''}
                  <span class="badge-tag badge-type">${item.type}</span>
                  <span class="badge-tag badge-gender">${genderLabel}</span>
                </div>
                <button class="btn-favorite-card" onclick="triggerAuthGate('Save Favorite')" title="Save Favorite">
                  <i class="far fa-heart"></i>
                </button>
              </div>

              <div class="card-body-custom">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="text-secondary-custom extra-small fw-medium"><i class="fas fa-location-dot text-danger me-1"></i> ${item.area}, ${item.city}</span>
                  <span class="badge bg-warning text-dark extra-small"><i class="fas fa-star me-1"></i> ${item.rating}</span>
                </div>

                <h6 class="fw-bold mb-2 text-truncate" title="${item.title}">${item.title}</h6>
                
                <div class="d-flex flex-wrap gap-1 mb-3">
                  ${item.amenities.slice(0, 3).map(a => `<span class="amenity-pill"><i class="fas fa-check me-1 text-success"></i>${a}</span>`).join('')}
                  ${item.amenities.length > 3 ? `<span class="amenity-pill">+${item.amenities.length - 3} more</span>` : ''}
                </div>

                <div class="extra-small text-secondary-custom mb-3">
                  <i class="fas fa-route me-1 text-bright-indigo"></i> ${item.nearby[0] || 'Prime Location'}
                </div>

                <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                  <div>
                    <span class="extra-small text-secondary-custom d-block">Monthly Rent</span>
                    <span class="rent-price-display">₹${item.rent.toLocaleString()} <span class="fs-xs fw-normal text-secondary-custom">/mo</span></span>
                  </div>
                  
                  <div class="d-flex gap-2">
                    <button class="btn btn-sm ${isCompared ? 'btn-success' : 'btn-nh-secondary'}" onclick="toggleCompare(${item.id})" title="${isCompared ? 'Remove from Compare' : 'Add to Compare'}">
                      <i class="fas fa-scale-balanced"></i>
                    </button>
                    <button class="btn btn-sm btn-nh-primary" onclick="openDetailModal(${item.id})">View Details</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        `;
        container.insertAdjacentHTML("beforeend", cardHtml);
      });
    }

    // Detail Modal Viewer
    function openDetailModal(id) {
      const item = PROPERTIES_DATA.find(p => p.id === id);
      if (!item) return;

      currentSelectedProperty = item;

      document.getElementById("md-title").innerText = item.title;
      document.getElementById("md-type-badge").innerText = item.type;

      const genderLabel = item.gender === 'male_only' ? 'Boys Only' : (item.gender === 'female_only' ?
        'Girls Only' : 'Unisex / Family');
      document.getElementById("md-gender-badge").innerText = genderLabel;

      document.getElementById("md-location").innerHTML =
        `<i class="fas fa-map-marker-alt text-danger me-1"></i> ${item.area}, ${item.city}`;
      document.getElementById("md-main-img").src = item.image;
      document.getElementById("md-rent").innerText = `₹${item.rent.toLocaleString()}/mo`;
      document.getElementById("md-side-rent").innerHTML =
        `₹${item.rent.toLocaleString()} <span class="fs-xs fw-normal text-secondary-custom">/mo</span>`;
      document.getElementById("md-deposit").innerText = `₹${item.deposit.toLocaleString()}`;
      document.getElementById("md-available").innerText = item.available_beds;
      document.getElementById("md-desc").innerText = item.desc;
      document.getElementById("md-rating-pill").innerHTML = `<i class="fas fa-star me-1"></i> ${item.rating}`;

      // Calculate initial breakdown
      updateModalPrice(document.getElementById("md-occupancy-select").value);

      // Render amenities
      const amBox = document.getElementById("md-amenities");
      amBox.innerHTML = item.amenities.map(a =>
        `<span class="badge bg-soft-lavender text-royal-blue p-2 rounded-3 border border-primary-subtle"><i class="fas fa-check-circle text-success me-1"></i> ${a}</span>`
      ).join('');

      // Render nearby
      const nbBox = document.getElementById("md-nearby-list");
      nbBox.innerHTML = item.nearby.map(n =>
        `<li class="d-flex align-items-center gap-2"><i class="fas fa-map-pin text-bright-indigo"></i> ${n}</li>`
      ).join('');

      const modal = new bootstrap.Modal(document.getElementById("propertyDetailModal"));
      modal.show();
    }

    // Dynamic Occupancy Pricing in Modal
    function updateModalPrice(occupancyType) {
      if (!currentSelectedProperty) return;
      let multiplier = 1.0;
      if (occupancyType === 'single') multiplier = 1.45;
      if (occupancyType === 'double') multiplier = 1.0;
      if (occupancyType === 'triple') multiplier = 0.78;

      const calcRent = Math.round(currentSelectedProperty.rent * multiplier / 100) * 100;
      const deposit = currentSelectedProperty.deposit;
      const total = calcRent + deposit;

      document.getElementById("md-calc-rent").innerText = `₹${calcRent.toLocaleString()}`;
      document.getElementById("md-calc-total").innerText = `₹${total.toLocaleString()}`;
    }

    // Auth Gate Modal Trigger
    function triggerAuthGate(actionName) {
      document.getElementById("auth-action-name").innerText = actionName;
      const detailModalEl = document.getElementById("propertyDetailModal");
      const detailModal = bootstrap.Modal.getInstance(detailModalEl);
      if (detailModal) detailModal.hide();

      const authModal = new bootstrap.Modal(document.getElementById("authGateModal"));
      authModal.show();
    }

    // Comparison Engine
    function toggleCompare(id) {
      const item = PROPERTIES_DATA.find(p => p.id === id);
      if (!item) return;

      const index = compareList.findIndex(c => c.id === id);

      if (index > -1) {
        compareList.splice(index, 1);
      } else {
        if (compareList.length >= 3) {
          alert("You can compare up to 3 properties at a time.");
          return;
        }
        compareList.push(item);
      }

      updateCompareBar();
      filterProperties();
    }

    function updateCompareBar() {
      const bar = document.getElementById("compare-float-bar");
      const countSpan = document.getElementById("compare-count");
      countSpan.innerText = compareList.length;

      if (compareList.length > 0) {
        bar.classList.remove("d-none");
      } else {
        bar.classList.add("d-none");
      }
    }

    function clearCompare() {
      compareList = [];
      updateCompareBar();
      filterProperties();
    }

    function showCompareModal() {
      if (compareList.length === 0) return;
      const wrapper = document.getElementById("compare-table-wrapper");

      let html = `
        <table class="table table-bordered text-center align-middle small mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 25%;">Feature</th>
              ${compareList.map(c => `
                <th>
                  <div class="fw-bold mb-1">${c.title}</div>
                  <span class="badge bg-primary">${c.type}</span>
                  <button class="btn btn-link btn-sm text-danger text-decoration-none p-0 d-block mx-auto mt-1" onclick="toggleCompare(${c.id}); showCompareModal();"><i class="fas fa-trash-can me-1"></i> Remove</button>
                </th>
              `).join('')}
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fw-bold text-start ps-3">Monthly Rent</td>
              ${compareList.map(c => `<td class="fw-bold text-royal-blue fs-6">₹${c.rent.toLocaleString()}/mo</td>`).join('')}
            </tr>
            <tr>
              <td class="fw-bold text-start ps-3">Security Deposit</td>
              ${compareList.map(c => `<td>₹${c.deposit.toLocaleString()}</td>`).join('')}
            </tr>
            <tr>
              <td class="fw-bold text-start ps-3">Location & Area</td>
              ${compareList.map(c => `<td>${c.area}, ${c.city}</td>`).join('')}
            </tr>
            <tr>
              <td class="fw-bold text-start ps-3">Gender Rule</td>
              ${compareList.map(c => `<td class="text-capitalize">${c.gender.replace('_', ' ')}</td>`).join('')}
            </tr>
            <tr>
              <td class="fw-bold text-start ps-3">Rating</td>
              ${compareList.map(c => `<td><span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i> ${c.rating}</span></td>`).join('')}
            </tr>
            <tr>
              <td class="fw-bold text-start ps-3">Availability</td>
              ${compareList.map(c => `<td class="text-success fw-semibold">${c.available_beds}</td>`).join('')}
            </tr>
            <tr>
              <td class="fw-bold text-start ps-3">Key Amenities</td>
              ${compareList.map(c => `<td class="extra-small">${c.amenities.join(', ')}</td>`).join('')}
            </tr>
          </tbody>
        </table>
      `;

      wrapper.innerHTML = html;
      const modal = new bootstrap.Modal(document.getElementById("compareModal"));
      modal.show();
    }

    function resetFilters() {
      document.getElementById("search-keyword").value = "";
      document.getElementById("search-budget").value = 35000;
      document.getElementById("budget-val").innerText = "₹35,000";
      document.getElementById("gender-filter").value = "all";
      document.getElementById("sort-by").value = "featured";
      setActiveCategory("all");
    }

    // View Switcher (Grid vs Leaflet Map) with InvalidateSize Bugfix
    function toggleView(view) {
      activeView = view;
      const gridBox = document.getElementById("property-grid-container");
      const mapBox = document.getElementById("map-view-container");
      const btnGrid = document.getElementById("btn-view-grid");
      const btnMap = document.getElementById("btn-view-map");

      if (view === "map") {
        gridBox.style.display = "flex";
        mapBox.style.display = "block";
        btnGrid.classList.remove("active");
        btnMap.classList.add("active");
        initLeafletMap();
      } else {
        gridBox.style.display = "flex";
        mapBox.style.display = "none";
        btnGrid.classList.add("active");
        btnMap.classList.remove("active");
      }
    }

    function initLeafletMap() {
      if (!leafletMap) {
        leafletMap = L.map('property-leaflet-map').setView([12.9716, 77.5946], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 18,
          attribution: '© OpenStreetMap contributors'
        }).addTo(leafletMap);
      }

      setTimeout(() => {
        if (leafletMap) {
          leafletMap.invalidateSize();
        }
      }, 200);

      const filtered = PROPERTIES_DATA.filter(p => p.city.toLowerCase() === currentCity.toLowerCase());
      renderMapMarkers(filtered);
    }

    function renderMapMarkers(list) {
      if (!leafletMap) return;

      mapMarkers.forEach(m => leafletMap.removeLayer(m));
      mapMarkers = [];

      if (list.length === 0) return;

      const bounds = [];
      list.forEach(p => {
        const marker = L.marker([p.lat, p.lng]).addTo(leafletMap);
        marker.bindPopup(`
          <div style="font-family: 'Inter', sans-serif; min-width: 160px; padding: 2px;">
            <strong style="color: #4338CA; font-size: 13px;">${p.title}</strong><br>
            <span style="font-weight: 700; color: #111827;">₹${p.rent.toLocaleString()}/mo</span> <span style="font-size: 11px; background: #EEF2FF; color: #4338CA; padding: 2px 6px; border-radius: 4px;">${p.type}</span><br>
            <small style="color: #64748B;">${p.area}, ${p.city}</small><br>
            <button style="margin-top: 6px; background: #4F46E5; color: #fff; border: none; padding: 4px 10px; border-radius: 20px; font-size: 11px; cursor: pointer;" onclick="openDetailModal(${p.id})">View Details</button>
          </div>
        `);
        mapMarkers.push(marker);
        bounds.push([p.lat, p.lng]);
      });

      if (bounds.length > 0) {
        leafletMap.fitBounds(bounds, {
          padding: [50, 50]
        });
      }
    }
  </script>
</body>

</html>