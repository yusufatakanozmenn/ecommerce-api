<?php
header("Content-Type: application/json");
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $name = $input['name'] ?? null;

    if ($name) {
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$name]);

        echo json_encode(["message" => "Kategori başarıyla eklendi"]);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Kategori adı gereklidir"]);
    }
}
?>
