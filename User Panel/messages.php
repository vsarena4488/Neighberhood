<?php
require_once __DIR__ . '/includes/functions.php';

$chats = &$_SESSION['user_chats'];
$activeChatId = $_GET['chat'] ?? $chats[0]['id'];

// Find active conversation
$activeChat = null;
foreach ($chats as &$c) {
    if ($c['id'] === $activeChatId) {
        $activeChat = &$c;
        $c['unread'] = 0; // mark as read
        break;
    }
}
if (!$activeChat) $activeChat = &$chats[0];

// Handle new chat message submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message_text'])) {
    $newMsgText = trim($_POST['message_text']);
    $activeChat['messages'][] = [
        'sender' => 'user',
        'text' => $newMsgText,
        'time' => date('h:i A')
    ];
    $activeChat['last_message'] = $newMsgText;
    $activeChat['last_time'] = 'Just now';
}

$pageTitle = 'Messages · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
      <div>
        <h3 class="fw-bold mb-0">Messages & Inquiries</h3>
        <span class="text-secondary-custom small">Direct verified communication with property hosts and landlords</span>
      </div>
    </div>

    <!-- 2-COLUMN CHAT ENGINE -->
    <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden" style="height: 720px;">
      <div class="row g-0 h-100">
        <!-- LEFT CONVERSATIONS LIST (Col-4) -->
        <div class="col-md-5 col-lg-4 border-end d-flex flex-column h-100">
          <div class="p-3 border-bottom">
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
              <input type="text" class="form-control bg-light border-start-0" placeholder="Search conversations..." />
            </div>
          </div>

          <div class="flex-grow-1 overflow-y-auto p-2 d-flex flex-column gap-1">
            <?php foreach ($chats as $ch): ?>
              <a href="messages.php?chat=<?= $ch['id'] ?>" class="p-2.5 rounded-3 border-0 text-decoration-none d-flex align-items-center gap-2.5 <?= ($ch['id'] === $activeChat['id']) ? 'bg-soft-lavender' : 'bg-white hover-bg-light' ?>" style="transition: var(--nh-transition);">
                <div class="position-relative" style="flex-shrink: 0;">
                  <img src="<?= htmlspecialchars($ch['owner_avatar']) ?>" alt="<?= htmlspecialchars($ch['owner_name']) ?>" class="rounded-circle" style="width: 44px; height: 44px; object-fit: cover;" />
                  <?php if (!empty($ch['online'])): ?>
                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle"></span>
                  <?php endif; ?>
                </div>

                <div class="flex-grow-1 overflow-hidden">
                  <div class="d-flex justify-content-between align-items-center mb-0.5">
                    <strong class="small text-dark text-truncate"><?= htmlspecialchars($ch['owner_name']) ?></strong>
                    <span class="fs-xs text-muted"><?= htmlspecialchars($ch['last_time']) ?></span>
                  </div>
                  <span class="extra-small text-primary fw-semibold d-block text-truncate"><?= htmlspecialchars($ch['property_title']) ?></span>
                  <p class="extra-small text-secondary-custom mb-0 text-truncate"><?= htmlspecialchars($ch['last_message']) ?></p>
                </div>

                <?php if ($ch['unread'] > 0): ?>
                  <span class="badge bg-danger rounded-pill extra-small"><?= $ch['unread'] ?></span>
                <?php endif; ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- RIGHT ACTIVE CHAT WINDOW (Col-8) -->
        <div class="col-md-7 col-lg-8 d-flex flex-column h-100 bg-light">
          <!-- Chat Header -->
          <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2.5">
              <img src="<?= htmlspecialchars($activeChat['owner_avatar']) ?>" alt="<?= htmlspecialchars($activeChat['owner_name']) ?>" class="rounded-circle" style="width: 42px; height: 42px; object-fit: cover;" />
              <div>
                <strong class="d-block small text-dark"><?= htmlspecialchars($activeChat['owner_name']) ?></strong>
                <span class="extra-small text-success"><i class="fas fa-circle fs-xs me-1"></i> Verified Property Host</span>
              </div>
            </div>

            <!-- Property / Booking Reference Badge Pill -->
            <div class="d-flex align-items-center gap-2">
              <a href="property-details.php?id=<?= $activeChat['property_id'] ?>" class="btn btn-sm btn-light border extra-small text-decoration-none">
                <i class="fas fa-building text-primary me-1"></i> <?= htmlspecialchars($activeChat['property_title']) ?>
              </a>
              <?php if (!empty($activeChat['booking_id'])): ?>
                <a href="booking-details.php?id=<?= $activeChat['booking_id'] ?>" class="badge bg-primary extra-small text-decoration-none p-2">
                  #<?= htmlspecialchars($activeChat['booking_id']) ?>
                </a>
              <?php endif; ?>
            </div>
          </div>

          <!-- Chat Messages Body -->
          <div class="flex-grow-1 overflow-y-auto p-3.5 d-flex flex-column gap-3" id="chatMessageContainer">
            <div class="text-center my-2">
              <span class="badge bg-white text-muted border px-3 py-1.5 extra-small">End-to-End Encrypted Inquiry Channel</span>
            </div>

            <?php foreach ($activeChat['messages'] as $msg): ?>
              <?php if ($msg['sender'] === 'user'): ?>
                <!-- Student Bubble (Right) -->
                <div class="d-flex flex-column align-items-end">
                  <div class="p-3 rounded-4 shadow-sm text-white" style="max-width: 75%; background: var(--nh-gradient-primary); border-bottom-right-radius: 4px;">
                    <p class="mb-0 small"><?= htmlspecialchars($msg['text']) ?></p>
                  </div>
                  <span class="fs-xs text-muted mt-1 me-1"><?= htmlspecialchars($msg['time']) ?> <i class="fas fa-check-double text-primary ms-1"></i></span>
                </div>
              <?php else: ?>
                <!-- Host Bubble (Left) -->
                <div class="d-flex flex-column align-items-start">
                  <div class="p-3 rounded-4 shadow-sm bg-white border text-dark" style="max-width: 75%; border-bottom-left-radius: 4px;">
                    <p class="mb-0 small"><?= htmlspecialchars($msg['text']) ?></p>
                  </div>
                  <span class="fs-xs text-muted mt-1 ms-1"><?= htmlspecialchars($msg['time']) ?></span>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>

          <!-- Chat Input Bar -->
          <div class="p-3 bg-white border-top">
            <form action="messages.php?chat=<?= $activeChat['id'] ?>" method="POST" class="d-flex align-items-center gap-2">
              <button type="button" class="btn btn-light border rounded-circle p-2" title="Attach Photos or Documents" onclick="alert('Photo attachment dialog simulated.')">
                <i class="fas fa-paperclip text-muted"></i>
              </button>
              <input type="text" name="message_text" class="form-control rounded-pill px-3.5" placeholder="Type your message to host..." required autocomplete="off" />
              <button type="submit" class="btn btn-nh-primary px-4 py-2 flex-shrink-0">
                <i class="fas fa-paper-plane me-1"></i> Send
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById("chatMessageContainer");
    if (container) {
      container.scrollTop = container.scrollHeight;
    }
  });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
