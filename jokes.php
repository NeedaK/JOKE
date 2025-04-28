<?php require_once 'includes/header.php'; ?>

<h2>Browse Jokes</h2>

<?php
// --- Fetch Jokes (Add category filtering, search, pagination later) ---
try {
    // Basic query - add JOINs for category name and username later
    $stmt = $pdo->query("SELECT j.id, j.joke_text, j.created_at, u.username, c.name as category_name
                         FROM jokes j
                         LEFT JOIN users u ON j.user_id = u.id
                         LEFT JOIN categories c ON j.category_id = c.id
                         ORDER BY j.created_at DESC"); // Example ordering

    $jokes = $stmt->fetchAll();

} catch (PDOException $e) {
    echo '<p class="message error">Could not fetch jokes: ' . htmlspecialchars($e->getMessage()) . '</p>'; // Dev only
    // echo '<p class="message error">Could not fetch jokes. Please try again later.</p>'; // Production
    $jokes = []; // Ensure $jokes is an array even on error
}
?>

<?php if (empty($jokes)): ?>
    <p>No jokes found yet!</p>
<?php else: ?>
    <?php foreach ($jokes as $joke): ?>
        <div class="joke">
            <blockquote><?php echo nl2br(htmlspecialchars($joke['joke_text'])); ?></blockquote>
            <p class="joke-meta">
                Category: <?php echo htmlspecialchars($joke['category_name'] ?? 'Uncategorized'); ?> |
                Submitted by: <?php echo htmlspecialchars($joke['username'] ?? 'Anonymous'); ?> |
                On: <?php echo date('Y-m-d', strtotime($joke['created_at'])); ?>
            </p>
            <div class="joke-actions">
                 <a href="joke_view.php?id=<?php echo $joke['id']; ?>" class="button">View Details</a>
                 <?php // --- Show Edit/Delete only if logged in and owner or admin ---
                 $is_owner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $joke['user_id'];
                 $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

                 if ($is_owner || $is_admin): ?>
                    <a href="joke_edit.php?id=<?php echo $joke['id']; ?>" class="button edit">Edit</a>
                    <a href="process_joke_delete.php?id=<?php echo $joke['id']; ?>" class="button delete">Delete</a>
                 <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


<?php require_once 'includes/footer.php'; ?>