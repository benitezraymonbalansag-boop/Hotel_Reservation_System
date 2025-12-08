<?php
session_start();
require_once(__DIR__ . '/../classes/Client.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../pages/login.php");
    exit();
}

$client = new Client();
$staff_id = $_SESSION['user_id'];

$conn = $client->connect();

$staffInfo = ['name' => '', 'email' => ''];

$stmt = $conn->prepare("SELECT name, email FROM staff_info WHERE staff_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $stmt->bind_result($name, $email);
    if ($stmt->fetch()) {
        $staffInfo['name'] = $name;
        $staffInfo['email'] = $email;
    }
    $stmt->close();
} else {
    die("Prepare failed: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $checkStmt = $conn->prepare("SELECT id FROM staff_info WHERE staff_id = ?");
    $checkStmt->bind_param("i", $staff_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE staff_info SET name = ?, email = ? WHERE staff_id = ?");
        $stmt->bind_param("ssi", $name, $email, $staff_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO staff_info (staff_id, name, email) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $staff_id, $name, $email);
    }

    $stmt->execute();
    $stmt->close();
    $checkStmt->close();

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fill Your Information</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        body {
            background-image: url('images/hotel8.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: rgba(255, 255, 255, 0.9); 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            text-align: center;
            width: 350px;
            max-width: 90%;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h1>Fill Your Information</h1>

        <label for="name">Full Name:</label><br>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($staffInfo['name']) ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($staffInfo['email']) ?>" required><br><br>

        <button type="submit">Save Information</button>
        <a href="dashboard.php">Skip and go to Dashboard</a>
    </form>
</body>
</html>
