<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

require_once 'php/db_connetion.php';

$id_usuario = $_SESSION['id']; 

$sql = "SELECT id, equipamento, local, data_abertura, status FROM chamados WHERE id_usuario = ? ORDER BY data_abertura DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Chamados - Sistema de Suporte</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<header>
    <div class="header-container">
        <h1>
            Sistema de Suporte
            <span class="user-greeting">| Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</span>
        </h1>
        <div class="header-buttons">
            <a href="index.php"><button>Abrir Novo Chamado</button></a>
            <a href="php/logout.php"><button>Sair</button></a>
            <button id="theme-toggle" title="Alternar tema">
                <svg xmlns="http://www.w.org/2000/svg" width="24" height="24" viewBox="0 0 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
            </button>
        </div>
    </div>
</header>

<main>
    <div class="dashboard-container">
        <h2>Meus Chamados</h2>
        <table>
            <thead>
                <tr>
                    <th>Equipamento</th>
                    <th>Local</th>
                    <th>Data de Abertura</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($chamado = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($chamado['equipamento']); ?></td>
                            <td><?php echo htmlspecialchars($chamado['local']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($chamado['data_abertura'])); ?></td>
                            <td>
                                <!-- A classe CSS muda dinamicamente com o status -->
                                <span class="status <?php echo strtolower(htmlspecialchars($chamado['status'])); ?>">
                                    <?php echo htmlspecialchars($chamado['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($chamado['status'] == 'Aberta'): ?>
                                    <form action="php/update_status.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="chamado_id" value="<?php echo $chamado['id']; ?>">
                                        <input type="hidden" name="novo_status" value="Resolvida">
                                        <button type="submit" class="action-btn">Marcar como Resolvida</button>
                                    </form>
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Você ainda não abriu nenhum chamado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;
    themeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
    });
</script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>