<?php
session_start();
include_once("../includes/_connection.php");

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$senha2 = $_POST['senha2'] ?? '';

if (!$nome || !$email || !$senha || !$senha2) {
    die("Erro: Preencha todos os campos.");
}

if ($senha !== $senha2) {
    die("Erro: Senhas não conferem.");
}

$hash = password_hash($senha, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $hash);

if ($stmt->execute()) {
    $usuario_id = $stmt->insert_id;
    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['usuario_nome'] = $nome;
    header("Location: ../html/mapView.php");
    exit;
} else {
    if ($conn->errno === 1062) {
        die("Erro: E-mail já cadastrado.");
    } else {
        die("Erro ao cadastrar: " . $conn->error);
    }
}
