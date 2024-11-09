<?php
header("Content-Type: application/json");
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? null;
    $name = $input['name'] ?? null;
    $description = $input['description'] ?? null;
    $price = $input['price'] ?? null;

    if ($id && $name && $price) {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $id]);

        echo json_encode(["message" => "Ürün başarıyla güncellendi"]);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Ürün ID, adı ve fiyatı gereklidir"]);
    }
}
?>
