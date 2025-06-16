<link rel="stylesheet" href="assets/css/styleComentarios.css">
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
require_once __DIR__ . '/../../Model/Comentario.php';
$comentarios = ComentarioController::listarComentarios($filme_id);
$usuario_logado = $_SESSION['usuario']['id'] ?? null;
if (!empty($comentarios) && is_array($comentarios)): ?>
    <div class="lista-comentarios">
        <?php foreach($comentarios as $comentario): ?>
            <div class="comentario">
                <div class="comentario-header">
                    <strong><?= htmlspecialchars($comentario['nome_usuario']) ?></strong>
                    <span class="data"><?= date('d/m/Y', strtotime($comentario['data_comentario'])) ?></span>
                </div>
                <p class="comentario-texto"><?= nl2br(htmlspecialchars($comentario['texto'])) ?></p>
                <?php if ($usuario_logado && $usuario_logado == $comentario['usuario_id']): ?>
                <div class="comentario-botoes">
                    <form method="POST" action="index.php?p=editarComentario&id=<?= htmlspecialchars($comentario['id']) ?>" style="display:inline;">
                        <input type="hidden" name="comentario_id" value="<?= $comentario['id'] ?>">
                        <input type="hidden" name="filme_id" value="<?= $filme_id ?>">
                        <button type="submit">Editar</button>
                    </form>
                    <form method="POST" action="index.php?p=excluirComentario" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este comentário?');">
                        <input type="hidden" name="comentario_id" value="<?= $comentario['id'] ?>">
                        <input type="hidden" name="filme_id" value="<?= $filme_id ?>">
                        <button type="submit">Excluir</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="sem-comentarios">Ainda não há comentários para este filme.</p>
<?php endif; ?>

