<?php
header("Content-Type: application/json");
require 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($products);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Bir hata oluştu: " . $e->getMessage()]);
}
?>
