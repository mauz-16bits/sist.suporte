<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Suporte</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <header>
        <div class="header-container">
            <h1>
                Sistema de Suporte 
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <span class="user-greeting">| Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</span>
                <?php endif; ?>
            </h1>
            <div class="header-buttons">
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <a href="dashboard.php"><button>Meus Chamados</button></a>
                    <a href="php/logout.php"><button>Sair</button></a>
                <?php else: ?>
                    <button id="loginBtn">Login</button>
                    <button id="cadastroBtn">Cadastro</button>
                <?php endif; ?>
                <button id="theme-toggle" title="Alternar tema">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        <div class="form-container">
            <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
                <div class="login-notice">
                    <h2>Bem-vindo!</h2>
                    <p>Por favor, <a href="#" id="loginLink">faça login</a> ou <a href="#" id="cadastroLink">cadastre-se</a> para abrir um novo chamado.</p>
                </div>
            <?php endif; ?>

            <h2>Abrir Novo Chamado</h2>
            <p class="subtitle">Feito por Maurício e Cauan</p>

            <form action="php/create_ticket.php" method="POST">
                <div class="input-group">
                    <label for="equip">Nome do equipamento</label>
                    <input placeholder="Ex: Notebook" type="text" name="equip" id="equip" required>
                </div>

                <div class="input-group">
                    <label for="local">Local do equipamento</label>
                    <input placeholder="Ex: Lab 6 😼" type="text" name="local" id="local" required>
                </div>

                <div class="input-group">
                    <label for="date_equip">Data e hora da abertura</label>
                    <div class="datetime-group">
                        <input type="date" name="date_equip" id="date_equip" required>
                        <input type="time" name="hora_equip" id="hora_equip" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="nome">Responsável pela abertura</label>
                    <input placeholder="Digite seu nome completo" type="text" name="nome" id="nome"
                           value="<?php echo isset($_SESSION['nome']) ? htmlspecialchars($_SESSION['nome']) : ''; ?>" 
                           <?php echo isset($_SESSION['nome']) ? 'readonly' : ''; ?> required>
                </div>
                
                <button type="submit" class="submit-btn" <?php echo (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) ? 'disabled' : ''; ?>>
                    Concluir Abertura
                </button>
            </form>
        </div>
    </main>

    <dialog id="loginDialog">
        <form action="php/login.php" method="POST">
            <h2>Login</h2>
            <div class="input-group">
                <label for="login-email">Email</label>
                <input type="email" id="login-email" name="login-email" placeholder="seuemail@exemplo.com" required>
            </div>
            <div class="input-group">
                <label for="login-senha">Senha</label>
                <input type="password" id="login-senha" name="login-senha" placeholder="Sua senha" required>
            </div>
            <div class="dialog-actions">
                <button type="submit" class="submit-btn">Entrar</button>
                <button type="button" class="close-btn">Fechar</button>
            </div>
        </form>
    </dialog>

    <dialog id="cadastroDialog">
        <form action="php/register.php" method="POST">
            <h2>Cadastro</h2>
            <div class="input-group">
                <label for="cad-nome">Nome Completo</label>
                <input type="text" id="cad-nome" name="cad-nome" placeholder="Seu nome" required>
            </div>
            <div class="input-group">
                <label for="cad-email">Email</label>
                <input type="email" id="cad-email" name="cad-email" placeholder="seuemail@exemplo.com" required>
            </div>
            <div class="input-group">
                <label for="cad-senha">Senha</label>
                <input type="password" id="cad-senha" name="cad-senha" placeholder="Crie uma senha forte" required>
            </div>
            <div class="dialog-actions">
                <button type="submit" class="submit-btn">Cadastrar</button>
                <button type="button" class="close-btn">Fechar</button>
            </div>
        </form>
    </dialog>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        const loginBtn = document.getElementById('loginBtn');
        const cadastroBtn = document.getElementById('cadastroBtn');
        const loginDialog = document.getElementById('loginDialog');
        const cadastroDialog = document.getElementById('cadastroDialog');
        
        const loginLink = document.getElementById('loginLink');
        const cadastroLink = document.getElementById('cadastroLink');

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
        });

        if (loginBtn) {
            loginBtn.addEventListener('click', () => loginDialog.showModal());
        }
        if (cadastroBtn) {
            cadastroBtn.addEventListener('click', () => cadastroDialog.showModal());
        }

        if (loginLink) {
            loginLink.addEventListener('click', (e) => {
                e.preventDefault();
                loginDialog.showModal();
            });
        }
        if (cadastroLink) {
            cadastroLink.addEventListener('click', (e) => {
                e.preventDefault();
                cadastroDialog.showModal();
            });
        }
        
        loginDialog.querySelector('.close-btn').addEventListener('click', () => loginDialog.close());
        cadastroDialog.querySelector('.close-btn').addEventListener('click', () => cadastroDialog.close());
    </script>

</body>
</html>