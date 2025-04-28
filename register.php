<?php require_once 'includes/header.php'; ?>

<h2>Register New Account</h2>

<?php
// Display potential errors passed from registration process via session flash message
if (isset($_SESSION['error_message'])) {
    echo '<p class="message error">' . htmlspecialchars($_SESSION['error_message']) . '</p>';
    unset($_SESSION['error_message']); // Clear the message after displaying
}
?>

<form action="process_register.php" method="POST">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    <button type="submit">Register</button>
</form>

<?php require_once 'includes/footer.php'; ?>