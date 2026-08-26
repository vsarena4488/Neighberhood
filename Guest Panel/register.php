<?php
session_start();

$message = '';
$message_type = '';

// Handle Registration Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = trim($_POST['fullname'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm_password = $_POST['confirm_password'] ?? '';
  $terms = isset($_POST['terms']);

  if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
    $message = 'Please fill out all required fields.';
    $message_type = 'danger';
  } elseif ($password !== $confirm_password) {
    $message = 'Passwords do not match. Please try again.';
    $message_type = 'danger';
  } elseif (!$terms) {
    $message = 'You must agree to the Terms of Service and Privacy Policy.';
    $message_type = 'warning';
  } else {
    // Demo registration handling
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $fullname;
    $_SESSION['user_role'] = 'user';

    $message = 'Registration successful! Welcome to NeighborNest. Redirecting to login...';
    $message_type = 'success';
    // Header redirect ready: header('Refresh: 2; URL=login.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NeighborNest · Register New Resident Account</title>

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

    .auth-page {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
      background: radial-gradient(circle at top left, rgba(79, 70, 229, 0.08), transparent 40%),
        radial-gradient(circle at bottom right, rgba(30, 58, 95, 0.06), transparent 40%);
    }

    .auth-card {
      background: var(--nn-white);
      border-radius: var(--nn-radius);
      box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
      border: 1px solid var(--nn-border);
      overflow: hidden;
      width: 100%;
      max-width: 1050px;
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
      top: -20%;
      left: -20%;
      width: 320px;
      height: 320px;
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
      height: 48px;
      border-radius: 12px;
      border: 1.5px solid var(--nn-border);
      font-size: 0.95rem;
      transition: var(--nn-transition);
    }

    .form-control-icon .form-control:focus {
      border-color: var(--nn-primary-light);
      box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
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

    .feature-list-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.2rem;
      color: rgba(255, 255, 255, 0.9);
      font-size: 0.95rem;
    }

    .feature-icon-circle {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      flex-shrink: 0;
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

        <!-- Left Visual Banner Column -->
        <div class="col-lg-5 auth-banner d-none d-lg-flex">
          <div>
            <span class="badge bg-white text-dark rounded-pill px-3 py-2 fw-semibold mb-3">
              <i class="fas fa-user-plus text-primary me-1"></i> New Resident Portal
            </span>
            <h3 class="fw-bold text-white mb-3 fs-2">Join Your Neighborhood Today</h3>
            <p class="text-white-50 leading-relaxed mb-4">
              Create a free account to discover verified homes, local community events, safety ratings, and school statistics.
            </p>

            <div class="mt-4">
              <div class="feature-list-item">
                <div class="feature-icon-circle"><i class="fas fa-check"></i></div>
                <div>Explore 3,200+ verified local properties</div>
              </div>
              <div class="feature-list-item">
                <div class="feature-icon-circle"><i class="fas fa-calendar-alt"></i></div>
                <div>RSVP to upcoming neighborhood block parties</div>
              </div>
              <div class="feature-list-item">
                <div class="feature-icon-circle"><i class="fas fa-shield-alt"></i></div>
                <div>Access real-time safety & walkability metrics</div>
              </div>
            </div>
          </div>

          <div class="pt-4 border-top border-white-10">
            <small class="text-white-50">Trusted by over 10,000+ residents across top communities.</small>
          </div>
        </div>

        <!-- Right Form Column -->
        <div class="col-lg-7 p-4 p-md-5">
          <div class="mb-4">
            <h2 class="fw-bold text-dark mb-1">Create an Account</h2>
            <p class="text-muted small">Register as a new resident to unlock full community features</p>
          </div>

          <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $message_type ?> alert-dismissible fade show rounded-3 small mb-4" role="alert">
              <i class="fas <?= $message_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?> me-1"></i>
              <?= htmlspecialchars($message) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- Registration Form -->
          <form action="register.php" method="POST">

            <div class="mb-3">
              <label class="form-label small fw-semibold text-secondary">Full Name *</label>
              <div class="form-control-icon">
                <i class="fas fa-user"></i>
                <input type="text" name="fullname" class="form-control" placeholder="John Doe" required />
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Email Address *</label>
                <div class="form-control-icon">
                  <i class="fas fa-envelope"></i>
                  <input type="email" name="email" class="form-control" placeholder="name@example.com" required />
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Phone Number</label>
                <div class="form-control-icon">
                  <i class="fas fa-phone"></i>
                  <input type="tel" name="phone" class="form-control" placeholder="+91 98765 43210" />
                </div>
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Password *</label>
                <div class="form-control-icon">
                  <i class="fas fa-lock"></i>
                  <input type="password" name="password" id="regPassword" class="form-control" placeholder="••••••••" required />
                  <button type="button" class="btn-password-toggle" onclick="toggleVisibility('regPassword', 'regEye1')">
                    <i class="fas fa-eye" id="regEye1"></i>
                  </button>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Confirm Password *</label>
                <div class="form-control-icon">
                  <i class="fas fa-lock"></i>
                  <input type="password" name="confirm_password" id="regConfirmPassword" class="form-control" placeholder="••••••••" required />
                  <button type="button" class="btn-password-toggle" onclick="toggleVisibility('regConfirmPassword', 'regEye2')">
                    <i class="fas fa-eye" id="regEye2"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="form-check mb-4">
              <input class="form-check-input" type="checkbox" id="agreeTerms" name="terms" required />
              <label class="form-check-label small text-secondary" for="agreeTerms">
                I agree to the <a href="#" class="text-primary text-decoration-none fw-semibold">Terms of Service</a> and <a href="#" class="text-primary text-decoration-none fw-semibold">Privacy Policy</a>
              </label>
            </div>

            <button type="submit" class="btn btn-submit mb-4">
              <i class="fas fa-user-plus me-1"></i> Register Account
            </button>
          </form>

          <div class="text-center">
            <p class="small text-secondary mb-0">
              Already have an account?
              <a href="login.php" class="fw-bold text-primary text-decoration-none ms-1">Sign In</a>
            </p>
          </div>
        </div>

      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleVisibility(inputId, eyeId) {
      const input = document.getElementById(inputId);
      const eye = document.getElementById(eyeId);
      if (input.type === 'password') {
        input.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
      }
    }
  </script>
</body>

</html>
