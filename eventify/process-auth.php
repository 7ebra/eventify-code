<?php
require 'config/database.php';
require 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$action = $_POST['action'] ?? '';
$errors = [];

if ($action === 'signup') {
    $full_name = trim($_POST['full_name'] ?? '');
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';

    // Validate
    if (strlen($full_name) < 2) $errors[] = 'Please enter your name.';
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) 
        $errors[] = 'Username must be 3-20 chars (letters, numbers, underscore).';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email.';
    if (strlen($password) < 6) $errors[] = 'Password needs at least 6 characters.';

    // Check uniqueness
    if (!$errors) {
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email=? OR username=?");
        $stmt->execute([$email, $username]);
        if ($stmt->fetch()) $errors[] = 'That email or username is already taken.';
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = compact('full_name','username','email');
        header('Location: signup.php');
        exit;
    }

    // Insert
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password_hash, full_name)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$username, $email, $hash, $full_name]);

    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['username'] = $username;
    header('Location: index.php?welcome=1');
    exit;
}

if ($action === 'login') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        $_SESSION['errors'] = ['Email or password doesn\'t match. Try again.'];
        $_SESSION['old'] = ['email' => $email];
        header('Location: login.php');
        exit;
    }

    $pdo->prepare("UPDATE users SET last_login = NOW() WHERE user_id = ?")
        ->execute([$user['user_id']]);

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    header('Location: index.php');
    exit;
}

header('Location: login.php');
exit;
?>