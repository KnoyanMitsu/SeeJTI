<?php
include 'core.php';
session_start();
session_unset();
session_destroy();
echo json_encode(['status' => 'berhasil']);
?>