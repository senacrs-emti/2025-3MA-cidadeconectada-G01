<?php include_once "../includes/_header.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Denúncias</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

    <div class="topbar">
        <button id="btnDenuncia" class="btn-toggle">Denúncia: OFF</button>
        <button id="btnLocalizar" class="btn-center">Centralizar Usuário</button>
        <div id="statusText">Clique em "Denúncia" para maracar um local</div>
    </div>

    <div id="map"></div>


    <div class="filter-bar">
        <label for="">Filtrar por tempo</label>
        <button class="1" class="filter-btn active">1 Hora</button>
        <button class="24" class="filter-btn">1 Dia</button>
        <button class="168" class="filter-btn">7 Dias</button>
        <button class="720" class="filter-btn">30 Dias</button>
        <button class="2160" class="filter-btn">90 Dias</button>
    </div>

    <div class="osm-licence">
        Titles: OpenStreetMap contributors - uso local para fins educativos
    </div>
    
    
    <?php include_once "../includes/_footer.php"?>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="../script/script.js"></script>

</body>
</html>