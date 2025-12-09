<?php
// admin/about/add_about.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content'] ?? '');
    if ($content !== '') {
        $stmt = $conn->prepare("INSERT INTO about (content) VALUES (?)");
        $stmt->execute([$content]);
        echo "<script>window.opener=null;window.location='../dashboard.php';</script>";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add About - Admin</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include '../../components/navbar.php'; ?>
  <div class="form-container">
    <h2>Add About</h2>
    <form method="post">
      <textarea name="content" rows="6" placeholder="Write about yourself..." required></textarea>
      <button class="btn-primary" type="submit">Save</button>
    </form>
  </div>
  <?php include '../../components/footer.php'; ?>
</body>
</html>
