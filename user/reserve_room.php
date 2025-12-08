<?php
require_once(__DIR__ . '/../classes/Client.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../pages/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Room not found.");
}

$room_id = intval($_GET['id']);

echo "<h1>You selected Room ID: $room_id</h1>";
echo "<p>Reservation page coming soon...</p>";
echo '<a href="select_room.php">Back</a>';
