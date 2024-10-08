<?php include '../includes/header.php'; ?>
<h2>Dine oppgaver</h2>

<?php
require_once '../config/config.php';
require_once '../classes/Task.php';

// Opprett Task-objekt
$task = new Task($conn);
$tasks = $task->getTasksByUserId($_SESSION['user_id']);

if (!empty($tasks)) {
    echo "<ul>";
    foreach ($tasks as $t) {
        echo "<li>";
        echo htmlspecialchars($t['task']);
        echo " – Frist: " . htmlspecialchars($t['due_date']);
        echo " – Status: " . ($t['completed'] ? "Fullført" : "Ikke fullført");
        echo " <a href='../tasks/complete_task.php?id=" . $t['id'] . "'>Fullfør</a>";
        echo " <a href='../tasks/delete_task.php?id=" . $t['id'] . "'>Slett</a>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Ingen oppgaver tilgjengelig.</p>";
}
?>

<a href="../tasks/add_task.php">Legg til ny oppgave</a>
<?php include '../includes/footer.php'; ?>
