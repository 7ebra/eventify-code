<?php
require 'includes/auth.php';

session_start();
$_SESSION['is_guest'] = true;
$_SESSION['guest_started'] = time();

header('Location: index.php?guest=1');
exit;
?>