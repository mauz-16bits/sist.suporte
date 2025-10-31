<?php
session_start();
require_once 'db_connetion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['login-email'];
    $senha = $_POST['login-senha'];

    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            header("Location: ../index.php");
        } else {
            header("Location: ../index.php?error=credenciais_invalidas");
        }
    } else {
        header("Location: ../index.php?error=credenciais_invalidas");
    }

    $stmt->close();
    $conn->close();
}
?>