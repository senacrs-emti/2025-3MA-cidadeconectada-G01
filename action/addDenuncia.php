<?php 
header("Content-Type": aplication/json);
$data = json_decode(file_get_contents("php://input"), true);

$lat = $data["lat"];
$lng = $data["lng"];

$con = new mysqli("localhost", "root", "", "bancoAssault");

$stmt = $con->prepare("INSERT INTO denuncias (data_registro, latitude, longitude) VALUES (NOW(), ?, ?)");
$stmt->bind_param("dd", $lat, $lng);
$stmt->execute();

$stmt->close();
$con->close();

?>