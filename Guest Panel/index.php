<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NeighborNest · Guest Panel</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

  <!-- Font Awesome 6 (free) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    /* ===================================================
       MASTER DESIGN SYSTEM (premium real estate SaaS)
       =================================================== */
    :root {
      --nn-primary: #1E3A5F;
      --nn-primary-light: #4F46E5;
      --nn-gradient: linear-gradient(135deg, #1E3A5F 0%, #4F46E5 100%);
      --nn-lavender: #EEF2FF;
      --nn-success: #10B981;
      --nn-amber: #F59E0B;
      --nn-white: #FFFFFF;
      --nn-bg-light: #F8FAFC;
      --nn-dark: #0F172A;
      --nn-text-primary: #1E293B;
      --nn-text-secondary: #64748B;
      --nn-border: #E2E8F0;
      --nn-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
      --nn-shadow-hover: 0 24px 72px rgba(0, 0, 0, 0.12);
      --nn-radius: 20px;
      --nn-radius-sm: 12px;
      --nn-transition: 0.25s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--nn-white);
      color: var(--nn-text-primary);
      line-height: 1.6;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }

    html {
      scroll-behavior: smooth;
    }

    section[id],
    footer[id] {
      scroll-margin-top: 90px;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    .heading-font {
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
      font-weight: 700;
      letter-spacing: -0.02em;
    }

    .text-secondary-custom {
      color: var(--nn-text-secondary);
    }

    .bg-lavender {
      background-color: var(--nn-lavender);
    }

    .bg-dark-section {
      background-color: var(--nn-dark);
    }

    /* ----- buttons & CTAs ----- */
    .btn-nn-primary {
      background: var(--nn-gradient);
      color: #fff;
      border: none;
      padding: 0.7rem 2rem;
      border-radius: 60px;
      font-weight: 600;
      font-size: 0.95rem;
      transition: var(--nn-transition);
      box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);
    }

    .btn-nn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 16px 40px rgba(79, 70, 229, 0.35);
      color: #fff;
      background: var(--nn-gradient);
    }

    .btn-nn-outline {
      background: transparent;
      border: 1.5px solid var(--nn-primary-light);
      color: var(--nn-primary-light);
      padding: 0.7rem 2rem;
      border-radius: 60px;
      font-weight: 600;
      font-size: 0.95rem;
      transition: var(--nn-transition);
    }

    .btn-nn-outline:hover {
      background: var(--nn-primary-light);
      color: #fff;
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(79, 70, 229, 0.15);
    }

    /* ----- glass / cards ----- */
    .glass-panel {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.4);
      border-radius: var(--nn-radius);
      box-shadow: var(--nn-shadow);
    }

    .card-premium {
      background: var(--nn-white);
      border: none;
      border-radius: var(--nn-radius);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
      transition: var(--nn-transition);
      overflow: hidden;
      height: 100%;
    }

    .card-premium:hover {
      transform: translateY(-8px);
      box-shadow: var(--nn-shadow-hover);
    }

    .card-premium .card-img-top {
      height: 200px;
      object-fit: cover;
      transition: var(--nn-transition);
    }

    .card-premium:hover .card-img-top {
      transform: scale(1.02);
    }

    /* ----- top bar & nav ----- */
    .top-bar {
      background: var(--nn-bg-light);
      font-size: 0.8rem;
      padding: 6px 0;
      border-bottom: 1px solid var(--nn-border);
      color: var(--nn-text-secondary);
    }

    .top-bar a {
      color: var(--nn-text-secondary);
      text-decoration: none;
      margin-right: 1.2rem;
      transition: var(--nn-transition);
    }

    .top-bar a:hover {
      color: var(--nn-primary-light);
    }

    .top-bar .social-icon {
      margin-left: 0.75rem;
      font-size: 0.9rem;
    }

    .navbar-nn {
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(226, 232, 240, 0.4);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.02);
      padding: 0.7rem 0;
    }

    .navbar-nn .navbar-brand {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.6rem;
      color: var(--nn-primary);
      letter-spacing: -0.5px;
    }

    .navbar-nn .navbar-brand i {
      color: var(--nn-primary-light);
      margin-right: 6px;
    }

    .navbar-nn .navbar-toggler {
      border: 1px solid rgba(30, 58, 95, 0.16);
      border-radius: 12px;
    }

    .navbar-nn .navbar-toggler-icon {
      width: 1.4rem;
      height: 1.4rem;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(30,58,95,0.85)' stroke-width='2' stroke-linecap='round' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    .navbar-nn .nav-link {
      font-weight: 500;
      color: var(--nn-text-primary);
      padding: 0.5rem 1rem;
      border-radius: 40px;
      transition: var(--nn-transition);
      font-size: 0.9rem;
    }

    .navbar-nn .nav-link:hover,
    .navbar-nn .nav-link.active {
      color: var(--nn-primary-light);
      background: var(--nn-lavender);
    }

    /* ----- hero split ----- */
    .hero-section {
      padding: 60px 0 80px 0;
      background: var(--nn-white);
      position: relative;
    }

    .hero-search {
      gap: 0.75rem;
    }

    .hero-search button {
      min-width: 140px;
    }

    .top-bar a {
      margin-right: 1.35rem;
    }

    .section-header {
      margin-bottom: 3rem;
      padding: 0 0.25rem;
    }

    .section-header h2 {
      margin-bottom: 0.5rem;
    }

    .card-premium .card-body {
      padding: 1.8rem;
    }

    .category-card {
      padding: 2rem 1.4rem;
    }

    .event-card .event-body {
      padding: 1.6rem;
    }

    .testimonial-card {
      padding: 2.4rem;
    }

    .newsletter-wrap {
      padding: 3.5rem 2.5rem;
    }

    .newsletter-wrap .input-group {
      gap: 0.75rem;
      padding: 6px;
    }

    .footer-nn {
      padding: 4rem 0 2.5rem;
    }

    .hero-left h1 {
      font-size: 3.8rem;
      line-height: 1.1;
      font-weight: 800;
      color: var(--nn-text-primary);
      letter-spacing: -0.03em;
    }

    .hero-left h1 span {
      background: var(--nn-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-left .lead {
      font-size: 1.15rem;
      color: var(--nn-text-secondary);
      max-width: 90%;
    }

    .trust-badge {
      display: inline-block;
      background: rgba(16, 185, 129, 0.12);
      color: var(--nn-success);
      padding: 0.3rem 1.2rem;
      border-radius: 60px;
      font-size: 0.8rem;
      font-weight: 600;
      letter-spacing: 0.3px;
    }

    .hero-search {
      background: var(--nn-white);
      border-radius: 80px;
      padding: 6px 6px 6px 20px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
      border: 1px solid var(--nn-border);
      transition: var(--nn-transition);
      max-width: 100%;
    }

    .hero-search:focus-within {
      border-color: var(--nn-primary-light);
      box-shadow: 0 12px 48px rgba(79, 70, 229, 0.12);
    }

    .hero-search input {
      border: none;
      background: transparent;
      padding: 12px 0;
      font-size: 0.95rem;
      width: 100%;
      outline: none;
      font-weight: 400;
    }

    .hero-search input::placeholder {
      color: var(--nn-text-secondary);
      opacity: 0.7;
    }

    .hero-search button {
      border: none;
      background: var(--nn-gradient);
      color: #fff;
      padding: 10px 28px;
      border-radius: 60px;
      font-weight: 600;
      font-size: 0.95rem;
      transition: var(--nn-transition);
      white-space: nowrap;
    }

    .hero-search button:hover {
      transform: scale(1.02);
      box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);
    }

    .hero-avatars img {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 3px solid var(--nn-white);
      margin-right: -10px;
      object-fit: cover;
    }

    .hero-avatars .more-badge {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: var(--nn-lavender);
      color: var(--nn-primary-light);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 0.75rem;
      border: 3px solid var(--nn-white);
    }

    .hero-right {
      position: relative;
    }

    .hero-right .main-img {
      border-radius: var(--nn-radius);
      box-shadow: var(--nn-shadow-hover);
      width: 100%;
      height: 460px;
      object-fit: cover;
    }

    .floating-card {
      position: absolute;
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border-radius: var(--nn-radius-sm);
      padding: 1.2rem 1.6rem;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.6);
      max-width: 220px;
    }

    .floating-card.top-right {
      top: 20px;
      right: -10px;
    }

    .floating-card.bottom-left {
      bottom: 30px;
      left: -10px;
    }

    .floating-card .label {
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--nn-text-secondary);
      font-weight: 600;
    }

    .floating-card .value {
      font-weight: 700;
      font-size: 1.1rem;
      color: var(--nn-text-primary);
    }

    .floating-card .rating i {
      color: var(--nn-amber);
      font-size: 0.8rem;
    }

    /* section headers */
    .section-header {
      margin-bottom: 3rem;
    }

    .section-header h2 {
      font-size: 2.6rem;
      font-weight: 800;
      letter-spacing: -0.02em;
    }

    .section-header .view-all {
      font-weight: 600;
      color: var(--nn-primary-light);
      text-decoration: none;
      border-bottom: 2px solid transparent;
      transition: var(--nn-transition);
    }

    .section-header .view-all:hover {
      border-bottom-color: var(--nn-primary-light);
    }

    /* category cards */
    .category-card {
      background: var(--nn-white);
      border-radius: var(--nn-radius);
      padding: 1.8rem 1.2rem;
      text-align: center;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
      border: 1px solid var(--nn-border);
      transition: var(--nn-transition);
      height: 100%;
    }

    .category-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--nn-shadow);
      border-color: var(--nn-lavender);
    }

    .category-card .icon-wrap {
      width: 64px;
      height: 64px;
      background: var(--nn-lavender);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 0.75rem;
      font-size: 1.8rem;
      color: var(--nn-primary-light);
      transition: var(--nn-transition);
    }

    .category-card:hover .icon-wrap {
      transform: scale(1.05);
      background: #dde3ff;
    }

    .category-card h6 {
      font-weight: 700;
      font-size: 1rem;
    }

    .category-card .count {
      font-size: 0.8rem;
      color: var(--nn-text-secondary);
    }

    /* stats */
    .stat-number {
      font-size: 3rem;
      font-weight: 800;
      color: var(--nn-primary);
      line-height: 1.1;
    }

    .stat-label {
      color: var(--nn-text-secondary);
      font-weight: 500;
      font-size: 0.95rem;
    }

    /* service chip */
    .service-chip {
      background: var(--nn-white);
      border: 1px solid var(--nn-border);
      border-radius: 60px;
      padding: 0.6rem 1.2rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 500;
      font-size: 0.85rem;
      transition: var(--nn-transition);
      color: var(--nn-text-primary);
      text-decoration: none;
    }

    .service-chip:hover {
      background: var(--nn-lavender);
      border-color: var(--nn-primary-light);
      transform: translateY(-2px);
      color: var(--nn-primary-light);
    }

    .service-chip i {
      color: var(--nn-primary-light);
      font-size: 1rem;
    }

    /* event card */
    .event-card {
      background: var(--nn-white);
      border-radius: var(--nn-radius);
      overflow: hidden;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
      border: 1px solid var(--nn-border);
      transition: var(--nn-transition);
      height: 100%;
    }

    .event-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--nn-shadow-hover);
    }

    .event-card .event-img {
      height: 140px;
      object-fit: cover;
      width: 100%;
    }

    .event-card .event-body {
      padding: 1.2rem 1.2rem 1.4rem;
    }

    .event-card .event-tag {
      font-size: 0.65rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      background: var(--nn-lavender);
      color: var(--nn-primary-light);
      padding: 0.2rem 0.8rem;
      border-radius: 60px;
      display: inline-block;
    }

    .event-card .event-title {
      font-weight: 700;
      font-size: 1.05rem;
      margin: 0.5rem 0 0.3rem;
    }

    .event-card .event-meta {
      font-size: 0.8rem;
      color: var(--nn-text-secondary);
    }

    .event-card .event-meta i {
      width: 1.2rem;
      color: var(--nn-primary-light);
    }

    /* testimonial */
    .testimonial-card {
      background: var(--nn-white);
      border-radius: var(--nn-radius);
      padding: 2.2rem 2rem;
      box-shadow: var(--nn-shadow);
      border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .testimonial-card .quote {
      font-size: 1.1rem;
      font-style: italic;
      color: var(--nn-text-primary);
      line-height: 1.7;
    }

    .testimonial-card .stars i {
      color: var(--nn-amber);
      font-size: 0.9rem;
    }

    .testimonial-card .avatar {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid var(--nn-white);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    /* newsletter */
    .newsletter-wrap {
      background: var(--nn-gradient);
      border-radius: var(--nn-radius);
      padding: 3.5rem 2.5rem;
      box-shadow: var(--nn-shadow-hover);
      position: relative;
      overflow: hidden;
    }

    .newsletter-wrap::after {
      content: '';
      position: absolute;
      top: -40%;
      right: -10%;
      width: 400px;
      height: 400px;
      background: rgba(255, 255, 255, 0.03);
      border-radius: 50%;
      pointer-events: none;
    }

    .newsletter-wrap h3 {
      color: #fff;
      font-weight: 800;
      font-size: 2rem;
    }

    .newsletter-wrap p {
      color: rgba(255, 255, 255, 0.8);
    }

    .newsletter-wrap .input-group {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 80px;
      padding: 4px;
      backdrop-filter: blur(4px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .newsletter-wrap .input-group input {
      background: transparent;
      border: none;
      padding: 0.8rem 1.5rem;
      color: #fff;
      font-weight: 400;
    }

    .newsletter-wrap .input-group input::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }

    .newsletter-wrap .input-group input:focus {
      outline: none;
      box-shadow: none;
    }

    .newsletter-wrap .input-group button {
      background: var(--nn-white);
      border: none;
      border-radius: 60px;
      padding: 0.6rem 2rem;
      font-weight: 700;
      color: var(--nn-primary);
      transition: var(--nn-transition);
    }

    .newsletter-wrap .input-group button:hover {
      transform: scale(1.02);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    /* footer */
    .footer-nn {
      background: var(--nn-dark);
      padding: 4rem 0 2rem;
      color: rgba(255, 255, 255, 0.7);
    }

    .footer-nn h6 {
      color: #fff;
      font-weight: 700;
      margin-bottom: 1.2rem;
      font-size: 1rem;
    }

    .footer-nn a {
      color: rgba(255, 255, 255, 0.6);
      text-decoration: none;
      display: block;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
      transition: var(--nn-transition);
    }

    .footer-nn a:hover {
      color: #fff;
      transform: translateX(4px);
    }

    .footer-nn .brand-footer {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.6rem;
      color: #fff;
    }

    .footer-nn .brand-footer i {
      color: var(--nn-primary-light);
    }

    .footer-nn .social-circle {
      display: inline-flex;
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.06);
      border-radius: 50%;
      align-items: center;
      justify-content: center;
      color: #fff;
      margin-right: 0.5rem;
      transition: var(--nn-transition);
      text-decoration: none;
      font-size: 1rem;
    }

    .footer-nn .social-circle:hover {
      background: var(--nn-primary-light);
      transform: translateY(-3px);
    }

    /* responsive tweaks */
    @media (max-width: 992px) {
      .hero-left h1 {
        font-size: 2.8rem;
      }

      .hero-right .main-img {
        height: 320px;
      }

      .floating-card {
        display: none;
      }

      .stat-number {
        font-size: 2.2rem;
      }

      .section-header h2 {
        font-size: 2rem;
      }

      .newsletter-wrap {
        padding: 2.5rem 1.5rem;
      }
    }

    @media (max-width: 768px) {
      .top-bar .d-none {
        display: none !important;
      }

      .hero-left h1 {
        font-size: 2.2rem;
      }

      .hero-search {
        border-radius: 30px;
        padding: 6px;
        flex-wrap: wrap;
      }

      .hero-search input {
        padding: 10px 16px;
        font-size: 0.9rem;
      }

      .hero-search button {
        width: 100%;
        border-radius: 30px;
        margin-top: 4px;
      }

      .hero-avatars img {
        width: 36px;
        height: 36px;
      }

      .stat-number {
        font-size: 1.8rem;
      }

      .section-header h2 {
        font-size: 1.8rem;
      }

      .newsletter-wrap .input-group {
        flex-direction: column;
        background: transparent;
        border: none;
      }

      .newsletter-wrap .input-group input {
        background: rgba(255, 255, 255, 0.12);
        border-radius: 60px;
        margin-bottom: 0.5rem;
      }

      .newsletter-wrap .input-group button {
        width: 100%;
      }
    }

    @media (max-width: 576px) {
      .hero-left h1 {
        font-size: 1.8rem;
      }

      .hero-section {
        padding: 30px 0 50px;
      }

      .floating-card {
        display: none;
      }
    }

    /* helper animations */
    .fade-up {
      opacity: 0;
      transform: translateY(30px);
      animation: fadeUp 0.7s ease forwards;
    }

    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .delay-1 {
      animation-delay: 0.1s;
    }

    .delay-2 {
      animation-delay: 0.2s;
    }

    .delay-3 {
      animation-delay: 0.3s;
    }

    .delay-4 {
      animation-delay: 0.4s;
    }
  </style>
</head>

<body>

  <!-- ============================================================
     STICKY NAVIGATION
     ============================================================ -->
  <nav class="navbar navbar-expand-lg navbar-nn sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <i class="fas fa-house-chimney"></i> NeighborNest
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nnNav" aria-controls="nnNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="nnNav">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#neighborhoods">Neighborhoods</a></li>
          <li class="nav-item"><a class="nav-link" href="#properties">Properties</a></li>
          <li class="nav-item"><a class="nav-link" href="#community">Community</a></li>
          <li class="nav-item"><a class="nav-link" href="#events">Events</a></li>
          <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        </ul>
        <div class="d-flex align-items-center gap-2">
          <a href="#" class="btn btn-nn-outline btn-sm px-4">Login</a>
          <a href="#" class="btn btn-nn-primary btn-sm px-4">Sign Up</a>
          <a href="#" class="btn btn-nn-primary btn-sm px-4 d-none d-lg-inline-flex">
            <i class="fas fa-compass me-1"></i> Explore
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- ============================================================
     HERO SECTION (split 50/50)
     ============================================================ -->

  <section id="home" class="hero-section">
    <div class="container">
      <div class="row g-5 align-items-center">
        <!-- LEFT -->
        <div class="col-lg-6 hero-left fade-up">
          <span class="trust-badge mb-3 d-inline-block">
            <i class="fas fa-check-circle me-1"></i> Trusted by 10,000+ Residents
          </span>
          <h1 class="mb-3">Find Your Perfect <br /><span>Neighborhood</span></h1>
          <p class="lead mb-4">Discover homes, schools, parks, and community in one place.</p>

          <!-- search bar -->
          <div class="hero-search d-flex align-items-center mb-4">
            <i class="fas fa-map-pin text-secondary me-2 opacity-50"></i>
            <input type="text" placeholder="Enter location, city, or ZIP" aria-label="Search location" />
            <button class="btn"><i class="fas fa-search me-1"></i> Search</button>
          </div>

          <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
            <a href="#" class="btn btn-nn-primary">Browse Homes</a>
            <a href="#" class="btn btn-nn-outline">Learn More</a>
          </div>

          <!-- social proof -->
          <div class="d-flex align-items-center gap-3 mt-3">
            <div class="hero-avatars d-flex">
              <img src="https://i.pravatar.cc/150?img=1" alt="resident" />
              <img src="https://i.pravatar.cc/150?img=2" alt="resident" />
              <img src="https://i.pravatar.cc/150?img=3" alt="resident" />
              <img src="https://i.pravatar.cc/150?img=4" alt="resident" />
              <span class="more-badge">+2.4k</span>
            </div>
            <div>
              <div class="fw-bold text-dark">2,400+ residents</div>
              <div class="small text-secondary-custom">1,200 homes · 45 schools</div>
            </div>
          </div>
        </div>

        <!-- RIGHT -->
        <div class="col-lg-6 hero-right fade-up delay-1">
          <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&h=500&fit=crop&crop=center" alt="Premium neighborhood" class="main-img" />

          <!-- floating card top right -->
          <div class="floating-card top-right">
            <div class="label"><i class="fas fa-star text-warning me-1"></i> Featured</div>
            <div class="value">The Grand Residence</div>
            <div class="small text-secondary-custom">📍 Manhattan, NYC</div>
            <div class="rating mt-1">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
              <span class="ms-1 small fw-bold">4.9</span>
            </div>
          </div>
          <!-- floating card bottom left -->
          <div class="floating-card bottom-left">
            <div class="label"><i class="fas fa-shield-alt me-1 text-success"></i> Safety</div>
            <div class="value">96/100</div>
            <div class="small text-secondary-custom">🏫 School 8.5 · 🚶 Walk 92</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
     NEIGHBORHOOD CATEGORIES
     ============================================================ -->
  <section id="neighborhoods" class="py-5">
    <div class="container">
      <div class="section-header d-flex flex-wrap justify-content-between align-items-center">
        <div>
          <h2>🌆 Explore Neighborhoods</h2>
          <p class="text-secondary-custom">Discover the perfect community for your lifestyle</p>
        </div>
        <a href="#" class="view-all">View All <i class="fas fa-arrow-right ms-1"></i></a>
      </div>
      <div class="row g-4">
        <div class="col-6 col-md-4 col-lg-2 fade-up delay-1">
          <div class="category-card">
            <div class="icon-wrap"><i class="fas fa-crown"></i></div>
            <h6>Luxury Homes</h6>
            <span class="count">245 listings</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 fade-up delay-2">
          <div class="category-card">
            <div class="icon-wrap"><i class="fas fa-users"></i></div>
            <h6>Family</h6>
            <span class="count">312 listings</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 fade-up delay-3">
          <div class="category-card">
            <div class="icon-wrap"><i class="fas fa-building"></i></div>
            <h6>Apartments</h6>
            <span class="count">189 listings</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 fade-up delay-4">
          <div class="category-card">
            <div class="icon-wrap"><i class="fas fa-city"></i></div>
            <h6>Townhouses</h6>
            <span class="count">156 listings</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 fade-up delay-1">
          <div class="category-card">
            <div class="icon-wrap"><i class="fas fa-graduation-cap"></i></div>
            <h6>School Districts</h6>
            <span class="count">78 listings</span>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 fade-up delay-2">
          <div class="category-card">
            <div class="icon-wrap"><i class="fas fa-tree"></i></div>
            <h6>Parks & Rec</h6>
            <span class="count">67 listings</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
     FEATURED NEIGHBORHOODS
     ============================================================ -->
  <section id="properties" class="py-5 bg-lavender">
    <div class="container">
      <div class="section-header d-flex flex-wrap justify-content-between align-items-center">
        <div>
          <h2>🏡 Featured Neighborhoods</h2>
          <p class="text-secondary-custom">Handpicked communities for your perfect lifestyle</p>
        </div>
        <a href="#" class="view-all">View All <i class="fas fa-arrow-right ms-1"></i></a>
      </div>
      <div class="row g-4">
        <!-- card 1 -->
        <div class="col-md-6 col-lg-4 fade-up delay-1">
          <div class="card-premium">
            <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&h=400&fit=crop" class="card-img-top" alt="Luxury villa" />
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <span class="badge bg-success mb-2">Featured</span>
                <a href="#" class="text-danger"><i class="fas fa-heart"></i></a>
              </div>
              <h5 class="card-title fw-bold">The Grand Residence</h5>
              <p class="text-secondary-custom small"><i class="fas fa-map-pin me-1"></i> Manhattan, NYC</p>
              <p class="fw-bold text-primary fs-5">$850K - $1.2M</p>
              <div class="d-flex gap-3 small mb-2">
                <span><i class="fas fa-bed"></i> 4</span>
                <span><i class="fas fa-bath"></i> 3.5</span>
                <span><i class="fas fa-vector-square"></i> 3,200 sf</span>
              </div>
              <div class="d-flex gap-2 flex-wrap small mb-3">
                <span class="badge bg-light text-dark border">🛡️ Safety 96</span>
                <span class="badge bg-light text-dark border">🏫 School 8.5</span>
                <span class="badge bg-light text-dark border">🚶 Walk 92</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <span class="small"><img src="https://i.pravatar.cc/40?img=5" width="28" height="28" class="rounded-circle me-1" alt="agent" /> Sarah Park</span>
                <a href="#" class="btn btn-nn-outline btn-sm">Explore <i class="fas fa-arrow-right ms-1"></i></a>
              </div>
            </div>
          </div>
        </div>
        <!-- card 2 -->
        <div class="col-md-6 col-lg-4 fade-up delay-2">
          <div class="card-premium">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&h=400&fit=crop" class="card-img-top" alt="Modern home" />
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <span class="badge bg-warning text-dark mb-2">Top Rated</span>
                <a href="#" class="text-danger"><i class="fas fa-heart"></i></a>
              </div>
              <h5 class="card-title fw-bold">Hudson Gardens</h5>
              <p class="text-secondary-custom small"><i class="fas fa-map-pin me-1"></i> Brooklyn, NYC</p>
              <p class="fw-bold text-primary fs-5">$650K - $950K</p>
              <div class="d-flex gap-3 small mb-2">
                <span><i class="fas fa-bed"></i> 3</span>
                <span><i class="fas fa-bath"></i> 2.5</span>
                <span><i class="fas fa-vector-square"></i> 2,800 sf</span>
              </div>
              <div class="d-flex gap-2 flex-wrap small mb-3">
                <span class="badge bg-light text-dark border">🛡️ Safety 92</span>
                <span class="badge bg-light text-dark border">🏫 School 7.8</span>
                <span class="badge bg-light text-dark border">🚶 Walk 88</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <span class="small"><img src="https://i.pravatar.cc/40?img=6" width="28" height="28" class="rounded-circle me-1" alt="agent" /> John Lee</span>
                <a href="#" class="btn btn-nn-outline btn-sm">Explore <i class="fas fa-arrow-right ms-1"></i></a>
              </div>
            </div>
          </div>
        </div>
        <!-- card 3 -->
        <div class="col-md-6 col-lg-4 fade-up delay-3">
          <div class="card-premium">
            <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=600&h=400&fit=crop" class="card-img-top" alt="Park view" />
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <span class="badge bg-danger mb-2">Hot Deal</span>
                <a href="#" class="text-danger"><i class="fas fa-heart"></i></a>
              </div>
              <h5 class="card-title fw-bold">Park Place Residences</h5>
              <p class="text-secondary-custom small"><i class="fas fa-map-pin me-1"></i> Queens, NYC</p>
              <p class="fw-bold text-primary fs-5">$550K - $780K</p>
              <div class="d-flex gap-3 small mb-2">
                <span><i class="fas fa-bed"></i> 3</span>
                <span><i class="fas fa-bath"></i> 2</span>
                <span><i class="fas fa-vector-square"></i> 2,400 sf</span>
              </div>
              <div class="d-flex gap-2 flex-wrap small mb-3">
                <span class="badge bg-light text-dark border">🛡️ Safety 89</span>
                <span class="badge bg-light text-dark border">🏫 School 8.2</span>
                <span class="badge bg-light text-dark border">🚶 Walk 85</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <span class="small"><img src="https://i.pravatar.cc/40?img=7" width="28" height="28" class="rounded-circle me-1" alt="agent" /> Maria Santos</span>
                <a href="#" class="btn btn-nn-outline btn-sm">Explore <i class="fas fa-arrow-right ms-1"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
     WHY CHOOSE US (4 cards)
     ============================================================ -->
  <section id="community" class="py-5">
    <div class="container">
      <div class="section-header text-center">
        <h2>✨ Why Choose Our Community</h2>
        <p class="text-secondary-custom">We make finding your perfect neighborhood simple and secure</p>
      </div>
      <div class="row g-4">
        <div class="col-md-6 col-lg-3 fade-up delay-1">
          <div class="card-premium p-4 text-center">
            <div class="icon-wrap mx-auto" style="width:64px;height:64px;background:var(--nn-lavender);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:var(--nn-primary-light);"><i class="fas fa-shield-alt"></i></div>
            <h5 class="fw-bold mt-3">Safe Neighborhood</h5>
            <p class="text-secondary-custom small">24/7 security and verified communities</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 fade-up delay-2">
          <div class="card-premium p-4 text-center">
            <div class="icon-wrap mx-auto" style="width:64px;height:64px;background:var(--nn-lavender);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:var(--nn-primary-light);"><i class="fas fa-school"></i></div>
            <h5 class="fw-bold mt-3">Excellent Schools</h5>
            <p class="text-secondary-custom small">Top-rated educational institutions</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 fade-up delay-3">
          <div class="card-premium p-4 text-center">
            <div class="icon-wrap mx-auto" style="width:64px;height:64px;background:var(--nn-lavender);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:var(--nn-primary-light);"><i class="fas fa-tree"></i></div>
            <h5 class="fw-bold mt-3">Green Parks</h5>
            <p class="text-secondary-custom small">Beautiful green spaces for everyone</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 fade-up delay-4">
          <div class="card-premium p-4 text-center">
            <div class="icon-wrap mx-auto" style="width:64px;height:64px;background:var(--nn-lavender);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:var(--nn-primary-light);"><i class="fas fa-store"></i></div>
            <h5 class="fw-bold mt-3">Nearby Shopping</h5>
            <p class="text-secondary-custom small">Convenient retail and dining options</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
     COMMUNITY STATISTICS
     ============================================================ -->
  <section class="py-5 bg-lavender">
    <div class="container">
      <div class="row g-4 text-center">
        <div class="col-6 col-md-3 fade-up delay-1">
          <div class="stat-number"><span class="counter" data-target="12400">0</span>+</div>
          <div class="stat-label">Residents</div>
        </div>
        <div class="col-6 col-md-3 fade-up delay-2">
          <div class="stat-number"><span class="counter" data-target="3200">0</span>+</div>
          <div class="stat-label">Homes</div>
        </div>
        <div class="col-6 col-md-3 fade-up delay-3">
          <div class="stat-number"><span class="counter" data-target="245">0</span>+</div>
          <div class="stat-label">Schools</div>
        </div>
        <div class="col-6 col-md-3 fade-up delay-4">
          <div class="stat-number"><span class="counter" data-target="180">0</span>+</div>
          <div class="stat-label">Parks</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
     COMMUNITY SERVICES (chips)
     ============================================================ -->
  <section id="services" class="py-5">
    <div class="container">
      <div class="section-header text-center">
        <h2>🏥 Community Services</h2>
        <p class="text-secondary-custom">Everything you need, right in your neighborhood</p>
      </div>
      <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="#" class="service-chip"><i class="fas fa-hospital"></i> Healthcare</a>
        <a href="#" class="service-chip"><i class="fas fa-graduation-cap"></i> Education</a>
        <a href="#" class="service-chip"><i class="fas fa-shield-alt"></i> Security</a>
        <a href="#" class="service-chip"><i class="fas fa-subway"></i> Transportation</a>
        <a href="#" class="service-chip"><i class="fas fa-bolt"></i> Utilities</a>
        <a href="#" class="service-chip"><i class="fas fa-broom"></i> Cleaning</a>
        <a href="#" class="service-chip"><i class="fas fa-tools"></i> Maintenance</a>
        <a href="#" class="service-chip"><i class="fas fa-ambulance"></i> Emergency</a>
        <a href="#" class="service-chip"><i class="fas fa-landmark"></i> Government</a>
        <a href="#" class="service-chip"><i class="fas fa-book"></i> Public Library</a>
      </div>
    </div>
  </section>

  <!-- ============================================================
     UPCOMING EVENTS
     ============================================================ -->
  <section id="events" class="py-5 bg-lavender">
    <div class="container">
      <div class="section-header d-flex flex-wrap justify-content-between align-items-center">
        <div>
          <h2>📅 Upcoming Events</h2>
          <p class="text-secondary-custom">Connect with your community through local events</p>
        </div>
        <a href="#" class="view-all">View All <i class="fas fa-arrow-right ms-1"></i></a>
      </div>
      <div class="row g-4">
        <div class="col-md-6 col-lg-3 fade-up delay-1">
          <div class="event-card">
            <img src="https://images.unsplash.com/photo-1533105079780-92b9be482077?w=600&h=300&fit=crop" class="event-img" alt="block party" />
            <div class="event-body">
              <span class="event-tag"><i class="fas fa-tag me-1"></i> Free Event</span>
              <h6 class="event-title">Neighborhood Block Party</h6>
              <div class="event-meta"><i class="fas fa-calendar-day"></i> June 15, 2024</div>
              <div class="event-meta"><i class="fas fa-clock"></i> 4:00 PM – 8:00 PM</div>
              <div class="event-meta"><i class="fas fa-map-pin"></i> Central Park</div>
              <a href="#" class="btn btn-nn-primary btn-sm mt-2 w-100">RSVP <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 fade-up delay-2">
          <div class="event-card">
            <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&h=300&fit=crop" class="event-img" alt="workshop" />
            <div class="event-body">
              <span class="event-tag" style="background:#dbeafe;color:#2563eb;"><i class="fas fa-tag me-1"></i> Workshop</span>
              <h6 class="event-title">Smart Home Workshop</h6>
              <div class="event-meta"><i class="fas fa-calendar-day"></i> June 18, 2024</div>
              <div class="event-meta"><i class="fas fa-clock"></i> 2:00 PM – 5:00 PM</div>
              <div class="event-meta"><i class="fas fa-map-pin"></i> Community Hub</div>
              <a href="#" class="btn btn-nn-primary btn-sm mt-2 w-100">RSVP <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 fade-up delay-3">
          <div class="event-card">
            <img src="https://images.unsplash.com/photo-1558002038-1055907df827?w=600&h=300&fit=crop" class="event-img" alt="bbq" />
            <div class="event-body">
              <span class="event-tag" style="background:#fef3c7;color:#d97706;"><i class="fas fa-tag me-1"></i> Social</span>
              <h6 class="event-title">Community BBQ Cookout</h6>
              <div class="event-meta"><i class="fas fa-calendar-day"></i> June 22, 2024</div>
              <div class="event-meta"><i class="fas fa-clock"></i> 6:00 PM – 9:00 PM</div>
              <div class="event-meta"><i class="fas fa-map-pin"></i> Lakefront</div>
              <a href="#" class="btn btn-nn-primary btn-sm mt-2 w-100">RSVP <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 fade-up delay-4">
          <div class="event-card">
            <img src="https://images.unsplash.com/photo-1531058020387-3be344556be6?w=600&h=300&fit=crop" class="event-img" alt="art festival" />
            <div class="event-body">
              <span class="event-tag" style="background:#e0e7ff;color:#4338ca;"><i class="fas fa-tag me-1"></i> Kids</span>
              <h6 class="event-title">Children's Art Festival</h6>
              <div class="event-meta"><i class="fas fa-calendar-day"></i> June 25, 2024</div>
              <div class="event-meta"><i class="fas fa-clock"></i> 10:00 AM - 4:00 PM</div>
              <div class="event-meta"><i class="fas fa-map-pin"></i> Civic Center</div>
              <a href="#" class="btn btn-nn-primary btn-sm mt-2 w-100">RSVP <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
     TESTIMONIALS
     ============================================================ -->
  <section id="about" class="py-5">
    <div class="container">
      <div class="section-header text-center">
        <h2>⭐ What Our Residents Say</h2>
        <p class="text-secondary-custom">Real stories from real neighbors</p>
      </div>
      <div class="row g-4">
        <div class="col-md-4 fade-up delay-1">
          <div class="testimonial-card">
            <div class="stars mb-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> 5.0</div>
            <div class="quote">“NeighborNest helped us find the perfect neighborhood. The school ratings and safety scores gave us confidence.”</div>
            <div class="d-flex align-items-center mt-3">
              <img src="https://i.pravatar.cc/100?img=8" class="avatar me-3" alt="Sarah" />
              <div><strong>Sarah Johnson</strong>
                <div class="small text-secondary-custom">Homeowner, Manhattan</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 fade-up delay-2">
          <div class="testimonial-card">
            <div class="stars mb-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> 5.0</div>
            <div class="quote">“The community events and nearby parks made us feel at home immediately. Highly recommend!”</div>
            <div class="d-flex align-items-center mt-3">
              <img src="https://i.pravatar.cc/100?img=9" class="avatar me-3" alt="Michael" />
              <div><strong>Michael Brown</strong>
                <div class="small text-secondary-custom">Renter, Brooklyn</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 fade-up delay-3">
          <div class="testimonial-card">
            <div class="stars mb-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> 5.0</div>
            <div class="quote">“We moved cross-country and NeighborNest made it stress-free. The agent connections were incredible.”</div>
            <div class="d-flex align-items-center mt-3">
              <img src="https://i.pravatar.cc/100?img=10" class="avatar me-3" alt="Emily" />
              <div><strong>Emily Davis</strong>
                <div class="small text-secondary-custom">Homebuyer, Queens</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
     NEWSLETTER
     ============================================================ -->
  <section class="py-5">
    <div class="container">
      <div class="newsletter-wrap text-center text-md-start">
        <div class="row align-items-center">
          <div class="col-md-7">
            <h3><i class="fas fa-envelope me-2"></i> Subscribe to Our Newsletter</h3>
            <p>Stay updated with new neighborhoods, community events, and exclusive real estate insights.</p>
          </div>
          <div class="col-md-5">
            <div class="input-group">
              <input type="email" class="form-control" placeholder="Enter your email address" aria-label="Email" />
              <button class="btn" type="button">Subscribe</button>
            </div>
            <small class="d-block mt-2 text-white-50"><i class="fas fa-lock me-1"></i> We'll never spam you. Unsubscribe anytime.</small>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
     FOOTER
     ============================================================ -->
  <footer id="contact" class="footer-nn">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="brand-footer"><i class="fas fa-house-chimney"></i> NeighborNest</div>
          <p class="mt-2" style="max-width:260px;">Find. Live. Connect. Better. Your trusted partner in finding the perfect neighborhood.</p>
          <div class="mt-3">
            <a href="#" class="social-circle"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-circle"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-circle"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="social-circle"><i class="fab fa-x-twitter"></i></a>
          </div>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
          <h6>Neighborhoods</h6>
          <a href="#">Luxury Homes</a>
          <a href="#">Apartments</a>
          <a href="#">Townhouses</a>
          <a href="#">Schools</a>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
          <h6>Resources</h6>
          <a href="#">FAQ</a>
          <a href="#">Blog</a>
          <a href="#">Buying Guide</a>
          <a href="#">Renting Guide</a>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
          <h6>Community</h6>
          <a href="#">Events</a>
          <a href="#">Services</a>
          <a href="#">Amenities</a>
          <a href="#">Safety</a>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
          <h6>Support</h6>
          <a href="#">Help Center</a>
          <a href="#">Contact Us</a>
          <a href="#">Privacy</a>
          <a href="#">Terms</a>
        </div>
        <div class="col-md-6 col-lg-1">
          <h6>Contact</h6>
          <a href="#"><i class="fas fa-envelope me-1"></i> info@...</a>
          <a href="#"><i class="fas fa-phone me-1"></i> +1 (800)</a>
          <a href="#"><i class="fas fa-map-pin me-1"></i> NYC, USA</a>
        </div>
      </div>
      <hr class="border-secondary opacity-25 my-4" />
      <div class="d-flex flex-wrap justify-content-between align-items-center small">
        <span>© 2024 NeighborNest. All rights reserved.</span>
        <span>Designed with <i class="fas fa-heart text-danger"></i> for community living</span>
      </div>
    </div>
  </footer>

  <!-- ============================================================
     Bootstrap JS + custom counter
     ============================================================ -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>
  <script>
    (function() {
      'use strict';

      // ---- counter animation ----
      const counters = document.querySelectorAll('.counter');
      let animated = false;

      function animateCounters() {
        counters.forEach(counter => {
          const target = parseInt(counter.getAttribute('data-target'), 10);
          if (isNaN(target)) return;
          const duration = 1800;
          const startTime = performance.now();

          function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            // easeOutExpo
            const eased = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
            const currentVal = Math.floor(eased * target);
            counter.textContent = currentVal.toLocaleString();
            if (progress < 1) {
              requestAnimationFrame(update);
            } else {
              counter.textContent = target.toLocaleString();
            }
          }
          requestAnimationFrame(update);
        });
      }

      // Intersection Observer for counters
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting && !animated) {
            animated = true;
            animateCounters();
          }
        });
      }, {
        threshold: 0.3
      });

      const statsSection = document.querySelector('.bg-lavender .stat-number');
      if (statsSection) {
        observer.observe(statsSection.closest('.row') || statsSection);
      }

      // fallback: if no observer, trigger after 1.2s
      setTimeout(() => {
        if (!animated) {
          animated = true;
          animateCounters();
        }
      }, 1200);

      // ---- smooth hover for floating cards (optional) ----
      console.log('NeighborNest · Guest Panel loaded.');
    })();
  </script>

</body>

</html>