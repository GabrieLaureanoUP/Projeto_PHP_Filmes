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
        <nav>
            <a href="index.php?p=listar">Home</a>
            <?php if(!isset($_SESSION['usuario'])): ?>
                <a href="index.php?p=login">Login</a>
                <a href="index.php?p=cadastro">Cadastrar</a>
            <?php else: ?>
                <a href="index.php?p=criar">Adicionar filme</a>
                <a href="index.php?p=listar">Logout</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="container">
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
        </div>
        <?php unset($_SESSION['success_message']);
    endif; ?>