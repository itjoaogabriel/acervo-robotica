<?php
/**
 * Componentes de interface (modelagem seção 4). Cada função devolve HTML pronto.
 * Prefixo ac_ para não colidir com funções do tema WordPress.
 */
require_once __DIR__ . '/dados.php';

/* ---------- Ícones (SVG inline, traço 2px; baseados no conjunto Lucide) ---------- */

function ac_icone(string $nome, string $classe = ''): string
{
    static $svg = [
        'menu'          => '<path d="M4 6h16M4 12h16M4 18h16"/>',
        'busca'         => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
        'seta-esq'      => '<path d="m15 18-6-6 6-6"/>',
        'seta-dir'      => '<path d="m9 18 6-6-6-6"/>',
        'seta-direita'  => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        'calendario'    => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
        'entrar'        => '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="m10 17 5-5-5-5"/><path d="M15 12H3"/>',
        // Figura humana de braços abertos (acesso universal).
        'acessibilidade'=> '<circle cx="12" cy="4.5" r="2"/><path d="M4 8.5h16M12 8.5V14m0 0-3.5 6m3.5-6 3.5 6"/>',
        // TODO(asset): substituir pelo ícone oficial de Libras. Provisório: mão.
        'libras'        => '<path d="M18 11V6a2 2 0 0 0-2-2a2 2 0 0 0-2 2"/><path d="M14 10V4a2 2 0 0 0-2-2a2 2 0 0 0-2 2v2"/><path d="M10 10.5V6a2 2 0 0 0-2-2a2 2 0 0 0-2 2v8"/><path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"/>',
    ];
    $miolo = $svg[$nome] ?? '';
    return '<svg class="acervo-icone ' . e($classe) . '" viewBox="0 0 24 24" width="24" height="24" fill="none" '
        . 'stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'
        . $miolo . '</svg>';
}

/* ---------- Logo ---------- */

/** Usa o asset local da marca; mantém fallback textual se o arquivo não existir. */
function ac_logo(bool $branco = false): string
{
    $candidatos = $branco
        ? ['assets/img/logo-prefeitura-joinville-branco.svg', 'assets/img/logo-prefeitura-joinville-branco.png']
        : ['assets/img/logo-prefeitura-joinville.svg', 'assets/img/logo-prefeitura-joinville.png'];
    foreach ($candidatos as $arquivo) {
        if (is_file(__DIR__ . '/../' . $arquivo)) {
            return '<img class="acervo-logo__img" src="' . e(base_path() . $arquivo) . '" alt="Prefeitura de Joinville">';
        }
    }
    return '<span class="acervo-logo__texto" aria-label="Prefeitura de Joinville">'
        . '<small>Prefeitura de</small><strong>Joinville</strong></span>';
}

/* ---------- Mídia com proporção fixa e selo ---------- */

function ac_selo(string $variante = 'overlay'): string
{
    return '<span class="acervo-selo acervo-selo--' . e($variante) . '">DADO FICTÍCIO</span>';
}

/**
 * Imagem com proporção fixa (ex.: "4 / 1"). Se o arquivo ainda não existir, mostra um
 * espaço reservado com o texto alternativo, mantendo o layout idêntico ao final.
 */
function ac_midia(?array $img, string $proporcao, bool $selo = false, string $classe = ''): string
{
    $img = $img ?: ['src' => '', 'alt' => ''];
    $existe = $img['src'] !== '' && is_file(__DIR__ . '/../' . $img['src']);
    ob_start(); ?>
    <div class="acervo-midia <?= e($classe) ?>" style="--ac-prop: <?= e($proporcao) ?>">
        <?php if ($existe): ?>
            <img src="<?= e(base_path() . $img['src']) ?>" alt="<?= e($img['alt']) ?>" loading="lazy">
        <?php else: ?>
            <div class="acervo-ph" role="img" aria-label="<?= e($img['alt']) ?>"><span aria-hidden="true"><?= e($img['alt']) ?></span></div>
        <?php endif; ?>
        <?= $selo ? ac_selo('overlay') : '' ?>
    </div>
    <?php
    return ob_get_clean();
}

/* ---------- Seções ---------- */

function ac_titulo_secao(string $id, string $titulo, ?string $subtitulo = null): string
{
    return '<h2 id="' . e($id) . '" class="acervo-titulo">' . e($titulo) . '</h2>'
        . ($subtitulo ? '<p class="acervo-desc">' . e($subtitulo) . '</p>' : '');
}

