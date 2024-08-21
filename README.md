# Desafio

Desafio API Rest - Carne

## Descrição
Criação de uma API RESTful para Parcelas de Carnê

## Inicializando o Projeto

Para começar a usar, siga estas etapas:

1. Realizar o `git clone` e entrar do diretório recém criado;
2. Criar arquivo .env `cp .env.example .env` e inserir dados de banco de dados
3. Execute `docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs`;
4. Inicie o ambiente de desenvolvimento utilizando o Sail (Docker Compose): `./vendor/bin/sail up -d`;
5. Acesse o terminal dentro do container Laravel Sail: `docker-compose exec laravel.test bash`;
6. Gere a chave de criptografia do Laravel: `php artisan key:generate`;
7. Execute as migrações do banco de dados: `php artisan migrate`;
8. E por fim, Agora pode testar o projeto


## Helpers
1. Rotas
     - **POST:** localhost/api/carne
     - **GET:**  localhost/api/carne/{id}/parcelas
