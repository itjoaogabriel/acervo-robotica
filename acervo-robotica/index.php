<?php
// Página A — Home do campeonato (modelagem 7.1)
require __DIR__ . '/inc/dados.php';

$ultima      = edicao_mais_recente();
$concluidas  = edicoes_da_home(true);
$outras      = edicoes_da_home(false);
$slides      = ACERVO_CARROSSEL;

$titulo    = 'Histórico Público | ' . ACERVO_NOME;
$descricao = 'Memória, projetos e resultados de cada edição do Campeonato Joinvilense de Robótica.';
include __DIR__ . '/inc/cabecalho.php';

if (!modo_embed()) {
    $hero_titulo    = ACERVO_NOME;
    $hero_subtitulo = 'Memória, projetos e resultados de cada edição';
    $hero_h1        = true;
    include __DIR__ . '/inc/hero.php';
}
?>
<main id="conteudo" class="acervo-container">

    <section aria-labelledby="t-historia" class="acervo-secao">
        <?= ac_titulo_secao('t-historia', 'História do campeonato', 'Explore as edições concluídas e conheça projetos, temas e resultados publicados no acervo.') ?>

        <?php if ($ultima): ?>
        <div class="acervo-stats">
            <?= ac_estatistica((string) total_edicoes(), 'edições') ?>
            <?= ac_estatistica((string) (int) $ultima['equipes'], 'equipes em ' . (int) $ultima['ano']) ?>
            <?= ac_estatistica((string) (int) $ultima['escolas'], 'escolas em ' . (int) $ultima['ano']) ?>
            <?= ac_estatistica(ac_numero_estudantes($ultima), 'estudantes em ' . (int) $ultima['ano']) ?>
        </div>
        <?php endif; ?>

        <div class="acervo-carrossel" data-acervo-carrossel role="region" aria-roledescription="carrossel" aria-label="Destaques do campeonato">
            <div class="acervo-carrossel__palco">
                <?php foreach ($slides as $i => $s): ?>
                <div class="acervo-carrossel__slide<?= $i === 0 ? ' is-ativo' : '' ?>" role="group" aria-roledescription="slide"
                     aria-label="Slide <?= $i + 1 ?> de <?= count($slides) ?>">
                    <?= ac_midia($s, '7 / 1', false, 'acervo-midia--carrossel') ?>
                </div>
                <?php endforeach; ?>
                <button type="button" class="acervo-carrossel__nav acervo-carrossel__nav--ant" data-carrossel="ant" aria-label="Slide anterior"><?= ac_icone('seta-esq') ?></button>
                <button type="button" class="acervo-carrossel__nav acervo-carrossel__nav--prox" data-carrossel="prox" aria-label="Próximo slide"><?= ac_icone('seta-dir') ?></button>
            </div>
            <div class="acervo-carrossel__pontos">
                <?php foreach ($slides as $i => $s): ?>
                    <button type="button" data-ponto="<?= $i ?>" aria-label="Ir para o slide <?= $i + 1 ?>"<?= $i === 0 ? ' aria-current="true"' : '' ?>></button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section aria-labelledby="t-concluidas" class="acervo-secao">
        <?= ac_titulo_secao('t-concluidas', 'Edições concluídas', 'Selecione um ano para abrir a página da edição.') ?>
        <?php if (!$concluidas): ?>
            <p class="acervo-vazio">Nenhuma edição publicada até o momento.</p>
        <?php else: ?>
        <div class="acervo-grade acervo-grade--2">
            <?php foreach ($concluidas as $ed): ?><?= ac_card_edicao_destaque($ed) ?><?php endforeach; ?>
        </div>
        <?php endif; ?>
    </section>

    <?php if ($outras): ?>
    <section aria-labelledby="t-outras" class="acervo-secao">
        <?= ac_titulo_secao('t-outras', 'Outras edições') ?>
        <div class="acervo-grade acervo-grade--2">
            <?php foreach ($outras as $ed): ?><?= ac_card_edicao_linha($ed) ?><?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

</main>
<?php include __DIR__ . '/inc/rodape.php'; ?>