function ac_estatistica(string $numero, string $rotulo): string
{
    return '<div class="acervo-stat"><strong>' . e($numero) . '</strong><span>' . e($rotulo) . '</span></div>';
}

/* ---------- Cards de edição ---------- */

/** Home > "Edições concluídas" (modelagem 4.10). */
function ac_card_edicao_destaque(array $ed): string
{
    $ano = (int) $ed['ano'];
    ob_start(); ?>
    <article class="acervo-card-ed">
        <?= ac_midia($ed['imagens']['capa'] ?? null, '4 / 1', !empty($ed['ficticio'])) ?>
        <div class="acervo-card-ed__corpo">
            <p class="acervo-card-ed__ano"><?= $ano ?></p>
            <h3 class="acervo-card-ed__titulo"><?= e($ed['tema'] ?? $ed['edicao']) ?></h3>
            <?php if (!empty($ed['descricao_card'])): ?>
                <p class="acervo-card-ed__desc"><?= e($ed['descricao_card']) ?></p>
            <?php endif; ?>
            <a class="acervo-link acervo-link--esticado" href="<?= e(url_edicao($ano)) ?>">
                Ver edição <?= ac_icone('seta-direita') ?>
                <span class="acervo-sr"> <?= $ano ?>: <?= e($ed['tema'] ?? '') ?></span>
            </a>
        </div>
    </article>
    <?php
    return ob_get_clean();
}

/** Home > "Outras edições" (modelagem 4.10b). */
function ac_card_edicao_linha(array $ed): string
{
    $ano = (int) $ed['ano'];
    ob_start(); ?>
    <article class="acervo-card-linha">
        <span class="acervo-card-linha__icone"><?= ac_icone('calendario') ?></span>
        <div class="acervo-card-linha__texto">
            <p class="acervo-card-linha__ano"><?= $ano ?></p>
            <h3 class="acervo-card-linha__titulo"><?= e($ed['tema'] ?? $ed['edicao']) ?></h3>
            <?php if (!empty($ed['projetos_total'])): ?>
                <p class="acervo-card-linha__meta"><?= (int) $ed['projetos_total'] ?> projetos demonstrativos</p>
            <?php endif; ?>
        </div>
        <a class="acervo-link acervo-link--esticado acervo-card-linha__acao" href="<?= e(url_edicao($ano)) ?>">
            Acessar <?= ac_icone('seta-direita') ?>
            <span class="acervo-sr"> edição <?= $ano ?></span>
        </a>
    </article>
    <?php
    return ob_get_clean();
}

/* ---------- Resultado por categoria (modelagem 4.14) ---------- */

function ac_card_resultado(array $r, int $ano, bool $ficticio): string
{
    $c = $r['categoria'];
    ob_start(); ?>
    <article class="acervo-card-res">
        <?= ac_midia($c['imagem'] ?? null, '2.1 / 1', $ficticio) ?>
        <div class="acervo-card-res__corpo">
            <h3 class="acervo-card-res__titulo"><?= e($c['nome']) ?></h3>
            <p class="acervo-card-res__linha"><?= e($r['equipe']) ?></p>
            <p class="acervo-card-res__linha"><?= e($r['item']) ?></p>
            <span class="acervo-chip acervo-chip--<?= e($r['colocacao']) ?>"><?= e($r['rotulo']) ?></span>
            <a class="acervo-link acervo-link--esticado" href="<?= e(url_categoria($ano, $c['slug'])) ?>">
                Ver detalhes <?= ac_icone('seta-direita') ?>
                <span class="acervo-sr"> de <?= e($c['nome']) ?></span>
            </a>
        </div>
    </article>
    <?php
    return ob_get_clean();
}

/* ---------- Breadcrumb (modelagem 4.11) ---------- */

/** $itens: lista de [rotulo, href|null]. O último item (href null) é a página atual. */
function ac_breadcrumb(array $itens): string
{
    $partes = [];
    foreach ($itens as [$rotulo, $href]) {
        $partes[] = $href === null
            ? '<li aria-current="page">' . e($rotulo) . '</li>'
            : '<li><a href="' . e($href) . '">' . e($rotulo) . '</a></li>';
    }
    return '<nav class="acervo-migalhas" aria-label="Você está aqui"><ol>' . implode('', $partes) . '</ol></nav>';
}
