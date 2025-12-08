<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9f9;
    color: #333;
    text-align: center;
    padding: 50px;
}

h1 {
    color: #1e3d59;
    font-size: 36px;
    margin-bottom: 40px;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 25px;
    font-size: 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

button:hover {
    background-color: #45a049;
    transform: scale(1.05);
}

a {
    text-decoration: none;
    color: #fff;
}

.logout-link {
    display: inline-block;
    margin-top: 30px;
    background-color: #ff4c4c;
    padding: 10px 20px;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.logout-link:hover {
    background-color: #e04343;
    transform: scale(1.05);
    color: #fff;
}

a + a, a + br {
    margin-top: 20px;
}
</style>
</head>
<body>

<h1>Welcome Admin!</h1>

<a href="pending_reservations.php">
    <button type="button">View Pending Reservations</button>
</a>

<br><br>

<a href="../handlers/logout.php" class="logout-link">Logout</a>

</body>
</html>
