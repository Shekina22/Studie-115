<?php
session_start();
require_once '../config/config.php';  // Inkluderer databaseforbindelsen

if (!isset($_SESSION['user_id'])) {
    header(header: 'Location: login.php');
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil | Study Tool</title>
    <link rel="stylesheet" href="../Assets/CSS/black.css">
</head>

<body class="login-body">
    <div class="profile-container">
        <h2>Profilinformasjon</h2>
        <p><strong>Brukernavn:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>E-post:</strong> <?php echo htmlspecialchars($email); ?></p>

        <form method="POST" action="update_profile.php">
            <label for="email">Oppdater e-post:</label>
            <input type="email" name="email" placeholder="Oppgi ny e-postadresse" required>
            <button type="submit">Oppdater</button>
        </form>

        <div class="back-link">
            <p><a href="dashboard.php">Tilbake til Dashboard</a></p>
        </div>
    </div>
</body>

</html>