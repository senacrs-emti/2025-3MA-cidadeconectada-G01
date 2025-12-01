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
        <div style="margin-bottom: 1vh; margin-top: 1vh;">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <span style="color: white; margin-right:8px;">Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
                <a href="../action/logout.php"><button class="btn-index">Logout</button></a>
            <?php else: ?>
                <a href="login.php"><button class="btn-index">Entrar</button></a>
                <a href="register.php"><button class="btn-index">Cadastre-se</button></a>
            <?php endif; ?>
        </div>
        <button id="btnDenuncia" class="btn-toggle btn-index">Denúncia: OFF</button>
        <button id="btnLocalizar" class="btn-center btn-index">Centralizar Usuário</button>
        <div id="statusText" class="p">Clique em "Denúncia" para marcar um local</div>
    </div>

    <div id="map"></div>

    <div class="filter-bar">
        <label>Filtrar por tempo:</label>
        <br>
        <button data-tempo="1" class="filter-btn active btn-index">1 Hora</button>
        <button data-tempo="24" class="filter-btn btn-index">1 Dia</button>
        <button data-tempo="168" class="filter-btn btn-index">7 Dias</button>
        <button data-tempo="720" class="filter-btn btn-index">30 Dias</button>
        <button data-tempo="2160" class="filter-btn btn-index">90 Dias</button>
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
