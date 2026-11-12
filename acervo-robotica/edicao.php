<?php
// Página B — Edição (modelagem 7.2)
require __DIR__ . '/inc/dados.php';

$ano = filter_input(INPUT_GET, 'ano', FILTER_VALIDATE_INT);
$ed  = $ano ? buscar_edicao($ano) : null;

if (!$ed) {
    http_response_code(404);
    $titulo = 'Edição não encontrada | ' . ACERVO_NOME;
    include __DIR__ . '/inc/cabecalho.php';
    echo '<main id="conteudo" class="acervo-container"><section class="acervo-secao"><h1 class="acervo-titulo">Edição não encontrada</h1>'
       . '<p>Esta edição não existe ou ainda não foi publicada.</p><p><a href="' . e(url_inicio()) . '">Voltar ao início</a></p></section></main>';
    include __DIR__ . '/inc/rodape.php';
    exit;
}

$ficticio   = !empty($ed['ficticio']);
$resultados = resultados_da_edicao($ed);
$galeria    = $ed['galeria'] ?? [];
$memoria    = array_merge(ACERVO_MEMORIA_PADRAO, $ed['memoria'] ?? []);
$imagemMem  = $ed['imagens']['destaque'] ?? ($ed['imagens']['capa'] ?? null);

$titulo    = 'Edição ' . (int) $ed['ano'] . (empty($ed['tema']) ? '' : ' — ' . $ed['tema']) . ' | ' . ACERVO_NOME;
$descricao = $ed['resumo'];
include __DIR__ . '/inc/cabecalho.php';

if (!modo_embed()) {
    $hero_titulo    = ACERVO_NOME;
    $hero_subtitulo = 'Edição ' . (int) $ed['ano'] . ($ficticio ? ' • página demonstrativa' : '');
    $hero_h1        = false;
    include __DIR__ . '/inc/hero.php';
}
?>
<main id="conteudo" class="acervo-container">
    <?= ac_breadcrumb([
        ['Início',  ACERVO_PORTAL_URL],
        ['Robótica', url_inicio()],
        ['Edições', url_edicoes()],
        [(string) (int) $ed['ano'], null],
    ]) ?>

    <header class="acervo-edicao-cab">
        <h1 class="acervo-edicao-cab__h1">Edição <?= (int) $ed['ano'] ?></h1>
        <?= $ficticio ? ac_selo('solid') : '' ?>
        <?php if (!empty($ed['tema'])): ?><h2 class="acervo-edicao-cab__tema"><?= e($ed['tema']) ?></h2><?php endif; ?>
        <?php if (!empty($ed['introducao'])): ?><p class="acervo-desc"><?= e($ed['introducao']) ?></p><?php endif; ?>
    </header>

    <section class="acervo-memoria" aria-labelledby="t-memoria">
        <?= ac_midia($imagemMem, '3 / 1', false, 'acervo-midia--memoria') ?>
        <div class="acervo-memoria__texto">
            <p class="acervo-memoria__eyebrow"><?= e($ed['edicao']) ?></p>
            <h2 id="t-memoria" class="acervo-memoria__titulo"><?= e($memoria['titulo']) ?></h2>
            <p><?= e($memoria['texto']) ?></p>
            <p class="acervo-memoria__rotulo"><?= e($memoria['rotulo']) ?></p>
        </div>
    </section>

    <section aria-labelledby="t-resultados" class="acervo-secao">
        <?= ac_titulo_secao('t-resultados', 'Resultados por categoria', 'Exemplo de como vencedores e projetos podem ser consultados por edição.') ?>
        <?php if (!$resultados): ?>
            <!-- TODO(modelagem): estado vazio das edições sem resultados no seed. -->
            <p class="acervo-vazio">Resultados em breve.</p>
        <?php else: ?>
            <div class="acervo-grade acervo-grade--4">
                <?php foreach ($resultados as $r): ?><?= ac_card_resultado($r, (int) $ed['ano'], $ficticio) ?><?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <?php if ($galeria): ?>
    <section aria-labelledby="t-galeria" class="acervo-secao">
        <?= ac_titulo_secao('t-galeria', 'Galeria da edição') ?>
        <div class="acervo-grade acervo-grade--4 acervo-galeria">
            <?php foreach ($galeria as $img): ?><?= ac_midia($img, '2 / 1') ?><?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (ACERVO_MOSTRAR_PROCEDENCIA): ?>
    <section class="acervo-secao acervo-fonte" aria-labelledby="t-fonte">
        <h2 id="t-fonte" class="acervo-titulo">Procedência das informações</h2>
        <dl>
            <dt>Situação</dt><dd>Publicado</dd>
            <dt>Fonte</dt><dd><?= e($ed['fonte']['origem'] ?? '—') ?></dd>
            <dt>Validado por</dt><dd><?= e($ed['fonte']['validado_por'] ?? '—') ?>, em <?= e(data_br($ed['fonte']['validado_em'] ?? null)) ?></dd>
        </dl>
        <?php if (!empty($ed['historico_correcoes'])): ?>
            <h3>Correções registradas</h3>
            <ul>
                <?php foreach ($ed['historico_correcoes'] as $c): ?>
                <li><?= e(data_br($c['data'] ?? null)) ?> — <?= e($c['descricao'] ?? '') ?> <em>(<?= e($c['por'] ?? '') ?>)</em></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/inc/rodape.php'; ?>
