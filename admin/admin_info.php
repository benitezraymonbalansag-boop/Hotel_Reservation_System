<?php
session_start();
require_once(__DIR__ . '/../classes/Client.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit();
}

$client = new Client();
$admin_id = $_SESSION['user_id'];

$conn = $client->connect();

$adminInfo = ['name' => '', 'email' => ''];

$stmt = $conn->prepare("SELECT name, email FROM admin_info WHERE admin_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $stmt->bind_result($name, $email);
    if ($stmt->fetch()) {
        $adminInfo['name'] = $name;
        $adminInfo['email'] = $email;
    }
    $stmt->close();
} else {
    die("Prepare failed: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $checkStmt = $conn->prepare("SELECT id FROM admin_info WHERE admin_id = ?");
    $checkStmt->bind_param("i", $admin_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE admin_info SET name = ?, email = ? WHERE admin_id = ?");
        $stmt->bind_param("ssi", $name, $email, $admin_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO admin_info (admin_id, name, email) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $admin_id, $name, $email);
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
    <title>Admin Information</title>
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
            background: url('../images/hotel7.jpg') no-repeat center center;
            background-size: cover;
        }

        .background::before {
            content: "";
            position: absolute;
            top:0; left:0;
            width:100%; height:100%;
            background: rgba(0,0,0,0.4);
            z-index: 0;
        }

        .info-card {
            position: relative;
            z-index: 1;
            background: rgba(255,255,255,0.95);
            padding: 2rem;
            border-radius: 1rem;
            width: 400px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
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

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 0.7rem;
            background-color: #2a8cdcff;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #2a8cdcff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="info-card">
            <h1>Fill Your Information</h1>
            <form method="POST" action="">
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($adminInfo['name']) ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($adminInfo['email']) ?>" required>

                <button type="submit">Save Information</button>
            </form>
            <a href="dashboard.php">Skip and go to Dashboard</a>
        </div>
    </div>
</body>
</html>
