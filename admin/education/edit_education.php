<?php
// admin/education/edit_education.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

$id = $_GET['id'] ?? null; if (!$id) header('Location: ../dashboard.php');
$stmt = $conn->prepare("SELECT * FROM education WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC); if (!$row) header('Location: ../dashboard.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school = trim($_POST['school'] ?? '');
    $degree = trim($_POST['degree'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $desc = trim($_POST['description'] ?? '');

    $image_path = $row['image_path'];
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/../../assets/uploads/education/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            if (!empty($image_path) && file_exists(__DIR__ . '/../../' . $image_path)) @unlink(__DIR__ . '/../../' . $image_path);
            $image_path = 'assets/uploads/education/' . $filename;
        }
    }

    $update = $conn->prepare("UPDATE education SET school=?, degree=?, year=?, description=?, image_path=? WHERE id=?");
    $update->execute([$school, $degree, $year, $desc, $image_path, $id]);
    header('Location: ../dashboard.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Education - Admin</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include '../../components/navbar.php'; ?>
  <div class="form-container">
    <h2>Edit Education</h2>
    <form method="post" enctype="multipart/form-data">
      <input type="text" name="school" value="<?= htmlspecialchars($row['school']) ?>" required>
      <input type="text" name="degree" value="<?= htmlspecialchars($row['degree']) ?>">
      <input type="text" name="year" value="<?= htmlspecialchars($row['year']) ?>">
      <textarea name="description" rows="4"><?= htmlspecialchars($row['description']) ?></textarea>
      <label>Replace Image (optional)</label>
      <input type="file" name="image" accept="image/*">
      <?php if ($row['image_path']): ?><p>Current: <img src="../../<?= $row['image_path'] ?>" style="height:60px"></p><?php endif; ?>
      <button class="btn-primary" type="submit">Update</button>
    </form>
  </div>
  <?php include '../../components/footer.php'; ?>
</body>
</html>
