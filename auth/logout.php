<?php
// auth/logout.php
require_once "../database/config.php";
session_unset();
session_destroy();
header('Location: login.php');
exit;
