<?php
// admin/dashboard.php
require_once "../database/config.php";
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard - Dynamic Resume</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../assets/js/main.js"></script>
</head>
<body>
  <?php include '../components/navbar.php'; ?>

  <div class="admin-container">
    <h1>Admin Dashboard</h1>
    <p class="muted">Logged in as: <?= htmlspecialchars($_SESSION['username']) ?></p>

    <div class="admin-grid">
      <a class="admin-card" href="about/add_about.php">Manage About</a>
      <a class="admin-card" href="skills/add_skill.php">Manage Skills</a>
      <a class="admin-card" href="projects/add_project.php">Manage Projects</a>
      <a class="admin-card" href="education/add_education.php">Manage Education</a>
      <a class="admin-card" href="images/update_profile.php">Update Profile Photo</a>
      <a class="admin-card" href="images/update_cover.php">Update Cover Photo</a>
    </div>

    <hr>

    <h2>Quick Lists</h2>
    <div class="list-grid">
      <div>
        <h3>About</h3>
        <?php
          $rows = $conn->query("SELECT * FROM about ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
          if (!$rows) echo "<p class='muted'>No about entries yet.</p>";
          foreach ($rows as $r) {
            echo "<div class='list-item'>{$r['content']} <span class='list-actions'><a href='about/edit_about.php?id={$r['id']}'>Edit</a> | <a href='#' onclick=\"confirmDelete('about','{$r['id']}')\">Delete</a></span></div>";
          }
        ?>
      </div>

      <div>
        <h3>Skills</h3>
        <?php
          $rows = $conn->query("SELECT * FROM skills ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
          if (!$rows) echo "<p class='muted'>No skills yet.</p>";
          foreach ($rows as $r) {
            echo "<div class='list-item'>{$r['name']} <span class='list-actions'><a href='skills/edit_skill.php?id={$r['id']}'>Edit</a> | <a href='#' onclick=\"confirmDelete('skills','{$r['id']}')\">Delete</a></span></div>";
          }
        ?>
      </div>

      <div>
        <h3>Projects</h3>
        <?php
          $rows = $conn->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
          if (!$rows) echo "<p class='muted'>No projects yet.</p>";
          foreach ($rows as $r) {
            echo "<div class='list-item'>{$r['title']} <span class='list-actions'><a href='projects/edit_project.php?id={$r['id']}'>Edit</a> | <a href='#' onclick=\"confirmDelete('projects','{$r['id']}')\">Delete</a></span></div>";
          }
        ?>
      </div>

      <div>
        <h3>Education</h3>
        <?php
          $rows = $conn->query("SELECT * FROM education ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
          if (!$rows) echo "<p class='muted'>No education entries yet.</p>";
          foreach ($rows as $r) {
            echo "<div class='list-item'>{$r['school']} <span class='list-actions'><a href='education/edit_education.php?id={$r['id']}'>Edit</a> | <a href='#' onclick=\"confirmDelete('education','{$r['id']}')\">Delete</a></span></div>";
          }
        ?>
      </div>
    </div>

  </div>

  <?php include '../components/footer.php'; ?>
</body>
</html>
