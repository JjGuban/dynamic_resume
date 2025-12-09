<?php
// admin/education/add_education.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school = trim($_POST['school'] ?? '');
    $degree = trim($_POST['degree'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $desc = trim($_POST['description'] ?? '');

    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/../../assets/uploads/education/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_path = 'assets/uploads/education/' . $filename;
        }
    }

    if ($school !== '') {
        $stmt = $conn->prepare("INSERT INTO education (school, degree, year, description, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$school, $degree, $year, $desc, $image_path]);
        header('Location: ../dashboard.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Education - Admin</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include '../../components/navbar.php'; ?>
  <div class="form-container">
    <h2>Add Education</h2>
    <form method="post" enctype="multipart/form-data">
      <input type="text" name="school" placeholder="School / Institution" required>
      <input type="text" name="degree" placeholder="Degree / Program">
      <input type="text" name="year" placeholder="Year(s)">
      <textarea name="description" rows="4" placeholder="Notes or honors (optional)"></textarea>
      <label>Image (optional)</label>
      <input type="file" name="image" accept="image/*">
      <button class="btn-primary" type="submit">Add Education</button>
    </form>
  </div>
  <?php include '../../components/footer.php'; ?>
</body>
</html>
