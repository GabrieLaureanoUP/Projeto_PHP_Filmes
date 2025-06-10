<?php include __DIR__ . '/../partials/header.php'; ?>


<div class="container">
    <div class="auth-form">
        <h2>Recuperar Senha</h2>
            
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="cpf" placeholder="CPF (somente números)" required pattern="\d{11}">
            <input type="date" name="data_nascimento" required>
            <input type="password" name="nova_senha" placeholder="Nova senha (mínimo 6 caracteres)" required>
            <input type="password" name="confirmar_senha" placeholder="Confirme sua nova senha" required>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit">Redefinir Senha</button>
        </form>
            <div class="auth-links">
            <a href="/Projeto_PHP_Filmes/index.php?p=login">Voltar para o Login</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
