<?php
session_start();
require_once '../config/config.php';  // Inkluderer databaseforbindelsen

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Hent brukerens informasjon fra databasen
$user_id = $_SESSION['user_id'];
$query = "SELECT username, email FROM users WHERE id = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $email);
    $stmt->fetch();
}
?>

<h2>Profilinformasjon</h2>
<p>Brukernavn: <?php echo htmlspecialchars($username); ?></p>
<p>E-post: <?php echo htmlspecialchars($email); ?></p>

<h3>Oppdater e-post</h3>
<form method="POST" action="update_profile.php">
    <label for="email">Ny e-post:</label>
    <input type="email" name="email" required><br>

    <button type="submit">Oppdater</button>
</form>
