<?php
session_start();

// Hapus data user namun pertahankan sesi untuk membawa flash message
unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email']);
$_SESSION['flash'] = 'Berhasil logout';
session_destroy();

header('Location: index.php');
exit;
