<?php
// components/navbar.php
$loggedIn = isset($_SESSION['user_id']);
?>
<nav class="nav">
  <div class="nav-left">
    <a href="<?= $BASE_URL ?>">Portfolio</a>
  </div>
  <div class="nav-right">
    <?php if ($loggedIn): ?>
      <a href="<?= $BASE_URL ?>admin/dashboard.php">Dashboard</a>
      <a href="<?= $BASE_URL ?>auth/logout.php">Logout</a>
    <?php else: ?>
      <a href="<?= $BASE_URL ?>auth/login.php">Admin</a>
    <?php endif; ?>
  </div>
</nav>
