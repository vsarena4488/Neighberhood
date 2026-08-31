<?php
require_once __DIR__ . '/includes/functions.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = 'Your account settings & notification preferences have been saved!';
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
      <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 small" role="alert">
        <i class="fas fa-circle-check me-2"></i> <?= htmlspecialchars($message) ?>
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
            <button type="button" class="btn btn-sm btn-light border" onclick="alert('Password change dialog simulated.')">
              <i class="fas fa-key me-1 text-primary"></i> Change Account Password
            </button>
          </div>
        </div>
      </div>

      <!-- 3. PLATFORM PREFERENCES -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-sliders text-bright-indigo me-2"></i> Regional & Localization Preferences</h5>
        
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label small fw-bold text-secondary mb-1">Display Language</label>
            <select class="form-select rounded-3">
              <option value="en" selected>English (India)</option>
              <option value="hi">हिंदी (Hindi)</option>
              <option value="kn">ಕನ್ನಡ (Kannada)</option>
              <option value="te">తెలుగు (Telugu)</option>
              <option value="ta">தமிழ் (Tamil)</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label small fw-bold text-secondary mb-1">Currency Format</label>
            <select class="form-select rounded-3">
              <option value="inr" selected>₹ INR (Indian Rupee)</option>
              <option value="usd">$ USD (US Dollar)</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label small fw-bold text-secondary mb-1">Distance Metric</label>
            <select class="form-select rounded-3">
              <option value="km" selected>Kilometers (km)</option>
              <option value="miles">Miles (mi)</option>
            </select>
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
  </main>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
