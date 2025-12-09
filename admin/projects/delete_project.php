<?php
// admin/projects/delete_project.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

$id = $_GET['id'] ?? null;
if ($id) {
    // delete image file if exists
    $stmt = $conn->prepare("SELECT image_path FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r && $r['image_path']) {
        $file = __DIR__ . '/../../' . $r['image_path'];
        if (file_exists($file)) @unlink($file);
    }
    $del = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $del->execute([$id]);
}
header('Location: ../dashboard.php');
exit;
