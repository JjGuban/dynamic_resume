<?php
// admin/skills/add_skill.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    if ($name !== '') {
        $stmt = $conn->prepare("INSERT INTO skills (name, category) VALUES (?, ?)");
        $stmt->execute([$name, $category]);
        header('Location: ../dashboard.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Skill - Admin</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include '../../components/navbar.php'; ?>
  <div class="form-container">
    <h2>Add Skill</h2>
    <form method="post">
      <input type="text" name="name" placeholder="Skill name (e.g. JavaScript)" required>
      <input type="text" name="category" placeholder="Category (Language / Framework / Tool)">
      <button class="btn-primary" type="submit">Add Skill</button>
    </form>
  </div>
  <?php include '../../components/footer.php'; ?>
</body>
</html>
