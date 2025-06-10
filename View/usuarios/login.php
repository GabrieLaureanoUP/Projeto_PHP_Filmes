<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <div class="auth-form">            
        <h2>Login</h2>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit" value="login">Entrar</button>
        </form>
        <div class="auth-links">    
            <a href="/Projeto_PHP_Filmes/index.php?p=recuperar-senha">Esqueceu sua senha?</a>
            <a href="/Projeto_PHP_Filmes/index.php?p=cadastro">Criar uma conta</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>