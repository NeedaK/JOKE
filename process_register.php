<?php
require_once 'config.php'; // Includes session_start() and $pdo

// --- Basic Input Validation ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    empty($_POST['username']) ||
    empty($_POST['email']) ||
    empty($_POST['password']) ||
    empty($_POST['confirm_password'])) {
    $_SESSION['error_message'] = "Please fill in all fields.";
    header('Location: register.php');
    exit;
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// --- More Validation ---
if ($password !== $confirm_password) {
    $_SESSION['error_message'] = "Passwords do not match.";
    header('Location: register.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     $_SESSION['error_message'] = "Invalid email format.";
     header('Location: register.php');
     exit;
}

// --- Check if username or email already exists (using prepared statements) ---
try {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        $_SESSION['error_message'] = "Username or Email already taken.";
        header('Location: register.php');
        exit;
    }
} catch (PDOException $e) {
    // Log error properly in production
    $_SESSION['error_message'] = "Database error checking user. Please try again.";
    header('Location: register.php');
    exit;
}


// --- Hash the password (CRUCIAL!) ---
$password_hash = password_hash($password, PASSWORD_DEFAULT);
if ($password_hash === false) {
     // Handle hashing failure
     $_SESSION['error_message'] = "Error processing password. Please try again.";
     header('Location: register.php');
     exit;
}


// --- Insert user into database ---
try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$username, $email, $password_hash]);

    // Registration successful - redirect to login
    $_SESSION['success_message'] = "Registration successful! Please log in.";
    header('Location: login.php');
    exit;

} catch (PDOException $e) {
    // Log error properly in production
    error_log("Registration DB Error: " . $e->getMessage()); // Example logging
    $_SESSION['error_message'] = "Registration failed due to a server error.";
    header('Location: register.php');
    exit;
}

?>