<?php
session_start();
$error_message = '';
$first_name = '';
$last_name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    require 'config.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match";
    } elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long";
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $error_message = "Password must contain both letters and numbers";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Error: Could not register. Please try again later.";
        }

        $stmt->close();
    }

    if ($error_message) {
        $password = '';
        $confirm_password = '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="logowanie.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="logo.png" alt="Travel Logo">
            <span>Travel</span>
        </div>
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <nav class="nav">
            <a href="index.php">Strona główna</a>
            <a href="kraje.php">Kraje</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="reservations.php"><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></a>
                <a href="logout.php">Wyloguj</a>
            <?php else: ?>
                <a href="login.php" class="login">Logowanie</a>
                <a href="register.php" class="register">Rejestracja</a>
            <?php endif; ?>
        </nav>
        <div class="mobile-menu">
            <a href="index.php">Strona główna</a>
            <a href="kraje.php">Kraje</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="reservations.php"><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></a>
                <a href="logout.php">Wyloguj</a>
            <?php else: ?>
                <a href="login.php" class="login">Logowanie</a>
                <a href="register.php" class="register">Rejestracja</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="main-content">
        <div class="login-container">
            <h2>Rejestracja</h2>
            <form action="register.php" method="POST" class="login-form">
                <div class="form-group">
                    <input type="text" name="first_name" placeholder="First Name" value="<?php echo htmlspecialchars($first_name); ?>" required>
                </div>
                <div class="form-group">
                    <input type="text" name="last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($last_name); ?>" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Create password" required>
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" placeholder="Confirm password" required>
                </div>
                <button type="submit" name="register">Signup</button>
                <?php
                if (!empty($error_message)) {
                    echo '<p class="error-message">' . $error_message . '</p>';
                }
                ?>
            </form>
            <p class="signup-prompt">Posiadasz już konto? <a href="login.php">Logowanie</a></p>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-column">
            <div class="social-media">
                <h4>Social Media</h4>
                <div class="social-icons">
                    <a href="https://www.facebook.com/"><img src="https://upload.wikimedia.org/wikipedia/commons/b/b9/2023_Facebook_icon.svg" alt="Facebook"></a>
                    <a href="https://www.x.com/"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/X_logo_2023.svg/2267px-X_logo_2023.svg.png" alt="X"></a>
                    <a href="https://www.instagram.com/"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Instagram_logo_2016.svg/768px-Instagram_logo_2016.svg.png" alt="Instagram"></a>
                </div>
            </div>
        </div>
        <div class="footer-column">
            <h4>Przydatne linki</h4>
            <ul>
                <li><a href="index.php">Strona główna</a></li>
                <li><a href="terms.php">Regulamin</a></li>
                <li><a href="kraje.php">Kraje</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Kontakt</h4>
            <ul>
                <li><a>+48 123 456 789</a></li>
                <li><a>Travel@Email.Com</a></li>
                <li><a>Wrocław, Ul. Leśna 11/3B</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
