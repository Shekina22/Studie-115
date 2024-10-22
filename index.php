<?php
// Start en ny eller eksisterende sesjon
session_start();

// Hvis brukeren allerede er logget inn, omdiriger til dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Inkluder nødvendige filer
require_once 'config/config.php';
require_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Tool - Welcome</title>
    <link rel="stylesheet" href="Assets/CSS/black.css"> 
</head>
<body>

    <div class="tabbed">
    <!-- Tab 1 -->
    <input type="radio" id="tab-nav-1" name="tab-control" checked>
    <label for="tab-nav-1">Dashboard</label>

    <!-- Tab 1 Content -->
    <div class="tabs">
        <div>
            <h2>Welcome to the Study Tool</h2>
            <p>Your personal task manager for academic success!</p>
            <nav>
        <a href="users/login.php">Login</a> | 
        <a href="users/register.php">Register</a>
    </nav>
        </div>
</body>
</html>

