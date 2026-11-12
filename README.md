# Memória da Robótica

Protótipo acadêmico desenvolvido para o Hackathon ADS — Histórico Público do Campeonato Joinvilense de Robótica.

## Objetivo

Criar um espaço público estruturado para organizar e preservar a memória das diferentes edições do campeonato, permitindo consultar edições, projetos, resultados e galerias em uma experiência visual compatível com o portal da Prefeitura.

## Tecnologias

- PHP
- HTML5
- CSS3
- JavaScript
- Apache
- XAMPP

## Como executar

1. Instale o XAMPP.
2. Copie a pasta `acervo-robotica` para:

   `C:\xampp\htdocs\`

3. Inicie o Apache pelo painel do XAMPP.

4. Acesse:

   `http://localhost:8080/acervo-robotica/`

> A porta pode variar conforme a configuração local do Apache.

## Dados do protótipo

Todos os nomes, números, equipes, projetos, resultados e demais informações apresentadas no MVP são fictícios e utilizados exclusivamente para demonstração.

O projeto não utiliza dados pessoais reais de estudantes, equipes ou escolas.

## Funcionalidades demonstradas

- Página inicial do acervo
- Navegação entre edições
- Carrossel de imagens
- Busca no acervo
- Página individual de edição
- Resultados organizados por categoria
- Galeria de imagens
- Navegação responsiva
- Recursos de acessibilidade previstos na interface

## Arquitetura do MVP

O protótipo utiliza PHP para composição das páginas, HTML/CSS para apresentação e JavaScript para interações no navegador.

Nesta etapa não foi utilizado banco de dados.

A estrutura foi mantida simples para facilitar a demonstração, manutenção e futura adaptação para uma infraestrutura institucional.

## Integração futura

Uma evolução do projeto poderá consumir:

- edições fornecidas pelo domínio de gestão do evento;
- categorias e resultados provenientes da gestão das competições;
- conteúdos previamente autorizados e validados para publicação.

A fonte oficial dos dados deverá permanecer sob responsabilidade institucional.

## Limitações

- MVP acadêmico
- Dados exclusivamente fictícios
- Sem integração com sistemas oficiais
- Sem autenticação
- Sem banco de dados
- Não representa um sistema oficial da Prefeitura de Joinville

## Próximos passos

- integração com fonte de dados oficial e validada;
- definição do fluxo editorial de publicação;
- histórico completo das edições;
- homologação institucional;
- revisão de acessibilidade;
- testes automatizados;
- adaptação ao ambiente tecnológico utilizado pela Prefeitura.

## Uso de Inteligência Artificial

Ferramentas de inteligência artificial foram utilizadas como apoio durante pesquisa, documentação, refinamento de interface e desenvolvimento do MVP.

As decisões técnicas, revisão e validação da entrega são de responsabilidade da equipe.

## Arquitetura e continuidade

O MVP foi desenvolvido em PHP, HTML, CSS e JavaScript e executado
localmente em Apache/XAMPP.

Essa escolha reduz a complexidade da demonstração e permite validar
a experiência do usuário antes de introduzir persistência ou integrações
institucionais.

Em uma eventual implantação, a proposta é aproveitar o ambiente
WordPress já existente no portal, estruturando cada edição como conteúdo
gerenciável e relacionando categorias, resultados e galeria.

Não é objetivo deste MVP criar um banco de dados paralelo nem substituir
sistemas responsáveis pela gestão do evento ou pelos resultados das
competições.

O fluxo previsto é:

Fonte institucional → validação/curadoria → publicação → consulta pública.

## Aviso

Este é um protótipo acadêmico desenvolvido para fins de demonstração no Hackathon ADS e não constitui uma aplicação oficial da Prefeitura de Joinville.
