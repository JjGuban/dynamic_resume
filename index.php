<?php
// index.php (public)
require_once "database/config.php";

// get latest profile and cover from images
$profile = $conn->query("SELECT file_path FROM images WHERE type='profile' ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$cover = $conn->query("SELECT file_path FROM images WHERE type='cover' ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

$about = $conn->query("SELECT * FROM about ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$skills = $conn->query("SELECT * FROM skills ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$projects = $conn->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$education = $conn->query("SELECT * FROM education ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Jacinto Jose M. Guban — Resume</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <?php include 'components/navbar.php'; ?>

  <header class="hero">
    <?php if ($cover && $cover['file_path']): ?>
      <img src="assets/uploads/cover/<?= htmlspecialchars($cover['file_path']) ?>" class="cover">
    <?php else: ?>
      <img src="assets/img/cover-placeholder.jpg" class="cover">
    <?php endif; ?>

    <div class="profile-info">
      <?php if ($profile && $profile['file_path']): ?>
        <img src="assets/uploads/profile/<?= htmlspecialchars($profile['file_path']) ?>" class="profile-img">
      <?php else: ?>
        <img src="assets/img/profile-placeholder.jpg" class="profile-img">
      <?php endif; ?>
      <h1>Jacinto Jose M. Guban</h1>
      <p class="muted">Aspiring Software Engineer</p>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a class="btn-small" href="admin/dashboard.php">Admin Dashboard</a>
      <?php endif; ?>
    </div>
  </header>

  <div class="container">
    <section class="card">
      <h2>About</h2>
      <?php if (!$about) echo "<p class='muted'>No about yet.</p>"; ?>
      <?php foreach ($about as $a): ?>
        <p><?= nl2br(htmlspecialchars($a['content'])) ?></p>
      <?php endforeach; ?>
    </section>

    <section class="card">
      <h2>Technical Skills</h2>
      <?php if (!$skills) echo "<p class='muted'>No skills yet.</p>"; ?>
      <div class="skills-grid">
        <?php foreach ($skills as $s): ?>
          <div class="skill-pill"><?= htmlspecialchars($s['name']) ?> <small class="muted"><?= htmlspecialchars($s['category']) ?></small></div>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="card">
      <h2>Projects</h2>
      <?php if (!$projects) echo "<p class='muted'>No projects yet.</p>"; ?>
      <div class="project-grid">
        <?php foreach ($projects as $p): ?>
          <div class="project-card">
            <?php if ($p['image_path']): ?>
              <img src="<?= htmlspecialchars($p['image_path']) ?>" class="project-img">
            <?php else: ?>
              <img src="assets/img/project-placeholder.png" class="project-img">
            <?php endif; ?>
            <h3><?= htmlspecialchars($p['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($p['description'])) ?></p>
            <small class="muted"><?= htmlspecialchars($p['tech_stack']) ?></small>
            <?php if ($p['project_url']): ?>
              <p><a class="link" href="<?= htmlspecialchars($p['project_url']) ?>" target="_blank">View project</a></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id'])): ?>
              <div><a href="admin/projects/edit_project.php?id=<?= $p['id'] ?>">Edit</a> | <a href="#" onclick="confirmDelete('projects', <?= $p['id'] ?>)">Delete</a></div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="card">
      <h2>Education & Certifications</h2>
      <?php if (!$education) echo "<p class='muted'>No education entries yet.</p>"; ?>
      <?php foreach ($education as $e): ?>
        <div class="edu-item">
          <strong><?= htmlspecialchars($e['school']) ?></strong> — <?= htmlspecialchars($e['degree']) ?> (<?= htmlspecialchars($e['year']) ?>)
          <?php if ($e['image_path']): ?><div><img src="<?= htmlspecialchars($e['image_path']) ?>" style="height:70px"></div><?php endif; ?>
          <?php if (isset($_SESSION['user_id'])): ?>
            <div><a href="admin/education/edit_education.php?id=<?= $e['id'] ?>">Edit</a> | <a href="#" onclick="confirmDelete('education', <?= $e['id'] ?>)">Delete</a></div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </section>
  </div>

  <?php include 'components/footer.php'; ?>
  <script src="assets/js/main.js"></script>
</body>
</html>
