<?php
session_start();
require_once '../config/config.php';  // Inkluderer databaseforbindelsen

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_email = $_POST['email'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE users SET email = ? WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("si", $new_email, $user_id);
        if ($stmt->execute()) {
            echo "E-post oppdatert!";
        } else {
            echo "Noe gikk galt. Prøv igjen.";
        }
    }
}
?>
