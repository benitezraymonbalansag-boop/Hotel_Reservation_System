<?php
require_once(__DIR__ . '/../classes/Client.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../pages/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('../assets/hotel4.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4); 
            z-index: 0;
        }

        .dashboard-container {
    position: relative; 
    z-index: 1;
    padding: 50px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    text-align: center;
    max-width: 500px;
    width: 90%;
    background: linear-gradient(135deg, #026122ff, #fefe08ff, #ffcc00, rgba(6, 255, 114, 1));
    background-size: 400% 400%;
    animation: fireGradient 8s ease infinite;
    color: white; 
}

@keyframes fireGradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.dashboard-container h1 {
    color: white;
    margin-bottom: 40px;
    font-size: 2.5rem;
}


        .dashboard-container button,
        .dashboard-container a.button-link {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px 0;
            font-size: 18px;
            font-weight: bold;
            color: white;
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .dashboard-container button:hover,
        .dashboard-container a.button-link:hover {
            background: linear-gradient(135deg, #ff4b2b, #ff416c);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .logout-link {
            display: block;
            margin-top: 20px;
            color: #ff4b2b;
            text-decoration: none;
            font-weight: bold;
        }

        .logout-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .dashboard-container {
                padding: 30px 20px;
            }

            .dashboard-container h1 {
                font-size: 2rem;
            }

            .dashboard-container button,
            .dashboard-container a.button-link {
                font-size: 16px;
                padding: 12px 25px;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h1>Welcome User!</h1>

    <a href="select_room.php" class="button-link">Request Room Reservation</a>

    <a href="../handlers/logout.php" class="logout-link">Logout</a>
</div>

</body>
</html>
