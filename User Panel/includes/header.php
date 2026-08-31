<?php
require_once __DIR__ . '/functions.php';
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
if (!isset($pageTitle)) {
    $pageTitle = 'NeighborNest · Student & Tenant Accommodation Portal';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="NeighborNest User & Student Accommodation Portal - Find, compare, and manage verified student PGs, hostels, and rental flats." />

  <!-- Google Fonts: Inter & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Leaflet CSS for Map View -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <style>
    /* ===================================================
       MASTER DESIGN SYSTEM - USER PANEL (NEIGHBORNEST)
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
      --nh-rose: #EF4444;
      --nh-teal: #0D9488;
      
      --nh-gradient-primary: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
      --nh-gradient-hero: linear-gradient(180deg, #EEF2FF 0%, #F8FAFC 100%);
      
      --nh-sidebar-width: 260px;
      --nh-topbar-height: 70px;
      
      --nh-radius-xl: 20px;
      --nh-radius-lg: 16px;
      --nh-radius-md: 12px;
      --nh-radius-sm: 8px;
      --nh-radius-pill: 50px;
      
      --nh-shadow-subtle: 0 4px 15px rgba(67, 56, 202, 0.04);
      --nh-shadow-card: 0 8px 24px -4px rgba(67, 56, 202, 0.08), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
      --nh-shadow-hover: 0 16px 32px -6px rgba(67, 56, 202, 0.16);
      --nh-transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
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
      line-height: 1.55;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }

    h1, h2, h3, h4, h5, h6, .heading-font {
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
      font-weight: 700;
      color: var(--nh-dark-text);
      letter-spacing: -0.02em;
    }

    /* Core Layout Setup */
    .app-layout {
      display: flex;
      min-height: 100vh;
      width: 100%;
    }

    .main-wrapper {
      flex: 1;
      margin-left: var(--nh-sidebar-width);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      transition: var(--nh-transition);
      background-color: var(--nh-bg-light);
    }

    .page-content {
      flex: 1;
      padding: 1.75rem 2rem 3rem 2rem;
    }

    /* Sidebar Navigation */
    .app-sidebar {
      width: var(--nh-sidebar-width);
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background: var(--nh-white);
      border-right: 1px solid var(--nh-border);
      display: flex;
      flex-direction: column;
      z-index: 1050;
      transition: var(--nh-transition);
    }

    .sidebar-brand-box {
      height: var(--nh-topbar-height);
      display: flex;
      align-items: center;
      padding: 0 1.5rem;
      border-bottom: 1px solid var(--nh-border);
      gap: 0.65rem;
      text-decoration: none;
    }

    .sidebar-brand-icon {
      width: 36px;
      height: 36px;
      background: var(--nh-gradient-primary);
      color: #fff;
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
      box-shadow: 0 4px 10px rgba(67, 56, 202, 0.25);
      flex-shrink: 0;
    }

    .sidebar-brand-text {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.25rem;
      color: var(--nh-royal-blue);
      line-height: 1.1;
    }

    .sidebar-brand-sub {
      font-size: 0.68rem;
      color: var(--nh-secondary-text);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .sidebar-menu-wrapper {
      flex: 1;
      overflow-y: auto;
      padding: 1.25rem 0.9rem;
    }

    .sidebar-heading {
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #94A3B8;
      padding: 0.5rem 0.75rem 0.35rem 0.75rem;
    }

    .sidebar-nav-item {
      display: flex;
      align-items: center;
      padding: 0.65rem 0.85rem;
      font-size: 0.88rem;
      font-weight: 600;
      color: var(--nh-dark-text);
      border-radius: var(--nh-radius-md);
      text-decoration: none;
      transition: var(--nh-transition);
      margin-bottom: 0.25rem;
      position: relative;
    }

    .sidebar-nav-item i {
      width: 24px;
      font-size: 1.05rem;
      color: var(--nh-secondary-text);
      transition: var(--nh-transition);
      margin-right: 0.65rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .sidebar-nav-item:hover {
      background: var(--nh-bg-light);
      color: var(--nh-royal-blue);
    }

    .sidebar-nav-item:hover i {
      color: var(--nh-bright-indigo);
    }

    .sidebar-nav-item.active {
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
    }

    .sidebar-nav-item.active i {
      color: var(--nh-bright-indigo);
    }

    .sidebar-nav-item.active::before {
      content: '';
      position: absolute;
      left: 0;
      top: 15%;
      height: 70%;
      width: 3.5px;
      background: var(--nh-bright-indigo);
      border-radius: 0 4px 4px 0;
    }

    .sidebar-badge {
      font-size: 0.72rem;
      font-weight: 700;
      padding: 0.15rem 0.55rem;
      border-radius: var(--nh-radius-pill);
      margin-left: auto;
    }

    .sidebar-badge-primary {
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
    }

    .sidebar-badge-danger {
      background: #FEE2E2;
      color: var(--nh-rose);
    }

    /* Top Navbar */
    .app-topbar {
      height: var(--nh-topbar-height);
      background: var(--nh-white);
      border-bottom: 1px solid var(--nh-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 1040;
    }

    .topbar-search-box {
      width: 380px;
      position: relative;
    }

    .topbar-search-box input {
      width: 100%;
      height: 40px;
      background: var(--nh-bg-light);
      border: 1px solid var(--nh-border);
      border-radius: var(--nh-radius-pill);
      padding: 0 1rem 0 2.5rem;
      font-size: 0.85rem;
      transition: var(--nh-transition);
    }

    .topbar-search-box input:focus {
      background: #fff;
      border-color: var(--nh-bright-indigo);
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
      outline: none;
    }

    .topbar-search-box i {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--nh-secondary-text);
      font-size: 0.85rem;
    }

    .topbar-action-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--nh-bg-light);
      border: 1px solid var(--nh-border);
      color: var(--nh-dark-text);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      position: relative;
      cursor: pointer;
      text-decoration: none;
      transition: var(--nh-transition);
    }

    .topbar-action-btn:hover {
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
      border-color: var(--nh-lavender-border);
    }

    .topbar-dot-badge {
      position: absolute;
      top: 3px;
      right: 3px;
      width: 9px;
      height: 9px;
      background: var(--nh-rose);
      border: 2px solid #fff;
      border-radius: 50%;
    }

    .topbar-user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--nh-lavender-border);
    }

    /* Standard Cards & Elements */
    .stat-card {
      background: var(--nh-white);
      border: 1px solid var(--nh-border);
      border-radius: var(--nh-radius-lg);
      padding: 1.35rem 1.4rem;
      box-shadow: var(--nh-shadow-subtle);
      transition: var(--nh-transition);
      height: 100%;
      display: flex;
      align-items: center;
      gap: 1.1rem;
    }

    .stat-card:hover {
      transform: translateY(-3px);
      box-shadow: var(--nh-shadow-card);
      border-color: var(--nh-lavender-border);
    }

    .stat-icon-wrapper {
      width: 52px;
      height: 52px;
      border-radius: var(--nh-radius-md);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.35rem;
      flex-shrink: 0;
    }

    .btn-nh-primary {
      background: var(--nh-gradient-primary);
      color: #FFFFFF !important;
      border: none;
      padding: 0.55rem 1.35rem;
      border-radius: var(--nh-radius-pill);
      font-weight: 600;
      font-size: 0.88rem;
      box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
      transition: var(--nh-transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.45rem;
      cursor: pointer;
      text-decoration: none;
      white-space: nowrap;
    }

    .btn-nh-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 20px rgba(79, 70, 229, 0.45);
      color: #FFFFFF !important;
    }

    .btn-nh-outline {
      background: transparent;
      color: var(--nh-royal-blue) !important;
      border: 1.5px solid var(--nh-bright-indigo);
      padding: 0.5rem 1.25rem;
      border-radius: var(--nh-radius-pill);
      font-weight: 600;
      font-size: 0.88rem;
      transition: var(--nh-transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.45rem;
      cursor: pointer;
      text-decoration: none;
      white-space: nowrap;
    }

    .btn-nh-outline:hover {
      background: var(--nh-soft-lavender);
      transform: translateY(-2px);
      color: var(--nh-royal-blue) !important;
    }

    /* Property Card Layout */
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
      transform: translateY(-4px);
      box-shadow: var(--nh-shadow-hover);
      border-color: var(--nh-lavender-border);
    }
    .card-img-wrapper {
      position: relative;
      height: 195px;
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
      transform: scale(1.04);
    }

    .badge-status {
      padding: 0.28rem 0.75rem;
      border-radius: var(--nh-radius-pill);
      font-size: 0.72rem;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      letter-spacing: 0.02em;
    }
    .status-pending { background: #FEF3C7; color: #B45309; }
    .status-approved { background: #EEF2FF; color: #4338CA; }
    .status-active { background: #DCFCE7; color: #15803D; }
    .status-completed { background: #CCFBF1; color: #0F766E; }
    .status-cancelled { background: #FEE2E2; color: #B91C1C; }

    /* Custom Utilities */
    .bg-soft-lavender { background-color: var(--nh-soft-lavender) !important; }
    .text-royal-blue { color: var(--nh-royal-blue) !important; }
    .text-bright-indigo { color: var(--nh-bright-indigo) !important; }
    .text-secondary-custom { color: var(--nh-secondary-text) !important; }
    .extra-small { font-size: 0.78rem; }
    .fs-xs { font-size: 0.72rem; }

    /* Mobile Responsive */
    @media (max-width: 991px) {
      .app-sidebar {
        transform: translateX(-100%);
      }
      .app-sidebar.show {
        transform: translateX(0);
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.25);
      }
      .main-wrapper {
        margin-left: 0;
      }
      .topbar-search-box {
        width: 240px;
      }
      .page-content {
        padding: 1.25rem 1rem 2.5rem 1rem;
      }
    }
  </style>
</head>

<body>
  <div class="app-layout">
