<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $hotel_id = $_POST['hotel_id'];

    $query = "INSERT INTO reservations (user_id, hotel_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $hotel_id);
    $stmt->execute();
    $stmt->close();

    $query = "UPDATE hotels SET is_reserved = TRUE WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $stmt->close();

    header("Location: reservations.php");
    exit();
}
?>
