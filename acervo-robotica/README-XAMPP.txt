ACERVO DA ROBÓTICA — VERSÃO PARA XAMPP
======================================

REQUISITOS
- XAMPP com Apache e PHP 7.4+ (PHP 8.x recomendado).
- Não precisa de Node.js, npm, banco de dados ou build.

INSTALAÇÃO
1. Copie a pasta do projeto para:
   C:\xampp\htdocs\acervo-robotica
2. Abra o XAMPP Control Panel.
3. Inicie apenas o Apache.
4. Se o Apache estiver na porta 80, acesse:
   http://localhost/acervo-robotica/
5. Se o Apache estiver na porta 8080, acesse:
   http://localhost:8080/acervo-robotica/

PÁGINAS PRINCIPAIS
- Home: /index.php
- Edição demonstrativa: /edicao.php?ano=2026
- Edições: /edicoes.php
- Busca: /busca.php

OBSERVAÇÕES
- Todos os números, equipes, projetos, resultados e registros editoriais do protótipo são sintéticos/fictícios.
- Nenhum dado operacional, escolar ou pessoal real foi usado no seed demonstrativo.
- O carrossel funciona sem autoplay, com setas, indicadores e teclado.
- O layout é responsivo e inclui foco visível, skip link e controles de acessibilidade.
- Os assets usados na demonstração estão dentro de assets/img.
- As rotas usam arquivos .php e parâmetros de query; não dependem de mod_rewrite.
