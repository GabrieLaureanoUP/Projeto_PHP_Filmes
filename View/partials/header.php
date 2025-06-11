<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de filmes</title>
    <link rel="stylesheet" href="/Projeto_PHP_Filmes/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <div class="logo">
            <span>Catálogo</span> de Filmes
        </div>
        <nav>
            <ul>
                <li><a href="/Projeto_PHP_Filmes/index.php?p=listar">Home</a></li>

                <?php if(!isset($_SESSION['usuario'])): ?>
                    <li><a href="/Projeto_PHP_Filmes/index.php?p=login">Login</a></li>
                    <li><a href="/Projeto_PHP_Filmes/index.php?p=cadastro">Cadastrar</a></li>
                <?php else: ?>
                    <li><a href="/Projeto_PHP_Filmes/index.php?p=criar">Adicionar Filme</a></li>
                    <li>
                        <form method="POST" action="/Projeto_PHP_Filmes/index.php?p=logout" style="display: inline;">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="container">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>