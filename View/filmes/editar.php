<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="form-container">
    <h2>Editar Filme</h2>
    <form method="POST" action="index.php?p=atualizar">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="id" value="<?= $filme['id'] ?>">

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($filme['titulo']) ?>" required>

        <label for="ano">Ano:</label>
        <input type="text" name="ano" id="ano" required maxlength="4" value="<?= htmlspecialchars($filme['ano']) ?>" required>

        <label for="genero">Gênero:</label>
        <input type="text" name="genero" id="genero" value="<?= htmlspecialchars($filme['genero']) ?>" required>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required style="height:150px; resize:none;"><?= htmlspecialchars($filme['descricao']) ?></textarea>

        <button type="submit" class="btn">Salvar Alterações</button>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>