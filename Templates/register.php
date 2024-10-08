<?php
require_once '../config/config.php';
require_once '../classes/User.php';
require_once '../includes/functions.php';

$user = new User($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);
    
    if ($user->register($username, $password)) {
        redirect('login.php');
    } else {
        echo "Error registering user.";
    }
}
?>

<form method="post" action="register.php">
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    
    <button type="submit">Register</button>
</form>
