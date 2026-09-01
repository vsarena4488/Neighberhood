<?php
// Owner Panel settings.php - Preferences & Change Password Modal
$pageTitle = 'Account Settings · NeighborNest Owner Console';
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
            $message = 'Your host account password has been updated successfully!';
            $messageType = 'success';
        }
    } else {
        $message = 'Your host notification & account preferences have been saved!';
        $messageType = 'success';
    }
}

$pageTitle = 'Account Settings · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    
    <!-- Header Title -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">Account & Alert Settings</h3>
        <span class="text-secondary-custom small">Configure instant notification preferences, WhatsApp alerts, privacy settings, and security passwords</span>
      </div>
    </div>

    <?php if ($message): ?>
      <div class="alert alert-<?= $messageType ?> alert-dismissible fade show rounded-4 mb-4 shadow-sm" role="alert">
        <i class="fas <?= ($messageType === 'success') ? 'fa-check-circle' : 'fa-triangle-exclamation' ?> me-1"></i> <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form action="settings.php" method="POST">
      
      <!-- 1. NOTIFICATION PREFERENCES -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-bell text-bright-indigo me-2"></i> Instant Notification Channels</h5>
        
        <div class="d-flex flex-column gap-3 extra-small">
          <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
            <div>
              <strong class="d-block text-dark">Instant WhatsApp Alerts for Booking Requests</strong>
              <span class="text-secondary-custom">Receive instant WhatsApp messages when a student pays token fee and submits a booking application.</span>
            </div>
            <div class="form-check form-switch fs-5">
              <input class="form-check-input" type="checkbox" checked />
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
            <div>
              <strong class="d-block text-dark">Email Alerts for Tenant Messages</strong>
              <span class="text-secondary-custom">Get email notifications when tenants post questions about your properties.</span>
            </div>
            <div class="form-check form-switch fs-5">
              <input class="form-check-input" type="checkbox" checked />
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <div>
              <strong class="d-block text-dark">SMS Rent Payout Confirmations</strong>
              <span class="text-secondary-custom">SMS alert when withdrawal payouts are deposited to your bank account.</span>
            </div>
            <div class="form-check form-switch fs-5">
              <input class="form-check-input" type="checkbox" checked />
            </div>
          </div>
        </div>
      </div>

      <!-- 2. SECURITY & CHANGE PASSWORD -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-shield-halved text-bright-indigo me-2"></i> Security & Password</h5>
        
        <p class="extra-small text-secondary-custom mb-3">Ensure your host account stays secure by periodically updating your password.</p>
        <button type="button" class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
          <i class="fas fa-key me-1 text-primary"></i> Change Account Password
        </button>
      </div>

      <!-- 3. DANGER ZONE -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4 border-start border-danger border-4">
        <h5 class="fw-bold text-danger mb-2"><i class="fas fa-triangle-exclamation me-2"></i> Danger Zone</h5>
        <p class="extra-small text-secondary-custom mb-3">Deleting your owner account removes your listed accommodations, active booking histories, and host reputation badges.</p>
        <button type="button" class="btn btn-outline-danger btn-sm px-3" onclick="if(confirm('Are you absolutely sure you want to delete your NeighborNest owner account? This action cannot be undone.')) { alert('Account deletion simulated.'); }">
          <i class="fas fa-trash-can me-1"></i> Delete My Owner Account
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
              <i class="fas fa-key text-bright-indigo me-2"></i> Change Host Account Password
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
    const field = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (field.type === 'password') {
      field.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      field.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
