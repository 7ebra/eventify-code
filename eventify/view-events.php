<?php
$pageTitle = 'Events';
require 'config/database.php';
require 'includes/auth.php';

$category = $_GET['category'] ?? '';
$search = trim($_GET['q'] ?? '');
$success = isset($_GET['success']);

$sql = "SELECT * FROM event_details WHERE 1=1";
$params = [];

if ($category) { $sql .= " AND event_category = ?"; $params[] = $category; }
if ($search) {
    $sql .= " AND (event_name LIKE ? OR venue LIKE ? OR description LIKE ?)";
    $params = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
}

$sql .= " ORDER BY event_date ASC, event_time ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$events = $stmt->fetchAll();

include 'includes/header.php';
?>

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Section II · The Directory</span>
        <h1><em class="italic-display">All</em> events</h1>
        <p>A curated index of public happenings — chronologically arranged.</p>
    </div>
</section>

<?php if ($success): ?>
<div class="wrap">
    <div class="alert alert-success">
        <strong>Submitted</strong> Your event has been added to the directory.
    </div>
</div>
<?php endif; ?>

<section class="section-pad">
    <div class="wrap">
        <form method="GET" class="filter-form">
            <input type="search" name="q" placeholder="Search by name, venue, or theme…" value="<?= htmlspecialchars($search) ?>">
            <select name="category">
                <option value="">All categories</option>
                <?php
                $cats = ['Music','Sports','Food & Drink','Arts & Culture','Tech & Business','Community','Education','Other'];
                foreach ($cats as $c) {
                    $s = $c === $category ? 'selected' : '';
                    echo "<option value=\"$c\" $s>$c</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn" data-sound="click">Filter</button>
        </form>

        <?php if (!$events): ?>
            <div class="empty-state">
                <span class="script">— nothing here, yet —</span>
                <h2>The page awaits</h2>
                <p>No events match your search. Why not be the first to write the next entry.</p>
                <a href="add-event.php" class="btn btn-primary" data-sound="click">Submit an event</a>
            </div>
        <?php else: ?>
            <div class="event-grid">
                <?php foreach ($events as $event):
                    $d = new DateTime($event['event_date']);
                    $t = new DateTime($event['event_time']);
                ?>
                <article class="event-card">
                    <div class="event-media">
                        <?php if (!empty($event['backdrop_url'])): ?>
                            <img src="<?= htmlspecialchars($event['backdrop_url']) ?>" alt="" loading="lazy">
                        <?php else: ?>
                            <div class="event-media-empty">
                                <em><?= strtoupper(substr($event['event_name'], 0, 1)) ?></em>
                            </div>
                        <?php endif; ?>
                        
                        <span class="event-cat-tag"><?= htmlspecialchars($event['event_category']) ?></span>
                        
                        <div class="event-date-stamp">
                            <span class="day"><?= $d->format('d') ?></span>
                            <span class="month"><?= $d->format('M') ?></span>
                        </div>
                    </div>
                    
                    <div class="event-info">
                        <h3><?= htmlspecialchars($event['event_name']) ?></h3>
                        
                        <p class="event-meta">
                            <span><?= $t->format('g:i A') ?></span>
                            <span><?= htmlspecialchars($event['venue']) ?></span>
                        </p>
                        
                        <p class="event-desc">
                            <?= htmlspecialchars(
                                strlen($event['description']) > 150
                                    ? substr($event['description'], 0, 150) . '…'
                                    : $event['description']
                            ) ?>
                        </p>
                        
                        <div class="event-foot">
                            <span class="event-price">
                                <?= $event['ticket_price'] > 0 ? '£' . number_format($event['ticket_price'], 2) : 'Gratis' ?>
                            </span>
                            <span class="event-organizer">
                                <?= htmlspecialchars($event['organizer_name']) ?>
                            </span>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>