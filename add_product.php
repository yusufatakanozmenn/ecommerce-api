<?php
header("Content-Type: application/json");
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $name = $input['name'] ?? null;
    $description = $input['description'] ?? '';
    $price = $input['price'] ?? null;

    if ($name && $price) {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
        $stmt->execute([$name, $description, $price]);

        echo json_encode(["message" => "Ürün başarıyla eklendi"]);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Ürün adı ve fiyatı gereklidir"]);
    }
}
?>
