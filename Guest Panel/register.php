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
    $message = 'Please fill out all required fields with valid details.';
    $message_type = 'danger';
  } elseif ($password !== $confirm_password) {
    $message = 'Passwords do not match. Please verify your password confirmation.';
    $message_type = 'danger';
  } elseif (!$terms) {
    $message = 'You must agree to the Terms of Service and Privacy Policy.';
    $message_type = 'warning';
  } else {
    // Demo registration handling
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $fullname;
    $_SESSION['user_type'] = $user_type;
    $_SESSION['user_role'] = ($user_type === 'landlord') ? 'owner' : 'user';

    $message = 'Registration successful! Welcome to NeighborHood. You can now log in to your account.';
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
      padding: 3rem 1.25rem;
      background: radial-gradient(circle at top left, rgba(79, 70, 229, 0.12), transparent 45%),
                  radial-gradient(circle at bottom left, rgba(67, 56, 202, 0.08), transparent 45%);
    }

    .auth-card {
      background: var(--nh-white);
      border-radius: var(--nh-radius-xl);
      box-shadow: 0 20px 50px -10px rgba(67, 56, 202, 0.12), 0 2px 10px rgba(0, 0, 0, 0.02);
      border: 1px solid var(--nh-border);
      overflow: hidden;
      width: 100%;
      max-width: 1050px;
    }

    .auth-sidebar {
      background: var(--nh-gradient-primary);
      color: #fff;
      padding: 3.5rem 2.75rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
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
      padding: 0.75rem 1.6rem;
      border-radius: var(--nh-radius-pill);
      font-weight: 600;
      font-size: 0.95rem;
      box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
      transition: var(--nh-transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }
    .btn-nh-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(79, 70, 229, 0.45);
    }

    .form-control, .form-select {
      border-radius: 10px;
      border: 1.5px solid var(--nh-border);
      padding: 0.65rem 1rem;
      font-size: 0.92rem;
      transition: var(--nh-transition);
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--nh-bright-indigo);
      box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
    }

    .input-group-text {
      border-radius: 10px 0 0 10px;
      border: 1.5px solid var(--nh-border);
      background: #F8FAFC;
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
              <h3 class="fw-bold text-white mb-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">Join Thousands Finding & Listing Places Seamlessly</h3>
              <p class="text-white-50 small mb-4 leading-relaxed">Create your account to book verified student PGs, hostels, rooms, or apartments, save your favorite listings, and message property owners directly with zero brokerage.</p>
            </div>

            <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
              <div class="d-flex align-items-center gap-2 mb-1">
                <i class="fas fa-certificate text-warning fs-5"></i>
                <span class="fw-bold small text-white">Verified Tenant & Landlord Network</span>
              </div>
              <p class="extra-small text-white-50 mb-0">Help landlords verify your inquiry quickly with your student or professional profile tag.</p>
            </div>
          </div>
        </div>

        <!-- Register Form Column -->
        <div class="col-lg-7 p-4 p-md-5">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="index.php" class="text-decoration-none small text-secondary fw-medium"><i class="fas fa-arrow-left me-1"></i> Back to Guest Home</a>
            <span class="small text-secondary">Already registered? <a href="login.php" class="text-primary fw-bold text-decoration-none">Log In</a></span>
          </div>

          <h3 class="fw-bold mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">Create Free Account</h3>
          <p class="text-secondary small mb-4">Fill out your details to start booking or listing accommodations.</p>

          <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $message_type ?> alert-dismissible fade show rounded-3 small mb-4" role="alert">
              <i class="fas <?= $message_type === 'success' ? 'fa-circle-check text-success' : 'fa-circle-exclamation text-danger' ?> me-2"></i>
              <?= htmlspecialchars($message) ?>
              <?php if ($message_type === 'success'): ?>
                <div class="mt-2"><a href="login.php" class="btn btn-sm btn-primary rounded-pill px-3">Proceed to Login</a></div>
              <?php endif; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form action="register.php" method="POST" oninput="checkPasswordMatch()">
            <div class="row g-3">
              <!-- Full Name -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Full Name *</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                  <input type="text" name="fullname" class="form-control" placeholder="e.g. Ananya Rao" required />
                </div>
              </div>

              <!-- User Persona Type -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">I am registering as *</label>
                <select name="user_type" class="form-select" required>
                  <option value="student" selected>College Student (PG / Hostel)</option>
                  <option value="employee">Working Professional / Employee</option>
                  <option value="family">Family Renter (Flats / Houses)</option>
                  <option value="landlord">Property Owner / Landlord</option>
                </select>
              </div>

              <!-- Email -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Email Address *</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                  <input type="email" name="email" class="form-control" placeholder="name@example.com" required />
                </div>
              </div>

              <!-- Phone -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Phone Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-phone text-muted"></i></span>
                  <input type="tel" name="phone" class="form-control" placeholder="+91 98765 43210" />
                </div>
              </div>

              <!-- Password -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Password *</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                  <input type="password" id="reg-password" name="password" class="form-control" placeholder="••••••••" required />
                  <button class="btn btn-outline-secondary border-1 border-start-0" type="button" onclick="togglePass('reg-password', this)">
                    <i class="far fa-eye text-muted"></i>
                  </button>
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Confirm Password *</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-shield-halved text-muted"></i></span>
                  <input type="password" id="reg-confirm-password" name="confirm_password" class="form-control" placeholder="••••••••" required />
                  <button class="btn btn-outline-secondary border-1 border-start-0" type="button" onclick="togglePass('reg-confirm-password', this)">
                    <i class="far fa-eye text-muted"></i>
                  </button>
                </div>
                <div id="password-match-status" class="extra-small mt-1 text-muted"></div>
              </div>
            </div>

            <!-- Terms Checkbox -->
            <div class="form-check mt-4 mb-4">
              <input class="form-check-input" type="checkbox" name="terms" id="terms" required checked />
              <label class="form-check-label extra-small text-secondary" for="terms">
                I agree to NeighborHood's <a href="javascript:void(0)" class="text-primary text-decoration-none">Terms of Service</a> and <a href="javascript:void(0)" class="text-primary text-decoration-none">Privacy Policy</a>.
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function togglePass(inputId, btn) {
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

    function checkPasswordMatch() {
      const p1 = document.getElementById('reg-password').value;
      const p2 = document.getElementById('reg-confirm-password').value;
      const status = document.getElementById('password-match-status');
      if (!p2) {
        status.innerText = '';
        return;
      }
      if (p1 === p2) {
        status.innerText = '✓ Passwords match';
        status.className = 'extra-small mt-1 text-success fw-semibold';
      } else {
        status.innerText = '✗ Passwords do not match';
        status.className = 'extra-small mt-1 text-danger fw-semibold';
      }
    }
  </script>
</body>

</html>
