<?php
session_start();
include_once("../includes/_connection.php");

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    die("Erro: Preencha os campos.");
}

$stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($user = $res->fetch_assoc()) {
    if (password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nome'] = $user['nome'];
        header("Location: ../html/mapView.php");
        exit;
    } else {
        die("Erro: E-mail ou senha inválidos.");
    }
} else {
    die("Erro: E-mail ou senha inválidos.");
}
