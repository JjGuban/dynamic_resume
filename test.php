<?php
echo password_verify("123456789", '$2y$10$whatever-is-in-your-db') ? "match" : "no match";
?>
