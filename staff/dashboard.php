<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../pages/login.php");
    exit;
}
?>

<h1>Welcome Staff!</h1>

<a href="todays_reservations.php"
   style="display:inline-block;
          padding:10px 20px;
          background:#007bff;
          color:white;
          text-decoration:none;
          border-radius:5px;">
   View Today's Reservations
</a>

<br><br>

<a href="../handlers/logout.php">Logout</a>
