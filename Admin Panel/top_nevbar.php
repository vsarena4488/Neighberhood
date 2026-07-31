<?php
// top_navbar.php - Admin Panel Top Navigation Bar
?>
<header class="top-navbar">
  <div class="navbar-left">
    <button class="toggle-sidebar" id="toggleSidebar" aria-label="Toggle sidebar">
      <i class="fas fa-bars"></i>
    </button>
  </div>

  <div class="navbar-right">
    <button class="icon-btn" aria-label="Notifications">
      <i class="fas fa-bell"></i>
      <span class="badge-dot"></span>
      <span class="badge-count">8</span>
    </button>

    <div class="dropdown">
      <a href="#" class="profile-toggle dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://i.pravatar.cc/80?img=11" alt="Admin" />
        <span class="name">Admin</span>
      </a>

      <ul class="dropdown-menu profile-dropdown-menu" aria-labelledby="profileDropdown">
        <li class="dropdown-header">
          <div class="fw-bold">Admin User</div>
          <div class="small text-muted-custom">admin@neighbornest.com</div>
          <div class="mt-1"><span class="badge bg-primary" style="font-size:0.6rem;">Super Admin</span></div>
        </li>
        <li><hr class="dropdown-divider" /></li>
        <li>
          <a class="dropdown-item" href="#">
            <i class="fas fa-user-shield"></i> My Profile
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="#">
            <i class="fas fa-cog"></i> Settings
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="#">
            <i class="fas fa-question-circle"></i> Help Center
          </a>
        </li>
        <li><hr class="dropdown-divider" /></li>
        <li>
          <a class="dropdown-item logout-item" href="#">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>

