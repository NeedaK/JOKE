<?php
// Include the header, which starts the session, connects to DB,
// and includes the basic HTML structure + navigation.
require_once 'includes/header.php';
?>

<!-- Main Content Area for the Homepage -->
<div class="page-content">

    <h2>Welcome to Chuckle Hub!</h2>
    <p>Your daily dose of laughter! Browse jokes, submit your own (if you log in), and share the fun.</p>

    <hr> <!-- Simple separator -->

    <h3>Latest Jokes</h3>

    <?php
    // --- Fetch the 5 most recent jokes ---
    try {
        // Query to get jokes along with submitter's username and category name
        // Using LEFT JOIN in case a category or user is missing/deleted
        $sql = "SELECT
                    j.id, j.joke_text, j.created_at,
                    u.username AS submitter_username,
                    c.name AS category_name
                FROM jokes j
                LEFT JOIN users u ON j.user_id = u.id
                LEFT JOIN categories c ON j.category_id = c.id
                ORDER BY j.created_at DESC
                LIMIT 5"; // Get the latest 5

        $stmt = $pdo->query($sql); // Simple query as no user input is involved here
        $latest_jokes = $stmt->fetchAll();

    } catch (PDOException $e) {
        // Display a user-friendly error message
        echo '<p class="message error">Oops! Could not load the latest jokes. Please try again later.</p>';
        // Optionally log the detailed error: error_log("Index Joke Fetch Error: " . $e->getMessage());
        $latest_jokes = []; // Ensure the variable exists as an empty array
    }
    ?>

    <?php if (empty($latest_jokes)): ?>
        <p>No jokes have been submitted yet. Why not <a href="register.php">register</a> and add the first one?</p>
    <?php else: ?>
        <?php foreach ($latest_jokes as $joke): ?>
            <div class="joke">
                <blockquote>
                    <?php echo nl2br(htmlspecialchars($joke['joke_text'])); // nl2br respects line breaks, htmlspecialchars prevents XSS ?>
                </blockquote>
                <p class="joke-meta">
                    Category: <?php echo htmlspecialchars($joke['category_name'] ?? 'Uncategorized'); ?> |
                    Submitted by: <?php echo htmlspecialchars($joke['submitter_username'] ?? 'Anonymous'); ?>
                    <!-- You could format the date: echo date('M d, Y', strtotime($joke['created_at'])); -->
                </p>
                <div class="joke-actions">
                    <a href="joke_view.php?id=<?php echo $joke['id']; ?>" class="button">View Details</a>
                    <?php // Example: Only show Edit/Delete here if needed, but usually better on jokes.php or joke_view.php
                        // $is_owner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $joke['user_id']; // Need user_id in SELECT
                        // $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
                        // if ($is_owner || $is_admin) { ... show buttons ... }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
        <p style="margin-top: 20px;">
            <a href="jokes.php" class="button">Browse All Jokes »</a>
        </p>
    <?php endif; ?>

</div> <!-- /page-content -->


<?php
// Include the footer, which closes the main tags, adds footer text, and JS script link.
require_once 'includes/footer.php';
?>