<?php
session_start();
require 'config.php';

$country_id = isset($_GET['country']) ? intval($_GET['country']) : null;
$departure = isset($_GET['departure']) ? $_GET['departure'] : null;
$return = isset($_GET['return']) ? $_GET['return'] : null;
$people = isset($_GET['people']) ? intval($_GET['people']) : null;

$query = "
    SELECT h.name, h.price, h.image_url, h.location, h.start_date, h.end_date, h.duration, h.departure, h.inclusive, c.name as country_name
    FROM hotels h
    JOIN countries c ON h.country_id = c.id
    WHERE 1 = 1
";

$params = [];
if ($country_id) {
    $query .= " AND h.country_id = ?";
    $params[] = $country_id;
}
if ($departure) {
    $query .= " AND h.start_date >= ?";
    $params[] = $departure;
}
if ($return) {
    $query .= " AND h.end_date <= ?";
    $params[] = $return;
}

$stmt = $conn->prepare($query);

if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$hotels = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyniki wyszukiwania</title>
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
                <a href="login.php" class="login">logowanie</a>
                <a href="register.php" class="register">rejestracja</a>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <section class="search-results">
            <h2>Wyniki wyszukiwania</h2>
            <div class="cards-container">
                <?php if (count($hotels) > 0): ?>
                    <?php foreach ($hotels as $hotel): ?>
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" alt="<?php echo htmlspecialchars($hotel['name']); ?>">
                            <div class="card-content">
                                <div class="card-header">
                                    <h3><?php echo htmlspecialchars($hotel['country_name']); ?>, <?php echo htmlspecialchars($hotel['location']); ?></h3>
                                    <span><?php echo htmlspecialchars(number_format($hotel['price'], 2)); ?> Zł/os.</span>
                                </div>
                                <ul class="card-details">
                                    <li>Data: <?php echo htmlspecialchars($hotel['start_date']); ?> - <?php echo htmlspecialchars($hotel['end_date']); ?></li>
                                    <li>Miejsce wylotu: <?php echo htmlspecialchars($hotel['departure']); ?></li>
                                    <li>All inclusive: <?php echo htmlspecialchars($hotel['inclusive']); ?></li>
                                </ul>
                                <a href="hotel.php?id=<?php echo htmlspecialchars($hotel['id']); ?>">
                                    <button type="button">Zarezerwuj</button>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Brak wyników dla podanych kryteriów wyszukiwania.</p>
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
