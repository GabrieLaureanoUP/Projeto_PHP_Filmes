<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="detalhes-filme">
    <h2><?= htmlspecialchars($filme['titulo']) ?></h2>
    <p><strong>Gênero:</strong> <?= htmlspecialchars($filme['genero']) ?></p>
    <p><strong>Ano:</strong> <?= htmlspecialchars($filme['ano']) ?></p>
    <p><strong>Descrição completa:</strong></p>
    <div class="descricao-completa">
        <?= nl2br(htmlspecialchars($filme['descricao'])) ?>
    </div>
    <a href="index.php?p=listar" class="btn">Voltar à lista</a>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>