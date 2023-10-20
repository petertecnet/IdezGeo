IdezGeo - Desafio Técnico de Desenvolvimento PHP

Este repositório contém a solução para o desafio técnico de desenvolvimento PHP proposto pela Idez. O objetivo do desafio é criar uma aplicação Laravel que consulta e lista os municípios de uma Unidade Federativa (UF) a partir de duas fontes de dados: Brasil API e IBGE.

Requisitos Atendidos:

 Criação de rota para listar municípios de uma UF.
 Integração com as APIs Brasil API e IBGE.
 Uso de Cache para otimizar a performance.
 Tratamento de exceções para garantir robustez.
 Documentação do projeto para facilitar a manutenção futura.
 Configuração do projeto com GitHub Actions para integração contínua.
Bônus Atendidos:

 Paginação dos resultados.
 Criação de Single Page Application (SPA) consumindo o endpoint criado.
 Disponibilização do projeto em ambiente cloud.
 Conteinerização para facilitar a distribuição e escalabilidade.
Decisões de Arquitetura:

O projeto utiliza o framework Laravel e segue princípios de boas práticas, como SOLID e MVP, para garantir código limpo e manutenível. A integração com as APIs é feita através da biblioteca Guzzle.

Como Executar:

Clonar o repositório.
Instalar as dependências com composer install.
Configurar o ambiente e as variáveis de ambiente conforme o arquivo .env.example.
Executar o servidor Laravel com php artisan serve.
Observações:

Para mais detalhes sobre o desafio e a implementação, consulte a documentação no diretório docs.
