<?php
$pageTitle = 'Submit';
require 'config/database.php';
require 'includes/auth.php';

if (!isLoggedIn() && !isGuest()) { header('Location: login.php'); exit; }

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

include 'includes/header.php';
?>

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Section III · Submission</span>
        <h1>Submit an <em class="italic-display">event</em></h1>
        <p>The particulars, please. We'll handle the typesetting.</p>
    </div>
</section>

<section class="section-pad">
    <div class="wrap narrow">
        <?php if ($errors): ?>
            <div class="alert alert-error">
                <strong>Note</strong>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="process-event.php" method="POST" class="event-form form-card" novalidate>
            <div class="field">
                <label for="event_name">Title of event</label>
                <input type="text" id="event_name" name="event_name" required maxlength="150"
                       value="<?= htmlspecialchars($old['event_name'] ?? '') ?>"
                       placeholder="e.g., Quartet at the Old Library">
            </div>

            <div class="form-row two-col">
                <div class="field">
                    <label for="event_category">Category</label>
                    <select id="event_category" name="event_category" required>
                        <option value="">— Choose —</option>
                        <?php
                        $cats = ['Music','Sports','Food & Drink','Arts & Culture','Tech & Business','Community','Education','Other'];
                        $sel = $old['event_category'] ?? '';
                        foreach ($cats as $c) {
                            $s = $c === $sel ? 'selected' : '';
                            echo "<option value=\"$c\" $s>$c</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="field">
                    <label for="ticket_price">Admission <span class="hint">in pounds</span></label>
                    <input type="number" id="ticket_price" name="ticket_price" min="0" step="0.01"
                           value="<?= htmlspecialchars($old['ticket_price'] ?? '0.00') ?>">
                </div>
            </div>

            <div class="form-row two-col">
                <div class="field">
                    <label for="event_date">Date</label>
                    <input type="date" id="event_date" name="event_date" required
                           min="<?= date('Y-m-d') ?>"
                           value="<?= htmlspecialchars($old['event_date'] ?? '') ?>">
                </div>
                <div class="field">
                    <label for="event_time">Hour</label>
                    <input type="time" id="event_time" name="event_time" required
                           value="<?= htmlspecialchars($old['event_time'] ?? '') ?>">
                </div>
            </div>

            <div class="field">
                <label for="venue">Venue</label>
                <input type="text" id="venue" name="venue" required maxlength="200"
                       value="<?= htmlspecialchars($old['venue'] ?? '') ?>">
            </div>

            <div class="form-row two-col">
                <div class="field">
                    <label for="organizer_name">Curator</label>
                    <input type="text" id="organizer_name" name="organizer_name" required maxlength="100"
                           value="<?= htmlspecialchars($old['organizer_name'] ?? (isLoggedIn() ? $_SESSION['username'] : '')) ?>">
                </div>
                <div class="field">
                    <label for="contact_email">Correspondence</label>
                    <input type="email" id="contact_email" name="contact_email" required maxlength="120"
                           value="<?= htmlspecialchars($old['contact_email'] ?? '') ?>">
                </div>
            </div>

            <div class="field">
                <label for="backdrop_url">Image URL <span class="hint">optional, for the photograph</span></label>
                <input type="url" id="backdrop_url" name="backdrop_url"
                       value="<?= htmlspecialchars($old['backdrop_url'] ?? '') ?>"
                       placeholder="https://…">
            </div>

            <div class="field">
                <label for="description">Description <span class="hint" id="charCount">0 / 1000</span></label>
                <textarea id="description" name="description" required maxlength="1000" rows="6"
                          placeholder="Tell us the character of the evening…"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
            </div>

            <hr class="rule">

            <div style="display:flex;gap:1.5rem;justify-content:flex-end;flex-wrap:wrap;">
                <button type="reset" class="btn-link">Reset form</button>
                <button type="submit" class="btn btn-primary" data-sound="click">Submit for publication</button>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>