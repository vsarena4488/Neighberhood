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
       MASTER DESIGN SYSTEM - EXACT COLOR SPECIFICATIONS
       Deep Royal Blue: #4338CA | Bright Indigo: #4F46E5
       Soft Lavender: #EEF2FF   | Light Background: #F8FAFC
       White: #FFFFFF          | Dark Text: #111827
       Secondary Text: #6B7280 | Border: #E5E7EB
       Success: #22C55E
       =================================================== */
    :root {
      --nh-royal-blue: #4338CA;
      --nh-bright-indigo: #4F46E5;
      --nh-indigo-hover: #3730A3;
      --nh-soft-lavender: #EEF2FF;
      --nh-lavender-border: #C7D2FE;
      --nh-white: #FFFFFF;
      --nh-bg-light: #F8FAFC;
      --nh-dark-text: #111827;
      --nh-secondary-text: #6B7280;
      --nh-border: #E5E7EB;
      --nh-success: #22C55E;
      --nh-amber: #F59E0B;
      --nh-rose: #F43F5E;
      
      --nh-gradient-primary: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
      --nh-gradient-hero: linear-gradient(180deg, #EEF2FF 0%, #F8FAFC 100%);
      --nh-gradient-card: linear-gradient(180deg, rgba(255,255,255,0.9) 0%, #FFFFFF 100%);
      
      --nh-radius-lg: 22px;
      --nh-radius-md: 16px;
      --nh-radius-sm: 10px;
      --nh-radius-pill: 50px;
      
      --nh-shadow-subtle: 0 4px 20px rgba(67, 56, 202, 0.05);
      --nh-shadow-card: 0 10px 30px -5px rgba(67, 56, 202, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
      --nh-shadow-hover: 0 20px 40px -10px rgba(67, 56, 202, 0.16);
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

    h1, h2, h3, h4, h5, h6, .heading-font {
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
      font-weight: 700;
      color: var(--nh-dark-text);
      letter-spacing: -0.02em;
    }

    /* Custom Utilities */
    .bg-soft-lavender { background-color: var(--nh-soft-lavender) !important; }
    .bg-slate-canvas { background-color: var(--nh-bg-light) !important; }
    .text-royal-blue { color: var(--nh-royal-blue) !important; }
    .text-bright-indigo { color: var(--nh-bright-indigo) !important; }
    .text-secondary-custom { color: var(--nh-secondary-text) !important; }
    .text-success-custom { color: var(--nh-success) !important; }
    
    /* Buttons */
    .btn-nh-primary {
      background: var(--nh-gradient-primary);
      color: #FFFFFF !important;
      border: none;
      padding: 0.75rem 1.75rem;
      border-radius: var(--nh-radius-pill);
      font-weight: 600;
      font-size: 0.95rem;
      box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
      transition: var(--nh-transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      cursor: pointer;
    }
    .btn-nh-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(79, 70, 229, 0.45);
      color: #FFFFFF !important;
    }

    .btn-nh-outline {
      background: transparent;
      color: var(--nh-royal-blue) !important;
      border: 2px solid var(--nh-bright-indigo);
      padding: 0.7rem 1.6rem;
      border-radius: var(--nh-radius-pill);
      font-weight: 600;
      font-size: 0.95rem;
      transition: var(--nh-transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      cursor: pointer;
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
      padding: 0.65rem 1.4rem;
      border-radius: var(--nh-radius-md);
      font-weight: 600;
      font-size: 0.9rem;
      transition: var(--nh-transition);
    }
    .btn-nh-secondary:hover {
      background: var(--nh-bright-indigo);
      color: #FFFFFF !important;
      border-color: var(--nh-bright-indigo);
    }

    /* Navbar */
    .navbar-nh {
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--nh-border);
      padding: 0.85rem 0;
      position: sticky;
      top: 0;
      z-index: 1040;
      transition: var(--nh-transition);
    }
    .navbar-nh .navbar-brand {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.5rem;
      color: var(--nh-royal-blue);
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }
    .navbar-nh .brand-icon {
      width: 40px;
      height: 40px;
      background: var(--nh-gradient-primary);
      color: #fff;
      border-radius: var(--nh-radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      box-shadow: 0 4px 12px rgba(67, 56, 202, 0.3);
    }
    .navbar-nh .nav-link {
      font-weight: 500;
      color: var(--nh-dark-text);
      padding: 0.5rem 1rem;
      font-size: 0.95rem;
      transition: var(--nh-transition);
    }
    .navbar-nh .nav-link:hover,
    .navbar-nh .nav-link.active {
      color: var(--nh-bright-indigo);
    }
    .city-select-pill {
      background: var(--nh-soft-lavender);
      border: 1px solid var(--nh-lavender-border);
      border-radius: var(--nh-radius-pill);
      padding: 0.4rem 1rem;
      font-size: 0.88rem;
      font-weight: 600;
      color: var(--nh-royal-blue);
      display: flex;
      align-items: center;
      gap: 0.4rem;
      cursor: pointer;
    }

    /* Hero Section */
    .hero-section {
      background: var(--nh-gradient-hero);
      padding: 4.5rem 0 5.5rem 0;
      position: relative;
      overflow: hidden;
    }
    .hero-section::before {
      content: '';
      position: absolute;
      top: -100px;
      right: -100px;
      width: 450px;
      height: 450px;
      background: radial-gradient(circle, rgba(79, 70, 229, 0.15) 0%, rgba(238, 242, 255, 0) 70%);
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
      padding: 0.4rem 1.1rem;
      border-radius: var(--nh-radius-pill);
      font-size: 0.85rem;
      font-weight: 700;
      margin-bottom: 1.2rem;
    }

    /* Master Search Bar Card */
    .search-box-card {
      background: var(--nh-white);
      border-radius: var(--nh-radius-lg);
      padding: 1.75rem;
      box-shadow: var(--nh-shadow-card);
      border: 1px solid var(--nh-border);
    }
    .search-tab-btn {
      background: transparent;
      border: none;
      padding: 0.5rem 1.2rem;
      font-weight: 600;
      font-size: 0.9rem;
      color: var(--nh-secondary-text);
      border-radius: var(--nh-radius-pill);
      transition: var(--nh-transition);
    }
    .search-tab-btn.active {
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
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
      height: 210px;
      overflow: hidden;
      background: #e2e8f0;
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
      top: 14px;
      left: 14px;
      z-index: 2;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .badge-tag {
      padding: 0.3rem 0.75rem;
      border-radius: var(--nh-radius-pill);
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.03em;
    }
    .badge-verified {
      background: rgba(34, 197, 94, 0.95);
      color: #fff;
      backdrop-filter: blur(4px);
    }
    .badge-type {
      background: rgba(67, 56, 202, 0.92);
      color: #fff;
      backdrop-filter: blur(4px);
    }
    .btn-favorite-card {
      position: absolute;
      top: 14px;
      right: 14px;
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
    .btn-favorite-card:hover, .btn-favorite-card.active {
      background: #fff;
      color: var(--nh-rose);
      transform: scale(1.1);
    }
    .card-body-custom {
      padding: 1.25rem;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }
    .amenity-pill {
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
      font-size: 0.75rem;
      font-weight: 600;
      padding: 0.25rem 0.6rem;
      border-radius: var(--nh-radius-sm);
    }
    .rent-price-display {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.25rem;
      font-weight: 800;
      color: var(--nh-royal-blue);
    }

    /* Category Pill Grid */
    .category-box {
      background: var(--nh-white);
      border: 1px solid var(--nh-border);
      border-radius: var(--nh-radius-md);
      padding: 1.25rem 1rem;
      text-align: center;
      transition: var(--nh-transition);
      cursor: pointer;
      box-shadow: var(--nh-shadow-subtle);
    }
    .category-box:hover, .category-box.active {
      border-color: var(--nh-bright-indigo);
      background: var(--nh-soft-lavender);
      transform: translateY(-4px);
    }
    .category-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: var(--nh-soft-lavender);
      color: var(--nh-bright-indigo);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
      margin: 0 auto 0.75rem auto;
      transition: var(--nh-transition);
    }
    .category-box:hover .category-icon {
      background: var(--nh-bright-indigo);
      color: #fff;
    }

    /* City Card Grid */
    .city-card {
      position: relative;
      border-radius: var(--nh-radius-md);
      overflow: hidden;
      height: 180px;
      cursor: pointer;
      box-shadow: var(--nh-shadow-card);
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
      background: linear-gradient(180deg, rgba(17, 24, 39, 0.1) 0%, rgba(17, 24, 39, 0.85) 100%);
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 1.1rem;
      color: #fff;
    }

    /* How It Works Steps */
    .step-number-circle {
      width: 54px;
      height: 54px;
      border-radius: 50%;
      background: var(--nh-gradient-primary);
      color: #fff;
      font-weight: 800;
      font-size: 1.3rem;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.2rem;
      box-shadow: 0 8px 20px rgba(67, 56, 202, 0.25);
    }

    /* Interactive Map Container */
    #property-leaflet-map {
      height: 480px;
      border-radius: var(--nh-radius-lg);
      border: 1px solid var(--nh-border);
      box-shadow: var(--nh-shadow-card);
    }

    /* Compare Drawer & Floating Trigger */
    .compare-float-bar {
      position: fixed;
      bottom: 24px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 1030;
      background: var(--nh-dark-text);
      color: #fff;
      border-radius: var(--nh-radius-pill);
      padding: 0.75rem 1.75rem;
      box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
      display: flex;
      align-items: center;
      gap: 1.25rem;
    }

    /* Modal Styling */
    .modal-content-custom {
      border-radius: var(--nh-radius-lg);
      border: none;
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
    }

    /* Footer */
    footer {
      background: #0F172A;
      color: #94A3B8;
      padding: 4.5rem 0 2rem 0;
    }
    footer h5, footer h6 {
      color: #FFFFFF;
    }
    footer a {
      color: #94A3B8;
      text-decoration: none;
      transition: var(--nh-transition);
      display: block;
      margin-bottom: 0.5rem;
    }
    footer a:hover {
      color: #FFFFFF;
      padding-left: 4px;
    }

    @media (max-width: 768px) {
      .hero-section { padding: 2.5rem 0 3.5rem 0; }
      .search-box-card { padding: 1.2rem; }
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

      <!-- City Selector Dropdown in Navbar -->
      <div class="ms-lg-3 me-auto d-none d-sm-flex align-items-center">
        <div class="dropdown">
          <button class="city-select-pill dropdown-toggle" type="button" id="navCityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-location-dot text-bright-indigo"></i>
            <span id="selected-nav-city">Bangalore</span>
          </button>
          <ul class="dropdown-menu shadow-lg border-0 rounded-4 mt-2" aria-labelledby="navCityDropdown">
            <li><h6 class="dropdown-header text-uppercase fs-xs">Select City</h6></li>
            <li><a class="dropdown-item city-option-btn active" href="#" data-city="Bangalore"><i class="fas fa-building me-2"></i> Bangalore</a></li>
            <li><a class="dropdown-item city-option-btn" href="#" data-city="Mumbai"><i class="fas fa-building me-2"></i> Mumbai</a></li>
            <li><a class="dropdown-item city-option-btn" href="#" data-city="Delhi"><i class="fas fa-building me-2"></i> Delhi / NCR</a></li>
            <li><a class="dropdown-item city-option-btn" href="#" data-city="Pune"><i class="fas fa-building me-2"></i> Pune</a></li>
            <li><a class="dropdown-item city-option-btn" href="#" data-city="Hyderabad"><i class="fas fa-building me-2"></i> Hyderabad</a></li>
            <li><a class="dropdown-item city-option-btn" href="#" data-city="Chennai"><i class="fas fa-building me-2"></i> Chennai</a></li>
            <li><a class="dropdown-item city-option-btn" href="#" data-city="Noida"><i class="fas fa-building me-2"></i> Noida / Gurgaon</a></li>
          </ul>
        </div>
      </div>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-1">
          <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#categories">Categories</a></li>
          <li class="nav-item"><a class="nav-link" href="#properties">Explore Places</a></li>
          <li class="nav-item"><a class="nav-link" href="#how-it-works">How It Works</a></li>
          <li class="nav-item"><a class="nav-link" href="#verified-section">Verified PGs</a></li>
          <li class="nav-item"><a class="nav-link" href="#testimonials">Reviews</a></li>
        </ul>

        <div class="d-flex align-items-center gap-2 ms-lg-3 mt-3 mt-lg-0">
          <a href="login.php" class="btn btn-nh-outline btn-sm">Log In</a>
          <a href="register.php" class="btn btn-nh-primary btn-sm">Register / List Property</a>
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
            Discover verified PGs, hostels, rooms, apartments, and rental houses near your college or workplace. Compare options, inspect distance, and book with complete confidence.
          </p>

          <!-- Key Quick Stats -->
          <div class="d-flex flex-wrap gap-4 mb-4 pt-2">
            <div>
              <h3 class="fw-bold mb-0 text-royal-blue">15,000+</h3>
              <span class="text-secondary-custom fs-sm">Active Properties</span>
            </div>
            <div class="border-end d-none d-sm-block"></div>
            <div>
              <h3 class="fw-bold mb-0 text-royal-blue">12+ Cities</h3>
              <span class="text-secondary-custom fs-sm">Covered Nationwide</span>
            </div>
            <div class="border-end d-none d-sm-block"></div>
            <div>
              <h3 class="fw-bold mb-0 text-royal-blue">98%</h3>
              <span class="text-secondary-custom fs-sm">Verified Listings</span>
            </div>
          </div>
        </div>

        <div class="col-lg-5">
          <!-- Hero Illustration Card -->
          <div class="position-relative">
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
              <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80" alt="Modern PG Room" class="img-fluid" style="height: 380px; object-fit: cover;" />
              <div class="card-img-overlay d-flex flex-column justify-content-end p-4" style="background: linear-gradient(180deg, transparent 40%, rgba(15,23,42,0.85) 100%); color: #fff;">
                <span class="badge bg-success w-auto align-self-start mb-2"><i class="fas fa-check-circle me-1"></i> Verified Owner</span>
                <h5 class="fw-bold text-white mb-1">St. Mark's Executive PG for Men</h5>
                <p class="small text-white-50 mb-0"><i class="fas fa-map-marker-alt me-1"></i> Koramangala, Bangalore • 0.5km to Forum Mall</p>
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
            <div class="d-flex flex-wrap gap-2 mb-3 border-bottom pb-3">
              <button class="search-tab-btn active" data-type="all"><i class="fas fa-border-all me-1"></i> All Types</button>
              <button class="search-tab-btn" data-type="PG"><i class="fas fa-bed me-1"></i> PG / Paying Guest</button>
              <button class="search-tab-btn" data-type="Hostel"><i class="fas fa-building-user me-1"></i> Hostels</button>
              <button class="search-tab-btn" data-type="Room"><i class="fas fa-door-open me-1"></i> Rooms</button>
              <button class="search-tab-btn" data-type="House"><i class="fas fa-house me-1"></i> Rental Houses & Flats</button>
            </div>

            <form id="hero-search-form" onsubmit="event.preventDefault(); filterProperties();">
              <div class="row g-3 align-items-center">
                <!-- City Selector -->
                <div class="col-md-3">
                  <label class="form-label small fw-bold text-secondary-custom mb-1"><i class="fas fa-city me-1 text-bright-indigo"></i> City</label>
                  <select id="search-city" class="form-select border-1 rounded-3 py-2 fw-medium" onchange="filterProperties()">
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
                  <input type="text" id="search-keyword" class="form-control border-1 rounded-3 py-2" placeholder="e.g. Koramangala, RV College, Manyata" oninput="filterProperties()" />
                </div>

                <!-- Budget Range -->
                <div class="col-md-3">
                  <label class="form-label small fw-bold text-secondary-custom mb-1">
                    <i class="fas fa-indian-rupee-sign me-1 text-bright-indigo"></i> Max Rent: <span id="budget-val" class="text-royal-blue fw-bold">₹25,000</span>
                  </label>
                  <input type="range" class="form-range" id="search-budget" min="4000" max="40000" step="1000" value="25000" oninput="document.getElementById('budget-val').innerText = '₹' + parseInt(this.value).toLocaleString(); filterProperties();" />
                </div>

                <!-- Search Button CTA -->
                <div class="col-md-3">
                  <label class="form-label d-none d-md-block mb-1">&nbsp;</label>
                  <button type="submit" class="btn btn-nh-primary w-100 py-2">
                    <i class="fas fa-search me-1"></i> Search Accommodation
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
  <section class="py-5 bg-white">
    <div class="container">
      <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
          <span class="text-bright-indigo fw-bold text-uppercase fs-xs tracking-wide">City Discovery</span>
          <h2 class="h3 fw-bold mb-0">Explore Top Accommodation Hubs</h2>
        </div>
        <span class="text-secondary-custom small">Select a city to auto-filter</span>
      </div>

      <div class="row g-3">
        <div class="col-6 col-md-4 col-lg-2">
          <div class="city-card" onclick="setCityAndScroll('Bangalore')">
            <img src="https://images.unsplash.com/photo-1596176530529-78163a4f7af2?auto=format&fit=crop&w=400&q=80" alt="Bangalore" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0">Bangalore</h6>
              <span class="small opacity-75">4,200+ PGs & Rooms</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="city-card" onclick="setCityAndScroll('Mumbai')">
            <img src="https://images.unsplash.com/photo-1570168007204-dfb528c6958f?auto=format&fit=crop&w=400&q=80" alt="Mumbai" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0">Mumbai</h6>
              <span class="small opacity-75">3,100+ Listings</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="city-card" onclick="setCityAndScroll('Delhi')">
            <img src="https://images.unsplash.com/photo-1587474260584-136574528ed5?auto=format&fit=crop&w=400&q=80" alt="Delhi" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0">Delhi / NCR</h6>
              <span class="small opacity-75">3,800+ Listings</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="city-card" onclick="setCityAndScroll('Pune')">
            <img src="https://images.unsplash.com/photo-1605649487212-47bdab064df7?auto=format&fit=crop&w=400&q=80" alt="Pune" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0">Pune</h6>
              <span class="small opacity-75">2,400+ PGs & Rooms</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="city-card" onclick="setCityAndScroll('Hyderabad')">
            <img src="https://images.unsplash.com/photo-1605146769289-440113cc3d00?auto=format&fit=crop&w=400&q=80" alt="Hyderabad" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0">Hyderabad</h6>
              <span class="small opacity-75">2,900+ Listings</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="city-card" onclick="setCityAndScroll('Noida')">
            <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=400&q=80" alt="Gurgaon Noida" />
            <div class="city-overlay">
              <h6 class="fw-bold mb-0">Noida / Gurgaon</h6>
              <span class="small opacity-75">2,100+ Listings</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 5: PROPERTY TYPE CATEGORIES
       ============================================================ -->
  <section id="categories" class="py-5 bg-soft-lavender">
    <div class="container">
      <div class="text-center max-w-xl mx-auto mb-5">
        <span class="text-bright-indigo fw-bold text-uppercase fs-xs">Tailored Accommodations</span>
        <h2 class="h3 fw-bold">Browse by Property Type</h2>
        <p class="text-secondary-custom small">Whether you need a full apartment for your family or a budget sharing PG near your college, we have you covered.</p>
      </div>

      <div class="row g-3">
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" onclick="filterCategory('PG')">
            <div class="category-icon"><i class="fas fa-bed"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">PG / Paying Guest</h6>
            <span class="text-secondary-custom extra-small">Food & Laundry Included</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" onclick="filterCategory('Hostel')">
            <div class="category-icon"><i class="fas fa-building-user"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">Hostels</h6>
            <span class="text-secondary-custom extra-small">For Students & Youths</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" onclick="filterCategory('Room')">
            <div class="category-icon"><i class="fas fa-door-open"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">Individual Rooms</h6>
            <span class="text-secondary-custom extra-small">Private & Quiet Space</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" onclick="filterCategory('Shared Room')">
            <div class="category-icon"><i class="fas fa-people-arrows"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">Shared Rooms</h6>
            <span class="text-secondary-custom extra-small">Budget Friendly Sharing</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" onclick="filterCategory('Apartment')">
            <div class="category-icon"><i class="fas fa-building"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">Apartments & Flats</h6>
            <span class="text-secondary-custom extra-small">1BHK, 2BHK, 3BHK</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="category-box" onclick="filterCategory('House')">
            <div class="category-icon"><i class="fas fa-house"></i></div>
            <h6 class="fw-bold mb-1 fs-sm">Rental Houses</h6>
            <span class="text-secondary-custom extra-small">Independent & Family</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 7 & 12: FEATURED & LATEST PROPERTY LISTINGS
       ============================================================ -->
  <section id="properties" class="py-5 bg-white">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
          <span class="text-bright-indigo fw-bold text-uppercase fs-xs">Live Listings</span>
          <h2 class="h3 fw-bold mb-0">Discover Verified Accommodations</h2>
        </div>

        <!-- Filter Controls & View Switchers -->
        <div class="d-flex flex-wrap align-items-center gap-2">
          <!-- Gender Filter -->
          <select id="gender-filter" class="form-select form-select-sm rounded-pill px-3" onchange="filterProperties()">
            <option value="all">All Gender Rules</option>
            <option value="male_only">Boys / Men Only</option>
            <option value="female_only">Girls / Women Only</option>
            <option value="unisex">Unisex / Family</option>
          </select>

          <!-- Sorting -->
          <select id="sort-by" class="form-select form-select-sm rounded-pill px-3" onchange="filterProperties()">
            <option value="featured">Featured First</option>
            <option value="rent_asc">Lowest Rent</option>
            <option value="rent_desc">Highest Rent</option>
            <option value="rating_desc">Highest Rated</option>
          </select>

          <!-- View Mode Toggle -->
          <div class="btn-group btn-group-sm" role="group">
            <button id="btn-view-grid" class="btn btn-outline-primary active" onclick="toggleView('grid')"><i class="fas fa-th-large"></i> Grid</button>
            <button id="btn-view-map" class="btn btn-outline-primary" onclick="toggleView('map')"><i class="fas fa-map-marked-alt"></i> Map</button>
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
  <section id="how-it-works" class="py-5 bg-soft-lavender">
    <div class="container">
      <div class="text-center max-w-xl mx-auto mb-5">
        <span class="text-bright-indigo fw-bold text-uppercase fs-xs">Seamless Process</span>
        <h2 class="h3 fw-bold">How NeighborHood Works</h2>
        <p class="text-secondary-custom small">From searching in a new city to moving into your verified room in 4 simple steps.</p>
      </div>

      <div class="row g-4">
        <div class="col-md-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-white">
            <div class="step-number-circle mx-auto">1</div>
            <h5 class="fw-bold mb-2">Search</h5>
            <p class="text-secondary-custom small mb-0">Select your target city and accommodation type (PG, hostel, room, flat).</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-white">
            <div class="step-number-circle mx-auto">2</div>
            <h5 class="fw-bold mb-2">Explore</h5>
            <p class="text-secondary-custom small mb-0">Compare rents, security deposits, amenities, food options, and college proximity.</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-white">
            <div class="step-number-circle mx-auto">3</div>
            <h5 class="fw-bold mb-2">Connect</h5>
            <p class="text-secondary-custom small mb-0">Send booking inquiries directly to verified property landlords.</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-white">
            <div class="step-number-circle mx-auto">4</div>
            <h5 class="fw-bold mb-2">Book</h5>
            <p class="text-secondary-custom small mb-0">Confirm your bed or room securely with transparent platform receipt.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 9 & 10: VERIFIED PROPERTIES & PLATFORM BENEFITS
       ============================================================ -->
  <section id="verified-section" class="py-5 bg-white">
    <div class="container">
      <div class="row align-items-center gy-4">
        <div class="col-lg-6">
          <span class="text-bright-indigo fw-bold text-uppercase fs-xs">Trust & Safety First</span>
          <h2 class="h2 fw-bold mb-3">Why 100,000+ Tenants Trust NeighborHood</h2>
          <p class="text-secondary-custom mb-4">
            We physically audit properties and verify owner identity documents before awarding our Verified Badge. No fake photos, no surprise brokerage fees.
          </p>

          <div class="row g-3">
            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-3">
                <div class="p-2 rounded-circle bg-soft-lavender text-bright-indigo fs-5"><i class="fas fa-shield-check"></i></div>
                <div>
                  <h6 class="fw-bold mb-1">Verified Owners</h6>
                  <p class="extra-small text-secondary-custom mb-0">Govt ID & bank details verified by admin.</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-3">
                <div class="p-2 rounded-circle bg-soft-lavender text-bright-indigo fs-5"><i class="fas fa-tag"></i></div>
                <div>
                  <h6 class="fw-bold mb-1">Zero Hidden Charges</h6>
                  <p class="extra-small text-secondary-custom mb-0">Clear rent & deposit policies upfront.</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-3">
                <div class="p-2 rounded-circle bg-soft-lavender text-bright-indigo fs-5"><i class="fas fa-location-crosshairs"></i></div>
                <div>
                  <h6 class="fw-bold mb-1">Proximity Intelligence</h6>
                  <p class="extra-small text-secondary-custom mb-0">Filter PGs near your specific college or office.</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-3">
                <div class="p-2 rounded-circle bg-soft-lavender text-bright-indigo fs-5"><i class="fas fa-headset"></i></div>
                <div>
                  <h6 class="fw-bold mb-1">Tenant Assistance</h6>
                  <p class="extra-small text-secondary-custom mb-0">24/7 resolution support for any booking issue.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="p-4 bg-soft-lavender rounded-5 border">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="fw-bold mb-0"><i class="fas fa-badge-check text-success me-2"></i> Verified PG Inspection Checklist</h5>
              <span class="badge bg-success">100% Passed</span>
            </div>
            <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
              <li class="d-flex align-items-center gap-2"><i class="fas fa-check text-success"></i> High-Speed Wi-Fi & Dedicated Study Desk verified</li>
              <li class="d-flex align-items-center gap-2"><i class="fas fa-check text-success"></i> Hygienic 3-time Meal Quality & Water Filter Audit</li>
              <li class="d-flex align-items-center gap-2"><i class="fas fa-check text-success"></i> 24/7 CCTV & Gated Security Guard Entry</li>
              <li class="d-flex align-items-center gap-2"><i class="fas fa-check text-success"></i> Power Backup & Daily Housekeeping Verified</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 11: TESTIMONIALS (STUDENTS & EMPLOYEES)
       ============================================================ -->
  <section id="testimonials" class="py-5 bg-slate-canvas">
    <div class="container">
      <div class="text-center max-w-xl mx-auto mb-5">
        <span class="text-bright-indigo fw-bold text-uppercase fs-xs">Community Feedback</span>
        <h2 class="h3 fw-bold">Trusted by Thousands Moving to New Cities</h2>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex align-items-center gap-1 text-warning mb-3">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="small text-secondary-custom mb-4">"Moving to Bangalore for my software role was stressful until I found NeighborHood. Found a great PG in Koramangala 10 mins from my tech park!"</p>
            <div class="d-flex align-items-center gap-3">
              <div class="bg-soft-lavender rounded-circle p-2 text-royal-blue fw-bold">AR</div>
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
            <p class="small text-secondary-custom mb-4">"As a student at Delhi University, finding an affordable sharing room with good food was my main concern. NeighborHood filtered exact student PGs easily!"</p>
            <div class="d-flex align-items-center gap-3">
              <div class="bg-soft-lavender rounded-circle p-2 text-royal-blue fw-bold">KS</div>
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
            <p class="small text-secondary-custom mb-4">"We relocated our family to Pune and booked a 2BHK flat directly from a verified owner without paying any middleman brokerage fee."</p>
            <div class="d-flex align-items-center gap-3">
              <div class="bg-soft-lavender rounded-circle p-2 text-royal-blue fw-bold">VD</div>
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
       SECTION 13: DUAL CALL TO ACTION
       ============================================================ -->
  <section class="py-5" style="background: var(--nh-gradient-primary); color: #fff;">
    <div class="container text-center py-4">
      <h2 class="display-6 fw-bold text-white mb-3">Are You Ready to Find Your Next Home?</h2>
      <p class="lead text-white-50 max-w-xl mx-auto mb-4">Join thousands of students and working professionals who found their ideal accommodation seamlessly.</p>
      <div class="d-flex justify-content-center gap-3">
        <a href="#properties" class="btn btn-light rounded-pill px-4 py-2 fw-bold text-royal-blue shadow">Find Accommodation</a>
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
            <div class="brand-icon" style="width:36px;height:36px;background:var(--nh-bright-indigo);color:#fff;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-home"></i></div>
            <h5 class="fw-bold mb-0 text-white">NeighborHood</h5>
          </div>
          <p class="small text-secondary-custom mb-3">
            Centralized Neighborhood Rental & Accommodation Platform helping students, working professionals, and families easily find, compare, and book suitable places to stay.
          </p>
          <div class="d-flex gap-3">
            <a href="#" class="text-white-50"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white-50"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white-50"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white-50"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>

        <div class="col-6 col-md-3 col-lg-2">
          <h6 class="fw-bold text-white mb-3">Top Cities</h6>
          <a href="#" onclick="setCityAndScroll('Bangalore')">Bangalore PGs</a>
          <a href="#" onclick="setCityAndScroll('Mumbai')">Mumbai Rooms</a>
          <a href="#" onclick="setCityAndScroll('Delhi')">Delhi Hostels</a>
          <a href="#" onclick="setCityAndScroll('Pune')">Pune Flats</a>
          <a href="#" onclick="setCityAndScroll('Hyderabad')">Hyderabad PGs</a>
        </div>

        <div class="col-6 col-md-3 col-lg-2">
          <h6 class="fw-bold text-white mb-3">Categories</h6>
          <a href="#categories">Paying Guest (PG)</a>
          <a href="#categories">Student Hostels</a>
          <a href="#categories">Individual Rooms</a>
          <a href="#categories">Shared Beds</a>
          <a href="#categories">Rental Apartments</a>
        </div>

        <div class="col-6 col-md-3 col-lg-2">
          <h6 class="fw-bold text-white mb-3">Quick Links</h6>
          <a href="login.php">User Login</a>
          <a href="register.php">Owner Registration</a>
          <a href="#how-it-works">How It Works</a>
          <a href="#verified-section">Verification Process</a>
        </div>

        <div class="col-6 col-md-3 col-lg-2">
          <h6 class="fw-bold text-white mb-3">Support</h6>
          <a href="mailto:support@neighborhood.com"><i class="fas fa-envelope me-1"></i> Help Center</a>
          <a href="tel:+919876543210"><i class="fas fa-phone me-1"></i> 1800-NEIGHBOR</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Service</a>
        </div>
      </div>

      <hr class="border-secondary opacity-25" />
      <div class="d-flex flex-wrap justify-content-between align-items-center small py-2">
        <span>© 2026 NeighborHood Accommodation Inc. All rights reserved.</span>
        <span>Designed for Seamless City Relocation</span>
      </div>
    </div>
  </footer>

  <!-- ============================================================
       MODAL 1: PROPERTY DETAILS MODAL (FULL PREVIEW FOR GUESTS)
       ============================================================ -->
  <div class="modal fade" id="propertyDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content modal-content-custom">
        <div class="modal-header border-0 pb-0">
          <div>
            <span id="md-type-badge" class="badge bg-primary mb-1">PG</span>
            <h4 id="md-title" class="fw-bold mb-0">Property Name</h4>
            <p id="md-location" class="text-secondary-custom small mb-0"><i class="fas fa-map-marker-alt text-danger me-1"></i> Location</p>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">
          <div class="row g-4">
            <!-- Gallery & Media Column -->
            <div class="col-lg-7">
              <div id="modal-gallery" class="rounded-4 overflow-hidden mb-3 position-relative" style="height: 320px;">
                <img id="md-main-img" src="" class="w-100 h-100 object-fit-cover" alt="Property Preview" />
                <span id="md-verified-badge" class="badge bg-success position-absolute top-0 start-0 m-3 px-3 py-2"><i class="fas fa-check-circle me-1"></i> Verified Property</span>
              </div>

              <!-- Quick Highlights Grid -->
              <div class="row g-2 text-center mb-4">
                <div class="col-4">
                  <div class="p-2 bg-soft-lavender rounded-3">
                    <span class="extra-small text-secondary-custom d-block">Monthly Rent</span>
                    <strong id="md-rent" class="text-royal-blue">₹0</strong>
                  </div>
                </div>
                <div class="col-4">
                  <div class="p-2 bg-soft-lavender rounded-3">
                    <span class="extra-small text-secondary-custom d-block">Deposit</span>
                    <strong id="md-deposit" class="text-dark">₹0</strong>
                  </div>
                </div>
                <div class="col-4">
                  <div class="p-2 bg-soft-lavender rounded-3">
                    <span class="extra-small text-secondary-custom d-block">Availability</span>
                    <strong id="md-available" class="text-success">Immediate</strong>
                  </div>
                </div>
              </div>

              <h6 class="fw-bold mb-2">Description</h6>
              <p id="md-desc" class="small text-secondary-custom mb-4">Description text...</p>

              <h6 class="fw-bold mb-2">Amenities Included</h6>
              <div id="md-amenities" class="d-flex flex-wrap gap-2 mb-4">
                <!-- Dynamic amenity pills -->
              </div>
            </div>

            <!-- Booking Sidebar & Proximity Column -->
            <div class="col-lg-5">
              <div class="card border rounded-4 p-3 mb-3 bg-slate-canvas">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div>
                    <span class="extra-small text-secondary-custom">Rent Starts From</span>
                    <h3 id="md-side-rent" class="fw-bold text-royal-blue mb-0">₹0 <span class="fs-xs fw-normal text-secondary-custom">/mo</span></h3>
                  </div>
                  <span id="md-rating-pill" class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i> 4.8</span>
                </div>

                <div class="mb-3">
                  <label class="form-label extra-small fw-bold text-secondary-custom">Select Occupancy</label>
                  <select class="form-select form-select-sm">
                    <option>Single Occupancy (Private Room)</option>
                    <option>2-Sharing (Double Occupancy)</option>
                    <option>3-Sharing (Budget Sharing)</option>
                  </select>
                </div>

                <!-- Gated Action CTAs -->
                <div class="d-grid gap-2">
                  <button class="btn btn-nh-primary" onclick="triggerAuthGate('Book Property')"><i class="fas fa-bolt me-1"></i> Book Now</button>
                  <button class="btn btn-nh-outline" onclick="triggerAuthGate('Contact Owner')"><i class="fas fa-phone me-1"></i> Contact Landlord</button>
                  <button class="btn btn-nh-secondary" onclick="triggerAuthGate('Save Favorite')"><i class="far fa-heart me-1"></i> Save to Favorites</button>
                </div>
              </div>

              <!-- Nearby Distances -->
              <div class="card border rounded-4 p-3">
                <h6 class="fw-bold mb-2"><i class="fas fa-route text-bright-indigo me-1"></i> Nearby Proximity</h6>
                <ul id="md-nearby-list" class="list-unstyled extra-small text-secondary-custom mb-0 d-flex flex-column gap-1">
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
          <div class="mx-auto bg-soft-lavender text-bright-indigo rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; font-size: 1.8rem;">
            <i class="fas fa-lock"></i>
          </div>
        </div>
        <h4 class="fw-bold mb-2">Account Required</h4>
        <p class="text-secondary-custom small mb-4">
          To <strong id="auth-action-name" class="text-royal-blue">Book this Property</strong>, save favorites, or message property owners directly, please log in or create a quick free account.
        </p>

        <div class="d-grid gap-2">
          <a href="login.php" class="btn btn-nh-primary"><i class="fas fa-sign-in-alt me-1"></i> Log In to Account</a>
          <a href="register.php" class="btn btn-nh-outline"><i class="fas fa-user-plus me-1"></i> Register New User Account</a>
          <button type="button" class="btn btn-link text-secondary-custom extra-small" data-bs-dismiss="modal">Continue Browsing as Guest</button>
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
        <div class="modal-header">
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
    <span class="small"><i class="fas fa-layer-group text-warning me-1"></i> <span id="compare-count">0</span> Properties Selected to Compare</span>
    <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold" onclick="showCompareModal()">Compare Now</button>
    <button class="btn btn-sm btn-link text-white-50 text-decoration-none p-0" onclick="clearCompare()"><i class="fas fa-times"></i></button>
  </div>

  <!-- ============================================================
       JAVASCRIPT & INTERACTIVE DATA ENGINE
       ============================================================ -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <script>
    // Master Property Dataset (Sample for Guest Discovery Engine)
    const PROPERTIES_DATA = [
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
        amenities: ["Wi-Fi", "3 Time Meals", "AC", "Daily Housekeeping", "Laundry", "CCTV"],
        nearby: ["0.4 km to Forum Mall", "1.2 km to Christ University", "0.8 km to Metro Station"],
        lat: 12.9352, lng: 77.6245,
        desc: "Premium executive PG located in the heart of Koramangala. Includes delicious home-cooked meals, high-speed 200Mbps Wi-Fi, biometric security entry, and daily room cleaning."
      },
      {
        id: 102,
        title: "Serenity Womens Luxury Hostel & PG",
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
        amenities: ["Wi-Fi", "North & South Meals", "24/7 Security", "Biometric Lock", "Geyser"],
        nearby: ["0.6 km to NIFT College", "1.5 km to Silk Board Junction"],
        lat: 12.9121, lng: 77.6445,
        desc: "Safe and ultra-hygienic women's PG in HSR Sector 1. Gated security guard, electronic access cards, spacious cupboards, and terrace garden break area."
      },
      {
        id: 103,
        title: "Greenwood Independent 2BHK Apartment",
        type: "Apartment",
        city: "Bangalore",
        area: "Indiranagar",
        rent: 28000,
        deposit: 80000,
        gender: "unisex",
        rating: 4.7,
        available_beds: "Entire Place",
        verified: true,
        image: "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=600&q=80",
        amenities: ["Covered Parking", "Power Backup", "Modular Kitchen", "Balcony", "Pet Friendly"],
        nearby: ["0.3 km to 100ft Road", "0.5 km to Indiranagar Metro"],
        lat: 12.9784, lng: 77.6408,
        desc: "Spacious semi-furnished 2BHK flat ideal for working employees or small families. Prime Indiranagar location with reserved basement car parking."
      },
      {
        id: 104,
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
        amenities: ["Wi-Fi", "Library Desk", "Meals Included", "Power Backup"],
        nearby: ["0.2 km to Vishwavidyalaya Metro", "0.5 km to Hindu College"],
        lat: 28.6903, lng: 77.2134,
        desc: "Dedicated student hostel near Delhi University. Features quiet study library room, high-speed fiber internet, and nutritious student mess food."
      },
      {
        id: 105,
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
        amenities: ["AC", "Wi-Fi", "Attached Washroom", "Housekeeping"],
        nearby: ["0.4 km to Linking Road", "1.0 km to Bandra Station"],
        lat: 19.0596, lng: 72.8295,
        desc: "Fully furnished air-conditioned private bedroom in a premium Bandra West apartment. Attached modern bathroom and sea breeze views."
      },
      {
        id: 106,
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
        amenities: ["Wi-Fi", "Food", "Laundry", "Parking", "TV Lounge"],
        nearby: ["0.8 km to Symbiosis College", "1.2 km to Phoenix Mall"],
        lat: 18.5679, lng: 73.9143,
        desc: "Ideal PG accommodation for Symbiosis students and IT employees working in Viman Nagar tech parks."
      }
    ];

    let currentCity = "Bangalore";
    let activeCategory = "all";
    let activeView = "grid";
    let compareList = [];
    let leafletMap = null;
    let mapMarkers = [];

    document.addEventListener("DOMContentLoaded", function() {
      filterProperties();
    });

    // Filtering Engine
    function filterProperties() {
      const citySelect = document.getElementById("search-city").value;
      const keyword = document.getElementById("search-keyword").value.toLowerCase();
      const maxBudget = parseInt(document.getElementById("search-budget").value, 10);
      const genderFilter = document.getElementById("gender-filter").value;
      const sortBy = document.getElementById("sort-by").value;

      currentCity = citySelect;
      document.getElementById("selected-nav-city").innerText = citySelect;

      let filtered = PROPERTIES_DATA.filter(p => {
        const matchCity = (p.city === currentCity);
        const matchType = (activeCategory === "all" || p.type === activeCategory);
        const matchBudget = (p.rent <= maxBudget);
        const matchGender = (genderFilter === "all" || p.gender === genderFilter || p.gender === "unisex");
        const matchKeyword = (keyword === "" || 
          p.title.toLowerCase().includes(keyword) || 
          p.area.toLowerCase().includes(keyword) ||
          p.nearby.some(n => n.toLowerCase().includes(keyword)));

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
            <div class="p-4 max-w-md mx-auto bg-soft-lavender rounded-4">
              <i class="fas fa-search-minus text-bright-indigo display-5 mb-3"></i>
              <h5 class="fw-bold">No Accommodations Found</h5>
              <p class="text-secondary-custom small mb-3">Try adjusting your budget slider, gender preference, or area search keyword for ${currentCity}.</p>
              <button class="btn btn-nh-primary btn-sm" onclick="resetFilters()">Reset All Filters</button>
            </div>
          </div>
        `;
        return;
      }

      list.forEach(item => {
        const isCompared = compareList.some(c => c.id === item.id);
        const cardHtml = `
          <div class="col-md-6 col-lg-4">
            <div class="property-card">
              <div class="card-img-wrapper">
                <img src="${item.image}" alt="${item.title}" />
                <div class="card-badge-top">
                  ${item.verified ? '<span class="badge-tag badge-verified"><i class="fas fa-check-circle me-1"></i> Verified</span>' : ''}
                  <span class="badge-tag badge-type">${item.type}</span>
                </div>
                <button class="btn-favorite-card" onclick="triggerAuthGate('Save Favorite')" title="Save Favorite">
                  <i class="far fa-heart"></i>
                </button>
              </div>

              <div class="card-body-custom">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <span class="text-secondary-custom extra-small"><i class="fas fa-location-dot text-danger me-1"></i> ${item.area}, ${item.city}</span>
                  <span class="badge bg-warning text-dark extra-small"><i class="fas fa-star me-1"></i> ${item.rating}</span>
                </div>

                <h6 class="fw-bold mb-2 text-truncate" title="${item.title}">${item.title}</h6>
                
                <div class="d-flex flex-wrap gap-1 mb-3">
                  ${item.amenities.slice(0, 3).map(a => `<span class="amenity-pill"><i class="fas fa-check me-1"></i>${a}</span>`).join('')}
                  ${item.amenities.length > 3 ? `<span class="amenity-pill">+${item.amenities.length - 3} more</span>` : ''}
                </div>

                <div class="small text-secondary-custom mb-3">
                  <i class="fas fa-ruler-combined me-1"></i> ${item.nearby[0] || 'Prime Location'}
                </div>

                <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                  <div>
                    <span class="extra-small text-secondary-custom d-block">Monthly Rent</span>
                    <span class="rent-price-display">₹${item.rent.toLocaleString()} <span class="fs-xs fw-normal text-secondary-custom">/mo</span></span>
                  </div>
                  
                  <div class="d-flex gap-2">
                    <button class="btn btn-sm ${isCompared ? 'btn-success' : 'btn-nh-secondary'}" onclick="toggleCompare(${item.id})">
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

      document.getElementById("md-title").innerText = item.title;
      document.getElementById("md-type-badge").innerText = item.type;
      document.getElementById("md-location").innerText = `${item.area}, ${item.city}`;
      document.getElementById("md-main-img").src = item.image;
      document.getElementById("md-rent").innerText = `₹${item.rent.toLocaleString()}/mo`;
      document.getElementById("md-side-rent").innerText = `₹${item.rent.toLocaleString()}`;
      document.getElementById("md-deposit").innerText = `₹${item.deposit.toLocaleString()}`;
      document.getElementById("md-available").innerText = item.available_beds;
      document.getElementById("md-desc").innerText = item.desc;
      document.getElementById("md-rating-pill").innerHTML = `<i class="fas fa-star me-1"></i> ${item.rating}`;

      // Render amenities
      const amBox = document.getElementById("md-amenities");
      amBox.innerHTML = item.amenities.map(a => `<span class="badge bg-soft-lavender text-royal-blue p-2"><i class="fas fa-check-circle text-success me-1"></i> ${a}</span>`).join('');

      // Render nearby
      const nbBox = document.getElementById("md-nearby-list");
      nbBox.innerHTML = item.nearby.map(n => `<li><i class="fas fa-map-pin text-bright-indigo me-2"></i> ${n}</li>`).join('');

      const modal = new bootstrap.Modal(document.getElementById("propertyDetailModal"));
      modal.show();
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
              <th>Feature</th>
              ${compareList.map(c => `<th>${c.title}<br><span class="badge bg-primary">${c.type}</span></th>`).join('')}
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fw-bold">Monthly Rent</td>
              ${compareList.map(c => `<td class="fw-bold text-royal-blue fs-6">₹${c.rent.toLocaleString()}</td>`).join('')}
            </tr>
            <tr>
              <td class="fw-bold">Security Deposit</td>
              ${compareList.map(c => `<td>₹${c.deposit.toLocaleString()}</td>`).join('')}
            </tr>
            <tr>
              <td class="fw-bold">City & Area</td>
              ${compareList.map(c => `<td>${c.area}, ${c.city}</td>`).join('')}
            </tr>
            <tr>
              <td class="fw-bold">Gender Preference</td>
              ${compareList.map(c => `<td class="text-capitalize">${c.gender.replace('_', ' ')}</td>`).join('')}
            </tr>
            <tr>
              <td class="fw-bold">Rating</td>
              ${compareList.map(c => `<td><span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i> ${c.rating}</span></td>`).join('')}
            </tr>
            <tr>
              <td class="fw-bold">Key Amenities</td>
              ${compareList.map(c => `<td>${c.amenities.join(', ')}</td>`).join('')}
            </tr>
          </tbody>
        </table>
      `;

      wrapper.innerHTML = html;
      const modal = new bootstrap.Modal(document.getElementById("compareModal"));
      modal.show();
    }

    // Category Tabs Filter
    function filterCategory(cat) {
      activeCategory = cat;
      document.querySelectorAll(".category-box").forEach(el => el.classList.remove("active"));
      filterProperties();
    }

    // City Change Helpers
    function setCityAndScroll(cityName) {
      document.getElementById("search-city").value = cityName;
      currentCity = cityName;
      filterProperties();
      document.getElementById("properties").scrollIntoView({ behavior: "smooth" });
    }

    function resetFilters() {
      document.getElementById("search-keyword").value = "";
      document.getElementById("search-budget").value = 25000;
      document.getElementById("budget-val").innerText = "₹25,000";
      document.getElementById("gender-filter").value = "all";
      activeCategory = "all";
      filterProperties();
    }

    // View Switcher (Grid vs Leaflet Map)
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
          attribution: '© OpenStreetMap'
        }).addTo(leafletMap);
      }
      renderMapMarkers(PROPERTIES_DATA.filter(p => p.city === currentCity));
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
          <div style="font-family: 'Inter', sans-serif;">
            <strong style="color: #4338CA;">${p.title}</strong><br>
            <span style="font-weight: 700; color: #111827;">₹${p.rent.toLocaleString()}/mo</span> (${p.type})<br>
            <small style="color: #6B7280;">${p.area}</small>
          </div>
        `);
        mapMarkers.push(marker);
        bounds.push([p.lat, p.lng]);
      });

      if (bounds.length > 0) {
        leafletMap.fitBounds(bounds, { padding: [40, 40] });
      }
    }
  </script>
</body>

</html>