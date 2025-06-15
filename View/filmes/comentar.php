<?php 
include __DIR__ . '/../partials/header.php'; 
?>
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
    require_once __DIR__ . "/../Config/BancoPdo.php";
    $sql = "SELECT usuario, comentario, data FROM comentarios WHERE filme_id = :filme_id ORDER BY data DESC";
    $stmt = Database::conectar()->prepare($sql);
    $stmt->execute(['filme_id' => $filme_id]);
    $comentarios = $stmt->fetchAll();
    
    if($comentarios){
    foreach ($comentarios as $comentario) {
        echo "<div class='comentario'>";
        echo "<strong>" . htmlspecialchars($comentario['usuario']) . "</strong>: " . htmlspecialchars($comentario['comentario']);
        echo "<br><small>" . date("d/m/Y H:i", strtotime($comentario['data'])) . "</small>";
        echo "</div>";
    }}else{
        echo "<strong>Nenhum comentário feito!</strong>";
    }
?>


<?php include __DIR__ . '/../partials/footer.php'; ?>