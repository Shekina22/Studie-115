<?php
require_once '../config/config.php';
require_once '../classes/Task.php';

$task = new Task($conn);

if (isset($_GET['id'])) {
    $task->deleteTask($_GET['id']);
}

header('Location: ../dashboard.php');
exit();
?>
