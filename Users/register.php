    <?php
    require_once '../config/config.php';  // Include the database connection
    require_once '../classes/User.php';   // Include User class

    // Create User object
    $user = new User($conn);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Register the user and capture the result
        $result = $user->register($username, $email, $password);

        if ($result === true) {
            $successMessage = "Registrering vellykket! Du kan nå <a href='login.php'>logge inn</a>.";
        } elseif ($result === "Username already exists!") {
            $errorMessage = "Brukernavnet er allerede tatt. Velg et annet brukernavn.";
        } elseif ($result === "Email already exists!") {
            $errorMessage = "E-posten er allerede registrert. Bruk en annen e-post eller logg inn.";
        } else {
            $errorMessage = "Noe gikk galt under registreringen. Prøv igjen.";
        }
    }
    ?>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrer deg | Study Tool</title>
        <link rel="stylesheet" href="../Assets/CSS/black.css">
    </head>

    <body class="login-body">
        <div class="register-container">
            <h2>Registrer deg</h2>
            <?php if (!empty($successMessage)): ?>
                <p class="success-message"><?php echo $successMessage; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="username">Brukernavn:</label>
                <input type="text" name="username" placeholder="Velg et brukernavn" required>
                <?php if (!empty($errorMessage) && strpos($errorMessage, 'Brukernavnet') !== false): ?>
                    <p class="error-message"><?php echo $errorMessage; ?></p>
                <?php endif; ?>

                <label for="email">E-post:</label>
                <input type="email" name="email" placeholder="Din e-postadresse" required>
                <?php if (!empty($errorMessage) && strpos($errorMessage, 'E-posten') !== false): ?>
                    <p class="error-message"><?php echo $errorMessage; ?></p>
                <?php endif; ?>

                <label for="password">Passord:</label>
                <input type="password" name="password" placeholder="Opprett et passord" required>
                <?php if (!empty($errorMessage) && strpos($errorMessage, 'Passord') !== false): ?>
                    <p class="error-message"><?php echo $errorMessage; ?></p>
                <?php endif; ?>

                <button type="submit">Registrer</button>
            </form>
            <p>Har du allerede konto? <a href="login.php">Logg inn her</a>.</p>
        </div>
    </body>


    </html>