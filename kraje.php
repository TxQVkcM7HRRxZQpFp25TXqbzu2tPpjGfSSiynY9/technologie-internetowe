<?php
session_start();
require 'config.php';

$query = "
    SELECT c.id, c.name, c.image_url, MIN(h.price) AS min_price, COUNT(h.id) AS hotels_available
    FROM countries c
    LEFT JOIN hotels h ON c.id = h.country_id
    GROUP BY c.id
";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$countries = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kraje</title>
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
    <section class="search-section">
    <div class="overlay"></div>
    <h1>Wybierz gdzie chcesz się udać</h1>
    <form action="country.php" method="get" class="search-form">
        <div class="form-group">
            <label for="country">
                <select id="country" name="id" required>
                    <option value="" disabled selected>Kraj</option>
                    <?php
                    $query_all_countries = "SELECT id, name FROM countries";
                    $result_all_countries = $conn->query($query_all_countries);
                    while ($row = $result_all_countries->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
                    }
                    ?>
                </select>
            </label>
        </div>
        <div class="form-group">
            <label for="departure">
                <input type="date" id="departure" name="departure" placeholder="Od">
            </label>
        </div>
        <div class="form-group">
            <label for="return">
                <input type="date" id="return" name="return" placeholder="Do">
            </label>
        </div>
        <div class="form-group">
            <label for="people">
                <select id="people" name="people" required>
                    <option value="" disabled selected>Ilość osób</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </label>
        </div>
        <button type="submit">Szukaj</button>
    </form>
</section>
    <main>
        <section class="all-countries">
            <h2>Wszystkie Kraje</h2>
            <div class="cards-container">
                <?php foreach ($countries as $country): ?>
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($country['image_url']); ?>" alt="<?php echo htmlspecialchars($country['name']); ?>">
                        <div class="card-content">
                            <div class="card-header">
                                <h3><?php echo htmlspecialchars($country['name']); ?></h3>
                                <span>Od <?php echo htmlspecialchars(number_format($country['min_price'], 2)); ?> Zł</span>
                            </div>
                            <ul class="card-details">
                                <li>Ilość dostępnych hoteli: <?php echo htmlspecialchars($country['hotels_available']); ?></li>
                            </ul>
                            <a href="country.php?id=<?php echo htmlspecialchars($country['id']); ?>">
                                <button type="button">Wybierz</button>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
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
