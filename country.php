<?php
session_start();
require 'config.php'; // Your database connection file

// Fetch country details based on ID
if (isset($_GET['id'])) {
    $country_id = $_GET['id'];

    // Fetch country details
    $query = "SELECT * FROM countries WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $country_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $country = $result->fetch_assoc();
    $stmt->close();

    // Fetch hotels in the country with filters and check reservations
    $query = "
        SELECT h.*, r.id AS reservation_id
        FROM hotels h
        LEFT JOIN reservations r ON h.id = r.hotel_id
        WHERE h.country_id = ?
    ";
    $params = [$country_id];
    $types = "i";

    if (isset($_GET['departure']) && !empty($_GET['departure'])) {
        $query .= " AND h.start_date >= ?";
        $params[] = $_GET['departure'];
        $types .= "s";
    }

    if (isset($_GET['return']) && !empty($_GET['return'])) {
        $query .= " AND h.end_date <= ?";
        $params[] = $_GET['return'];
        $types .= "s";
    }

    if (isset($_GET['people']) && !empty($_GET['people'])) {
        $query .= " AND h.people = ?";
        $params[] = $_GET['people'];
        $types .= "i";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $hotels = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    // Redirect to the homepage if no country ID is provided
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($country['name']); ?></title>
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

    <main>
        <section class="country-banner" style="background-image: url('<?php echo htmlspecialchars($country['image_url']); ?>');">
            <h1><?php echo htmlspecialchars($country['name']); ?></h1>
        </section>

        <section class="hotels">
            <h2>Dostępne Hotele</h2>
            <div class="hotels-list">
                <?php if (empty($hotels)): ?>
                    <p class="no-results">Brak dostępnych hoteli</p>
                <?php else: ?>
                    <?php foreach ($hotels as $hotel): ?>
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
                                                                        <p>Liczba osób: <?php echo htmlspecialchars($hotel['people']); ?></p>
                                    <span class="price"><?php echo htmlspecialchars(number_format($hotel['price'], 2)); ?> Zł</span>
                                </div>
                                <?php if (!is_null($hotel['reservation_id'])): ?>
                                    <p class="reserved">Ten hotel jest już zarezerwowany</p>
                                <?php else: ?>
                                    <div class="hotel-book">
                                    <?php if (!isset($_SESSION['user_id'])): ?>
                                        <form action="login.php" method="get">
                                            <button type="submit" class="login-to-book">Zaloguj się, aby zarezerwować</button>
                                        </form>
                                    <?php elseif (isset($hotel['reservation_id'])): ?>
                                        <p class="reserved">Zarezerwowany</p>
                                    <?php else: ?>
                                        <form method="post" action="reserve.php">
                                            <input type="hidden" name="hotel_id" value="<?php echo htmlspecialchars($hotel['id']); ?>">
                                            <button type="submit">Zarezerwuj</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
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
