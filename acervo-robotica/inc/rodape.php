<?php if (!modo_embed()): ?>
<footer class="acervo-rodape">
    <div class="acervo-container acervo-rodape__conteudo">
        <a class="acervo-logo acervo-logo--branco" href="<?= e(url_inicio()) ?>"><?= ac_logo(true) ?></a>
        <nav class="acervo-rodape__nav" aria-label="Rodapé">
            <?php foreach (ACERVO_RODAPE_NAV as $item): ?>
                <a href="<?= e($item['href']) ?>"><?= e($item['rotulo']) ?></a>
            <?php endforeach; ?>
        </nav>
        <p class="acervo-rodape__texto"><?= e(ACERVO_RODAPE_TEXTO) ?></p>
    </div>
</footer>
<?php endif; ?>
<script src="<?= e(base_path()) ?>assets/script.js" defer></script>
</body>
</html>
