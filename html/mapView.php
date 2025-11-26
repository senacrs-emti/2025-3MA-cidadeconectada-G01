<?php
session_start();
include_once "../includes/_connection.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Denúncias</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/auth.css">
</head>
<body>

    <div class="topbar">
        <a href="./index.php">
            <button>Home</button>
        </a>
        <button id="btnDenuncia" class="btn-toggle">Denúncia: OFF</button>
        <button id="btnLocalizar" class="btn-center">Centralizar Usuário</button>
        <div id="statusText">Clique em "Denúncia" para marcar um local</div>
        <div style="margin-left: 10px;">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <span style="color: white; margin-right:8px;">Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
                <a href="../action/logout.php"><button>Logout</button></a>
            <?php else: ?>
                <a href="login.php"><button>Entrar</button></a>
                <a href="register.php"><button>Cadastre-se</button></a>
            <?php endif; ?>
        </div>
    </div>

    <div id="map"></div>

    <div class="filter-bar">
        <label>Filtrar por tempo:</label>
        <button data-tempo="1" class="filter-btn active">1 Hora</button>
        <button data-tempo="24" class="filter-btn">1 Dia</button>
        <button data-tempo="168" class="filter-btn">7 Dias</button>
        <button data-tempo="720" class="filter-btn">30 Dias</button>
        <button data-tempo="2160" class="filter-btn">90 Dias</button>
    </div>

    <div class="osm-licence">
        &#169; Tiles OpenStreetMap contributors - uso educativo
    </div>

    <script>
        // variáveis injetadas do PHP
        const LOGGED_IN = <?php echo isset($_SESSION['usuario_id']) ? 'true' : 'false'; ?>;
        const USER_NAME = <?php echo json_encode($_SESSION['usuario_nome'] ?? ''); ?>;
    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="../script/script.js"></script>

</body>
</html>
