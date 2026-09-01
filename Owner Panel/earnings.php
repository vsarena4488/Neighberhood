<?php
// Owner Panel earnings.php - Financial Overview & Payouts
$pageTitle = 'Earnings & Payouts · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';

$earnings = $_SESSION['owner_earnings'] ?? [];
$txns = $earnings['transactions'] ?? [];

$pageTitle = 'Earnings & Payouts · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">

    <!-- Page Header & Withdraw Action -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">Financial Earnings & Payouts</h3>
        <span class="text-secondary-custom small">Track rent revenue payouts, token deposits, transaction history, and instant bank withdrawals</span>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-light border px-3" onclick="alert('Exporting earnings data as CSV...')">
          <i class="fas fa-file-csv me-1 text-success"></i> Export CSV
        </button>
        <button class="btn btn-nh-primary px-3.5 shadow-sm" data-bs-toggle="modal" data-bs-target="#withdrawModal">
          <i class="fas fa-arrow-up-from-ground-water me-1"></i> Request Payout Withdrawal
        </button>
      </div>
    </div>



    <!-- TRANSACTIONS HISTORY TABLE CARD -->
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
      <h5 class="fw-bold mb-3"><i class="fas fa-receipt text-bright-indigo me-2"></i> Recent Transaction Logs</h5>

      <div class="table-responsive">
        <table class="table table-hover align-middle extra-small mb-0">
          <thead class="table-light">
            <tr>
              <th>TXN Reference ID</th>
              <th>Date & Time</th>
              <th>Student Tenant</th>
              <th>Property</th>
              <th>Payment Type</th>
              <th>Status</th>
              <th class="text-end">Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($txns as $tx): ?>
              <tr>
                <td><strong class="text-royal-blue"><?= htmlspecialchars($tx['id']) ?></strong></td>
                <td><?= htmlspecialchars($tx['date']) ?></td>
                <td><strong class="text-dark"><?= htmlspecialchars($tx['tenant']) ?></strong></td>
                <td><?= htmlspecialchars($tx['property']) ?></td>
                <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($tx['type']) ?></span></td>
                <td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="fas fa-check-circle me-1"></i> <?= htmlspecialchars($tx['status']) ?></span></td>
                <td class="text-end"><strong class="text-success fs-6">+ ₹<?= number_format($tx['amount']) ?></strong></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- WITHDRAWAL REQUEST MODAL -->
    <div class="modal fade" id="withdrawModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
          <div class="modal-header border-bottom px-4 py-3">
            <h5 class="modal-title fw-bold fs-6"><i class="fas fa-wallet text-bright-indigo me-2"></i> Request Payout Withdrawal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="earnings.php" method="POST" onsubmit="alert('Withdrawal request of ₹' + document.getElementById('withdrawAmt').value + ' submitted successfully!');">
            <div class="modal-body p-4">
              <div class="p-3 bg-soft-lavender rounded-3 mb-3 text-royal-blue extra-small">
                Available Withdrawable Balance: <strong class="fs-6">₹<?= number_format($earnings['withdrawable'] ?? 65000) ?></strong>
              </div>

              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary mb-1">Withdrawal Amount (₹) *</label>
                <input type="number" id="withdrawAmt" name="amount" class="form-control rounded-3" value="25000" max="<?= $earnings['withdrawable'] ?? 65000 ?>" required />
              </div>

              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary mb-1">Select Bank Account / UPI ID *</label>
                <select class="form-select rounded-3">
                  <option value="bank" selected>HDFC Bank (A/C: XXXX-XXXX-4891)</option>
                  <option value="upi">UPI ID (rajesh@okicici)</option>
                </select>
              </div>
            </div>

            <div class="modal-footer border-top px-4 py-3 bg-light">
              <button type="button" class="btn btn-light border px-3" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-nh-primary px-4"><i class="fas fa-check-circle me-1"></i> Confirm Withdrawal</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>

  <?php require_once __DIR__ . '/includes/footer.php'; ?>