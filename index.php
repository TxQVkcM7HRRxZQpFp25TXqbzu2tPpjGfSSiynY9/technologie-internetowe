<?php
session_start();
require 'config.php'; // Your database connection file

// Fetch recommended countries along with the count of hotels and the minimum hotel price
$query = "
    SELECT c.id, c.name, c.image_url, MIN(h.price) as min_price, COUNT(h.id) AS hotels_available
    FROM countries c
    LEFT JOIN hotels h ON c.id = h.country_id
    WHERE c.recommended = TRUE
    GROUP BY c.id
    LIMIT 4
";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$countries = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch all countries for the dropdown list
$query_all_countries = "
    SELECT id, name
    FROM countries
";
$stmt_all_countries = $conn->prepare($query_all_countries);
$stmt_all_countries->execute();
$result_all_countries = $stmt_all_countries->get_result();
$all_countries = $result_all_countries->fetch_all(MYSQLI_ASSOC);
$stmt_all_countries->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel</title>
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
                <a href="profile.php"><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></a>
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
    <section class="why-us">
        <h2>Dlaczego My?</h2>
        <div class="features">
            <div class="feature">
                <div class="icon">
                    <img src="https://e7.pngegg.com/pngimages/219/846/png-clipart-luxury-hotel-accommodation-hotel-icons-text-rectangle.png" alt="Hotel Icon">
                </div>
                <h3>Największy Wybór Hoteli</h3>
                <p>Zapewniamy bogactwo opcji zakwaterowania na każdą kieszeń i każdy gust. Od luksusowych kurortów po przytulne pensjonaty - z nami znajdziesz idealny nocleg dopasowany do Twoich potrzeb i preferencji. Zanurz się w wyjątkowym doświadczeniu podróży, wiedząc, że Twój komfort jest naszym priorytetem.</p>
            </div>
            <div class="feature">
                <div class="icon">
                    <img src="https://e7.pngegg.com/pngimages/11/291/png-clipart-computer-icons-three-people-black-%D0%BD%D0%BE%D0%B2%D1%8B%D0%B5-%D0%BF%D1%80%D0%B0%D0%B2%D0%B8%D0%BB%D0%B0-thumbnail.png" alt="Service Icon">
                </div>
                <h3>Najlepsza Obsługa</h3>
                <p>Nasz zespół doświadczonych doradców jest gotowy, by zadbać o każdy detal Twojej podróży, zapewniając Ci spokój i komfort od chwili rezerwacji do momentu powrotu do domu. Ufaj nam, aby uczynić Twoją podróż nie tylko wyjątkową, ale również bezproblemową i wyjątkowo przyjemną.</p>
            </div>
            <div class="feature">
                <div class="icon">
                    <img src="https://static.vecteezy.com/system/resources/thumbnails/017/784/762/small_2x/airplane-icon-in-black-colors-aviation-signs-illustration-png.png" alt="Experience Icon">
                </div>
                <h3>Niezapomniane Przeżycia</h3>
                <p>Odkryjcie razem z nami najbardziej fascynujące atrakcje, najpiękniejsze zakątki świata i unikalne doświadczenia, które na zawsze pozostaną w Twojej pamięci. Niech nasza pasja do podróżowania połączona z profesjonalizmem sprawi, że Twój wyjazd stanie się wyjątkową przygodą pełną niepowtarzalnych emocji i niezapomnianych chwil.</p>
            </div>
        </div>
    </section>
    <main>
        <section class="recommended-countries">
            <h2>Polecane Kraje</h2>
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
