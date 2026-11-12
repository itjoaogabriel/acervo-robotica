<?php
/**
 * Configuração e textos fixos do site (fonte de verdade: modelagem-campeonato-robotica.md).
 * Textos entre aspas na modelagem são literais: não altere sem atualizar a modelagem.
 */

const ACERVO_NOME = 'Campeonato Joinvilense de Robótica';

// Mostra a seção "Procedência das informações" (herdada do MVP) no fim da página da edição.
// A modelagem não a prevê na tela de referência, por isso começa desligada.
const ACERVO_MOSTRAR_PROCEDENCIA = false;

// Destino do "Início" no breadcrumb e dos links do portal. TODO(modelagem): definir URLs reais.
const ACERVO_PORTAL_URL = '#';

// Navegação do cabeçalho (ordem fixa, modelagem 4.2). TODO(modelagem): destinos reais.
const ACERVO_NAV = [
    ['rotulo' => 'Serviços',      'href' => '#'],
    ['rotulo' => 'Notícias',      'href' => '#'],
    ['rotulo' => 'Transparência', 'href' => '#'],
];
const ACERVO_AUTOSSERVICO_HREF = '#';

// Navegação e texto do rodapé (modelagem 4.16).
const ACERVO_RODAPE_NAV = [
    ['rotulo' => 'Joinville Fácil', 'href' => '#'],
    ['rotulo' => 'Educação',        'href' => '#'],
    ['rotulo' => 'Notícias',        'href' => '#'],
    ['rotulo' => 'Transparência',   'href' => '#'],
];
const ACERVO_RODAPE_TEXTO = 'Protótipo acadêmico · informações e resultados demonstrativos';

// Rótulos de classificação (modelagem 5.3).
const ACERVO_COLOCACOES = [
    'primeiro' => '1º lugar',
    'segundo'  => '2º lugar',
    'terceiro' => '3º lugar',
    'destaque' => 'Destaque',
];

// Bloco "Memória do evento" (modelagem 4.13). Uma edição pode sobrescrever com a chave "memoria".
const ACERVO_MEMORIA_PADRAO = [
    'titulo' => 'Memória do evento',
    'texto'  => 'Um acervo público organizado para preservar projetos, resultados e histórias ao longo dos anos.',
    'rotulo' => 'Conteúdo demonstrativo',
];

// Carrossel da home (modelagem 4.9 / 6.3). Apenas o slide 1 é conhecido; 2 a 4 são provisórios.
// TODO(asset): substituir os slides 2 a 4 por fotos reais do evento e ajustar os textos alternativos.
const ACERVO_CARROSSEL = [
    ['src' => 'assets/img/carrossel-1.jpg', 'alt' => 'Robô de peças brancas e cinza com rodas pretas sobre a mesa de competição, com estudantes de camiseta azul ao fundo.'],
    ['src' => 'assets/img/carrossel-2.jpg', 'alt' => 'Robô de competição em primeiro plano, com estudantes de camiseta azul ao fundo.'],
    ['src' => 'assets/img/carrossel-3.jpg', 'alt' => 'Robô baixo de competição em uma mesa de prova.'],
    ['src' => 'assets/img/carrossel-4.jpg', 'alt' => 'Robô diante de obstáculo em uma arena de competição.'],
];
