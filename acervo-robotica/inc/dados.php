<?php
/**
 * Camada de dados do acervo (pré-código).
 * Aproveitada do MVP: carregar_edicoes(), buscar_edicao(), e(), modo_embed(), base_path(),
 * url_*(), data_br() e o fluxo editorial rascunho -> validado -> publicado.
 * Novidades: catálogo de categorias, resultados por edição, destaques da home, busca.
 * Para migrar para banco de dados ou WordPress, troque apenas carregar_edicoes() e carregar_categorias().
 * Requer PHP 7.4+.
 */
require_once __DIR__ . '/config.php';

const ACERVO_ARQUIVO = __DIR__ . '/../data/edicoes.json';
const ACERVO_ARQUIVO_CATEGORIAS = __DIR__ . '/../data/categorias.json';
const ACERVO_URL_AMIGAVEL = false; // true quando o .htaccess (mod_rewrite) estiver ativo: /2025

/* ---------- Utilitários (do MVP) ---------- */

function e($v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function modo_embed(): bool
{
    return isset($_GET['embed']); // ?embed=1 => sem cabeçalho/rodapé (iframe no site da prefeitura)
}

function base_path(): string
{
    $dir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    return $dir . '/';
}

function data_br(?string $iso): string
{
    $t = $iso ? strtotime($iso) : false;
    return $t ? date('d/m/Y', $t) : '—';
}

/* ---------- URLs ---------- */

function ac_query_embed(string $prefixo = '?'): string
{
    return modo_embed() ? $prefixo . 'embed=1' : '';
}

function url_inicio(): string
{
    return base_path() . ac_query_embed();
}

function url_edicoes(): string
{
    return base_path() . 'edicoes.php' . ac_query_embed();
}

function url_edicao(int $ano): string
{
    if (ACERVO_URL_AMIGAVEL) {
        return base_path() . $ano . ac_query_embed();
    }
    return base_path() . 'edicao.php?ano=' . $ano . ac_query_embed('&');
}

function url_categoria(int $ano, string $slug): string
{
    return base_path() . 'categoria.php?ano=' . $ano . '&categoria=' . rawurlencode($slug) . ac_query_embed('&');
}

function url_busca(): string
{
    return base_path() . 'busca.php';
}

/* ---------- Edições ---------- */

function carregar_edicoes(bool $so_publicadas = true): array
{
    $json = is_readable(ACERVO_ARQUIVO) ? file_get_contents(ACERVO_ARQUIVO) : false;
    $dados = $json ? json_decode($json, true) : null;
    if (!is_array($dados) || !isset($dados['edicoes']) || !is_array($dados['edicoes'])) {
        return [];
    }
    $lista = $dados['edicoes'];
    if ($so_publicadas) {
        $lista = array_values(array_filter($lista, fn($x) => ($x['status'] ?? '') === 'publicado'));
    }
    usort($lista, fn($a, $b) => $a['ano'] <=> $b['ano']);
    return $lista;
}

function buscar_edicao(int $ano): ?array
{
    foreach (carregar_edicoes() as $ed) {
        if ((int) $ed['ano'] === $ano) {
            return $ed;
        }
    }
    return null;
}

/**
 * Total de edições já realizadas, em qualquer status editorial.
 * A home conta as edições cadastradas no seed demonstrativo, inclusive registros não publicados.
 * Todos os valores deste seed são sintéticos.
 */
function total_edicoes(): int
{
    return count(carregar_edicoes(false));
}

function edicao_mais_recente(): ?array
{
    $lista = carregar_edicoes();
    return $lista ? end($lista) : null;
}

/** Edições publicadas, da mais recente para a mais antiga, filtradas por destaque_home. */
function edicoes_da_home(bool $destaque): array
{
    $lista = array_filter(carregar_edicoes(), fn($x) => !empty($x['destaque_home']) === $destaque);
    return array_reverse(array_values($lista));
}

function edicoes_recentes_primeiro(): array
{
    return array_reverse(carregar_edicoes());
}

/** Adiciona "+" quando a contagem demonstrativa estiver marcada como aproximada. */
function ac_numero_estudantes(array $ed): string
{
    return (int) $ed['estudantes'] . (!empty($ed['estudantes_aproximado']) ? '+' : '');
}

/* ---------- Categorias e resultados ---------- */

function carregar_categorias(): array
{
    $json = is_readable(ACERVO_ARQUIVO_CATEGORIAS) ? file_get_contents(ACERVO_ARQUIVO_CATEGORIAS) : false;
    $dados = $json ? json_decode($json, true) : null;
    $mapa = [];
    foreach (($dados['categorias'] ?? []) as $c) {
        $mapa[$c['slug']] = $c;
    }
    return $mapa;
}

function buscar_categoria(string $slug): ?array
{
    return carregar_categorias()[$slug] ?? null;
}

function rotulo_colocacao(string $chave): string
{
    return ACERVO_COLOCACOES[$chave] ?? $chave;
}

/**
 * Resultados de uma edição já combinados com o catálogo de categorias,
 * prontos para o card (modelagem 4.14). Mantém a ordem do JSON.
 */
function resultados_da_edicao(array $ed): array
{
    $cats = carregar_categorias();
    $saida = [];
    foreach ($ed['resultados'] ?? [] as $r) {
        $c = $cats[$r['categoria'] ?? ''] ?? null;
        if (!$c) {
            continue; // categoria desconhecida: ignora em vez de quebrar a página
        }
        $saida[] = [
            'categoria'  => $c,
            'equipe'     => 'Equipe ' . $r['equipe'],
            'item'       => $c['rotulo_item'] . ' ' . $r['projeto'],
            'colocacao'  => $r['colocacao'],
            'rotulo'     => rotulo_colocacao($r['colocacao']),
        ];
    }
    return $saida;
}

/* ---------- Busca simples (sem acento, sem diferença de caixa) ---------- */

function ac_normalizar(string $s): string
{
    // Funciona mesmo quando a extensão mbstring não estiver habilitada no PHP/XAMPP.
    if (function_exists('mb_strtolower')) {
        $s = mb_strtolower($s, 'UTF-8');
    } else {
        $s = strtr($s, [
            'Á'=>'á','À'=>'à','Â'=>'â','Ã'=>'ã','Ä'=>'ä','É'=>'é','È'=>'è','Ê'=>'ê','Ë'=>'ë',
            'Í'=>'í','Ì'=>'ì','Î'=>'î','Ï'=>'ï','Ó'=>'ó','Ò'=>'ò','Ô'=>'ô','Õ'=>'õ','Ö'=>'ö',
            'Ú'=>'ú','Ù'=>'ù','Û'=>'û','Ü'=>'ü','Ç'=>'ç'
        ]);
        $s = strtolower($s);
    }
    return strtr($s, [
        'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
        'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ç' => 'c',
    ]);
}

/**
 * Procura em edições publicadas (tema, resumo, ano), resultados (equipe, projeto, categoria)
 * e projetos em destaque. Retorna uma lista plana de ocorrências.
 * TODO(modelagem): a página de resultados da busca não tem referência visual.
 */
function buscar_no_acervo(string $consulta): array
{
    $q = ac_normalizar(trim($consulta));
    if ($q === '') {
        return [];
    }
    $achou = fn(string ...$campos) => strpos(ac_normalizar(implode(' ', $campos)), $q) !== false;
    $ocorrencias = [];
    foreach (edicoes_recentes_primeiro() as $ed) {
        $ano = (int) $ed['ano'];
        if ($achou((string) $ano, (string) ($ed['tema'] ?? ''), (string) $ed['resumo'], (string) $ed['edicao'])) {
            $ocorrencias[] = ['tipo' => 'Edição', 'titulo' => 'Edição ' . $ano . (empty($ed['tema']) ? '' : ' — ' . $ed['tema']), 'url' => url_edicao($ano)];
        }
        foreach (resultados_da_edicao($ed) as $r) {
            if ($achou($r['categoria']['nome'], $r['equipe'], $r['item'])) {
                $ocorrencias[] = [
                    'tipo'   => 'Resultado',
                    'titulo' => $r['categoria']['nome'] . ' — ' . $r['equipe'] . ', ' . $r['item'] . ' (' . $ano . ')',
                    'url'    => url_categoria($ano, $r['categoria']['slug']),
                ];
            }
        }
        foreach ($ed['projetos'] ?? [] as $p) {
            if ($achou($p['titulo'], $p['equipe'])) {
                $ocorrencias[] = ['tipo' => 'Projeto', 'titulo' => $p['titulo'] . ' — ' . $p['equipe'] . ' (' . $ano . ')', 'url' => url_edicao($ano)];
            }
        }
    }
    return $ocorrencias;
}
