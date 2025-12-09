<?php
// auth/login.php
require_once "../database/config.php";

// if already logged in -> go to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: ../admin/dashboard.php');
    exit;
}

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $err = "Provide both email and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, email, password_hash FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password_hash'])) {
            // login success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: ../admin/dashboard.php');
            exit;
        } else {
            $err = "Invalid credentials.";
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Login - Dynamic Resume</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="login-bg">
  <div class="login-box">
    <h2>Admin Login</h2>

    <?php if ($err): ?>
      <div class="alert error"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button class="btn-primary" type="submit">Login</button>
      <p class="muted">Use <strong>admin@gmail.com</strong> / <strong>123456789</strong></p>
    </form>
  </div>
</body>
</html>
