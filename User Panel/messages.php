<?php
require_once __DIR__ . '/includes/functions.php';

$chats = &$_SESSION['user_chats'];
$activeChatId = $_GET['chat'] ?? $chats[0]['id'];
$mobileView = isset($_GET['chat']) ? 'chat' : 'list';

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

<style>
  /* Messages Page Custom Styles & Spacing System */
  .chat-card-container {
    height: calc(100vh - 200px);
    min-height: 560px;
    max-height: 760px;
    border: 1px solid var(--nh-border);
    border-radius: 16px;
    background: #FFFFFF;
    box-shadow: var(--nh-shadow-subtle);
    overflow: hidden;
  }

  .chat-item {
    padding: 0.75rem 0.85rem;
    border-radius: 12px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transition: var(--nh-transition);
    position: relative;
  }

  .chat-item:hover {
    background: var(--nh-bg-light);
  }

  .chat-item.active {
    background: var(--nh-soft-lavender);
  }

  .chat-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 15%;
    height: 70%;
    width: 3.5px;
    background: var(--nh-bright-indigo);
    border-radius: 0 4px 4px 0;
  }

  .chat-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
  }

  .online-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 10px;
    height: 10px;
    background-color: var(--nh-success);
    border: 2px solid #FFFFFF;
    border-radius: 50%;
  }

  .chat-bubble-user {
    background: var(--nh-gradient-primary);
    color: #FFFFFF;
    border-radius: 18px 18px 4px 18px;
    padding: 0.75rem 1.1rem;
    max-width: 78%;
    box-shadow: 0 3px 10px rgba(79, 70, 229, 0.18);
    font-size: 0.88rem;
    line-height: 1.45;
  }

  .chat-bubble-host {
    background: #FFFFFF;
    border: 1px solid var(--nh-border);
    color: var(--nh-dark-text);
    border-radius: 18px 18px 18px 4px;
    padding: 0.75rem 1.1rem;
    max-width: 78%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    font-size: 0.88rem;
    line-height: 1.45;
  }

  .chat-input-field {
    height: 44px;
    border-radius: 50px;
    padding: 0 1.25rem;
    font-size: 0.88rem;
    border: 1px solid var(--nh-border);
    transition: var(--nh-transition);
  }

  .chat-input-field:focus {
    border-color: var(--nh-bright-indigo);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
    outline: none;
    background: #FFFFFF;
  }

  .btn-attach {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: var(--nh-bg-light);
    border: 1px solid var(--nh-border);
    color: var(--nh-secondary-text);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: var(--nh-transition);
    cursor: pointer;
    flex-shrink: 0;
  }

  .btn-attach:hover {
    background: var(--nh-soft-lavender);
    color: var(--nh-royal-blue);
    border-color: var(--nh-lavender-border);
  }
