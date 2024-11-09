<?php
header("Content-Type: application/json");
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? null;

    if ($email) {
        // Veritabanında kullanıcının e-posta adresini kontrol et
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Token oluştur ve veritabanına kaydet
            $token = bin2hex(random_bytes(16));
            $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$email, $token]);

            // Token'ı yanıt olarak döndür (E-posta yerine test amaçlı)
            echo json_encode(["message" => "Parola sıfırlama talimatları oluşturuldu", "token" => $token]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "E-posta bulunamadı"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "E-posta adresi gereklidir"]);
    }
}
?>
