<?php
// admin/education/delete_education.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("SELECT image_path FROM education WHERE id = ?");
    $stmt->execute([$id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r && $r['image_path']) {
        $file = __DIR__ . '/../../' . $r['image_path'];
        if (file_exists($file)) @unlink($file);
    }
    $del = $conn->prepare("DELETE FROM education WHERE id = ?");
    $del->execute([$id]);
}
header('Location: ../dashboard.php');
exit;
