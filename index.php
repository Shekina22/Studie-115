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
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Welcome to the Study Tool</h1>
        <p>Your personal task manager for academic success!</p>
    </header>

    <nav>
        <a href="users/login.php">Login</a> | 
        <a href="users/register.php">Register</a>
    </nav>

    <section>
        <h2>About the Study Tool</h2>
        <p>This tool helps you keep track of your study tasks and even deadlines, and collaborate with others.</p>
    </section>
</body>
</html>
