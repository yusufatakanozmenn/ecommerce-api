<?php
header("Content-Type: application/json");
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $token = $input['token'] ?? null;
    $newPassword = $input['password'] ?? null;

    if ($token && $newPassword) {
        // Token'ı kontrol et
        $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
        $resetRequest = $stmt->fetch();

        if ($resetRequest) {
            // Parolayı sıfırla
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->execute([$hashedPassword, $resetRequest['email']]);

            // Token'ı veritabanından sil
            $stmt = $pdo->prepare("DELETE FROM password_resets WHERE token = ?");
            $stmt->execute([$token]);

            echo json_encode(["message" => "Şifre başarıyla güncellendi"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Geçersiz token"]);
        }
    } else {
        http_response_code(400);
        echo jsonencode(["message" => "Token ve yeni parola gereklidir"]);
    }
}
?>
