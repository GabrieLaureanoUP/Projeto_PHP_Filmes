<?php include __DIR__ . '/../partials/header.php'; ?>
<link rel="stylesheet" href="assets/css/styleComentarios.css">
<div class="editar-comentario-container">
    <h2 class="titulo-editar-comentario">Editar Comentário</h2>
    <form method="POST" action="index.php?p=atualizarComentario">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="id" value="<?= htmlspecialchars($comentario_id ?? '') ?>">
        <input type="hidden" name="filme_id" value="<?= htmlspecialchars($filme_id ?? '') ?>">
        <label for="comentario" class="label-editar-comentario">Comentário:</label>
        <textarea name="novoComentario" id="comentario" rows="5" required class="textarea-editar-comentario"><?= htmlspecialchars($comentario['comentario'] ?? $comentario_texto ?? '') ?></textarea>
        <button type="submit" class="btn-editar-comentario">Salvar Alteração</button>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
