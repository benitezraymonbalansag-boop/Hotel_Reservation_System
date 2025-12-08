<?php
session_start();
require_once(__DIR__ . '/../classes/Client.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../pages/login.php");
    exit();
}

$client = new Client();
$user_id = $_SESSION['user_id'];

$conn = $client->connect();

$userInfo = ['name' => '', 'phone' => '', 'address' => ''];

$stmt = $conn->prepare("SELECT name, phone, address FROM user_info WHERE user_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($name, $phone, $address);
    if ($stmt->fetch()) {
        $userInfo['name'] = $name;
        $userInfo['phone'] = $phone;
        $userInfo['address'] = $address;
    }
    $stmt->close();
} else {
    die("Prepare failed: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['save_info'])) {
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        $checkStmt = $conn->prepare("SELECT id FROM user_info WHERE user_id = ?");
        $checkStmt->bind_param("i", $user_id);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE user_info SET name = ?, phone = ?, address = ? WHERE user_id = ?");
            $stmt->bind_param("sssi", $name, $phone, $address, $user_id);
        } else {
            $stmt = $conn->prepare("INSERT INTO user_info (user_id, name, phone, address) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $user_id, $name, $phone, $address);
        }

        $stmt->execute();
        $stmt->close();
        $checkStmt->close();

        header("Location: dashboard.php");
        exit();
    }

    if (isset($_POST['view_pending'])) {
        $resStmt = $conn->prepare("SELECT id FROM reservations WHERE user_id = ?");
        $resStmt->bind_param("i", $user_id);
        $resStmt->execute();
        $resStmt->store_result();

        if ($resStmt->num_rows > 0) {
            header("Location: reservation_details.php");
        } else {
            echo "<script>alert('You have no reservations yet. Please make a reservation first.');</script>";
        }
        $resStmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fill Your Information</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .background {
            position: relative;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('../images/hotel3.jpg') no-repeat center center;
            background-size: cover;
        }

        .background::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.35);
            z-index: 0;
        }

        .info-card {
            position: relative;
            z-index: 1;
            background: rgba(255,255,255,0.95);
            padding: 2rem;
            border-radius: 1rem;
            width: 400px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 0.3rem;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 80px;
        }

        button {
            width: 48%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            margin-right: 2%;
            border: none;
            border-radius: 0.5rem;
            font-weight: bold;
            cursor: pointer;
        }

        button[name="save_info"] {
            background-color: #2a8cdcff;
            color: white;
        }

        button[name="view_pending"] {
            background-color: #f5f5f5;
            color: #333;
        }

        button:hover {
            opacity: 0.9;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="info-card">
            <h1>Fill Your Information</h1>
            <form method="POST" action="">
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($userInfo['name']) ?>" required>

                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($userInfo['phone']) ?>" required>

                <label for="address">Address:</label>
                <textarea name="address" id="address" required><?= htmlspecialchars($userInfo['address']) ?></textarea>

                <div class="button-container">
                    <button type="submit" name="save_info">Confirm</button>
                    <button type="submit" name="view_pending">View My Reservations</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
