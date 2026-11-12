<?php
// Espera: $titulo (string), $descricao (string, opcional)
require_once __DIR__ . '/componentes.php';
$base = base_path();
$embed = modo_embed();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo) ?></title>
    <meta name="description" content="<?= e($descricao ?? 'Acervo público com a história do Campeonato Joinvilense de Robótica.') ?>">
    <!-- TODO(asset): hospedar a fonte Roboto em assets/fonts (evita requisição externa). Sem ela, usa a pilha de reserva. -->
    <link rel="stylesheet" href="<?= e($base) ?>assets/style.css">
</head>
<body class="acervo-body<?= $embed ? ' acervo-embed' : '' ?>">
<a class="acervo-skip" href="#conteudo">Pular para o conteúdo</a>
<?php if (!$embed): ?>
<!-- Cabeçalho de referência. No WordPress da prefeitura, use o cabeçalho do tema e mantenha apenas o <main>. -->
<header class="acervo-cabecalho">
    <div class="acervo-container acervo-cabecalho__conteudo">
        <a class="acervo-logo" href="<?= e(url_inicio()) ?>"><?= ac_logo() ?></a>
        <nav class="acervo-cabecalho__nav" aria-label="Principal">
            <button type="button" class="acervo-menu-toggle" aria-label="Menu" aria-expanded="false" aria-controls="acervo-menu">
                <?= ac_icone('menu') ?>
            </button>
            <div class="acervo-cabecalho__links" id="acervo-menu">
                <?php foreach (ACERVO_NAV as $item): ?>
                    <a href="<?= e($item['href']) ?>"><?= e($item['rotulo']) ?></a>
                <?php endforeach; ?>
            </div>
            <button type="button" class="acervo-btn-icone" data-acervo-libras aria-label="Libras" title="Libras">
                <?= ac_icone('libras') ?>
            </button>
            <a class="acervo-btn acervo-btn--primario" href="<?= e(ACERVO_AUTOSSERVICO_HREF) ?>">
                Autosserviço <?= ac_icone('entrar') ?>
            </a>
        </nav>
    </div>
</header>
<?php include __DIR__ . '/acessibilidade.php'; ?>
<?php endif; ?>