</style>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <!-- Page Header Title -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">Messages & Inquiries</h3>
        <span class="text-secondary-custom small">Direct verified communication with property hosts and landlords</span>
      </div>
    </div>

    <!-- 2-COLUMN CHAT CARD CONTAINER -->
    <div class="chat-card-container">
      <div class="row g-0 h-100">

        <!-- LEFT CONVERSATIONS LIST PANEL -->
        <div class="col-md-5 col-lg-4 border-end d-flex flex-column h-100 <?= ($mobileView === 'chat') ? 'd-none d-md-flex' : 'd-flex' ?>">
          <!-- Search Conversations Bar -->
          <div class="p-3 border-bottom bg-white">
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-muted"><i class="fas fa-search"></i></span>
              <input type="text" class="form-control bg-light border-start-0 rounded-end-pill py-2 extra-small" placeholder="Search conversations..." />
            </div>
          </div>

          <!-- Conversations List -->
          <div class="flex-grow-1 overflow-y-auto p-2.5 d-flex flex-column gap-1.5">
            <?php foreach ($chats as $ch): ?>
              <a href="messages.php?chat=<?= $ch['id'] ?>" class="chat-item <?= ($ch['id'] === $activeChat['id']) ? 'active' : '' ?>">
                <div class="position-relative flex-shrink-0">
                  <img src="<?= htmlspecialchars($ch['owner_avatar']) ?>" alt="<?= htmlspecialchars($ch['owner_name']) ?>" class="chat-avatar" />
                  <?php if (!empty($ch['online'])): ?>
                    <span class="online-indicator"></span>
                  <?php endif; ?>
                </div>

                <div class="flex-grow-1 overflow-hidden">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong class="small text-dark text-truncate fw-bold"><?= htmlspecialchars($ch['owner_name']) ?></strong>
                    <span class="fs-xs text-muted ms-1 flex-shrink-0"><?= htmlspecialchars($ch['last_time']) ?></span>
                  </div>
                  <span class="extra-small text-primary fw-semibold d-block text-truncate mb-0.5"><?= htmlspecialchars($ch['property_title']) ?></span>
                  <p class="extra-small text-secondary-custom mb-0 text-truncate"><?= htmlspecialchars($ch['last_message']) ?></p>
                </div>

                <?php if ($ch['unread'] > 0): ?>
                  <span class="badge bg-danger rounded-pill extra-small px-2 py-1 flex-shrink-0"><?= $ch['unread'] ?></span>
                <?php endif; ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- RIGHT ACTIVE CHAT WINDOW PANEL -->
        <div class="col-md-7 col-lg-8 d-flex flex-column h-100 bg-light <?= ($mobileView === 'list') ? 'd-none d-md-flex' : 'd-flex' ?>">

          <!-- Chat Header Bar -->
          <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2.5">
              <!-- Back button on Mobile -->
              <a href="messages.php" class="btn btn-sm btn-light border p-2 d-md-none me-1" title="Back to All Chats">
                <i class="fas fa-arrow-left text-dark"></i>
              </a>

              <img src="<?= htmlspecialchars($activeChat['owner_avatar']) ?>" alt="<?= htmlspecialchars($activeChat['owner_name']) ?>" class="chat-avatar" style="width: 42px; height: 42px;" />
              <div>
                <strong class="d-block small text-dark fw-bold lh-1 mb-1"><?= htmlspecialchars($activeChat['owner_name']) ?></strong>
                <span class="extra-small text-success fw-semibold"><i class="fas fa-circle fs-xs me-1"></i> Verified Host</span>
              </div>
            </div>

            <!-- Property & Booking Badges -->
            <div class="d-flex align-items-center gap-2">
              <a href="property-details.php?id=<?= $activeChat['property_id'] ?>" class="btn btn-sm btn-light border extra-small text-decoration-none text-truncate d-none d-sm-inline-flex align-items-center gap-1.5 px-3 py-1.5 rounded-pill" style="max-width: 200px;">
                <i class="fas fa-building text-primary"></i> <?= htmlspecialchars($activeChat['property_title']) ?>
              </a>
              <?php if (!empty($activeChat['booking_id'])): ?>
                <a href="booking-details.php?id=<?= $activeChat['booking_id'] ?>" class="badge bg-primary extra-small text-decoration-none px-2.5 py-1.5 rounded-pill">
                  #<?= htmlspecialchars($activeChat['booking_id']) ?>
                </a>
              <?php endif; ?>
            </div>
          </div>

          <!-- Chat Messages Body -->
          <div class="flex-grow-1 overflow-y-auto p-3 p-md-4 d-flex flex-column gap-3" id="chatMessageContainer" style="background-color: #F8FAFC;">
            <div class="text-center my-1">
              <span class="badge bg-white text-muted border px-3 py-1.5 extra-small rounded-pill shadow-sm">
                <i class="fas fa-lock text-success me-1"></i> End-to-End Encrypted Inquiry
              </span>
            </div>

            <?php foreach ($activeChat['messages'] as $msg): ?>
              <?php if ($msg['sender'] === 'user'): ?>
                <!-- Student Bubble (Right) -->
                <div class="d-flex flex-column align-items-end">
                  <div class="chat-bubble-user">
                    <p class="mb-0"><?= htmlspecialchars($msg['text']) ?></p>
                  </div>
                  <span class="fs-xs text-muted mt-1 me-1"><?= htmlspecialchars($msg['time']) ?> <i class="fas fa-check-double text-primary ms-1"></i></span>
                </div>
              <?php else: ?>
                <!-- Host Bubble (Left) -->
                <div class="d-flex flex-column align-items-start">
                  <div class="chat-bubble-host">
                    <p class="mb-0"><?= htmlspecialchars($msg['text']) ?></p>
                  </div>
                  <span class="fs-xs text-muted mt-1 ms-1"><?= htmlspecialchars($msg['time']) ?></span>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>

          <!-- Chat Input Bar -->
          <div class="p-3 bg-white border-top">
            <form action="messages.php?chat=<?= $activeChat['id'] ?>" method="POST" class="d-flex align-items-center gap-2.5">
              <button type="button" class="btn-attach" title="Attach Photos" onclick="alert('Attachment feature simulated.')">
                <i class="fas fa-paperclip"></i>
              </button>
              <input type="text" name="message_text" class="form-control chat-input-field flex-grow-1" placeholder="Type your message..." required autocomplete="off" />
              <button type="submit" class="btn btn-nh-primary px-3.5 px-md-4 flex-shrink-0">
                <i class="fas fa-paper-plane me-1"></i> <span class="d-none d-sm-inline">Send</span>
              </button>
            </form>
          </div>

        </div>

      </div>
    </div>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const container = document.getElementById("chatMessageContainer");
      if (container) {
        container.scrollTop = container.scrollHeight;
      }
    });
  </script>

  <?php require_once __DIR__ . '/includes/footer.php'; ?>