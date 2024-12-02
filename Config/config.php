<?php
// Database configuration
$host = 'localhost';
$databaseName = 'study_tool';
$username = 'root';
$password = '';

// Opprett kobling til databasens server
$conn = new mysqli($host, $username, $password);

// Sjekk at den fikk koblet til
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sjekk at databasen er opprettet
$checkDatabase = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$databaseName'";
$result = $conn->query($checkDatabase);

if ($result->num_rows == 0) {
    // Hvis den ikke er opprettet, opprett ny
    $createDatabase = "CREATE DATABASE $databaseName";
    if (!$conn->query($createDatabase) === TRUE)  {
        die("Error creating database: " . $conn->error);
    }
}

// Velg databasen som aktiv database
$conn->select_db($databaseName);
?>
