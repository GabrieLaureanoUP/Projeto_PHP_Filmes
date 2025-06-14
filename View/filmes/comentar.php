<form action="processa_comentario.php" method="POST">
    <input type="hidden" name="filme_id" value="<?php echo $filme_id; ?>">
    <label for="usuario">Nome:</label>
    <input type="text" name="usuario" required>
    
    <label for="comentario">Comentário:</label>
    <textarea name="comentario" required></textarea>
    
    <button type="submit">Enviar Comentário</button>
</form>