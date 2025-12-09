<?php
// admin/projects/add_project.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $tech = trim($_POST['tech'] ?? '');
    $url = trim($_POST['project_url'] ?? '');

    // handle image upload
    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/../../assets/uploads/projects/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_path = 'assets/uploads/projects/' . $filename;
        } else {
            $err = "Image upload failed.";
        }
    }

    if ($title !== '' && $err === '') {
        $stmt = $conn->prepare("INSERT INTO projects (title, description, tech_stack, image_path, project_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $tech, $image_path, $url]);
        header('Location: ../dashboard.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Project - Admin</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include '../../components/navbar.php'; ?>
  <div class="form-container">
    <h2>Add Project</h2>
    <?php if ($err) echo "<div class='alert error'>$err</div>"; ?>
    <form method="post" enctype="multipart/form-data">
      <input type="text" name="title" placeholder="Project Title" required>
      <input type="text" name="tech" placeholder="Tech stack (comma-separated)">
      <input type="url" name="project_url" placeholder="Project link (optional)">
      <textarea name="description" rows="5" placeholder="Short description"></textarea>
      <label>Project Image (optional)</label>
      <input type="file" name="image" accept="image/*">
      <button class="btn-primary" type="submit">Add Project</button>
    </form>
  </div>
  <?php include '../../components/footer.php'; ?>
</body>
</html>
