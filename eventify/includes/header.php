<?php
require_once __DIR__ . '/auth.php';
$current = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' — Eventify' : 'Eventify' ?></title>
    
    <link rel="stylesheet" href="assets/css/editorial.css">
    
    <script>
        (function() {
            const t = localStorage.getItem('eventify-theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>

<header class="site-header">
    <div class="wrap">
        <a href="index.php" class="brand">
            Eventify
            <span class="brand-sub">Est. MMXXIV</span>
        </a>
        
        <nav>
            <ul class="nav-list" id="navList">
                <li><a href="index.php" class="<?= $current === 'index' ? 'active' : '' ?>">Index</a></li>
                <li><a href="view-events.php" class="<?= $current === 'view-events' ? 'active' : '' ?>">Events</a></li>
                <li><a href="add-event.php" class="<?= $current === 'add-event' ? 'active' : '' ?>">Submit</a></li>
                <li><a href="about.php" class="<?= $current === 'about' ? 'active' : '' ?>">Journal</a></li>
            </ul>
        </nav>
        
        <div class="header-tools">
            <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme" data-sound="click">
                <span class="theme-icon">◐</span>
            </button>
            
            <?php if (isLoggedIn()): ?>
                <a href="logout.php" class="user-pill"><?= htmlspecialchars($_SESSION['username']) ?></a>
            <?php elseif (isGuest()): ?>
                <a href="logout.php" class="user-pill">Guest</a>
            <?php else: ?>
                <a href="login.php" class="user-pill">Sign in</a>
            <?php endif; ?>
            
            <button class="menu-toggle" id="menuToggle" aria-label="Menu"></button>
        </div>
    </div>
</header>

<main>