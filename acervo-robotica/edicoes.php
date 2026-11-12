<?php
// Lista de edições (alvo do breadcrumb "Edições"). TODO(modelagem): sem referência visual; usa os cards de linha.
require __DIR__ . '/inc/dados.php';

$edicoes   = edicoes_recentes_primeiro();
$titulo    = 'Edições | ' . ACERVO_NOME;
$descricao = 'Todas as edições publicadas do Campeonato Joinvilense de Robótica.';
include __DIR__ . '/inc/cabecalho.php';

if (!modo_embed()) {
    $hero_titulo    = ACERVO_NOME;
    $hero_subtitulo = 'Memória, projetos e resultados de cada edição';
    $hero_h1        = false;
    include __DIR__ . '/inc/hero.php';
}
?>
<main id="conteudo" class="acervo-container">
    <?= ac_breadcrumb([['Início', ACERVO_PORTAL_URL], ['Robótica', url_inicio()], ['Edições', null]]) ?>
    <section aria-labelledby="t-edicoes" class="acervo-secao">
        <h1 id="t-edicoes" class="acervo-titulo">Edições</h1>
        <?php if (!$edicoes): ?>
            <p class="acervo-vazio">Nenhuma edição publicada até o momento.</p>
        <?php else: ?>
            <div class="acervo-grade acervo-grade--2">
                <?php foreach ($edicoes as $ed): ?><?= ac_card_edicao_linha($ed) ?><?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php include __DIR__ . '/inc/rodape.php'; ?>
