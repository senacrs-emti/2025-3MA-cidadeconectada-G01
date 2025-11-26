<?php
session_start();
include_once("../includes/_connection.php");

if (!isset($_SESSION['usuario_id'])) {
    echo "Erro: usuário não autenticado.";
    exit;
}

$lat = $_POST["lat"] ?? null;
$lng = $_POST["lng"] ?? null;
$usuario_id = intval($_SESSION['usuario_id']);

if (!$lat || !$lng) {
    echo "Erro: coordenadas inválidas.";
    exit;
}

$stmt = $conn->prepare("INSERT INTO localizacoes (usuario_id, data_hora, latitude, longitude) VALUES (?, NOW(), ?, ?)");
$stmt->bind_param("idd", $usuario_id, $lat, $lng);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "OK";
} else {
    echo "Erro ao registrar.";
}

$stmt->close();
$conn->close();
?>
