<?php
require 'config/database.php';
require 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add-event.php');
    exit;
}

$input = array_map('trim', $_POST);
$errors = [];

$required = [
    'event_name' => 'Event name', 'event_category' => 'Category',
    'event_date' => 'Date', 'event_time' => 'Time',
    'venue' => 'Venue', 'organizer_name' => 'Organizer',
    'contact_email' => 'Email', 'description' => 'Description'
];

foreach ($required as $k => $label) {
    if (empty($input[$k])) $errors[] = "$label is required.";
}

if (!empty($input['contact_email']) && !filter_var($input['contact_email'], FILTER_VALIDATE_EMAIL))
    $errors[] = 'Email looks invalid.';

if (!empty($input['event_date'])) {
    $d = DateTime::createFromFormat('Y-m-d', $input['event_date']);
    if (!$d || $d < new DateTime('today')) $errors[] = 'Date must be today or later.';
}

$price = (float)($input['ticket_price'] ?? 0);
if ($price < 0) $errors[] = 'Price can\'t be negative.';

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $input;
    header('Location: add-event.php');
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO event_details
            (user_id, event_name, event_category, event_date, event_time, venue,
             organizer_name, contact_email, ticket_price, description, backdrop_url, is_guest_post)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $_SESSION['user_id'] ?? null,
        $input['event_name'], $input['event_category'],
        $input['event_date'], $input['event_time'], $input['venue'],
        $input['organizer_name'], $input['contact_email'],
        $price, $input['description'],
        $input['backdrop_url'] ?: null,
        isGuest() ? 1 : 0
    ]);

    header('Location: view-events.php?success=1');
    exit;
} catch (PDOException $e) {
    $_SESSION['errors'] = ['Something broke: ' . $e->getMessage()];
    $_SESSION['old'] = $input;
    header('Location: add-event.php');
    exit;
}
?>