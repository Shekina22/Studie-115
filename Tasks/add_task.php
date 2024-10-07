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
    $taskType = $_POST['task_type'];  // Oppgavetype lagt til
    $dueDate = $_POST['due_date'];    // Frist lagt til
    
    // Legger til oppgaven med type og frist
    if ($task->addTask($_SESSION['user_id'], $title, $description, $taskType, $dueDate)) {
        header('Location: ../dashboard.php');
        exit();
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

    <label for="task_type">Type of Task:</label>
    <select name="task_type" required>
        <option value="Lesing av pensum">Lesing av pensum</option>
        <option value="Forberedelser til eksamen">Forberedelser til eksamen</option>
        <option value="Gruppemøte">Gruppemøte</option>
        <option value="Innlevering">Innlevering</option>
    </select>

    <label for="due_date">Due Date:</label>
    <input type="date" name="due_date" required>
    
    <button type="submit">Add Task</button>
</form>

