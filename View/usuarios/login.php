<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IMDB de Livros</title>
    <link rel="stylesheet" href="/Projeto_PHP_Filmes/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="auth-form">
            <h2>Login</h2>
            <form method="POST" action="">
                <input type="text" name="usuario" placeholder="Usuário">
                <input type="password" name="senha" placeholder="Senha">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit" value="login">Entrar</button>
            </form>
            
            <div class="auth-links">
                <a href="recuperar-senha">Esqueceu sua senha?</a>
            </div>
        </div>
    </div>
</body>
</html>