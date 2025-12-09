<?php
// admin/projects/edit_project.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

$id = $_GET['id'] ?? null; if (!$id) header('Location: ../dashboard.php');
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$project) header('Location: ../dashboard.php');

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $tech = trim($_POST['tech'] ?? '');
    $url = trim($_POST['project_url'] ?? '');

    // image handling (optional replace)
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/../../assets/uploads/projects/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // delete old if exists
            if (!empty($project['image_path']) && file_exists(__DIR__ . '/../../' . $project['image_path'])) {
                @unlink(__DIR__ . '/../../' . $project['image_path']);
            }
            $image_path = 'assets/uploads/projects/' . $filename;
        } else {
            $err = "Image upload failed.";
        }
    } else {
        $image_path = $project['image_path'];
    }

    if ($title !== '' && $err === '') {
        $update = $conn->prepare("UPDATE projects SET title=?, description=?, tech_stack=?, image_path=?, project_url=? WHERE id=?");
        $update->execute([$title, $description, $tech, $image_path, $url, $id]);
        header('Location: ../dashboard.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Project - Admin</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include '../../components/navbar.php'; ?>
  <div class="form-container">
    <h2>Edit Project</h2>
    <?php if ($err) echo "<div class='alert error'>$err</div>"; ?>
    <form method="post" enctype="multipart/form-data">
      <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required>
      <input type="text" name="tech" value="<?= htmlspecialchars($project['tech_stack']) ?>">
      <input type="url" name="project_url" value="<?= htmlspecialchars($project['project_url']) ?>">
      <textarea name="description" rows="5"><?= htmlspecialchars($project['description']) ?></textarea>
      <label>Replace Image (optional)</label>
      <input type="file" name="image" accept="image/*">
      <?php if ($project['image_path']): ?>
        <p>Current: <img src="../../<?= $project['image_path'] ?>" style="height:60px;border-radius:4px"></p>
      <?php endif; ?>
      <button class="btn-primary" type="submit">Update Project</button>
    </form>
  </div>
  <?php include '../../components/footer.php'; ?>
</body>
</html>
