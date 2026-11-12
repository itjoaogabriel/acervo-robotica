/* Interações do acervo (pré-código): carrossel, menu móvel, menu de acessibilidade e Libras.
   O pop-up da linha do tempo do MVP não é usado aqui (a modelagem não prevê linha do tempo). */
(() => {
  'use strict';

  /* ---------- Carrossel (modelagem 4.9): sem autoplay, circular, setas do teclado ---------- */
  document.querySelectorAll('[data-acervo-carrossel]').forEach(raiz => {
    const slides = Array.from(raiz.querySelectorAll('.acervo-carrossel__slide'));
    const pontos = Array.from(raiz.querySelectorAll('[data-ponto]'));
    if (slides.length < 2) return;
    let atual = Math.max(0, slides.findIndex(s => s.classList.contains('is-ativo')));

    function ir(i) {
      atual = (i + slides.length) % slides.length;
      slides.forEach((s, n) => s.classList.toggle('is-ativo', n === atual));
      pontos.forEach((p, n) => {
        if (n === atual) p.setAttribute('aria-current', 'true'); else p.removeAttribute('aria-current');
      });
    }

    raiz.querySelector('[data-carrossel="ant"]').addEventListener('click', () => ir(atual - 1));
    raiz.querySelector('[data-carrossel="prox"]').addEventListener('click', () => ir(atual + 1));
    pontos.forEach(p => p.addEventListener('click', () => ir(Number(p.dataset.ponto))));
    raiz.addEventListener('keydown', e => {
      if (e.key === 'ArrowLeft') { ir(atual - 1); e.preventDefault(); }
      if (e.key === 'ArrowRight') { ir(atual + 1); e.preventDefault(); }
    });
  });

  /* ---------- Menu móvel do cabeçalho (modelagem 8) ---------- */
  const toggle = document.querySelector('.acervo-menu-toggle');
  const links = document.getElementById('acervo-menu');
  if (toggle && links) {
    toggle.addEventListener('click', () => {
      const aberto = links.classList.toggle('is-aberto');
      toggle.setAttribute('aria-expanded', String(aberto));
    });
  }

  /* ---------- Menu de acessibilidade (modelagem 4.3 / 9) ---------- */
  const botao = document.getElementById('acervo-a11y-botao');
  const painel = document.getElementById('acervo-a11y-painel');
  if (botao && painel) {
    const CHAVE = 'acervo-a11y';
    const PADRAO = { tamanho: 100, contraste: false };
    const lerEstado = () => {
      try { return Object.assign({}, PADRAO, JSON.parse(localStorage.getItem(CHAVE)) || {}); } catch (_) { return Object.assign({}, PADRAO); }
    };
    const gravarEstado = s => { try { localStorage.setItem(CHAVE, JSON.stringify(s)); } catch (_) { /* sem armazenamento: segue sem salvar */ } };
    let estado = lerEstado();

    function aplicar() {
      document.documentElement.style.fontSize = estado.tamanho + '%';
      document.body.classList.toggle('acervo-alto-contraste', estado.contraste);
      const c = painel.querySelector('[data-a11y="contraste"]');
      if (c) c.setAttribute('aria-pressed', String(estado.contraste));
      gravarEstado(estado);
    }

    function abrirPainel(abrir) {
      painel.hidden = !abrir;
      botao.setAttribute('aria-expanded', String(abrir));
    }

    botao.addEventListener('click', () => abrirPainel(painel.hidden));
    painel.addEventListener('click', e => {
      const acao = e.target.closest('[data-a11y]');
      if (!acao) return;
      const tipo = acao.dataset.a11y;
      if (tipo === 'fonte-mais') estado.tamanho = Math.min(150, estado.tamanho + 10);
      if (tipo === 'fonte-menos') estado.tamanho = Math.max(80, estado.tamanho - 10);
      if (tipo === 'contraste') estado.contraste = !estado.contraste;
      if (tipo === 'restaurar') estado = Object.assign({}, PADRAO);
      aplicar();
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && !painel.hidden) { abrirPainel(false); botao.focus(); }
    });
    aplicar();
  }

  /* ---------- Libras (placeholder; modelagem 9) ----------
     Se o widget VLibras estiver na página, repassa o clique ao botão dele. */
  document.querySelectorAll('[data-acervo-libras]').forEach(b => {
    b.addEventListener('click', () => {
      const vl = document.querySelector('[vw-access-button]');
      if (vl) vl.click();
      document.dispatchEvent(new CustomEvent('acervo:libras'));
    });
  });
})();
