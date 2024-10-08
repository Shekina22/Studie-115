<?php
require_once 'config.php'; // Inkluderer databaseforbindelsen

// Define the database name
$databaseName = 'study_tool';

// SQL query to create the database if it doesn't exist
$createDatabase = "CREATE DATABASE IF NOT EXISTS $databaseName";

// Execute the query to create the database
if (mysqli_query($conn, $createDatabase)) {
    echo "Database '$databaseName' was created or already exists.<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// Select the newly created or existing database
mysqli_select_db($conn, $databaseName);

// SQL-koden for å opprette 'users'-tabellen
$createUsersTable = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

// SQL-koden for å opprette 'tasks'-tabellen
$createTasksTable = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    task VARCHAR(255) NOT NULL,
    due_date DATE NOT NULL,
    completed BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

// Kjør SQL-kommandoene
if (mysqli_query($conn, $createUsersTable)) {
    echo "Users-tabellen ble opprettet.<br>";
} else {
    echo "Feil ved opprettelse av users-tabellen: " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $createTasksTable)) {
    echo "Tasks-tabellen ble opprettet.<br>";
} else {
    echo "Feil ved opprettelse av tasks-tabellen: " . mysqli_error($conn) . "<br>";
}

// Lukk tilkoblingen
mysqli_close($conn);
?>
