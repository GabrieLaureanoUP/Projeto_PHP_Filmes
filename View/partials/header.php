<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imdb De Livros</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <header>
        <div class="logo">IMDB<span>LIVROS</span></div>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <?php if(isset($_SESSION['usuario_id'])): ?>
                
                <form action="logout" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <button type="submit" class="btn btn-logout">Sair</button>
                </form>
            <?php else: ?>
                
                <a href="login" class="btn btn-login">Entrar</a>
            <?php endif; ?>
        </div>
    </header>
    
    <div class="container">
        