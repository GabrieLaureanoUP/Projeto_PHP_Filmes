<?php if (isset($_SESSION['usuario'])): ?>

    <form method="POST" action="index.php?p=avaliar&filme_id=<?= $filme['id'] ?>">

        <label for="nota">Avalie o filme (1 a 10):</label>
        <select name="nota" id="nota" required>
            <option value="">Selecione</option>
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <option value="<?= $i ?>" <?= ($nota_atual == $i) ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <button type="submit">Avaliar</button>

    </form>
    <?php endif; ?>