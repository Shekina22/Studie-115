<?php
session_start();
require_once '../config/config.php';
require_once '../classes/Task.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit();
}

$task = new Task($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    if ($task->addTask($title, $description, $_SESSION['user_id'])) {
        header('Location: ../dashboard.php');
    } else {
        echo "Error adding task.";
    }
}
?>

<form method="post" action="add_task.php">
    <label for="title">Title:</label>
    <input type="text" name="title" required>
    
    <label for="description">Description:</label>
    <textarea name="description" required></textarea>
    
    <button type="submit">Add Task</button>
</form>
