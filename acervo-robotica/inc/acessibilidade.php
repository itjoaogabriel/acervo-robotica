<?php
/**
 * Botões flutuantes fixos à direita (modelagem 4.3).
 * 1) Menu de acessibilidade: painel com fonte maior/menor e alto contraste (o CSS .acervo-alto-contraste
 *    já existia no MVP, mas nenhum botão o ativava). Preferência salva em localStorage.
 * 2) Libras: placeholder. TODO(modelagem): integrar o VLibras (widget do governo federal):
 *      <div vw class="enabled"><div vw-access-button class="active"></div>
 *        <div vw-plugin-wrapper><div class="vw-plugin-top-wrapper"></div></div></div>
 *      <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
 *      <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>
 *    Enquanto isso, o script.js dispara o clique em [vw-access-button] se o widget existir.
 */
?>
<aside class="acervo-flutuante" aria-label="Recursos de acessibilidade">
    <button type="button" class="acervo-flutuante__a11y" id="acervo-a11y-botao"
            aria-label="Menu de acessibilidade" aria-expanded="false" aria-controls="acervo-a11y-painel">
        <?= ac_icone('acessibilidade') ?>
    </button>
    <button type="button" class="acervo-flutuante__libras" data-acervo-libras aria-label="Libras" title="Libras">
        <?= ac_icone('libras') ?>
    </button>
    <div id="acervo-a11y-painel" class="acervo-a11y-painel" role="group" aria-label="Opções de acessibilidade" hidden>
        <button type="button" data-a11y="fonte-mais">A+ <span class="acervo-sr">Aumentar fonte</span></button>
        <button type="button" data-a11y="fonte-menos">A- <span class="acervo-sr">Diminuir fonte</span></button>
        <button type="button" data-a11y="contraste" aria-pressed="false">Alto contraste</button>
        <button type="button" data-a11y="restaurar">Restaurar</button>
    </div>
</aside>
