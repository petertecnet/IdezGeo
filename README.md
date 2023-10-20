# IdezGeo

Este projeto foi desenvolvido como parte do desafio técnico proposto pela Idez. A aplicação consiste em uma API backend em Laravel que permite a busca e listagem de municípios de um determinado estado (UF).

## Funcionalidades

- Rota para pesquisa e listagem de municípios por UF.
- Resposta inclui uma lista de municípios com nome e código IBGE.
- Suporte aos provedores de dados Brasil API e IBGE.
- Cache para otimização de performance.
- Tratamento de exceções para melhor experiência do usuário.

## Tecnologias Utilizadas

- PHP
- Laravel
- Banco de dados relacional (PostgreSQL)
- Padrões de programação (SOLID, MVP)
- Testes unitários e de integração
- REST API
- Projeto seguindo a metodologia SCRUM

## Como Executar o Projeto

1. Clone o repositório.
2. Instale as dependências com `composer install`.
3. Configure as variáveis de ambiente no arquivo `.env`.
4. Execute as migrações com `php artisan migrate`.
5. Inicie o servidor local com `php artisan serve`.

## Autor

- Pedro

## Data

- 02/10/2023

## Versão do Projeto

- 1.0.0