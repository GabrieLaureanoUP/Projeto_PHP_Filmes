<?php include __DIR__ . '/../partials/header.php'; ?>


<div class="detalhes-filme">
    <img src="<?= htmlspecialchars($filme['imagem']) ?>" alt="Capa do filme" style="max-width:100%;height:auto;">
    <h2><?= htmlspecialchars($filme['titulo']) ?></h2>
    <p><strong>Gênero:</strong> <?= htmlspecialchars($filme['genero']) ?></p>
    <p><strong>Ano:</strong> <?= htmlspecialchars($filme['ano']) ?></p>
    <p><strong>Diretor:</strong> <?= htmlspecialchars($filme['diretor']) ?></p>
    <p><strong>Duração:</strong> <?= htmlspecialchars($filme['duracao']) ?> min</p>
    <p><strong>Descrição:</strong></p>
    <div class="descricao-completa">
    <?= nl2br(htmlspecialchars($filme['descricao'])) ?>
    </div>
    <a href="index.php?p=listar" class="btn btn-detalhes">Voltar à lista</a>
</div>

<?php
$filme_id = $filme['id'];
include __DIR__ . '/../filmes/comentar.php';
?>

<?php include __DIR__ . '/../partials/footer.php'; ?>