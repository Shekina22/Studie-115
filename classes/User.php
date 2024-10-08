<?php
class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Registrer bruker med brukernavn, e-post og passord
    public function register($username, $email, $password) {
        // Sjekk om brukernavn eksisterer
        $checkSql = "SELECT id FROM $this->table WHERE username = ?";
        $stmt = $this->conn->prepare($checkSql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return "Username already exists!";
        }

        // Sjekk om e-post eksisterer
        $checkEmailSql = "SELECT id FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($checkEmailSql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return "Email already exists!";
        }

        // Fortsett med registrering
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->table (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Brukerinnlogging
    public function login($username, $password) {
        $sql = "SELECT * FROM $this->table WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Sjekk om brukeren finnes
        if ($result->num_rows === 0) {
            return false; // Bruker finnes ikke
        }

        $user = $result->fetch_assoc();
        // Sjekk om passordet er korrekt
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    } 


    function checkReminders($conn) {
        $currentTime = new DateTime();
        $currentTime->modify('+1 hour'); // Sjekk for oppgaver som må minnes om innen en time
    
        $sql = "SELECT * FROM tasks WHERE reminder IS NOT NULL AND reminder <= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $currentTime->format('Y-m-d H:i:s'));
        $stmt->execute();
        $tasks = $stmt->get_result();
    
        while ($task = $tasks->fetch_assoc()) {
            // Send påminnelse, f.eks. via e-post
            sendReminderEmail($task);
        }
    }
    
    function sendReminderEmail($task) {
        // Her kan du implementere e-postsending
        $to = "user@example.com"; // Sett inn riktig e-postadresse
        $subject = "Påminnelse: " . $task['title'];
        $message = "Husk å fullføre oppgaven: " . $task['description'] . "\nFrist: " . $task['due_date'];
        // send mail
        mail($to, $subject, $message);
    }
    

}
?>
