<?php
session_start();
require_once '../config/config.php';  // Sørg for at databasen er initiert 
require_once '../classes/User.php';   // Inkluder User-klassen

// Opprett en instans av user-klassen
$user = new User($conn);
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Forsøk å logge inn brukeren
    $user = $user->login($username, $password);

    if ($user) {
        // Vellykket innlogging, sett brukerobjektet i session
        $_SESSION['user_id'] = $user;

        // redirect brukeren til dashboardet
        header('Location: ../dashboard.php');
        exit;
    } else {
        echo "Feil brukernavn eller passord.";
    }
}
?>

<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Tool - Logg inn</title>
    <link rel="stylesheet" href="../Assets/CSS/black.css">
</head>

<body class="login-body">
    <div class="login-container">
        <h2>Innlogging</h2>
        <?php if (!empty($errorMessage)): ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Brukernavn:</label>
            <input type="text" id="username" name="username" placeholder="Din e-post eller brukernavn" required>

            <label for="password">Passord:</label>
            <input type="password" id="password" name="password" placeholder="Ditt passord" required>

            <button type="submit">Logg inn</button>
        </form>
        <p>Har du ikke konto? <a href="register.php">Registrer deg her</a>.</p>
    </div>
</body>

</html>