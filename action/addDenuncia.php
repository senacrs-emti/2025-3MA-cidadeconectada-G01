<?php
include_once("../includes/_connection.php");

$lat = $_POST["lat"] ?? null;
$lng = $_POST["lng"] ?? null;

if (!$lat || !$lng) {
    echo "Erro: coordenadas inválidas.";
    exit;
}

$stmt = $conn->prepare("INSERT INTO localizacoes (data_hora, latitude, longitude) VALUES (NOW(), ?, ?)");
$stmt->bind_param("dd", $lat, $lng);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "OK";
} else {
    echo "Erro ao registrar.";
}

$stmt->close();
$conn->close();
?>
