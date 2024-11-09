<?php
header("Content-Type: application/json");
session_start();
require 'config.php'; // Veritabanı bağlantısını içeren dosya

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'] ?? null;
    $password = $input['password'] ?? null;

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo json_encode(["message" => "Giriş başarılı"]);
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Geçersiz kullanıcı adı veya parola"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Geçersiz giriş verileri"]);
    }
}
?>
