<?php
header("Content-Type: application/json");

$con = new mysqli("localhost", "root", "", "bancoAssault");

$tempo = $_GET["tempo"] ?? "1 HOUR";

$stmt = $con->prepare("SELECT latitude, longitude FROM denuncias WHERE data_registro >= NOW() - INTERVAL $tempo");
$stmt->execute();
$result = $stmt->get_result();

echo json_encode($result->fetch_all(MYSQLI_ASSOC));

$stmt->close();
$con->close();
?>
