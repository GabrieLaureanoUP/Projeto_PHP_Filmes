<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="filmes-container">
    <!-- Formulário de busca -->
    <form method="GET" action="index.php?p=buscar" class="search-form">
        <input type="text" name="termo" placeholder="Buscar por título ou gênero..." value="<?= isset($_GET['termo']) ? htmlspecialchars($_GET['termo']) : '' ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php if(isset($_SESSION['usuario'])): ?>
        <div class="actions">
            <a href="index.php?p=criar" class="btn-criar">Adicionar Novo Filme</a>
        </div>
    <?php endif; ?>

    <div class="filmes-grid">
        <?php foreach($filmes as $filme): ?>
            <div class="filme-item">
                <h3><?= htmlspecialchars($filme['titulo']) ?></h3>
                <p class="genero">Gênero: <?= htmlspecialchars($filme['genero']) ?></p>
                <p class="ano">Ano: <?= htmlspecialchars($filme['ano']) ?></p>
                <p class="descricao"><?= htmlspecialchars($filme['descricao']) ?></p>
                
                <?php if(isset($_SESSION['usuario'])): ?>
                    <div class="filme-acoes">
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
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>