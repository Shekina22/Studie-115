<?php
require_once '../config/config.php';
require_once '../classes/User.php';
require_once '../includes/functions.php';

$user = new User($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);
    
    $loggedInUser = $user->login($username, $password);
    
    if ($loggedInUser) {
        session_start();
        $_SESSION['user_id'] = $loggedInUser['id'];
        redirect('dashboard.php');
    } else {
        echo "Invalid login credentials.";
    }
}
?>

<form method="post" action="login.php">
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    
    <button type="submit">Login</button>
</form>
