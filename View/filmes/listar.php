<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="filmes-container">
    <form method="GET" action="index.php">
        <input type="hidden" name="p" value="buscarNomeGenero">
        <input type="text" name="termo" placeholder="Buscar por título ou gênero..." value="<?= isset($_GET['termo']) ? htmlspecialchars($_GET['termo']) : '' ?>">
        <button type="submit">Buscar</button>
    </form>

    <div class="filmes-grid">
        <?php foreach($filmes as $filme): ?>
            <div class="filme-item">
                <img src="<?= htmlspecialchars($filme['imagem']) ?>" alt="Capa do filme" style="max-width:100%;height:auto;">
                <h3><?= htmlspecialchars($filme['titulo']) ?></h3>
                <p class="genero"><strong>Gênero:</strong> <?= htmlspecialchars($filme['genero']) ?></p>
                <p class="ano"><strong>Ano:</strong> <?= htmlspecialchars($filme['ano']) ?></p>
                <p class="diretor"><strong>Diretor:</strong> <?= htmlspecialchars($filme['diretor']) ?></p>
                <p class="duracao"><strong>Duração:</strong> <?= htmlspecialchars($filme['duracao']) ?> min</p>
                <?php $descricao_resumida = mb_strimwidth($filme['descricao'], 0, 100, '...');?>
                <p class="descricao"><?= htmlspecialchars($descricao_resumida) ?></p>

                <div class="filme-acoes">
                    <form method="GET" action="index.php">
                        <input type="hidden" name="p" value="detalhes">
                        <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                        <button type="submit" class="btn-detalhes">Detalhes</button>
                    </form>

                    <?php if(isset($_SESSION['usuario'])): ?>
                        <form method="POST" action="index.php?p=editar" class="edit-form">
                            <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button type="submit" class="btn-editar">Editar</button>
                        </form>
                        <form method="POST" action="index.php?p=excluir" class="delete-form" onsubmit="return confirm('Tem certeza que deseja excluir este filme?');">
                            <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>