<?php
// admin/skills/delete_skill.php
require_once "../../database/config.php";
if (!isset($_SESSION['user_id'])) { header('Location: ../../auth/login.php'); exit; }
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM skills WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: ../dashboard.php');
exit;
