<?php include __DIR__ . '/partials/header.php'; ?>

<div class="home-container">
    <!-- Seção de Boas-vindas -->
    <section class="welcome-section">
        <h1>Bem-vindo ao Catálogo de Filmes</h1>
        <p class="intro-text">
            Explore nossa coleção de filmes, compartilhe suas opiniões e descubra novas histórias.
            <?php if(!isset($_SESSION['usuario'])): ?>
                <a href="index.php?p=cadastro">Cadastre-se</a> para avaliar e comentar!
            <?php endif; ?>
        </p>
    </section>

    <!-- Estatísticas -->
    <section class="stats-section">
        <h2>Estatísticas da Plataforma</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total de Filmes</h3>
                <p class="stat-number"><?= $estatisticas['total_filmes'] ?></p>
            </div>
            <div class="stat-card">
                <h3>Gêneros Populares</h3>
                <ul class="generos-list">
                    <?php foreach($estatisticas['generos_populares'] as $genero): ?>
                        <li><?= htmlspecialchars($genero['genero']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- Filmes Populares -->
    <section class="popular-section">
        <h2>Filmes Populares</h2>
        <div class="filmes-grid">
            <?php foreach($filmesPopulares as $filme): ?>
                <div class="filme-card">
                    <img src="<?= htmlspecialchars($filme['imagem']) ?>" alt="<?= htmlspecialchars($filme['titulo']) ?>">
                    <div class="filme-info">
                        <h3><?= htmlspecialchars($filme['titulo']) ?></h3>
                        <p class="genero"><?= htmlspecialchars($filme['genero']) ?></p>
                        <div class="stats">
                            <span><?= $filme['total_comentarios'] ?> comentários</span>
                            <span>Nota: <?= number_format($filme['media_avaliacoes'], 1) ?></span>
                        </div>
                        <a href="index.php?p=detalhes&id=<?= $filme['id'] ?>" class="btn-detalhes">Ver Detalhes</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="cta-section">
        <a href="index.php?p=listar" class="btn-primary">Ver Todos os Filmes</a>
    </section>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>