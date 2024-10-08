<?php
session_start();
require_once '../config/config.php';  // Inkluderer databaseforbindelsen
require_once '../classes/User.php';   // Inkluderer User-klassen

// Opprett User-objekt
$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Forsøk å logge inn brukeren
    $userId = $user->login($username, $password);

    if ($userId) {
        // Vellykket innlogging, sett session variabel
        $_SESSION['user_id'] = $userId;

        // Send bruker til dashboard
        header('Location: ../dashboard.php');
        exit;
    } else {
        echo "Feil brukernavn eller passord.";
    }
}
?>

<h2>Logg inn</h2>
<form method="POST" action="">
    <label for="username">Brukernavn:</label>
    <input type="text" name="username" required><br>

    <label for="password">Passord:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Logg inn</button>
</form>
<p>Har du ikke konto? <a href="register.php">Registrer deg her</a>.</p>