<style>
  /* ===================================================
     TOP NAVBAR STYLES (Admin Panel)
     =================================================== */
  :root {
    --nn-primary: #1E3A5F;
    --nn-primary-light: #4F46E5;
    --nn-gradient: linear-gradient(135deg, #1E3A5F 0%, #4F46E5 100%);
    --nn-lavender: #EEF2FF;
    --nn-success: #10B981;
    --nn-amber: #F59E0B;
    --nn-danger: #EF4444;
    --nn-white: #FFFFFF;
    --nn-bg-light: #F8FAFC;
    --nn-text-primary: #1E293B;
    --nn-text-secondary: #64748B;
    --nn-text-muted: #94A3B8;
    --nn-border: #E2E8F0;
    --nn-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    --nn-shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.08);
    --nn-radius-sm: 12px;
    --nn-transition: 0.25s ease;
    --nn-navbar-height: 64px;
    --nn-sidebar-width: 260px;
    --nn-sidebar-collapsed: 72px;
  }

  .top-navbar {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(226, 232, 240, 0.5);
    height: var(--nn-navbar-height);
    padding: 0 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 1040;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.02);
  }

  .top-navbar .navbar-left {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .top-navbar .toggle-sidebar {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: var(--nn-text-secondary);
    padding: 4px 8px;
    border-radius: 8px;
    transition: var(--nn-transition);
    cursor: pointer;
  }

  .top-navbar .toggle-sidebar:hover {
    background: var(--nn-bg-light);
    color: var(--nn-text-primary);
  }

  .top-navbar .breadcrumb-custom {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--nn-text-secondary);
  }

  .top-navbar .breadcrumb-custom .separator {
    color: var(--nn-text-muted);
    font-size: 0.6rem;
  }

  .top-navbar .breadcrumb-custom .current {
    color: var(--nn-text-primary);
    font-weight: 600;
  }

  .top-navbar .breadcrumb-custom .home-link {
    color: var(--nn-primary-light);
    text-decoration: none;
    transition: var(--nn-transition);
  }

  .top-navbar .breadcrumb-custom .home-link:hover {
    color: var(--nn-primary);
  }

  .top-navbar .navbar-center {
    flex: 1;
    display: flex;
    justify-content: center;
    padding: 0 1rem;
  }

  .top-navbar .search-bar {
    display: flex;
    align-items: center;
    background: var(--nn-bg-light);
    border: 1px solid var(--nn-border);
    border-radius: 60px;
    padding: 0.2rem 0.8rem 0.2rem 1.2rem;
    transition: var(--nn-transition);
    max-width: 360px;
    width: 100%;
  }

  .top-navbar .search-bar:focus-within {
    border-color: var(--nn-primary-light);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.08);
    background: var(--nn-white);
  }

  .top-navbar .search-bar input {
    border: none;
    background: transparent;
    padding: 0.4rem 0;
    font-size: 0.8rem;
    width: 100%;
    outline: none;
    color: var(--nn-text-primary);
  }

  .top-navbar .search-bar input::placeholder {
    color: var(--nn-text-muted);
  }

  .top-navbar .search-bar i {
    color: var(--nn-text-muted);
    font-size: 0.8rem;
    margin-right: 6px;
  }

  .top-navbar .navbar-right {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .top-navbar .navbar-right .icon-btn {
    background: none;
    border: none;
    color: var(--nn-text-secondary);
    font-size: 1.1rem;
    padding: 6px 8px;
    border-radius: 8px;
    transition: var(--nn-transition);
    position: relative;
    cursor: pointer;
  }

  .top-navbar .navbar-right .icon-btn:hover {
    background: var(--nn-bg-light);
    color: var(--nn-text-primary);
  }

  .top-navbar .navbar-right .icon-btn .badge-dot {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 8px;
    height: 8px;
    background: var(--nn-danger);
    border-radius: 50%;
    border: 2px solid #fff;
  }

  .top-navbar .navbar-right .icon-btn .badge-count {
    position: absolute;
    top: -4px;
    right: -4px;
    background: var(--nn-danger);
    color: #fff;
    font-size: 0.5rem;
    font-weight: 700;
    border-radius: 40px;
    padding: 0.1rem 0.4rem;
    border: 2px solid #fff;
  }

  .top-navbar .profile-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 12px 4px 8px;
    border-radius: 60px;
    border: 1px solid transparent;
    transition: var(--nn-transition);
    cursor: pointer;
    background: none;
    color: var(--nn-text-primary);
    text-decoration: none;
  }

  .top-navbar .profile-toggle:hover {
    border-color: var(--nn-border);
    background: var(--nn-bg-light);
  }

  .top-navbar .profile-toggle img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
  }

  .top-navbar .profile-toggle .name {
    font-weight: 500;
    font-size: 0.85rem;
  }

  .top-navbar .profile-toggle i {
    font-size: 0.7rem;
    color: var(--nn-text-muted);
  }

  /* Dropdown menu */
  .profile-dropdown-menu {
    min-width: 220px;
    padding: 0.5rem 0;
    border: 1px solid var(--nn-border);
    border-radius: var(--nn-radius-sm);
    box-shadow: var(--nn-shadow-hover);
    background: var(--nn-white);
  }

  .profile-dropdown-menu .dropdown-header {
    padding: 0.6rem 1rem 0.4rem;
    font-weight: 600;
    font-size: 0.8rem;
    color: var(--nn-text-primary);
    border-bottom: 1px solid var(--nn-border);
  }

  .profile-dropdown-menu .dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.85rem;
    color: var(--nn-text-secondary);
    display: flex;
    align-items: center;
    gap: 10px;
    transition: var(--nn-transition);
  }

  .profile-dropdown-menu .dropdown-item:hover {
    background: var(--nn-lavender);
    color: var(--nn-primary-light);
  }

  .profile-dropdown-menu .dropdown-item i {
    width: 18px;
    font-size: 0.9rem;
    color: var(--nn-text-muted);
  }

  .profile-dropdown-menu .dropdown-item:hover i {
    color: var(--nn-primary-light);
  }

  .profile-dropdown-menu .dropdown-divider {
    border-color: var(--nn-border);
    margin: 0.3rem 0;
  }

  .profile-dropdown-menu .dropdown-item.logout-item {
    color: var(--nn-danger);
  }

  .profile-dropdown-menu .dropdown-item.logout-item i {
    color: var(--nn-danger);
  }

  .profile-dropdown-menu .dropdown-item.logout-item:hover {
    background: #FEF2F2;
    color: #DC2626;
  }

  .profile-dropdown-menu .dropdown-item.logout-item:hover i {
    color: #DC2626;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .top-navbar {
      padding: 0 1rem;
    }
    .top-navbar .search-bar {
      max-width: 200px;
    }
    .top-navbar .profile-toggle .name {
      display: none;
    }
  }

  @media (max-width: 768px) {
    .top-navbar {
      padding: 0 0.75rem;
    }
    .top-navbar .navbar-center {
      flex: 0 1 auto;
      padding: 0 0.5rem;
    }
    .top-navbar .search-bar {
      max-width: 140px;
      padding: 0.1rem 0.6rem 0.1rem 0.8rem;
    }
    .top-navbar .search-bar input {
      font-size: 0.7rem;
      padding: 0.3rem 0;
    }
    .top-navbar .breadcrumb-custom {
      font-size: 0.75rem;
    }
    .top-navbar .breadcrumb-custom .separator {
      font-size: 0.5rem;
    }
    .top-navbar .profile-toggle {
      padding: 4px 8px;
    }
    .top-navbar .profile-toggle .name {
      display: none;
    }
    .top-navbar .navbar-right .icon-btn {
      font-size: 0.9rem;
      padding: 4px 6px;
    }
  }

  @media (max-width: 576px) {
    .top-navbar .search-bar {
      display: none;
    }
    .top-navbar .breadcrumb-custom .home-link span {
      display: none;
    }
    .top-navbar .navbar-right .icon-btn.hide-mobile {
      display: none;
    }
  }
</style>