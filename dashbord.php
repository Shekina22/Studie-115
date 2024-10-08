<?php
session_start(); // Start the session
require_once 'config/config.php';
require_once 'classes/User.php';
require_once 'classes/Task.php';

$user = new User($conn);
$task = new Task($conn);

// Fetch user tasks
$userId = 1; // Example user ID, change this dynamically based on logged-in user
$tasks = $task->getTasks($userId);

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: users/login.php");
    exit();
}
?>

<?php include 'includes/header.php'; ?>
<h2>Dashboard</h2>

<!-- Welcome Message -->
<p>Velkommen til dashbordet!</p>

<!-- Task List -->
<h3>Dine Oppgaver</h3>
<table>
    <thead>
        <tr>
            <th>Tittel</th>
            <th>Beskrivelse</th>
            <th>Type</th> <!-- Ny kolonne for type oppgave -->
            <th>Frist</th>
            <th>Status</th>
            <th>Handlinger</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($tasks)): ?>
            <tr>
                <td colspan="6">Ingen oppgaver funnet.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                    <td><?php echo htmlspecialchars($task['task_type']); ?></td> <!-- Viser type oppgave -->
                    <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                    <td><?php echo $task['completed'] ? 'Fullført' : 'Ikke fullført'; ?></td>
                    <td>
                        <form method="POST" action="tasks/complete_task.php">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <button type="submit">Fullfør</button>
                        </form>
                        <form method="POST" action="tasks/delete_task.php">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <button type="submit">Slett</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<!-- Add Task Form -->

<h3>Legg til ny oppgave</h3>
<form method="POST" action="tasks/add_task.php">
    <label for="title">Tittel:</label>
    <input type="text" name="title" required>

    <label for="description">Beskrivelse:</label>
    <textarea name="description" required></textarea>

    <label for="task_type">Type oppgave:</label>
    <select name="task_type" required>
        <option value="Lesing av pensum">Lesing av pensum</option>
        <option value="Forberedelser til eksamen">Forberedelser til eksamen</option>
        <option value="Gruppemøte">Gruppemøte</option>
        <option value="Innlevering">Innlevering</option>
    </select>

    <label for="due_date">Frist:</label>
    <input type="date" name="due_date" required>

    <label for="reminder">Påminnelse (valgfritt):</label>
    <input type="datetime-local" name="reminder">

    <button type="submit">Legg til oppgave</button>
</form>

 
<?php include 'includes/footer.php'; ?>
