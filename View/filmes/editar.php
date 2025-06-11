<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="form-container">
    <h2>Editar Filme</h2>
    <form method="POST" action="index.php?p=atualizar">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="id" value="<?= $filme['id'] ?>">

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($filme['titulo']) ?>" required>

        <label for="ano">Ano:</label>
        <input type="text" name="ano" id="ano" value="<?= htmlspecialchars($filme['ano']) ?>" required maxlength="4">

        <label for="genero">Gênero:</label>
        <input type="text" name="genero" id="genero" value="<?= htmlspecialchars($filme['genero']) ?>" required>

        <label for="imagem">URL da Imagem:</label>
        <input type="text" name="imagem" id="imagem" value="<?= htmlspecialchars($filme['imagem']) ?>">

        <label for="diretor">Diretor:</label>
        <input type="text" name="diretor" id="diretor" value="<?= htmlspecialchars($filme['diretor']) ?>">

        <label for="duracao">Duração (minutos):</label>
        <input type="number" name="duracao" id="duracao" value="<?= htmlspecialchars($filme['duracao']) ?>" min="1">

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required style="height:150px; resize:none;"><?= htmlspecialchars($filme['descricao']) ?></textarea>

        <button type="submit" class="btn">Salvar Alterações</button>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>