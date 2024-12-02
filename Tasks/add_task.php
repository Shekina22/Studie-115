<?php
session_start();
require_once '../config/config.php';
require_once '../classes/Task.php';

if (!isset($_SESSION['user_id']['id'])) {
    header('Location: ../users/login.php');
    exit();
}

$task = new Task($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $taskType = $_POST['task_type'];
    $dueDate = $_POST['due_date'];
    $reminder = $_POST['reminder'];

    if ($task->addTask($_SESSION['user_id']['id'], $title, $description, $taskType, $dueDate, $reminder)) {
        header('Location: ../dashboard.php');
        exit();
    } else {
        echo "Error adding task.";
    }
}
?>

