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

    <p><strong>Média das avaliações:</strong> 
        <?= $media !== null ? $media : 'Ainda não há avaliações' ?>
    </p>

    <?php
        include __DIR__ . '/avaliar.php';
    ?>

    <?php
        $filme_id = $filme['id'];
        include __DIR__ . '/../filmes/comentar.php';
    ?>
    </div>

    </div>

    <div class="acoes-filme">
        <a href="index.php?p=listar" class="btn btn-voltar">Voltar à lista</a>
        
        <?php if(isset($_SESSION['usuario'])): ?>
            <form method="POST" action="index.php?p=editar">
                <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <button type="submit" class="btn btn-editar">Editar</button>
            </form>         

            <form method="POST" action="index.php?p=excluir" class="delete-form" 
                  onsubmit="return confirm('Tem certeza que deseja excluir este filme?');">
                <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <button type="submit" class="btn btn-excluir">Excluir</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
