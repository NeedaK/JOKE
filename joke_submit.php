<?php
require_once 'includes/header.php';

// --- Authorization Check ---
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "You must be logged in to submit a joke.";
    header('Location: login.php');
    exit;
}

// --- Fetch Categories for Dropdown ---
try {
    $catStmt = $pdo->query("SELECT id, name FROM categories ORDER BY name");
    $categories = $catStmt->fetchAll();
} catch (PDOException $e) {
    $categories = []; // Handle error gracefully
    echo '<p class="message error">Could not load categories.</p>';
}
?>

<h2>Submit a New Joke</h2>

<form action="process_joke_submit.php" method="POST">
    <div class="form-group">
        <label for="joke_text">Joke:</label>
        <textarea id="joke_text" name="joke_text" required></textarea>
    </div>
    <div class="form-group">
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id">
            <option value="">-- Select a Category (Optional) --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit">Submit Joke</button>
</form>

<?php require_once 'includes/footer.php'; ?>
