<?php
class Task {
    private $conn;
    private $table = 'tasks';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Hent oppgaver for en spesifikk bruker
    public function getTasks($userId) {
        $sql = "SELECT * FROM $this->table WHERE user_id = ? ORDER BY due_date ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Legg til en ny oppgave med påminnelse
    public function addTask($userId, $title, $description, $taskType, $dueDate, $reminder = null) {
        $sql = "INSERT INTO $this->table (user_id, title, description, task_type, due_date, reminder) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssss", $userId, $title, $description, $taskType, $dueDate, $reminder);
        return $stmt->execute();
    }

    // Fullfør oppgave
    public function completeTask($taskId) {
        $sql = "UPDATE $this->table SET completed = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $taskId);
        return $stmt->execute();
    }

    // Slett oppgave
    public function deleteTask($taskId) {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $taskId);
        return $stmt->execute();
    }
}
?>
