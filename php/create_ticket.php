<?php
session_start();
require_once 'db_connetion.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php?error=nao_logado");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION['id'];
    $equipamento = $_POST['equip'];
    $local = $_POST['local'];
    $data = $_POST['date_equip'];
    $hora = $_POST['hora_equip'];
    $responsavel = $_POST['nome'];

    $data_abertura = $data . ' ' . $hora;

    $sql = "INSERT INTO chamados (id_usuario, equipamento, local, data_abertura, responsavel) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $id_usuario, $equipamento, $local, $data_abertura, $responsavel);

    if ($stmt->execute()) {
        header("Location: ../index.php?status=chamado_sucesso");
    } else {
        header("Location: ../index.php?status=erro_chamado");
    }

    $stmt->close();
    $conn->close();
}
?>