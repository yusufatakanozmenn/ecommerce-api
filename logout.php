<?php
header("Content-Type: application/json");
session_start();
session_unset();
session_destroy();

echo json_encode(["message" => "Oturum kapatıldı"]);
?>
