<?php
/**
 * Auth helper — handles session checks & user state.
 * Include this at the top of any page that needs user info.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isGuest() {
    return isset($_SESSION['is_guest']) && $_SESSION['is_guest'] === true;
}

function currentUser($pdo) {
    if (!isLoggedIn()) return null;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

function requireAuth() {
    if (!isLoggedIn() && !isGuest()) {
        header('Location: login.php');
        exit;
    }
}

function displayName() {
    if (isLoggedIn()) return $_SESSION['username'] ?? 'User';
    if (isGuest())    return 'Guest';
    return null;
}
?>