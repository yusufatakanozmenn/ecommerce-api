<?php
header("Content-Type: application/json");
require 'config.php';

session_start();

// Başlıkta gelen token'ı kontrol edin
$headers = getallheaders();
$token = $headers['Authorization'] ?? null;

if ($token !== $_SESSION['token']) {
    http_response_code(401);
    echo json_encode(["message" => "Geçersiz veya eksik token"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'] ?? null;
    $email = $input['email'] ?? null;

    if ($username && $email) {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        if ($stmt->execute([$username, $email, $_SESSION['user_id']])) {
            echo json_encode(["message" => "Profil güncellendi"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Profil güncellenirken bir hata oluştu"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Geçersiz giriş verileri"]);
    }
}
?>
