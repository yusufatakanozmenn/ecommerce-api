<?php
header("Content-Type: application/json");
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? null;

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(["message" => "Ürün başarıyla silindi"]);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Ürün ID gereklidir"]);
    }
}
?>
