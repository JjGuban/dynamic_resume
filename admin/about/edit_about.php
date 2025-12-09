<?php
// admin/about/edit_about.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: ../dashboard.php'); exit; }

$stmt = $conn->prepare("SELECT * FROM about WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) { header('Location: ../dashboard.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content'] ?? '');
    if ($content !== '') {
        $update = $conn->prepare("UPDATE about SET content = ? WHERE id = ?");
        $update->execute([$content, $id]);
        echo "<script>location.href='../dashboard.php';</script>";
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit About - Admin</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include '../../components/navbar.php'; ?>
  <div class="form-container">
    <h2>Edit About</h2>
    <form method="post">
      <textarea name="content" rows="6" required><?php echo htmlspecialchars($row['content']); ?></textarea>
      <button class="btn-primary" type="submit">Update</button>
    </form>
  </div>
  <?php include '../../components/footer.php'; ?>
</body>
</html>
