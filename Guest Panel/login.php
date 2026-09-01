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
      header('Location: ../Admin Panel/index.php');
      exit;
    } elseif ($role === 'owner' || $role === 'landlord') {
      header('Location: ../Owner Panel/dashboard.php');
      exit;
    } else {
      header('Location: ../User Panel/dashboard.php');
      exit;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NeighborHood · Account Login</title>

  <!-- Google Fonts: Inter & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
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
      --nh-gradient-primary: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
      --nh-radius-xl: 24px;
      --nh-radius-lg: 16px;
      --nh-radius-md: 12px;
      --nh-radius-pill: 50px;
      --nh-transition: all 0.2s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--nh-bg-light);
      color: var(--nh-dark-text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      -webkit-font-smoothing: antialiased;
    }

    .auth-page {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2.5rem 1.25rem;
      background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.12), transparent 45%),
                  radial-gradient(circle at bottom left, rgba(67, 56, 202, 0.08), transparent 45%);
    }

    .auth-card {
      background: var(--nh-white);
      border-radius: var(--nh-radius-xl);
      box-shadow: 0 20px 50px -10px rgba(67, 56, 202, 0.12), 0 2px 10px rgba(0, 0, 0, 0.02);
      border: 1px solid var(--nh-border);
      overflow: hidden;
      width: 100%;
      max-width: 980px;
    }

    .auth-sidebar {
      background: var(--nh-gradient-primary);
      color: #fff;
      padding: 3.5rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
      position: relative;
    }

    .brand-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.4rem;
      color: #fff;
      text-decoration: none;
    }
    .brand-icon {
      width: 38px;
      height: 38px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
    }

    .btn-nh-primary {
      background: var(--nh-gradient-primary);
      color: #FFFFFF !important;
      border: none;
      padding: 0.7rem 1.5rem;
      border-radius: var(--nh-radius-pill);
      font-weight: 600;
      font-size: 0.95rem;
      box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
      transition: var(--nh-transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      width: 100%;
    }
    .btn-nh-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(79, 70, 229, 0.45);
    }

    /* Clean Grid for Role Selector to Avoid Any Overflow or Misalignment */
    .role-selector-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 0.65rem;
      width: 100%;
    }

    .role-option-box {
      border: 1.5px solid var(--nh-border);
      border-radius: var(--nh-radius-md);
      padding: 0.75rem 0.4rem;
      text-align: center;
      cursor: pointer;
      transition: var(--nh-transition);
      background: var(--nh-white);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 76px;
      user-select: none;
    }
    .role-option-box:hover, .role-option-box.active {
      border-color: var(--nh-bright-indigo);
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
      box-shadow: 0 3px 10px rgba(79, 70, 229, 0.12);
    }
    .role-option-box i {
      font-size: 1.2rem;
      margin-bottom: 0.3rem;
      display: block;
    }
    .role-option-box .role-title {
      font-size: 0.8rem;
      font-weight: 700;
      display: block;
      line-height: 1.2;
      white-space: nowrap;
    }
    .role-option-box .role-subtitle {
      font-size: 0.68rem;
      color: var(--nh-secondary-text);
      display: block;
      margin-top: 1px;
      line-height: 1;
      white-space: nowrap;
    }
    .role-option-box.active .role-subtitle {
      color: var(--nh-royal-blue);
    }

    .form-control, .form-select {
      border-radius: 10px;
      border: 1.5px solid var(--nh-border);
      padding: 0.62rem 0.95rem;
      font-size: 0.92rem;
      transition: var(--nh-transition);
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--nh-bright-indigo);
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }

    .input-group-text {
      border-radius: 10px 0 0 10px;
      border: 1.5px solid var(--nh-border);
      background: #F8FAFC;
    }

    .quick-demo-btn {
      font-size: 0.75rem;
      padding: 0.28rem 0.75rem;
      border-radius: var(--nh-radius-pill);
      border: 1px solid var(--nh-lavender-border);
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
      font-weight: 600;
      cursor: pointer;
      transition: var(--nh-transition);
      white-space: nowrap;
    }
    .quick-demo-btn:hover {
      background: var(--nh-bright-indigo);
      color: #fff;
    }
  </style>
</head>

