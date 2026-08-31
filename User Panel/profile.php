<?php
require_once __DIR__ . '/includes/functions.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['user']['name'] = trim($_POST['fullname'] ?? $_SESSION['user']['name']);
    $_SESSION['user']['email'] = trim($_POST['email'] ?? $_SESSION['user']['email']);
    $_SESSION['user']['phone'] = trim($_POST['phone'] ?? $_SESSION['user']['phone']);
    $_SESSION['user']['city'] = trim($_POST['city'] ?? $_SESSION['user']['city']);
    $_SESSION['user']['college'] = trim($_POST['college'] ?? $_SESSION['user']['college']);
    $_SESSION['user']['course'] = trim($_POST['course'] ?? $_SESSION['user']['course']);
    $_SESSION['user']['year'] = trim($_POST['year'] ?? $_SESSION['user']['year']);
    $_SESSION['user']['emergency_contact'] = trim($_POST['emergency_contact'] ?? $_SESSION['user']['emergency_contact']);
    
    $message = 'Your user profile details have been successfully updated!';
}

$user = $_SESSION['user'];

$pageTitle = 'My Profile · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <div class="mb-4">
      <h3 class="fw-bold mb-1">My Tenant & Student Profile</h3>
      <span class="text-secondary-custom small">Manage your personal details, verified student identity, and contact information</span>
    </div>

    <?php if (!empty($message)): ?>
      <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 small" role="alert">
        <i class="fas fa-circle-check me-2"></i> <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form action="profile.php" method="POST">
      <div class="row g-4">
        <!-- LEFT COLUMN: AVATAR & VERIFICATION BADGE -->
        <div class="col-lg-4">
          <div class="card border-0 rounded-4 shadow-sm bg-white p-4 text-center mb-4">
            <div class="position-relative d-inline-block mx-auto mb-3">
              <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="User Avatar" class="rounded-circle shadow" style="width: 110px; height: 110px; object-fit: cover; border: 4px solid var(--nh-soft-lavender);" />
              <button type="button" class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0 shadow" style="width: 32px; height: 32px; padding: 0;" onclick="alert('Photo upload dialog opened.')" title="Change Photo">
                <i class="fas fa-camera fs-xs"></i>
              </button>
            </div>

            <h5 class="fw-bold mb-1"><?= htmlspecialchars($user['name']) ?></h5>
            <span class="extra-small text-secondary-custom d-block mb-3"><?= htmlspecialchars($user['email']) ?></span>

            <div class="p-3 bg-soft-lavender rounded-3 border border-primary-subtle text-start extra-small text-royal-blue mb-3">
              <div class="d-flex align-items-center gap-2 mb-1">
                <i class="fas fa-shield-halved text-success fs-5"></i>
                <strong class="d-block">Verified Student Profile</strong>
              </div>
              <span>Student ID <strong class="text-dark"><?= htmlspecialchars($user['student_id']) ?></strong> verified by NeighborNest Team.</span>
            </div>

            <span class="fs-xs text-muted d-block">Member Since <?= htmlspecialchars($user['member_since']) ?></span>
          </div>
        </div>

        <!-- RIGHT COLUMN: PROFILE FORMS -->
        <div class="col-lg-8">
          <!-- Personal Information Card -->
          <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
            <h5 class="fw-bold mb-3"><i class="fas fa-user text-bright-indigo me-2"></i> Personal Information</h5>
            
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Full Legal Name *</label>
                <input type="text" name="fullname" class="form-control rounded-3" value="<?= htmlspecialchars($user['name']) ?>" required />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Email Address *</label>
                <input type="email" name="email" class="form-control rounded-3" value="<?= htmlspecialchars($user['email']) ?>" required />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Phone Number *</label>
                <input type="text" name="phone" class="form-control rounded-3" value="<?= htmlspecialchars($user['phone']) ?>" required />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Primary City Hub</label>
                <input type="text" name="city" class="form-control rounded-3" value="<?= htmlspecialchars($user['city']) ?>" />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Emergency Contact Person & Phone</label>
                <input type="text" name="emergency_contact" class="form-control rounded-3" value="<?= htmlspecialchars($user['emergency_contact']) ?>" />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Date of Birth</label>
                <input type="date" class="form-control rounded-3" value="<?= htmlspecialchars($user['dob']) ?>" />
              </div>
            </div>
          </div>

          <!-- Academic & College Details Card -->
          <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
            <h5 class="fw-bold mb-3"><i class="fas fa-graduation-cap text-bright-indigo me-2"></i> College & Academic Verification</h5>
            
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">College / University Name</label>
                <input type="text" name="college" class="form-control rounded-3" value="<?= htmlspecialchars($user['college']) ?>" />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Course / Major Degree</label>
                <input type="text" name="course" class="form-control rounded-3" value="<?= htmlspecialchars($user['course']) ?>" />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Current Academic Year</label>
                <input type="text" name="year" class="form-control rounded-3" value="<?= htmlspecialchars($user['year']) ?>" />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Uploaded Student ID Proof</label>
                <div class="input-group">
                  <input type="file" class="form-control rounded-3" accept="image/*,.pdf" />
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-light border px-4">Reset</button>
            <button type="submit" class="btn btn-nh-primary px-4">
              <i class="fas fa-floppy-disk me-1"></i> Save Changes
            </button>
          </div>
        </div>
      </div>
    </form>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
