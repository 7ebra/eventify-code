<?php
$pageTitle = 'Sign in';
require 'config/database.php';
require 'includes/auth.php';

if (isLoggedIn()) { header('Location: index.php'); exit; }

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

include 'includes/header.php';
?>

<div class="auth-wrap">
    <div class="auth-card">
        <span class="auth-script script">welcome back</span>
        <h1>Sign <em class="italic-display">in</em></h1>
        <p class="auth-sub">For those who keep returning.</p>

        <?php if ($errors): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $e): ?>
                    <div><?= htmlspecialchars($e) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="process-auth.php" method="POST">
            <input type="hidden" name="action" value="login">
            
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>">
            </div>
            
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;" data-sound="click">
                Continue
            </button>
        </form>
        
        <div class="auth-divider">or</div>
        
        <a href="guest.php" class="guest-link" data-sound="click">Visit as a guest</a>
        
        <p class="auth-footer">
            Not yet a member? <a href="signup.php">Apply here</a>
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>