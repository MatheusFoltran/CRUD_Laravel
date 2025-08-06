# Projeto CRUD Simples

Este é um projeto simples que implementa as funcionalidades básicas de um sistema CRUD (Create, Read, Update, Delete) para gerenciamento de dados, incluindo também um mecanismo de busca para facilitar a localização dos registros.

## Funcionalidades

- **Criação**: Permite adicionar novos registros.
- **Visualização**: Lista e exibe os detalhes dos registros cadastrados.
- **Atualização**: Possibilita editar e modificar os registros existentes.
- **Remoção**: Permite excluir registros do sistema.
- **Busca**: Implementa filtros e pesquisa para facilitar a localização dos registros desejados.

## Tecnologias Utilizadas

- Laravel (PHP Framework)

## Como usar

1. Clone o repositório

2. Instale as dependências com Composer:
   
````
composer install
````

3. Crie o arquivo do banco de dados.

4. Execute as migrações para criar as tabelas:

````
php artisan migrate
````

5. Rode o servidor local:

````
php artisan serve
````
