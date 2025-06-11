<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="form-container">
    <h2>Adicionar Novo Filme</h2>
    <form method="POST" action="index.php?p=salvar">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required>

        <label for="ano">Ano:</label>
        <input type="text" name="ano" id="ano" required maxlength="4" required>

        <label for="genero">Gênero:</label>
        <input type="text" name="genero" id="genero" required>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required style="height:150px; resize:none;"></textarea>

        <button type="submit" class="btn">Salvar</button>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>