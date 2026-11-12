<?php
// Resultados da busca no acervo. TODO(modelagem): sem referência visual; lista simples.
require __DIR__ . '/inc/dados.php';

$q           = trim((string) filter_input(INPUT_GET, 'q', FILTER_UNSAFE_RAW));
$ocorrencias = buscar_no_acervo($q);

$titulo = ($q !== '' ? 'Busca: ' . $q : 'Busca') . ' | ' . ACERVO_NOME;
include __DIR__ . '/inc/cabecalho.php';

if (!modo_embed()) {
    $hero_titulo    = ACERVO_NOME;
    $hero_subtitulo = 'Memória, projetos e resultados de cada edição';
    $hero_h1        = false;
    $hero_busca     = $q;
    include __DIR__ . '/inc/hero.php';
}
?>
<main id="conteudo" class="acervo-container">
    <section aria-labelledby="t-busca" class="acervo-secao">
        <h1 id="t-busca" class="acervo-titulo">Resultados da busca</h1>
        <?php if ($q === ''): ?>
            <p class="acervo-desc">Digite um termo para buscar por edição, equipe, projeto ou categoria.</p>
        <?php elseif (!$ocorrencias): ?>
            <p class="acervo-vazio">Nenhum resultado para “<?= e($q) ?>”.</p>
        <?php else: ?>
            <p class="acervo-desc"><?= count($ocorrencias) ?> resultado(s) para “<?= e($q) ?>”.</p>
            <ul class="acervo-resultados-busca">
                <?php foreach ($ocorrencias as $o): ?>
                <li><span class="acervo-chip"><?= e($o['tipo']) ?></span> <a href="<?= e($o['url']) ?>"><?= e($o['titulo']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
</main>
<?php include __DIR__ . '/inc/rodape.php'; ?>
