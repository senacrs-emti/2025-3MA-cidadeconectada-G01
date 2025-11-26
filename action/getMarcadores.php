<?php
include_once("../includes/_connection.php");

$tempo = $_GET["tempo"] ?? 1;
$tempo = intval($tempo);

$query = "
    SELECT latitude, longitude, DATE_FORMAT(data_hora, '%Y-%m-%d %H:%i:%s') as dt
    FROM localizacoes
    WHERE data_hora >= NOW() - INTERVAL ? HOUR
    ORDER BY data_hora DESC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tempo);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo $row["latitude"] . "," . $row["longitude"] . "," . $row["dt"] . ";";
}

$stmt->close();
$conn->close();
?>
