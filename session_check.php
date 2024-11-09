<?php
header("Content-Type: application/json");
session_start();

if (isset($_SESSION['user_id'])) {
    echo json_encode(["authenticated" => true, "username" => $_SESSION['username']]);
} else {
    http_response_code(401);
    echo json_encode(["authenticated" => false, "message" => "Oturum bulunamadı"]);
}
?>
