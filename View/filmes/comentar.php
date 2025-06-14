<form method="POST" action="index.php?p=comentar&filme_id=<?= htmlspecialchars($filme_id) ?>">
    <input type="hidden" name="filme_id" value="<?php echo $filme_id; ?>">
    <input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>">
    
    <label for="comentario">Comentário:</label>
    <textarea name="comentario" required></textarea>
    
    <button type="submit">Enviar Comentário</button>
</form>