<?php
// Owner Panel profile.php - Owner Profile & Verification Checklist
$pageTitle = 'Host Profile & Verification · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';

$owner = &$_SESSION['owner'];
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $owner['name'] = trim($_POST['name'] ?? $owner['name']);
    $owner['phone'] = trim($_POST['phone'] ?? $owner['phone']);
    $owner['company_name'] = trim($_POST['company_name'] ?? $owner['company_name']);
    $message = 'Host profile details updated successfully!';
}

$pageTitle = 'Host Profile · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    
    <!-- Page Title -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">Owner Profile & Host Verification</h3>
        <span class="text-secondary-custom small">Manage host credentials, company info, and property ownership verification documents</span>
      </div>
    </div>

    <?php if ($message): ?>
      <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-1"></i> <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="row g-4 mb-4">
      
      <!-- LEFT COLUMN: EDIT PROFILE & VERIFICATION CHECKLIST -->
      <div class="col-lg-8">
        
        <!-- VERIFICATION CHECKLIST CARD -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-shield-check text-success me-2"></i> Verified Host Status Checklist</h5>
          
          <div class="row g-3 extra-small">
            <div class="col-md-6">
              <div class="p-3 bg-light rounded-3 border-start border-success border-4 d-flex align-items-center justify-content-between">
                <div>
                  <strong class="d-block text-dark mb-0.5"><i class="fas fa-id-card text-success me-1"></i> Government Identity Verified</strong>
                  <span class="text-muted">Aadhaar: <?= htmlspecialchars($owner['aadhaar_no']) ?></span>
                </div>
                <span class="badge bg-success text-white">Verified</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="p-3 bg-light rounded-3 border-start border-success border-4 d-flex align-items-center justify-content-between">
                <div>
                  <strong class="d-block text-dark mb-0.5"><i class="fas fa-envelope-circle-check text-success me-1"></i> Email & Mobile Verified</strong>
                  <span class="text-muted"><?= htmlspecialchars($owner['email']) ?></span>
                </div>
                <span class="badge bg-success text-white">Verified</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="p-3 bg-light rounded-3 border-start border-success border-4 d-flex align-items-center justify-content-between">
                <div>
                  <strong class="d-block text-dark mb-0.5"><i class="fas fa-file-contract text-success me-1"></i> Property Ownership Deeds</strong>
                  <span class="text-muted">Title Deed & Khata Verified</span>
                </div>
                <span class="badge bg-success text-white">Verified</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="p-3 bg-light rounded-3 border-start border-success border-4 d-flex align-items-center justify-content-between">
                <div>
                  <strong class="d-block text-dark mb-0.5"><i class="fas fa-building text-success me-1"></i> Bank Account Verified</strong>
                  <span class="text-muted">HDFC Payout Account</span>
                </div>
                <span class="badge bg-success text-white">Verified</span>
              </div>
            </div>
          </div>
        </div>

        <!-- EDIT HOST PROFILE FORM CARD -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-user-pen text-bright-indigo me-2"></i> Edit Personal & Business Details</h5>
          
          <form action="profile.php" method="POST">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Full Legal Name *</label>
                <input type="text" name="name" class="form-control rounded-3" value="<?= htmlspecialchars($owner['name']) ?>" required />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Company / Operating Business Name</label>
                <input type="text" name="company_name" class="form-control rounded-3" value="<?= htmlspecialchars($owner['company_name']) ?>" />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Registered Phone Number *</label>
                <input type="text" name="phone" class="form-control rounded-3" value="<?= htmlspecialchars($owner['phone']) ?>" required />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Account Email (Locked)</label>
                <input type="email" class="form-control rounded-3 bg-light" value="<?= htmlspecialchars($owner['email']) ?>" readonly />
              </div>
            </div>

            <div class="mt-4 text-end">
              <button type="submit" class="btn btn-nh-primary px-4 py-2">
                <i class="fas fa-floppy-disk me-1"></i> Save Profile Details
              </button>
            </div>
          </form>
        </div>

      </div>

      <!-- RIGHT COLUMN: PUBLIC HOST CARD PREVIEW -->
      <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 text-center">
          <h6 class="fw-bold mb-3 text-secondary text-uppercase fs-xs tracking-wider">Student View Preview Card</h6>
          
          <img src="<?= htmlspecialchars($owner['avatar']) ?>" alt="<?= htmlspecialchars($owner['name']) ?>" class="rounded-circle mx-auto mb-3 shadow" style="width: 100px; height: 100px; object-fit: cover; border: 4px solid var(--nh-soft-lavender);" />
          
          <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($owner['name']) ?></h5>
          <span class="badge bg-success text-white px-3 py-1 rounded-pill extra-small mb-2"><i class="fas fa-shield-check me-1"></i> Verified Property Owner</span>
          
          <p class="extra-small text-secondary-custom mb-3"><?= htmlspecialchars($owner['company_name']) ?></p>
          
          <div class="p-3 bg-light rounded-3 border extra-small text-start d-flex flex-column gap-1.5 mb-3">
            <div class="d-flex justify-content-between">
              <span class="text-muted">Host Rating:</span>
              <strong class="text-warning"><i class="fas fa-star me-1"></i> <?= $owner['rating'] ?> / 5.0</strong>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted">Listed Accommodations:</span>
              <strong class="text-dark"><?= count($_SESSION['owner_properties']) ?> Properties</strong>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted">Host Member Since:</span>
              <strong class="text-dark"><?= htmlspecialchars($owner['member_since']) ?></strong>
            </div>
          </div>

          <button class="btn btn-sm btn-light border w-100" onclick="alert('Host photo update dialog simulated.')">
            <i class="fas fa-camera me-1 text-primary"></i> Change Profile Photo
          </button>
        </div>
      </div>

    </div>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
