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

<<<<<<< HEAD
        <?php if(isset($_SESSION['usuario'])): ?>
            <form method="POST" action="index.php?p=salvar_avaliacao" class="avaliacao-form">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="filme_id" value="<?= $filme['id'] ?>">
                
                <div class="rating-container">
                    <h4>Sua Avaliação</h4>
                    <div class="star-rating">
                        <?php for($i = 10; $i >= 1; $i--): ?>
                            <input type="radio" id="star<?= $i ?>" name="nota" value="<?= $i ?>" 
                                <?= (isset($nota_atual) && $nota_atual == $i) ? 'checked' : '' ?>>
                            <label for="star<?= $i ?>"><?= $i ?></label>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-avaliar">Salvar Avaliação</button>
            </form>
        <?php endif; ?>
    </div>

    </div>
    <?php
        $filme_id = $filme['id'];
        include __DIR__ . '/../filmes/comentar.php';
    ?>
    <div class="acoes-filme">
        <a href="index.php?p=listar" class="btn btn-voltar">Voltar à lista</a>
        
        <?php if(isset($_SESSION['usuario'])): ?>
            <a href="index.php?p=editar&id=<?= $filme['id'] ?>" class="btn btn-editar">Editar</a>
            
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
=======
    <p><strong>Total de avaliações:</strong> 
        <?= $totalAvaliacoes > 0 ? $totalAvaliacoes : 'Nenhuma avaliação ainda' ?>
>>>>>>> b84a8710e877aac9d0a929206f91b0680f794de0
