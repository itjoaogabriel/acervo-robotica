<?php
/**
 * Hero com busca (modelagem 4.4 e 4.5).
 * Espera: $hero_titulo, $hero_subtitulo, $hero_h1 (bool: true na home, onde o título é o <h1>),
 *         $hero_busca (valor atual do campo, opcional).
 */
$hero_busca = $hero_busca ?? '';
?>
<section class="acervo-hero" aria-label="Busca no acervo">
    <div class="acervo-container acervo-hero__conteudo">
        <?php if (!empty($hero_h1)): ?>
            <h1 class="acervo-hero__titulo"><?= e($hero_titulo) ?></h1>
        <?php else: ?>
            <p class="acervo-hero__titulo"><?= e($hero_titulo) ?></p>
        <?php endif; ?>
        <p class="acervo-hero__subtitulo"><?= e($hero_subtitulo) ?></p>
        <form class="acervo-busca" role="search" action="<?= e(url_busca()) ?>" method="get">
            <label class="acervo-sr" for="acervo-busca-q">Buscar no acervo</label>
            <input id="acervo-busca-q" type="search" name="q" value="<?= e($hero_busca) ?>" placeholder="Buscar no acervo" autocomplete="off">
            <?php if (modo_embed()): ?><input type="hidden" name="embed" value="1"><?php endif; ?>
            <button type="submit" aria-label="Buscar"><?= ac_icone('busca') ?></button>
        </form>
    </div>
</section>
