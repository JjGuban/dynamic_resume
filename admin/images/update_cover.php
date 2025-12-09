<?php
// admin/images/update_cover.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['cover']['name'])) {
        $uploadDir = __DIR__ . '/../../assets/uploads/cover/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = time() . '_' . basename($_FILES['cover']['name']);
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
            $conn->prepare("INSERT INTO images (type, file_path) VALUES ('cover', ?)")->execute([$filename]);
            header('Location: ../dashboard.php');
            exit;
        } else {
            $msg = "Upload failed.";
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Update Cover Photo</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include '../../components/navbar.php'; ?>
  <div class="form-container">
    <h2>Update Cover Photo</h2>
    <?php if ($msg) echo "<div class='alert error'>$msg</div>"; ?>
    <form method="post" enctype="multipart/form-data">
      <input type="file" name="cover" accept="image/*" required>
      <button class="btn-primary" type="submit">Upload</button>
    </form>
  </div>
  <?php include '../../components/footer.php'; ?>
</body>
</html>
