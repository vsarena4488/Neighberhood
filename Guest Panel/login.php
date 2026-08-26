<?php
session_start();

$message = '';
$message_type = '';

// Handle Login Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $role = $_POST['role'] ?? 'user';

  if (empty($email) || empty($password)) {
    $message = 'Please enter both email/username and password.';
    $message_type = 'danger';
  } else {
    // Demo authentication handling
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role'] = $role;

    if ($role === 'admin') {
      $message = 'Admin login successful! Redirecting to Admin Dashboard...';
      $message_type = 'success';
      // Header redirect ready: header('Location: ../Admin Panel/index.php');
    } else {
      $message = 'Welcome back! Redirecting to Resident Dashboard...';
      $message_type = 'success';
      // Header redirect ready: header('Location: ../User Panel/index.php');
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NeighborNest · Login (User & Admin)</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    :root {
      --nn-primary: #1E3A5F;
      --nn-primary-light: #4F46E5;
      --nn-gradient: linear-gradient(135deg, #1E3A5F 0%, #4F46E5 100%);
      --nn-lavender: #EEF2FF;
      --nn-white: #FFFFFF;
      --nn-dark: #0F172A;
      --nn-text-primary: #1E293B;
      --nn-text-secondary: #64748B;
      --nn-border: #E2E8F0;
      --nn-radius: 20px;
      --nn-transition: 0.25s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #F8FAFC;
      color: var(--nn-text-primary);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Auth Wrapper */
    .auth-page {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
      background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.08), transparent 40%),
        radial-gradient(circle at bottom left, rgba(30, 58, 95, 0.06), transparent 40%);
    }

    .auth-card {
      background: var(--nn-white);
      border-radius: var(--nn-radius);
      box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
      border: 1px solid var(--nn-border);
      overflow: hidden;
      width: 100%;
      max-width: 1000px;
    }

    .auth-banner {
      background: var(--nn-gradient);
      color: #fff;
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }

    .auth-banner::after {
      content: '';
      position: absolute;
      bottom: -20%;
      right: -20%;
      width: 300px;
      height: 300px;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 50%;
      pointer-events: none;
    }

    .brand-logo {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.6rem;
      color: #fff;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .role-tabs {
      background: var(--nn-lavender);
      border-radius: 60px;
      padding: 4px;
      display: flex;
      gap: 4px;
      margin-bottom: 1.8rem;
    }

    .role-tab {
      flex: 1;
      border: none;
      background: transparent;
      padding: 0.65rem 1rem;
      border-radius: 60px;
      font-weight: 600;
      font-size: 0.9rem;
      color: var(--nn-text-secondary);
      transition: var(--nn-transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .role-tab.active {
      background: var(--nn-white);
      color: var(--nn-primary-light);
      box-shadow: 0 4px 12px rgba(79, 70, 229, 0.12);
    }

    .form-control-icon {
      position: relative;
    }

    .form-control-icon i {
      position: absolute;
      left: 1.1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--nn-text-secondary);
    }

    .form-control-icon .form-control {
      padding-left: 2.8rem;
      height: 50px;
      border-radius: 12px;
      border: 1.5px solid var(--nn-border);
      font-size: 0.95rem;
      transition: var(--nn-transition);
    }

    .form-control-icon .form-control:focus {
      border-color: var(--nn-primary-light);
      box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    /* Autofill fix */
    .form-control:-webkit-autofill,
    .form-control:-webkit-autofill:hover,
    .form-control:-webkit-autofill:focus {
      -webkit-box-shadow: 0 0 0px 1000px #ffffff inset !important;
      -webkit-text-fill-color: var(--nn-text-primary) !important;
    }

    .btn-password-toggle {
      position: absolute;
      right: 1.1rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--nn-text-secondary);
      cursor: pointer;
    }

    .btn-submit {
      background: var(--nn-gradient);
      color: #fff;
      border: none;
      height: 50px;
      border-radius: 60px;
      font-weight: 700;
      font-size: 1rem;
      width: 100%;
      transition: var(--nn-transition);
      box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 14px 32px rgba(79, 70, 229, 0.35);
      color: #fff;
    }

    .floating-badge {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 16px;
      padding: 1rem 1.2rem;
      color: #fff;
    }
  </style>
</head>

<body>

  <!-- Header Back Link -->
  <nav class="navbar navbar-light bg-transparent py-3">
    <div class="container">
      <a class="brand-logo text-dark" href="index.php">
        <i class="fas fa-house-chimney text-primary"></i> NeighborNest
      </a>
      <a href="index.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="fas fa-arrow-left me-1"></i> Back to Home
      </a>
    </div>
  </nav>

  <main class="auth-page">
    <div class="auth-card">
      <div class="row g-0">

        <!-- Left Form Column -->
        <div class="col-lg-6 p-4 p-md-5">
          <div class="mb-4">
            <h2 class="fw-bold text-dark mb-1" id="formTitle">Welcome Back</h2>
            <p class="text-muted small" id="formSubtitle">Sign in to access your NeighborNest portal</p>
          </div>

          <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $message_type ?> alert-dismissible fade show rounded-3 small mb-4" role="alert">
              <i class="fas <?= $message_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?> me-1"></i>
              <?= htmlspecialchars($message) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- Role Selector Tabs -->
          <div class="role-tabs">
            <button type="button" class="role-tab active" id="tabUser" onclick="selectRole('user')">
              <i class="fas fa-user"></i> Resident / User
            </button>
            <button type="button" class="role-tab" id="tabAdmin" onclick="selectRole('admin')">
              <i class="fas fa-user-shield"></i> Administrator
            </button>
          </div>

          <!-- Login Form -->
          <form action="login.php" method="POST">
            <input type="hidden" name="role" id="roleInput" value="user" />

            <div class="mb-3">
              <label class="form-label small fw-semibold text-secondary">Email or Username</label>
              <div class="form-control-icon">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" class="form-control" placeholder="name@example.com" required autocomplete="email" />
              </div>
            </div>

            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label small fw-semibold text-secondary mb-0">Password</label>
                <a href="#" class="small text-primary text-decoration-none fw-semibold">Forgot password?</a>
              </div>
              <div class="form-control-icon">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="passwordInput" class="form-control" placeholder="••••••••" required autocomplete="current-password" />
                <button type="button" class="btn-password-toggle" onclick="togglePasswordVisibility()">
                  <i class="fas fa-eye" id="passwordEye"></i>
                </button>
              </div>
            </div>

            <div class="form-check mb-4">
              <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" />
              <label class="form-check-label small text-secondary" for="rememberMe">
                Remember me on this device
              </label>
            </div>

            <button type="submit" class="btn btn-submit mb-4">
              <i class="fas fa-sign-in-alt me-1"></i> Sign In
            </button>
          </form>

          <div class="text-center">
            <p class="small text-secondary mb-0">
              Don't have a resident account?
              <a href="register.php" class="fw-bold text-primary text-decoration-none ms-1">Create Account</a>
            </p>
          </div>
        </div>

        <!-- Right Visual Banner Column -->
        <div class="col-lg-6 auth-banner d-none d-lg-flex">
          <div>
            <span class="badge bg-white text-dark rounded-pill px-3 py-2 fw-semibold mb-3">
              <i class="fas fa-shield-alt text-success me-1"></i> 24/7 Secure Portal
            </span>
            <h3 class="fw-bold text-white mb-3 fs-2">Connecting Communities & Managing Homes</h3>
            <p class="text-white-50 leading-relaxed">
              Access neighborhood insights, safety scores, property listings, and local event schedules with your NeighborNest account.
            </p>
          </div>

          <div class="floating-badge mt-5">
            <div class="d-flex align-items-center gap-3">
              <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="fas fa-building fs-5"></i>
              </div>
              <div>
                <div class="fw-bold text-white fs-6">Unified Guest & Management Panel</div>
                <div class="small text-white-50">Seamless login for Residents and Admins</div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function selectRole(role) {
      document.getElementById('roleInput').value = role;
      const tabUser = document.getElementById('tabUser');
      const tabAdmin = document.getElementById('tabAdmin');
      const formTitle = document.getElementById('formTitle');
      const formSubtitle = document.getElementById('formSubtitle');

      if (role === 'admin') {
        tabAdmin.classList.add('active');
        tabUser.classList.remove('active');
        formTitle.textContent = 'Admin Portal Login';
        formSubtitle.textContent = 'Sign in with administrative privileges';
      } else {
        tabUser.classList.add('active');
        tabAdmin.classList.remove('active');
        formTitle.textContent = 'Welcome Back';
        formSubtitle.textContent = 'Sign in to access your NeighborNest portal';
      }
    }

    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('passwordInput');
      const passwordEye = document.getElementById('passwordEye');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordEye.classList.remove('fa-eye');
        passwordEye.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        passwordEye.classList.remove('fa-eye-slash');
        passwordEye.classList.add('fa-eye');
      }
    }
  </script>
</body>

</html>
