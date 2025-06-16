
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
    require_once __DIR__ . "/../../Config/BancoPdo.php";
    $sql = "SELECT usuario_id, comentario FROM comentarios WHERE filme_id = :filme_id";
    $stmt = Database::conectar()->prepare($sql);
    $stmt->execute(['filme_id' => $filme_id, 'usuario_id' => $usuario_id]);
    $comentarios = $stmt->fetchAll();

    $sqlNome = "SELECT nome FROM usuarios WHERE usuario_id = :usuario_id";
    $stmt = Database::conectar()->prepare($sql);
    $stmt->execute(['nome' => $nomeUsuario]);
    $usuario = $stmt->fetchAll();
    
    
    if($comentarios){
    foreach ($comentarios as $comentario) {
        echo "<div class='comentario'>";
        $sqlNome = "SELECT nome FROM usuarios WHERE usuario_id = :usuario_id";
        $stmtNome = Database::conectar()->prepare($sqlNome);
        $stmtNome->execute(['usuario_id' => $comentario['usuario_id']]);
        $usuario = $stmtNome->fetch();
        $nomeUsuario = $usuario ? htmlspecialchars($usuario['nome']) : 'Usuário desconhecido';
        echo "<strong>" . $nomeUsuario . "</strong>: " . htmlspecialchars($comentario['comentario']);
        echo "</div>";
    }
    } else {
        echo "<strong>Nenhum comentário feito!</strong>";
    }
?>
