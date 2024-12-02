<?php
require_once 'config.php'; 

$databaseName = 'study_tool';

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
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    task_type VARCHAR(255) NOT NULL,
    due_date DATE NOT NULL,
    completed BOOLEAN DEFAULT FALSE,
    reminder DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

// Kjør SQL-kommandoene for å opprette tabellene
if (!mysqli_query($conn, $createUsersTable)) {
    echo "Feil ved opprettelse av users-tabellen: " . mysqli_error($conn) . "<br>";
}

if (!mysqli_query($conn, $createTasksTable)) {
    echo "Feil ved opprettelse av tasks-tabellen: " . mysqli_error($conn) . "<br>";
}

?>

