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
    <title>Cadastro - BancoAssault</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../style/stylelogin.css">
</head>
<body>
    <div class="auth-container">
        <h1>Cadastre-se</h1>
        <form action="../action/register.php" method="post" class="auth-form">
            <label>Nome</label>
            <input type="text" name="nome" required maxlength="100">
            <label>E-mail</label>
            <input type="email" name="email" required maxlength="150">
            <label>Senha</label>
            <input type="password" name="senha" required minlength="6">
            <label>Confirmar senha</label>
            <input type="password" name="senha2" required minlength="6">
            <button type="submit" class="btn-submit">Criar conta</button>
        </form>
        <p class="small">Já tem conta? <a href="login.php">Entrar</a></p>
    </div>
</body>
</html>
