
<form method="POST" action="index.php?p=comentar&filme_id=<?= htmlspecialchars($filme_id) ?>">

    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error_message']) ?></div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success_message']) ?></div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <label for="comentario">Comentário:</label>
    <textarea name="comentario" required></textarea>
    
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    <button type="submit">Enviar Comentário</button>
</form>
<?php
    header("Location: index.php?p=listarComentarios&id={$filme_id}");
?>

