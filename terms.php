<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regulamin Biura Podróży</title>
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

    <main class="main">
        <section class="terms-section">
            <h1>Regulamin Biura Podróży</h1>
            <div class="terms-content">
                <h2>1. Postanowienia ogólne</h2>
                <p>Niniejszy regulamin określa zasady korzystania z usług biura podróży Travel. Regulamin jest integralną częścią umowy zawieranej między klientem a biurem podróży.</p>
                <h2>2. Warunki rezerwacji</h2>
                <p>Rezerwacja może być dokonana online, telefonicznie lub osobiście w siedzibie biura. Po dokonaniu rezerwacji klient otrzymuje potwierdzenie zawarcia umowy wraz z informacjami o wycieczce.</p>
                <h2>3. Płatności</h2>
                <p>Wszystkie płatności należy dokonywać w terminach określonych w umowie. Biuro podróży akceptuje płatności gotówką, przelewem bankowym oraz kartą kredytową. Brak płatności w terminie może skutkować anulowaniem rezerwacji.</p>
                <h2>4. Rezygnacja i zwroty</h2>
                <p>Klient ma prawo do rezygnacji z wycieczki na warunkach określonych w umowie. Zwroty dokonywane są zgodnie z zasadami opisanymi w umowie, w zależności od terminu rezygnacji.</p>
                <h2>5. Odpowiedzialność biura</h2>
                <p>Biuro podróży ponosi odpowiedzialność za należyte wykonanie umowy. W przypadku nieprzewidzianych okoliczności, biuro zastrzega sobie prawo do zmiany programu wycieczki, zapewniając jednak świadczenia o tej samej lub wyższej wartości.</p>
                <h2>6. Postanowienia końcowe</h2>
                <p>Niniejszy regulamin wchodzi w życie z dniem jego publikacji na stronie internetowej biura podróży. Biuro zastrzega sobie prawo do zmian w regulaminie, które wchodzą w życie z dniem ich publikacji.</p>
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
