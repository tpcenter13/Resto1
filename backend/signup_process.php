<?php
require_once 'config.php';

// Read raw JSON data
$input = json_decode(file_get_contents('php://input'), true);
$fullname = $input['fullname'] ?? '';
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

if ($fullname && $email && $password) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already registered']);
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullname, $email, $hashed_password);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Account created successfully! Welcome to Kultura Cuisine family!', 'redirect' => 'login.html']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Signup failed: ' . $conn->error]);
        }
        $stmt->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Please fill in all fields']);
}

$conn->close();
?>