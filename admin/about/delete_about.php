<?php
// admin/about/delete_about.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM about WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: ../dashboard.php');
exit;
