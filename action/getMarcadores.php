<?php
include_once("../includes/_connection.php");

$tempo = $_GET["tempo"] ?? 1;
$tempo = intval($tempo);

$query = "
    SELECT latitude, longitude 
    FROM localizacoes 
    WHERE data_hora >= NOW() - INTERVAL ? HOUR
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tempo);
$stmt->execute();

$result = $stmt->get_result();

// gera HTML simples para cada marcador
while ($row = $result->fetch_assoc()) {
    echo $row["latitude"] . "," . $row["longitude"] . ";";
}

$stmt->close();
$conn->close();
?>
