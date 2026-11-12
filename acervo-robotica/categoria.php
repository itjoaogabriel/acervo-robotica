<?php
// Detalhe da categoria (alvo de "Ver detalhes →"). TODO(modelagem): sem referência visual; versão mínima.
require __DIR__ . '/inc/dados.php';

$ano  = filter_input(INPUT_GET, 'ano', FILTER_VALIDATE_INT);
$slug = (string) filter_input(INPUT_GET, 'categoria', FILTER_UNSAFE_RAW);
$ed   = $ano ? buscar_edicao($ano) : null;
$res  = null;
if ($ed) {
    foreach (resultados_da_edicao($ed) as $r) {
        if ($r['categoria']['slug'] === $slug) { $res = $r; break; }
    }
}

if (!$ed || !$res) {
    http_response_code(404);
    $titulo = 'Categoria não encontrada | ' . ACERVO_NOME;
    include __DIR__ . '/inc/cabecalho.php';
    echo '<main id="conteudo" class="acervo-container"><section class="acervo-secao"><h1 class="acervo-titulo">Categoria não encontrada</h1>'
       . '<p><a href="' . e(url_inicio()) . '">Voltar ao início</a></p></section></main>';
    include __DIR__ . '/inc/rodape.php';
    exit;
}

$c         = $res['categoria'];
$titulo    = $c['nome'] . ' — Edição ' . (int) $ed['ano'] . ' | ' . ACERVO_NOME;
$descricao = $c['nome'] . ': ' . $res['equipe'] . ', ' . $res['item'] . '.';
include __DIR__ . '/inc/cabecalho.php';

if (!modo_embed()) {
    $hero_titulo    = ACERVO_NOME;
    $hero_subtitulo = 'Edição ' . (int) $ed['ano'] . (!empty($ed['ficticio']) ? ' • página demonstrativa' : '');
    $hero_h1        = false;
    include __DIR__ . '/inc/hero.php';
}
?>
<main id="conteudo" class="acervo-container">
    <?= ac_breadcrumb([
        ['Início', ACERVO_PORTAL_URL], ['Robótica', url_inicio()], ['Edições', url_edicoes()],
        [(string) (int) $ed['ano'], url_edicao((int) $ed['ano'])], [$c['nome'], null],
    ]) ?>
    <section class="acervo-secao">
        <h1 class="acervo-titulo"><?= e($c['nome']) ?></h1>
        <?= !empty($ed['ficticio']) ? ac_selo('solid') : '' ?>
        <div class="acervo-grade acervo-grade--4" style="margin-top:16px">
            <?= ac_card_resultado($res, (int) $ed['ano'], !empty($ed['ficticio'])) ?>
        </div>
    </section>
</main>
<?php include __DIR__ . '/inc/rodape.php'; ?>
