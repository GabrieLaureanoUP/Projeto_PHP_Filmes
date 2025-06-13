<?php 
include __DIR__ . '/../partials/header.php'; 

$media = Avaliacao::calcularMediaPorFilme($filme_id);
?>

<div class="avaliar-filme">
    <h2>Avaliar Filme</h2>

    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error_message']) ?></div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success_message']) ?></div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <p><strong>Média das avaliações:</strong> 
        <?= $media !== null ? $media : 'Ainda não há avaliações' ?>
    </p>

    <form method="POST" action="index.php?p=avaliar&filme_id=<?= htmlspecialchars($filme_id) ?>">
        <label for="nota">Sua Nota (1 a 10):</label>
        <select name="nota" id="nota" required>
            <option value="">Selecione</option>
            <?php
            for ($i = 1; $i <= 10; $i++) {
                $selected = ($nota_atual == $i) ? 'selected' : '';
                echo "<option value=\"$i\" $selected>$i</option>";
            }
            ?>
        </select>

        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

        <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
    </form>

    <a href="index.php?p=detalhes&id=<?= htmlspecialchars($filme_id) ?>" class="btn btn-secondary">Voltar</a>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>