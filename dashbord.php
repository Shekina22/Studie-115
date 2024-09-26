<?php
session_start();
require_once 'config/config.php';
require_once 'classes/Task.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: users/login.php');
    exit();
}

$task = new Task($conn);
$tasks = $task->getTasks($_SESSION['user_id']);
?>

<h1>Dashboard</h1>
<a href="tasks/add_task.php">Add New Task</a>

<ul>
    <?php while ($row = $tasks->fetch_assoc()): ?>
        <li>
            <?php echo $row['title']; ?>
            <a href="tasks/delete_task.php?id=<?php echo $row['id']; ?>">Delete</a>
        </li>
    <?php endwhile; ?>
</ul>
