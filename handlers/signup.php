<?php
header('Content-Type: application/json');
include('../Classes/Client.php'); 

$client = new Client();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        echo json_encode(['error' => 'Email and password are required']);
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $insert = $client->signup($email, $hashed_password);

    if ($insert === 1) echo json_encode(['success' => 'Signup successful']);
    elseif ($insert === 3) echo json_encode(['error' => 'Email already exists']);
    else echo json_encode(['error' => 'Database error']);
    exit;
}

echo json_encode(['error' => 'Invalid request']);
exit;
?>
