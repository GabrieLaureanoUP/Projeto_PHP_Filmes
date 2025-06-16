<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="detalhes-filme">
    <h2><?= htmlspecialchars($filme['titulo']) ?></h2>
    
    <img src="<?= htmlspecialchars($filme['imagem']) ?>" alt="<?= htmlspecialchars($filme['titulo']) ?>">
    
    <div class="info-basica">
        <p class="info-item">
            <strong>Gênero:</strong> <?= htmlspecialchars($filme['genero']) ?>
        </p>
        <p class="info-item">
            <strong>Ano:</strong> <?= htmlspecialchars($filme['ano']) ?>
        </p>
        <p class="info-item">
            <strong>Diretor:</strong> <?= htmlspecialchars($filme['diretor']) ?>
        </p>
        <p class="info-item">
            <strong>Duração:</strong> <?= htmlspecialchars($filme['duracao']) ?> min
        </p>
    </div>

    <div class="descricao-completa">
        <h3>Sinopse</h3>
        <?= nl2br(htmlspecialchars($filme['descricao'])) ?>
    </div>

    <!-- Seção de Avaliação -->
    <div class="avaliacao-section">
        <?php if(isset($media)): ?>
            <div class="media-avaliacoes">
                <h3>Avaliação Média</h3>
                <div class="nota"><?= number_format($media, 1) ?></div>
            </div>
        <?php else: ?>
            <div class="media-avaliacoes">
                <h3>Avaliação Média</h3>
                <div class="nota">Sem avaliações</div>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['usuario'])): ?>
            <!-- Formulário de Avaliação inline -->
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

    <!-- Comentários e Formulário -->
    <div class="comentarios-section">
        <h3>Comentários</h3>
        
        <?php if(isset($_SESSION['usuario'])): ?>
            <!-- Formulário de Comentário inline -->
            <form method="POST" action="index.php?p=salvar_comentario" class="comentario-form">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="filme_id" value="<?= $filme['id'] ?>">
                
                <div class="form-group">
                    <textarea name="texto" placeholder="Escreva seu comentário..." required></textarea>
                </div>
                
                <button type="submit" class="btn btn-comentar">Enviar Comentário</button>
            </form>
        <?php endif; ?>
        
        <!-- Lista de Comentários -->
        <?php
        require_once __DIR__ . '/../../Model/Comentario.php';
        $comentarios = Comentario::listarComentariosPorFilme($filme['id']);
        
        if (!empty($comentarios)): ?>
            <div class="lista-comentarios">
                <?php foreach($comentarios as $comentario): ?>
                    <div class="comentario">
                        <div class="comentario-header">
                            <strong><?= htmlspecialchars($comentario['nome_usuario']) ?></strong>
                            <span class="data"><?= date('d/m/Y', strtotime($comentario['data_comentario'])) ?></span>
                        </div>
                        <p class="comentario-texto"><?= nl2br(htmlspecialchars($comentario['texto'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="sem-comentarios">Ainda não há comentários para este filme.</p>
        <?php endif; ?>
    </div>

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