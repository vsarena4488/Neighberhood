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
    } elseif ($role === 'owner') {
      $message = 'Landlord login successful! Redirecting to Owner Panel...';
      $message_type = 'success';
    } else {
      $message = 'Welcome back! Redirecting to Tenant Dashboard...';
      $message_type = 'success';
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
      --nh-royal-blue: #4338CA;
      --nh-bright-indigo: #4F46E5;
      --nh-soft-lavender: #EEF2FF;
      --nh-lavender-border: #C7D2FE;
      --nh-white: #FFFFFF;
      --nh-bg-light: #F8FAFC;
      --nh-dark-text: #111827;
      --nh-secondary-text: #6B7280;
      --nh-border: #E5E7EB;
      --nh-gradient-primary: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
      --nh-radius-lg: 22px;
      --nh-radius-pill: 50px;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--nh-bg-light);
      color: var(--nh-dark-text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .auth-page {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2.5rem 1rem;
      background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.12), transparent 45%),
                  radial-gradient(circle at bottom left, rgba(67, 56, 202, 0.08), transparent 45%);
    }

    .auth-card {
      background: var(--nh-white);
      border-radius: var(--nh-radius-lg);
      box-shadow: 0 20px 50px rgba(67, 56, 202, 0.1);
      border: 1px solid var(--nh-border);
      overflow: hidden;
      width: 100%;
      max-width: 950px;
    }

    .auth-sidebar {
      background: var(--nh-gradient-primary);
      color: #fff;
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
    }

    .brand-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.4rem;
      color: #fff;
      text-decoration: none;
    }

    .btn-nh-primary {
      background: var(--nh-gradient-primary);
      color: #FFFFFF !important;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: var(--nh-radius-pill);
      font-weight: 600;
      box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
      transition: all 0.2s ease;
    }
    .btn-nh-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(79, 70, 229, 0.45);
    }

    .role-option-box {
      border: 2px solid var(--nh-border);
      border-radius: 12px;
      padding: 0.75rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .role-option-box:hover, .role-option-box.active {
      border-color: var(--nh-bright-indigo);
      background: var(--nh-soft-lavender);
      color: var(--nh-royal-blue);
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
                <i class="fas fa-home"></i> NeighborHood
              </a>
              <h3 class="fw-bold text-white mb-3">Welcome Back to Your Accommodation Hub</h3>
              <p class="text-white-50 small mb-4">Log in to view your bookings, chat with property owners, save your favorite PGs, or manage your listed rental properties.</p>
            </div>

            <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);">
              <div class="d-flex align-items-center gap-2 mb-1">
                <i class="fas fa-shield-check text-warning fs-5"></i>
                <span class="fw-bold small">Verified & Encrypted Login</span>
              </div>
              <p class="extra-small text-white-50 mb-0">Your authentication data is safely protected with platform SSL encryption.</p>
            </div>
          </div>
        </div>

        <!-- Login Form Column -->
        <div class="col-lg-7 p-4 p-md-5">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="index.php" class="text-decoration-none small text-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Guest Home</a>
            <span class="small text-secondary">New user? <a href="register.php" class="text-primary fw-bold">Create Account</a></span>
          </div>

          <h3 class="fw-bold mb-1">Log In to Account</h3>
          <p class="text-secondary small mb-4">Choose your role and enter your credentials to access your dashboard.</p>

          <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $message_type ?> alert-dismissible fade show rounded-3 small mb-4" role="alert">
              <?= htmlspecialchars($message) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form action="login.php" method="POST">
            <!-- Role Selector -->
            <div class="mb-3">
              <label class="form-label small fw-bold text-secondary">Select Access Role</label>
              <div class="row g-2">
                <div class="col-4">
                  <label class="role-option-box active w-100 d-block">
                    <input type="radio" name="role" value="user" checked class="d-none" onchange="highlightRole(this)">
                    <i class="fas fa-user-graduate d-block mb-1 fs-5"></i>
                    <span class="extra-small fw-bold d-block">Tenant / User</span>
                  </label>
                </div>
                <div class="col-4">
                  <label class="role-option-box w-100 d-block">
                    <input type="radio" name="role" value="owner" class="d-none" onchange="highlightRole(this)">
                    <i class="fas fa-building d-block mb-1 fs-5"></i>
                    <span class="extra-small fw-bold d-block">Landlord / Owner</span>
                  </label>
                </div>
                <div class="col-4">
                  <label class="role-option-box w-100 d-block">
                    <input type="radio" name="role" value="admin" class="d-none" onchange="highlightRole(this)">
                    <i class="fas fa-user-shield d-block mb-1 fs-5"></i>
                    <span class="extra-small fw-bold d-block">Admin Panel</span>
                  </label>
                </div>
              </div>
            </div>

            <!-- Email / Phone Field -->
            <div class="mb-3">
              <label class="form-label small fw-bold text-secondary">Email Address or Phone Number</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                <input type="email" name="email" class="form-control border-start-0 py-2" placeholder="name@example.com" required />
              </div>
            </div>

            <!-- Password Field -->
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center">
                <label class="form-label small fw-bold text-secondary mb-1">Password</label>
                <a href="#" class="extra-small text-primary text-decoration-none">Forgot password?</a>
              </div>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control border-start-0 py-2" placeholder="••••••••" required />
              </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-nh-primary py-2"><i class="fas fa-right-to-bracket me-1"></i> Log In Now</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    function highlightRole(input) {
      document.querySelectorAll('.role-option-box').forEach(box => box.classList.remove('active'));
      input.closest('.role-option-box').classList.add('active');
    }
  </script>
</body>

</html>
