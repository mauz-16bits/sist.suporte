<?php
require_once 'db_connetion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['cad-nome'];
    $email = $_POST['cad-email'];
    $senha = $_POST['cad-senha'];

    if (empty($nome) || empty($email) || empty($senha)) {
        die("Por favor, preencha todos os campos.");
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $senha_hash);

    if ($stmt->execute()) {
        header("Location: ../index.php?status=cadastro_ok");
    } else {
        header("Location: ../index.php?status=erro_cadastro");
    }

    $stmt->close();
    $conn->close();
}
?>