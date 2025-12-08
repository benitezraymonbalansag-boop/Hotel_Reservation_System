<?php
session_start();
header('Content-Type: application/json');

require_once(__DIR__ . '/../classes/Client.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Invalid email']);
    exit;
}

$client = new Client();
$response = $client->login($email, $password);

if (isset($response['error'])) {
    echo json_encode(['error' => $response['error']]);
    exit;
}

$userId = $response['user_id'];

if ($userId == 1) {
    $role = 'admin';
} elseif ($userId == 2) {
    $role = 'staff';
} else {
    $role = 'user';
}

$_SESSION['user_id']   = $userId;
$_SESSION['email']     = $email;
$_SESSION['role']      = $role;

try {
    $conn = $client->connect();

    $stmt = $conn->prepare("
        INSERT INTO login (email, password, created_at)
        VALUES (?, ?, NOW())
    ");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();

} catch (Exception $e) {
}

switch ($role) {
    case 'admin':
        $redirect = '../admin/admin_info.php';
        break;

    case 'staff':
        $redirect = '../staff/staff_info.php';
        break;

    default:
        $redirect = '../user/user_info.php';
        break;
}

echo json_encode([
    'success' => 'Login successful',
    'role'    => $role,
    'redirect'=> $redirect
]);
exit;
?>
