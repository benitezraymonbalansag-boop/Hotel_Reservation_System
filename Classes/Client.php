<?php
require_once(__DIR__ . '/Connection.php');

class Client extends Dbh
{
    public function signup($email, $hashed_password) {
        $conn = $this->connect();
        $search = $conn->prepare('SELECT email FROM users WHERE email = ?');
        if (!$search) return 2;
        $search->bind_param('s', $email);
        $search->execute();
        $search->store_result();

        if ($search->num_rows > 0) return 3;

        $stmt = $conn->prepare('INSERT INTO users (email, password, created_at) VALUES (?, ?, NOW())');
        if (!$stmt) return 2;
        $stmt->bind_param('ss', $email, $hashed_password);

        return $stmt->execute() ? 1 : 2;
    }

    public function login($email, $password) {
        $conn = $this->connect();
        $stmt = $conn->prepare('SELECT id, email, password FROM users WHERE email = ? LIMIT 1');
        if (!$stmt) return ['error' => 'Database error'];

        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) return ['error' => 'Email not found'];

        $user = $result->fetch_assoc();

        return password_verify($password, $user['password'])
            ? ['success' => 'Login successful', 'user_id' => $user['id']]
            : ['error' => 'Incorrect password'];
    }
}
?>

