<?php
$pageTitle = 'Sign up';
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
        <span class="auth-script script">a warm welcome</span>
        <h1>Become a <em class="italic-display">member</em></h1>
        <p class="auth-sub">Membership is complimentary, and quite straightforward.</p>

        <?php if ($errors): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $e): ?>
                    <div><?= htmlspecialchars($e) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="process-auth.php" method="POST">
            <input type="hidden" name="action" value="signup">
            
            <div class="field">
                <label for="full_name">Full name</label>
                <input type="text" id="full_name" name="full_name" required maxlength="100"
                       value="<?= htmlspecialchars($old['full_name'] ?? '') ?>">
            </div>
            
            <div class="field">
                <label for="username">Username <span class="hint">3–20 characters</span></label>
                <input type="text" id="username" name="username" required minlength="3" maxlength="20"
                       value="<?= htmlspecialchars($old['username'] ?? '') ?>">
            </div>
            
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>">
            </div>
            
            <div class="field">
                <label for="password">Password <span class="hint">min. 6 characters</span></label>
                <input type="password" id="password" name="password" required minlength="6">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;" data-sound="click">
                Submit application
            </button>
        </form>
        
        <p class="auth-footer">
            Already a member? <a href="login.php">Sign in</a>
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>