<?php
session_start();

require_once 'classes/User.php';
require_once 'classes/Task.php';
require_once 'Config/setup_database.php';

//Sjekker etter brukerid
if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit();
}

$user = new User($conn);
if (isset($_SESSION['user_id'])) {
    $user = $user->checkLogin($_SESSION['user_id']['id']);
    if (!$user) {
        header('Location: Users/login.php');
        exit();
    }
}
// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: users/login.php");
    exit();
}

if (isset($_GET['complete_id'])) {
    $complete_id = intval($_GET['complete_id']);
    $task = new Task($conn); // Ensure the Task class is instantiated
    if ($task->completeTask($complete_id)) {
        header("Location: dashboard.php"); // Reload dashboard to reflect changes
        exit();
    } else {
        echo "<script>alert('Feil ved fullføring av oppgave.');</script>";
    }
}


if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if (!$stmt->execute()) {
        echo "<script>alert('Feil ved sletting av oppgave: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

$user = new User($conn);
$task = new Task($conn);

// Fetch user tasks
$userId = $_SESSION['user_id']['id'];
$tasks = isset($_GET['show_my_tasks'])
    ? $task->getTasks($userId)
    : $task->getAllTasks();


?>
<script>
    function showTab(tabId) {
        // Remove "active" class from all tab buttons and contents
        document.querySelectorAll('.tab-button').forEach(button => button.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        // Add "active" class to the clicked tab and its content
        document.getElementById(tabId).classList.add('active');
        document.querySelector(`[onclick="showTab('${tabId}')"]`).classList.add('active');
    }
</script>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboards | Study Tool</title>
    <link rel="stylesheet" href="../Assets/CSS/black.css">
</head>

<div class="container">
    <div class="header-container">
        <h3>Dine Oppgaver</h3>
        <div class="buttons">
            <form method="GET" action="" style="display: inline;">
                <label id="show_my_tasks_label">
                    <input type="checkbox" name="show_my_tasks" id="show_my_tasks"
                        onchange="this.form.submit()"
                        <?php echo isset($_GET['show_my_tasks']) ? 'checked' : ''; ?>>
                    Show only my tasks
                </label>
            </form>
            <button id="openModal">Legg til ny oppgave</button>
        </div>
    </div>
    <div class="tabs">
        <button id="allTasksTab" class="tab-button active" onclick="showTab('allTasks')">Alle Oppgaver</button>
        <button id="completedTasksTab" class="tab-button" onclick="showTab('completedTasks')">Fullførte Oppgaver</button>
    </div>
    <div id="allTasks" class="tab-content active">
        <table>
            <thead>
                <tr>
                    <th>Tittel</th>
                    <th>Beskrivelse</th>
                    <th>Type</th>
                    <th>Frist</th>
                    <th>Status</th>
                    <th>Handlinger</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $incompleteTasks = array_filter($tasks, function ($task) {
                    return !$task['completed'];
                });
                ?>
                <?php if (empty($incompleteTasks)): ?>
                        <tr>
                            <td colspan="6">Ingen oppgaver funnet.</td>
                        </tr>
                <?php else: ?>
                        <?php foreach ($incompleteTasks as $task): ?>
                                <?php
                                // Calculate the deadline status
                                $currentDate = new DateTime();
                                $dueDate = new DateTime($task['due_date']);
                                $interval = $currentDate->diff($dueDate);

                                // Determine row class based on deadline
                                $rowClass = '';
                                if ($task['completed']) {
                                    $rowClass = 'completed-task';
                                } elseif ($dueDate < $currentDate) {
                                    $rowClass = 'past-deadline'; // Red tint
                                } elseif ($interval->days <= 7 && !$interval->invert) {
                                    $rowClass = 'near-deadline'; // Orange tint
                                }
                                ?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                                    <td><?php echo htmlspecialchars($task['task_type']); ?></td>
                                    <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                                    <td><?php echo $task['completed'] ? 'Fullført' : 'Ikke fullført'; ?></td>
                                    <td>
                                        <form method="GET" style="display:inline;">
                                            <input type="hidden" name="complete_id" value="<?php echo $task['id']; ?>">
                                            <button type="submit">Fullfør</button>
                                        </form>

                                        </form>
                                        <form method="POST" action="?delete_id=<?php echo $task['id']; ?>" style="display:inline;">
                                            <button type="submit" onclick="return confirm('Er du sikker på at du vil slette oppgaven?')">Slett</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div id="completedTasks" class="tab-content">
        <table>
            <thead>
                <tr>
                    <th>Tittel</th>
                    <th>Beskrivelse</th>
                    <th>Type</th>
                    <th>Frist</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                        <?php if ($task['completed']): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                                    <td><?php echo htmlspecialchars($task['task_type']); ?></td>
                                    <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                                    <td>
                                        </form>
                                        <form method="POST" action="?delete_id=<?php echo $task['id']; ?>" style="display:inline;">
                                            <button type="submit" onclick="return confirm('Er du sikker på at du vil slette oppgaven?')">Slett</button>
                                        </form>
                                    </td>
                                </tr>

                        <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="taskModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Legg til ny oppgave</h3>
            <form method="POST" action="Tasks/add_task.php">
                <label for="title">Tittel:</label>
                <input type="text" name="title" placeholder="Skriv inn oppgavetittel" required>

                <label for="description">Beskrivelse:</label>
                <textarea name="description" placeholder="Beskriv oppgaven" required></textarea>

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
        </div>
    </div>

</div>
</div>


<script>
    // Get modal elements
    var modal = document.getElementById("taskModal");
    var openModal = document.getElementById("openModal");
    var closeModal = document.getElementsByClassName("close")[0];

    // Open modal on button click
    openModal.onclick = function() {
        modal.style.display = "block";
    };

    // Close modal on close button click
    closeModal.onclick = function() {
        modal.style.display = "none";
    };

    // Close modal on outside click
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
</script>

</body>

</html>