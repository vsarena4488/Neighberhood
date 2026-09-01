<?php
require_once __DIR__ . '/includes/functions.php';

$message = '';
$messageType = 'success';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['action']) && $_POST['action'] === 'change_password') {
    $currentPass = trim($_POST['current_password'] ?? '');
    $newPass = trim($_POST['new_password'] ?? '');
    $confirmPass = trim($_POST['confirm_password'] ?? '');

    if (empty($currentPass) || empty($newPass) || empty($confirmPass)) {
      $message = 'Please fill out all required password fields.';
      $messageType = 'danger';
    } elseif ($newPass !== $confirmPass) {
      $message = 'New password and confirmation password do not match.';
      $messageType = 'danger';
    } elseif (strlen($newPass) < 6) {
      $message = 'New password must be at least 6 characters long.';
      $messageType = 'danger';
    } else {
      $message = 'Your account password has been updated successfully!';
      $messageType = 'success';
    }
  } else {
    $message = 'Your account settings & notification preferences have been saved!';
    $messageType = 'success';
  }
}

$pageTitle = 'Settings · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <div class="mb-4">
      <h3 class="fw-bold mb-1">Account Settings & Preferences</h3>
      <span class="text-secondary-custom small">Configure alerts, communication channels, privacy security, and platform preferences</span>
    </div>

    <?php if (!empty($message)): ?>
      <div class="alert alert-<?= $messageType ?> alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 small" role="alert">
        <i class="fas <?= ($messageType === 'success') ? 'fa-circle-check' : 'fa-circle-exclamation' ?> me-2"></i> <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form action="settings.php" method="POST">
      <!-- 1. NOTIFICATION PREFERENCES -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-bell text-bright-indigo me-2"></i> Notification & Alert Preferences</h5>

        <div class="d-flex flex-column gap-3">
          <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
            <div>
              <strong class="d-block small">Booking Status & Approval Alerts</strong>
              <span class="extra-small text-secondary-custom">Instant alerts when an owner reviews, accepts, or confirms your booking.</span>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" checked />
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
            <div>
              <strong class="d-block small">New Chat Messages from Landlords</strong>
              <span class="extra-small text-secondary-custom">Receive push & email notifications when landlords message your inquiries.</span>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" checked />
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
            <div>
              <strong class="d-block small">SMS & WhatsApp Move-in Updates</strong>
              <span class="extra-small text-secondary-custom">Receive check-in verification codes and digital pass on WhatsApp.</span>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" checked />
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <div>
              <strong class="d-block small">Student Discounts & Accommodation Offers</strong>
              <span class="extra-small text-secondary-custom">Occasional curated room deals near your university campus.</span>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" />
            </div>
          </div>
        </div>
      </div>

      <!-- 2. PRIVACY & SECURITY -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-lock text-bright-indigo me-2"></i> Privacy & Password Security</h5>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary mb-1">Profile Visibility to Landlords</label>
            <select class="form-select rounded-3">
              <option value="public" selected>Public (Verified Landlords Can Contact)</option>
              <option value="private">Private (Only When Booking Request is Sent)</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary mb-1">Phone Number Privacy</label>
            <select class="form-select rounded-3">
              <option value="masked" selected>Masked / Show Only After Booking Approval</option>
              <option value="visible">Always Visible</option>
            </select>
          </div>
          <div class="col-12 mt-3">
            <button type="button" class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
              <i class="fas fa-key me-1 text-primary"></i> Change Account Password
            </button>
          </div>
        </div>
      </div>

      <!-- 4. DANGER ZONE -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4 border-start border-danger border-4">
        <h5 class="fw-bold text-danger mb-2"><i class="fas fa-triangle-exclamation me-2"></i> Danger Zone</h5>
        <p class="extra-small text-secondary-custom mb-3">Deleting your account permanently removes your booking history, saved wishlists, reviews, and active chat logs.</p>
        <button type="button" class="btn btn-outline-danger btn-sm px-3" onclick="if(confirm('Are you absolutely sure you want to delete your NeighborNest account? This cannot be undone.')) { alert('Account deletion simulated.'); }">
          <i class="fas fa-trash-can me-1"></i> Delete My Account
        </button>
      </div>

      <div class="d-flex justify-content-end gap-2">
        <button type="reset" class="btn btn-light border px-4">Reset</button>
        <button type="submit" class="btn btn-nh-primary px-4">
          <i class="fas fa-floppy-disk me-1"></i> Save Preferences
        </button>
      </div>
    </form>

    <!-- CHANGE PASSWORD MODAL DIALOG -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
          <div class="modal-header border-bottom px-4 py-3">
            <h5 class="modal-title fw-bold fs-6" id="changePasswordModalLabel">
              <i class="fas fa-key text-bright-indigo me-2"></i> Change Account Password
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="settings.php" method="POST">
            <input type="hidden" name="action" value="change_password" />
            <div class="modal-body p-4">
              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary mb-1">Current Password *</label>
                <div class="input-group">
                  <input type="password" name="current_password" id="currentPassword" class="form-control rounded-start-3" placeholder="Enter current password" required />
                  <button type="button" class="btn btn-outline-secondary rounded-end-3" onclick="togglePassVisibility('currentPassword', this)" title="Show/Hide Password"><i class="fas fa-eye"></i></button>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary mb-1">New Password *</label>
                <div class="input-group">
                  <input type="password" name="new_password" id="newPassword" class="form-control rounded-start-3" placeholder="Enter new password (min. 6 chars)" minlength="6" required />
                  <button type="button" class="btn btn-outline-secondary rounded-end-3" onclick="togglePassVisibility('newPassword', this)" title="Show/Hide Password"><i class="fas fa-eye"></i></button>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary mb-1">Confirm New Password *</label>
                <div class="input-group">
                  <input type="password" name="confirm_password" id="confirmPassword" class="form-control rounded-start-3" placeholder="Re-enter new password" minlength="6" required />
                  <button type="button" class="btn btn-outline-secondary rounded-end-3" onclick="togglePassVisibility('confirmPassword', this)" title="Show/Hide Password"><i class="fas fa-eye"></i></button>
                </div>
              </div>
            </div>
            <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
              <button type="button" class="btn btn-light border px-3" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-nh-primary px-4">
                <i class="fas fa-floppy-disk me-1"></i> Update Password
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>

  <script>
    function togglePassVisibility(inputId, btn) {
      const input = document.getElementById(inputId);
      const icon = btn ? btn.querySelector('i') : null;
      if (input && icon) {
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
    }
  </script>

  <?php require_once __DIR__ . '/includes/footer.php'; ?>