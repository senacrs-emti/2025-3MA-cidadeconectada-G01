<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: ./mapView.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Login - BancoAssault</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../style/stylelogin.css">
</head>
<body>
    <div class="auth-container">
        <h1>Entrar</h1>
        <form action="../action/login.php" method="post" class="auth-form">
            <label>E-mail</label>
            <input type="email" name="email" required maxlength="150">
            <label>Senha</label>
            <input type="password" name="senha" required>
            <button type="submit" class="btn-submit">Login</button>
        </form>
        <p class="small">Ainda não tem conta? <a href="register.php">Cadastre-se</a></p>
    </div>
</body>
</html>
