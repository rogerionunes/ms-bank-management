# API de Gestão Bancária

Este projeto é uma API de gestão bancária desenvolvida em Lumen. A API é leve, rápida e configurada para rodar em um ambiente Docker para facilitar a instalação e a execução.

## Índice

- [Pré-requisitos](#pré-requisitos)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Execução](#execução)

## Pré-requisitos

Antes de começar, certifique-se de ter os seguintes softwares instalados:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Instalação

Siga os passos abaixo para instalar e configurar a API:

1. **Clone o repositório:**

    ```bash
    git clone https://github.com/rogerionunes/ms-bank-management.git
    cd ms-bank-management
    ```

2. **Crie o arquivo `.env`:**

    Copie o arquivo `.env.example` para `.env` e ajuste conforme necessário:

    ```bash
    cp .env.example .env
    ```

3. **Inicie os contêineres Docker:**

    Use o Docker Compose para construir e iniciar os contêineres:

    ```bash
    docker-compose up -d --build
    ```

4. **Instale as dependências:**

    Execute o comando abaixo para instalar as dependências PHP usando o Composer:

    ```bash
    docker-compose exec app composer install
    ```

5. **Execute as migrações:**

    Para criar as tabelas no banco de dados:

    ```bash
    docker-compose exec app php artisan migrate
    ```

5. **Faça chamada dos endpoints:**

    Utilize Postman ou outra ferramenta do seu gosto:

    ```bash
    POST /conta -> Cria uma nova conta bancaria
        - numero_conta: 235
        - saldo: 1500

    GET /conta -> Exibe o saldo de uma conta bancaria
        - numero_conta: 235

    POST /transacao -> Gera uma transação em uma conta bancaria
        - numero_conta: 235
        - forma_pagamento: P, C, D (pix, credito ou debito)
        - valor: 100
    ```

## Configuração

- **Variáveis de Ambiente:** Certifique-se de que o arquivo `.env` está configurado corretamente. Veja um exemplo básico de configuração:

    ```env
    APP_NAME=ms-bank-management
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://localhost:8080
    APP_TIMEZONE=America/Sao_Paulo

    LOG_CHANNEL=stack
    LOG_SLACK_WEBHOOK_URL=

    DB_CONNECTION=sqlite
    DB_DATABASE=/var/www/html/storage/database.sqlite

    CACHE_DRIVER=file
    QUEUE_CONNECTION=sync
    ```

- **Banco de Dados:** As migrações devem criar automaticamente as tabelas necessárias. Certifique-se de que a configuração do banco de dados no `.env` corresponde ao serviço do banco de dados definido no `docker-compose.yml`.

## Execução

Para iniciar a aplicação, use o comando:

```bash
docker-compose up -d
