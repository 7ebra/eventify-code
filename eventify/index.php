<?php
$pageTitle = 'Index';
require 'config/database.php';
require 'includes/auth.php';

$totalEvents = $pdo->query("SELECT COUNT(*) FROM event_details")->fetchColumn();
$upcoming = $pdo->query("SELECT COUNT(*) FROM event_details WHERE event_date >= CURDATE()")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

include 'includes/header.php';
?>

<section class="hero">
    <span class="hero-numeral numeral-tl">N°</span>
    <span class="hero-numeral numeral-br">01</span>
    
    <!-- 3D parallax ornaments — frames you can replace with real images -->
    <div class="hero-ornament ornament-1" data-rotate="-8">
        <div class="ornament-frame">
            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=400&q=80" alt="">
        </div>
        <span class="ornament-caption">— a summer concert</span>
    </div>
    
    <div class="hero-ornament ornament-2" data-rotate="6">
        <div class="ornament-frame">
            <img src="https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?w=400&q=80" alt="">
        </div>
        <span class="ornament-caption">— gallery opening</span>
    </div>
    
    <div class="hero-ornament ornament-3" data-rotate="4">
        <div class="ornament-frame">
            <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=400&q=80" alt="">
        </div>
        <span class="ornament-caption">— supper club</span>
    </div>
    
    <div class="wrap hero-stage">
        <div class="hero-content">
            <span class="eyebrow hero-eyebrow">Volume i · A directory of gatherings</span>
            <h1>
                The art of<br>
                <em class="italic-display">showing</em> <span class="script">up</span>
            </h1>
            <p class="hero-lead">
                A considered place to discover and share the events that give a city
                its character — concerts, suppers, exhibitions, and the small affairs
                worth dressing for.
            </p>
            <div class="hero-cta">
                <a href="view-events.php" class="btn btn-primary" data-sound="click">Browse the directory</a>
                <a href="add-event.php" class="btn" data-sound="click">Submit an event</a>
            </div>
        </div>
    </div>
</section>

<section class="section-pad">
    <div class="wrap">
        <div class="stat-row">
            <div class="stat-cell">
                <strong><?= str_pad($totalEvents, 2, '0', STR_PAD_LEFT) ?></strong>
                <span>Listed in this volume</span>
            </div>
            <div class="stat-cell">
                <strong><?= str_pad($upcoming, 2, '0', STR_PAD_LEFT) ?></strong>
                <span>Forthcoming dates</span>
            </div>
            <div class="stat-cell">
                <strong><?= str_pad($totalUsers, 2, '0', STR_PAD_LEFT) ?></strong>
                <span>Contributing curators</span>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>