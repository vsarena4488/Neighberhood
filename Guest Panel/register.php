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
  $user_type = $_POST['user_type'] ?? 'student';
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
    $_SESSION['user_type'] = $user_type;
    $_SESSION['user_role'] = 'user';

    $message = 'Registration successful! Welcome to NeighborHood. Redirecting to login...';
    $message_type = 'success';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NeighborHood · Register Account</title>

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
      background: radial-gradient(circle at top left, rgba(79, 70, 229, 0.12), transparent 45%),
                  radial-gradient(circle at bottom left, rgba(67, 56, 202, 0.08), transparent 45%);
    }

    .auth-card {
      background: var(--nh-white);
      border-radius: var(--nh-radius-lg);
      box-shadow: 0 20px 50px rgba(67, 56, 202, 0.1);
      border: 1px solid var(--nh-border);
      overflow: hidden;
      width: 100%;
      max-width: 1000px;
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
              <h3 class="fw-bold text-white mb-3">Join Thousands Finding Places Seamlessly</h3>
              <p class="text-white-50 small mb-4">Create a free account to book PGs, hostels, rooms, or apartments, save your favorites, and message owners directly.</p>
            </div>

            <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);">
              <div class="d-flex align-items-center gap-2 mb-1">
                <i class="fas fa-user-shield text-warning fs-5"></i>
                <span class="fw-bold small">Verified Tenant Profiles</span>
              </div>
              <p class="extra-small text-white-50 mb-0">Help landlords trust your booking requests with your verified student or employee persona tag.</p>
            </div>
          </div>
        </div>

        <!-- Register Form Column -->
        <div class="col-lg-7 p-4 p-md-5">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="index.php" class="text-decoration-none small text-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Guest Home</a>
            <span class="small text-secondary">Already registered? <a href="login.php" class="text-primary fw-bold">Log In</a></span>
          </div>

          <h3 class="fw-bold mb-1">Create Account</h3>
          <p class="text-secondary small mb-4">Fill out your profile details to start booking accommodations.</p>

          <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $message_type ?> alert-dismissible fade show rounded-3 small mb-4" role="alert">
              <?= htmlspecialchars($message) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form action="register.php" method="POST">
            <div class="row g-3">
              <!-- Full Name -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary">Full Name *</label>
                <input type="text" name="fullname" class="form-control py-2" placeholder="e.g. Ananya Rao" required />
              </div>

              <!-- User Persona Type -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary">User Category *</label>
                <select name="user_type" class="form-select py-2">
                  <option value="student" selected>College Student</option>
                  <option value="employee">Working Employee / Professional</option>
                  <option value="family">Family Renter</option>
                  <option value="other">General Renter / Other</option>
                </select>
              </div>

              <!-- Email -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary">Email Address *</label>
                <input type="email" name="email" class="form-control py-2" placeholder="name@example.com" required />
              </div>

              <!-- Phone -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary">Phone Number</label>
                <input type="tel" name="phone" class="form-control py-2" placeholder="+91 98765 43210" />
              </div>

              <!-- Password -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary">Password *</label>
                <input type="password" name="password" class="form-control py-2" placeholder="••••••••" required />
              </div>

              <!-- Confirm Password -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary">Confirm Password *</label>
                <input type="password" name="confirm_password" class="form-control py-2" placeholder="••••••••" required />
              </div>
            </div>

            <!-- Terms Checkbox -->
            <div class="form-check mt-3 mb-4">
              <input class="form-check-input" type="checkbox" name="terms" id="terms" required />
              <label class="form-check-label extra-small text-secondary" for="terms">
                I agree to NeighborHood's <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>.
              </label>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
              <button type="submit" class="btn btn-nh-primary py-2"><i class="fas fa-user-plus me-1"></i> Register Account Now</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
