<?php
header("Content-Type: application/json");
require 'config.php'; // Veritabanı bağlantısını içeren dosya

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'] ?? null;
    $email = $input['email'] ?? null;
    $password = $input['password'] ?? null;

    if ($username && $email && $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashedPassword])) {
            echo json_encode(["message" => "Kayıt başarılı"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Kayıt sırasında bir hata oluştu"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Geçersiz giriş verileri"]);
    }
}
?>
