<?php
class Task {
    private $conn;
    private $table = 'tasks';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addTask($title, $description, $userId) {
        $sql = "INSERT INTO $this->table (title, description, user_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $description, $userId);

        return $stmt->execute();
    }

    public function getTasks($userId) {
        $sql = "SELECT * FROM $this->table WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function deleteTask($taskId) {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $taskId);
        return $stmt->execute();
    }
}
?>
