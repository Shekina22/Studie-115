<?php
require_once '../config/config.php';  // Include the database connection
require_once '../classes/User.php';   // Include User class

// Create User object
$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username']; 
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Register the user and capture the result
    $result = $user->register($username, $email, $password);

    if ($result === true) {
        echo "Registrering vellykket! Du kan nå <a href='login.php'>logge inn</a>.";
    } elseif ($result === "Username already exists!") {
        echo "Brukernavnet er allerede tatt. Velg et annet brukernavn.";
    } elseif ($result === "Email already exists!") {
        echo "E-posten er allerede registrert. Bruk en annen e-post eller logg inn.";
    } else {
        echo "Noe gikk galt under registreringen. Prøv igjen.";
    }
}
?>

<h2>Registrer deg</h2>
<form method="POST" action="">
    <label for="username">Brukernavn:</label>
    <input type="text" name="username" required><br>

    <label for="email">E-post:</label>
    <input type="email" name="email" required><br>

    <label for="password">Passord:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Registrer</button>
</form>
<p>Har du allerede konto? <a href="login.php">Logg inn her</a>.</p>