<body>

  <div class="auth-page">
    <div class="auth-card">
      <div class="row g-0">
        <!-- Sidebar Brand Column -->
        <div class="col-lg-5 d-none d-lg-block">
          <div class="auth-sidebar">
            <div>
              <a href="index.php" class="brand-badge mb-4">
                <div class="brand-icon"><i class="fas fa-home"></i></div>
                <span>NeighborHood</span>
              </a>
              <h3 class="fw-bold text-white mb-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">Welcome Back to Your Accommodation Portal</h3>
              <p class="text-white-50 small mb-4 leading-relaxed">Log in to view your booking inquiries, message landlords directly, save your favorite student PGs, or manage your listed properties.</p>
            </div>

            <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
              <div class="d-flex align-items-center gap-2 mb-1">
                <i class="fas fa-shield-halved text-warning fs-5"></i>
                <span class="fw-bold small text-white">Verified & Secure Portal</span>
              </div>
              <p class="extra-small text-white-50 mb-0">Your authentication credentials are encrypted and protected under NeighborHood Security Standard.</p>
            </div>
          </div>
        </div>

        <!-- Login Form Column -->
        <div class="col-lg-7 p-4 p-md-5">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="index.php" class="text-decoration-none small text-secondary fw-medium"><i class="fas fa-arrow-left me-1"></i> Back to Guest Home</a>
            <span class="small text-secondary">New here? <a href="register.php" class="text-primary fw-bold text-decoration-none">Create Account</a></span>
          </div>

          <h3 class="fw-bold mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">Log In to Account</h3>
          <p class="text-secondary small mb-4">Choose your role and enter your credentials to access your portal.</p>

          <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $message_type ?> alert-dismissible fade show rounded-3 small mb-4" role="alert">
              <i class="fas <?= $message_type === 'success' ? 'fa-circle-check text-success' : 'fa-circle-exclamation text-danger' ?> me-2"></i>
              <?= htmlspecialchars($message) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form action="login.php" method="POST">
            <!-- Role Selector with Structured Grid -->
            <div class="mb-3">
              <label class="form-label small fw-bold text-secondary mb-2">Select Your Role</label>
              <div class="role-selector-grid">
                <label class="role-option-box active" id="role-box-user">
                  <input type="radio" name="role" value="user" checked class="d-none" onchange="highlightRole(this)">
                  <i class="fas fa-user-graduate"></i>
                  <span class="role-title">Tenant</span>
                  <span class="role-subtitle">Student / Renter</span>
                </label>
                <label class="role-option-box" id="role-box-owner">
                  <input type="radio" name="role" value="owner" class="d-none" onchange="highlightRole(this)">
                  <i class="fas fa-building-user"></i>
                  <span class="role-title">Landlord</span>
                  <span class="role-subtitle">Property Owner</span>
                </label>
                <label class="role-option-box" id="role-box-admin">
                  <input type="radio" name="role" value="admin" class="d-none" onchange="highlightRole(this)">
                  <i class="fas fa-user-shield"></i>
                  <span class="role-title">Admin</span>
                  <span class="role-subtitle">Management</span>
                </label>
              </div>
            </div>

            <!-- Email / Phone Field -->
            <div class="mb-3">
              <label class="form-label small fw-bold text-secondary mb-1">Email Address or Phone</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                <input type="email" id="login-email" name="email" class="form-control" placeholder="name@example.com" value="guest.tenant@example.com" required />
              </div>
            </div>

            <!-- Password Field with Toggle -->
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label small fw-bold text-secondary mb-0">Password</label>
                <a href="javascript:void(0)" onclick="alert('Demo reset instructions sent to your email.')" class="extra-small text-primary text-decoration-none fw-medium">Forgot password?</a>
              </div>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" id="login-password" name="password" class="form-control" placeholder="••••••••" value="demo12345" required />
                <button class="btn btn-outline-secondary border-1 border-start-0" type="button" onclick="togglePasswordVisibility('login-password', this)">
                  <i class="far fa-eye text-muted"></i>
                </button>
              </div>
            </div>

            <!-- Quick Demo Credentials Selector -->
            <div class="d-flex flex-wrap align-items-center gap-2 mb-4 pt-1">
              <span class="extra-small text-secondary fw-semibold">Quick Demo:</span>
              <button type="button" class="quick-demo-btn" onclick="fillDemo('user')">Tenant Demo</button>
              <button type="button" class="quick-demo-btn" onclick="fillDemo('owner')">Landlord Demo</button>
              <button type="button" class="quick-demo-btn" onclick="fillDemo('admin')">Admin Demo</button>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
              <button type="submit" class="btn btn-nh-primary py-2"><i class="fas fa-right-to-bracket me-1"></i> Log In to Dashboard</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function highlightRole(input) {
      document.querySelectorAll('.role-option-box').forEach(box => box.classList.remove('active'));
      input.closest('.role-option-box').classList.add('active');
    }

    function togglePasswordVisibility(inputId, btn) {
      const input = document.getElementById(inputId);
      const icon = btn.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }

    function fillDemo(role) {
      const emailInput = document.getElementById('login-email');
      const passInput = document.getElementById('login-password');
      const roleRadio = document.querySelector(`input[name="role"][value="${role}"]`);

      if (role === 'admin') {
        emailInput.value = 'admin@neighborhood.com';
        passInput.value = 'admin12345';
      } else if (role === 'owner') {
        emailInput.value = 'landlord@neighborhood.com';
        passInput.value = 'owner12345';
      } else {
        emailInput.value = 'tenant@neighborhood.com';
        passInput.value = 'tenant12345';
      }

      if (roleRadio) {
        roleRadio.checked = true;
        highlightRole(roleRadio);
      }
    }
  </script>
</body>

</html>
