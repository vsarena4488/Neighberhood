<?php
require_once __DIR__ . '/functions.php';

if (!isset($currentPage)) {
  $currentPage = basename($_SERVER['PHP_SELF'], '.php');
}

if (!isset($pageTitle)) {
  $pageTitle = 'NeighborNest · Property Owner Management Portal';
}

$owner = $_SESSION['owner'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="NeighborNest Property Owner Management Portal - List accommodations, manage booking requests, track earnings, and converse directly with student tenants." />
  <meta name="theme-color" content="#4F46E5" />

  <!-- Google Fonts: Inter & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

  <!-- Font Awesome 6 Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Leaflet CSS for Maps -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <style>
    /* ===================================================
       MASTER RESPONSIVE DESIGN SYSTEM - NEIGHBORNEST OWNER
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
      --nh-bottombar-height: 64px;

      --nh-radius-xl: 20px;
      --nh-radius-lg: 16px;
      --nh-radius-md: 12px;
      --nh-radius-sm: 8px;
      --nh-radius-pill: 50px;

      --nh-shadow-subtle: 0 4px 15px rgba(67, 56, 202, 0.04);
      --nh-shadow-card: 0 8px 24px -4px rgba(67, 56, 202, 0.08), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
      --nh-shadow-hover: 0 16px 32px -6px rgba(67, 56, 202, 0.16);
      --nh-transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      -webkit-tap-highlight-color: transparent;
    }

    html,
    body {
      width: 100%;
      min-height: 100%;
      overflow-x: hidden;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background-color: var(--nh-bg-light);
      color: var(--nh-dark-text);
      line-height: 1.55;
      -webkit-font-smoothing: antialiased;
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

    /* Core Layout */
    .app-layout {
      display: flex;
      min-height: 100vh;
      width: 100%;
      position: relative;
    }

    .main-wrapper {
      flex: 1;
      margin-left: var(--nh-sidebar-width);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      min-width: 0;
      transition: var(--nh-transition);
      background-color: var(--nh-bg-light);
    }

    .page-content {
      flex: 1;
      padding: 1.75rem 2rem 3rem 2rem;
      width: 100%;
      max-width: 100%;
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
      transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
    }

    .sidebar-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(15, 23, 42, 0.5);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      z-index: 1045;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .sidebar-overlay.show {
      display: block;
      opacity: 1;
    }

    .sidebar-brand-box {
      height: var(--nh-topbar-height);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1.25rem;
      border-bottom: 1px solid var(--nh-border);
      text-decoration: none;
    }

    .sidebar-brand-content {
      display: flex;
      align-items: center;
      gap: 0.65rem;
      text-decoration: none;
    }

    .sidebar-brand-icon {
      width: 38px;
      height: 38px;
      background: var(--nh-gradient-primary);
      color: #fff;
      border-radius: 10px;
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
      font-size: 1.22rem;
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

    .sidebar-close-btn {
      display: none;
      background: transparent;
      border: none;
      color: var(--nh-secondary-text);
      font-size: 1.25rem;
      cursor: pointer;
      padding: 0.4rem;
      border-radius: 8px;
    }

    .sidebar-close-btn:hover {
      background: var(--nh-bg-light);
      color: var(--nh-dark-text);
    }

    .sidebar-menu-wrapper {
      flex: 1;
      overflow-y: auto;
      padding: 1.25rem 0.9rem;
    }

    .sidebar-nav-item {
      display: flex;
      align-items: center;
      padding: 0.68rem 0.85rem;
      font-size: 0.88rem;
      font-weight: 600;
      color: var(--nh-dark-text);
      border-radius: var(--nh-radius-md);
      text-decoration: none;
      transition: var(--nh-transition);
      margin-bottom: 0.25rem;
      position: relative;
      min-height: 44px;
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
      padding: 0.18rem 0.55rem;
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
      gap: 1rem;
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 1040;
    }

    .topbar-left,
    .topbar-actions {
      min-width: 0;
    }

    .topbar-left {
      flex: 1 1 auto;
    }

    .topbar-actions {
      flex: 0 0 auto;
      justify-content: flex-end;
      white-space: nowrap;
    }

    .topbar-search-box {
      width: min(380px, 100%);
      max-width: 100%;
      position: relative;
    }

    .topbar-search-box input {
      width: 100%;
      min-width: 0;
      height: 42px;
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
      width: 42px;
      height: 42px;
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
      flex-shrink: 0;
    }

    .topbar-action-btn:hover {
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
      border-color: var(--nh-lavender-border);
    }

    .topbar-dot-badge {
      position: absolute;
      top: 4px;
      right: 4px;
      width: 9px;
      height: 9px;
      background: var(--nh-rose);
      border: 2px solid #fff;
      border-radius: 50%;
    }

    .topbar-user-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--nh-lavender-border);
      flex-shrink: 0;
    }

    .topbar-profile {
      flex: 0 0 auto;
      min-height: 42px;
      white-space: nowrap;
    }
    /* Mobile Bottom Navigation */
    .mobile-bottom-nav {
      display: none;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      height: var(--nh-bottombar-height);
      background: #FFFFFF;
      border-top: 1px solid var(--nh-border);
      z-index: 1030;
      box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.06);
    }

    .mobile-bottom-nav-inner {
      display: flex;
      align-items: center;
      justify-content: space-around;
      height: 100%;
      padding: 0 0.5rem;
    }

    .mobile-nav-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      flex: 1;
      height: 100%;
      text-decoration: none;
      color: var(--nh-secondary-text);
      font-size: 0.68rem;
      font-weight: 600;
      position: relative;
      transition: var(--nh-transition);
    }

    .mobile-nav-item i {
      font-size: 1.15rem;
      margin-bottom: 2px;
      transition: var(--nh-transition);
    }

    .mobile-nav-item.active {
      color: var(--nh-bright-indigo);
    }

    .mobile-nav-item.active i {
      transform: translateY(-2px);
    }

    /* Common Card Styles */
    .stat-card {
      background: var(--nh-white);
      border: 1px solid var(--nh-border);
      border-radius: var(--nh-radius-lg);
      padding: 1rem 1.15rem;
      box-shadow: var(--nh-shadow-subtle);
      transition: var(--nh-transition);
      height: 100%;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      overflow: hidden;
      min-width: 0;
    }

    .stat-card:hover {
      transform: translateY(-3px);
      box-shadow: var(--nh-shadow-card);
      border-color: var(--nh-lavender-border);
    }

    .stat-icon-wrapper {
      width: 44px;
      height: 44px;
      border-radius: var(--nh-radius-md);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
      flex-shrink: 0;
    }

    .stat-value {
      font-size: clamp(1.1rem, 1.8vw, 1.5rem);
      font-weight: 800;
      line-height: 1.2;
      letter-spacing: -0.02em;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    @media (max-width: 575.98px) {
      .stat-card {
        padding: 0.85rem 0.75rem;
        gap: 0.5rem;
      }
      .stat-icon-wrapper {
        width: 36px;
        height: 36px;
        font-size: 1rem;
      }
      .stat-value {
        font-size: 1.1rem;
      }
    }

    .btn-nh-primary {
      background: var(--nh-gradient-primary);
      color: #FFFFFF !important;
      border: none;
      padding: 0.55rem 1.35rem;
      border-radius: var(--nh-radius-pill);
      font-weight: 600;
      font-size: 0.85rem;
      box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
      transition: var(--nh-transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.45rem;
      cursor: pointer;
      text-decoration: none;
      white-space: nowrap;
      min-height: 40px;
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
      font-size: 0.85rem;
      transition: var(--nh-transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.45rem;
      cursor: pointer;
      text-decoration: none;
      white-space: nowrap;
      min-height: 40px;
    }

    .btn-nh-outline:hover {
      background: var(--nh-soft-lavender);
      transform: translateY(-2px);
      color: var(--nh-royal-blue) !important;
    }

    .btn-action-sm {
      padding: 0.45rem 1.1rem;
      font-size: 0.82rem;
      font-weight: 600;
      border-radius: 50px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.45rem;
      transition: var(--nh-transition);
      text-decoration: none;
      white-space: nowrap;
      cursor: pointer;
      line-height: 1.4;
    }

    .btn-action-sm:hover {
      transform: translateY(-2px);
    }

    .btn-action-sm.btn-light-custom {
      background: #F8FAFC;
      border: 1px solid var(--nh-border);
      color: var(--nh-dark-text);
    }

    .btn-action-sm.btn-light-custom:hover {
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
      border-color: var(--nh-lavender-border);
    }

    .btn-action-sm.btn-warning-custom {
      background: #FFFBEB;
      border: 1px solid #FDE68A;
      color: #B45309;
    }

    .btn-action-sm.btn-warning-custom:hover {
      background: #FEF3C7;
      border-color: #F59E0B;
      color: #92400E;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
    }

    .btn-action-sm.btn-danger-custom {
      background: #FEF2F2;
      border: 1px solid #FECACA;
      color: #DC2626;
    }

    .btn-action-sm.btn-danger-custom:hover {
      background: #FEE2E2;
      border-color: #EF4444;
      color: #991B1B;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

    /* ===================================================
       PROPERTY CARD DESIGN SYSTEM (PIXEL-PERFECT MATCH)
       =================================================== */
    .property-card {
      width: 100%;
      background: #FFFFFF;
      border-radius: 24px;
      border: 1px solid #E2E8F0;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
      overflow: hidden;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      display: flex;
      flex-direction: column;
      height: 100%;
      position: relative;
    }

    .property-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px -12px rgba(67, 56, 202, 0.16);
      border-color: #CBD5E1;
    }

    .card-image-wrapper {
      position: relative;
      height: 220px;
      overflow: hidden;
      background: #E2E8F0;
      flex-shrink: 0;
    }

    .card-image-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .property-card:hover .card-image-wrapper img {
      transform: scale(1.05);
    }

    .card-badges {
      position: absolute;
      top: 14px;
      left: 14px;
      z-index: 2;
      display: flex;
      flex-direction: column;
      gap: 6px;
      align-items: flex-start;
    }

    .badge-tag {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      line-height: 1.2;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .badge-verified {
      background: #10B981;
      color: #FFFFFF;
      backdrop-filter: blur(4px);
    }

    .badge-type {
      background: #4F46E5;
      color: #FFFFFF;
      backdrop-filter: blur(4px);
    }

    .badge-gender {
      background: #1E293B;
      color: #FFFFFF;
      backdrop-filter: blur(4px);
    }

    .badge-status {
      background: #1E293B;
      color: #FFFFFF;
      backdrop-filter: blur(4px);
    }

    .badge-status.active {
      background: #10B981;
      color: #FFFFFF;
    }

    .badge-status.pending {
      background: #F59E0B;
      color: #FFFFFF;
    }

    .badge-status.inactive {
      background: #64748B;
      color: #FFFFFF;
    }

    .btn-wishlist-circle {
      position: absolute;
      top: 14px;
      right: 14px;
      z-index: 2;
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: #FFFFFF;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
      color: #EF4444;
      font-size: 16px;
      cursor: pointer;
      border: none;
      transition: transform 0.2s ease;
    }

    .btn-wishlist-circle:hover {
      transform: scale(1.1);
    }

    .card-body {
      padding: 20px 20px 22px;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }

    .card-top-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 8px;
    }

    .card-location {
      font-size: 13px;
      font-weight: 600;
      color: #475569;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .card-location i {
      color: #EF4444;
      font-size: 12px;
    }

    .badge-deposit {
      background: #EFF6FF;
      border: 1px solid #BFDBFE;
      color: #1D4ED8;
      font-size: 11px;
      font-weight: 700;
      border-radius: 8px;
      padding: 2px 8px;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    .badge-rating {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      background: #FEF3C7;
      color: #D97706;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 700;
      flex-shrink: 0;
    }

    .badge-rating i {
      color: #F59E0B;
      font-size: 11px;
    }

    .badge-rating .rating-count {
      font-weight: 400;
      color: #94A3B8;
    }

    .card-title {
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
      font-size: 18px;
      font-weight: 800;
      color: #0F172A;
      margin: 8px 0 12px;
      line-height: 1.3;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .card-title a {
      color: #0F172A;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .card-title a:hover {
      color: #3B82F6;
    }

    .card-amenities {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin-bottom: 12px;
    }

    .amenity-pill {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: #EEF2FF;
      color: #4338CA;
      font-size: 12px;
      font-weight: 600;
      padding: 4px 12px;
      border-radius: 20px;
      line-height: 1.4;
    }

    .amenity-pill i {
      font-size: 10px;
      color: #10B981;
    }

    .amenity-pill.more {
      background: #F1F5F9;
      color: #64748B;
    }

    .card-nearby {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      color: #64748B;
      margin-bottom: 14px;
      font-weight: 500;
    }

    .card-nearby i {
      color: #6366F1;
      font-size: 13px;
    }

    .card-footer-row {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      padding-top: 14px;
      border-top: 1px solid #E2E8F0;
      margin-top: auto;
    }

    .card-price {
      display: flex;
      flex-direction: column;
    }

    .price-label {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #94A3B8;
      line-height: 1;
      margin-bottom: 3px;
    }

    .price-amount {
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
      font-size: 26px;
      font-weight: 800;
      color: #1E293B;
      line-height: 1.1;
    }

    .price-amount .price-period {
      font-size: 13px;
      font-weight: 500;
      color: #64748B;
    }

    /* ===================================================
       OWNER PROPERTY CARD DESIGN SYSTEM
       =================================================== */
    .card-metrics {
      display: flex;
      gap: 14px;
      margin-bottom: 12px;
      font-size: 12px;
      color: var(--nh-secondary-text);
      flex-wrap: wrap;
    }

    .card-metrics .metric-item {
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .card-metrics .metric-item i {
      color: var(--nh-bright-indigo);
      font-size: 13px;
    }

    .card-metrics .metric-item strong {
      color: var(--nh-dark-text);
      font-weight: 700;
    }

    .card-pricing {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 10px;
      border-top: 1px solid var(--nh-border);
      margin-bottom: 12px;
    }

    .price-block {
      display: flex;
      flex-direction: column;
    }

    .price-deposit-highlight {
      font-size: 11px;
      font-weight: 700;
      color: #1D4ED8;
      background: #EFF6FF;
      border: 1px solid #BFDBFE;
      padding: 4px 10px;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      box-shadow: 0 1px 3px rgba(29, 78, 216, 0.08);
    }

    .card-actions {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      margin-top: auto;
    }

    .btn-action {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
      padding: 6px 12px;
      border-radius: 30px;
      font-size: 12px;
      font-weight: 600;
      text-decoration: none;
      border: 1px solid transparent;
      transition: var(--nh-transition);
      cursor: pointer;
      white-space: nowrap;
      flex: 1 1 auto;
    }

    .btn-action i {
      font-size: 11px;
    }

    .btn-view {
      background: var(--nh-gradient-primary);
      color: #FFFFFF !important;
      box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .btn-view:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(79, 70, 229, 0.35);
      color: #FFFFFF !important;
    }

    .btn-edit {
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue) !important;
      border-color: var(--nh-soft-lavender);
    }

    .btn-edit:hover {
      background: #DDE3FF;
      border-color: var(--nh-royal-blue);
    }

    .btn-manage {
      background: #FFFFFF;
      color: var(--nh-secondary-text) !important;
      border-color: var(--nh-border);
    }

    .btn-manage:hover {
      border-color: var(--nh-bright-indigo);
      color: var(--nh-bright-indigo) !important;
      background: var(--nh-bg-light);
    }

    .btn-delete {
      background: transparent;
      color: var(--nh-rose) !important;
      border-color: transparent;
    }

    .btn-delete:hover {
      background: #FEF2F2;
      border-color: var(--nh-rose);
    }

    .quick-action-link {
      transition: var(--nh-transition);
      border: 1px solid var(--nh-border);
    }

    .quick-action-link:hover {
      background: var(--nh-soft-lavender) !important;
      border-color: var(--nh-lavender-border) !important;
      transform: translateX(3px);
    }

    .status-pending {
      background: #FEF3C7;
      color: #B45309;
    }

    .status-approved {
      background: #EEF2FF;
      color: #4338CA;
    }

    .status-active {
      background: #DCFCE7;
      color: #15803D;
    }

    .status-completed {
      background: #CCFBF1;
      color: #0F766E;
    }

    .status-cancelled {
      background: #FEE2E2;
      color: #B91C1C;
    }

    .status-draft {
      background: #F3F4F6;
      color: #4B5563;
    }

    .bg-soft-lavender {
      background-color: var(--nh-soft-lavender) !important;
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

    .extra-small {
      font-size: 0.78rem;
    }

    .fs-xs {
      font-size: 0.72rem;
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
      .app-sidebar { transform: translateX(-100%); box-shadow: none; }
      .app-sidebar.show { transform: translateX(0); box-shadow: 0 0 50px rgba(0, 0, 0, 0.35); }
      .sidebar-close-btn { display: block; }
      .main-wrapper { margin-left: 0 !important; }
      .app-topbar { padding: 0 1rem; }
      .topbar-search-box { width: min(220px, 100%); }
      .page-content { padding: 1.25rem 1rem calc(var(--nh-bottombar-height) + 1.5rem) 1rem; }
      .mobile-bottom-nav { display: block; }
    }

    @media (max-width: 575.98px) {
      .app-topbar {
        height: auto;
        min-height: var(--nh-topbar-height);
        padding: 0.75rem;
        gap: 0.75rem;
      }

      .topbar-search-box { display: none !important; }
      .topbar-actions { gap: 0.5rem !important; }
      .topbar-profile { margin-left: 0 !important; }
      .page-content { padding: 1rem 0.75rem calc(var(--nh-bottombar-height) + 1.25rem) 0.75rem; }
    }  </style>
</head>

<body>
  <div class="app-layout">
    <!-- Backdrop overlay for mobile drawer -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>