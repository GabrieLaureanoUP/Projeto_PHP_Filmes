<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - IMDB de Livros</title>
    <link rel="stylesheet" href="/Projeto_PHP_Filmes/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="auth-form">
            <h2>Cadastro de Usuário</h2>
            <form method="POST" action="">
                <input type="text" name="nome" placeholder="Nome completo" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="cpf" placeholder="CPF (somente números)" required pattern="\d{11}">
                <input type="date" name="data_nascimento" required>
                <input type="password" name="senha" placeholder="Senha (mínimo 6 caracteres)" required>
                <input type="password" name="confirmar_senha" placeholder="Confirme sua senha" required>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit">Cadastrar</button>
            </form>
            
            <div class="auth-links">
                <a href="/Projeto_PHP_Filmes/index.php?p=login">Já possui conta? Faça login</a>
            </div>
        </div>
    </div>
</body>
</html>
