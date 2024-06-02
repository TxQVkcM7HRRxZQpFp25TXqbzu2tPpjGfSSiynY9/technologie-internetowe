<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "
    SELECT r.id AS reservation_id, h.*
    FROM reservations r
    JOIN hotels h ON r.hotel_id = h.id
    WHERE r.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$reservations = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje Rezerwacje</title>
    <link rel="stylesheet" href="styles.css">
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
                <a href="login.php" class="login">logowanie</a>
                <a href="register.php" class="register">rejestracja</a>
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

    <main>
        <section class="hotels">
            <h2>Moje Rezerwacje</h2>
            <div class="hotels-list">
                <?php if (empty($reservations)): ?>
                    <p class="no-results">Brak dostępnych rezerwacji</p>
                <?php else: ?>
                    <?php foreach ($reservations as $hotel): ?>
                        <div class="hotel-card">
                            <div class="hotel-image">
                                <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" alt="<?php echo htmlspecialchars($hotel['name']); ?>">
                            </div>
                            <div class="hotel-info">
                                <div class="hotel-header">
                                    <h3><?php echo htmlspecialchars($hotel['name']); ?></h3>
                                    <div class="hotel-meta">
                                        <p><?php echo htmlspecialchars($hotel['location']); ?></p>
                                    </div>
                                </div>
                                <div class="hotel-details">
                                    <p><?php echo htmlspecialchars($hotel['start_date']); ?> - <?php echo htmlspecialchars($hotel['end_date']); ?> (<?php echo htmlspecialchars($hotel['duration']); ?> dni)</p>
                                    <p><?php echo htmlspecialchars($hotel['departure']); ?></p>
                                    <p><?php echo htmlspecialchars($hotel['inclusive']); ?></p>
                                    <span class="price"><?php echo htmlspecialchars(number_format($hotel['price'], 2)); ?> Zł/os.</span>
                                </div>
                                <div class="hotel-book">
                                    <form method="post" action="cancel_reservation.php">
                                        <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($hotel['reservation_id']); ?>">
                                        <button type="submit">Anuluj rezerwację</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>

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
