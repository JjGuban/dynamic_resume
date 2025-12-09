<?php
// admin/skills/edit_skill.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

$id = $_GET['id'] ?? null; if (!$id) header('Location: ../dashboard.php');

$stmt = $conn->prepare("SELECT * FROM skills WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) header('Location: ../dashboard.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    if ($name !== '') {
        $update = $conn->prepare("UPDATE skills SET name=?, category=? WHERE id=?");
        $update->execute([$name, $category, $id]);
        header('Location: ../dashboard.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Skill - Admin</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include '../../components/navbar.php'; ?>
  <div class="form-container">
    <h2>Edit Skill</h2>
    <form method="post">
      <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
      <input type="text" name="category" value="<?php echo htmlspecialchars($row['category']); ?>">
      <button class="btn-primary" type="submit">Update Skill</button>
    </form>
  </div>
  <?php include '../../components/footer.php'; ?>
</body>
</html>
