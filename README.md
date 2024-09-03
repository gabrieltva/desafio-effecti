# Desafio Effecti

Este projeto Laravel/Vue foi criado para o teste do processo seletivo para Desenvolvedor FullStack PHP na empresa Effecti.

## Requisitos

Certifique-se de ter o Docker e o Docker Compose instalados em sua máquina.

- Docker: [Instalação do Docker](https://docs.docker.com/get-docker/)
- Docker Compose: [Instalação do Docker Compose](https://docs.docker.com/compose/install/)

## Instruções

### 1. Clonar o Repositório

Clone o repositório do GitHub para o seu ambiente local:

```bash
git clone https://github.com/gabrieltva/desafio-plan.git
cd desafio-plan
```

### 2. Configuração do Ambiente

Renomeie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente conforme necessário para o seu projeto Laravel.

### 3. Buildar o Ambiente Docker

Para construir os contêineres Docker e iniciar o ambiente de desenvolvimento:

```bash
docker-compose up --build -d
```

Este comando irá construir e iniciar os contêineres especificados no `docker-compose.yml`.

### 4. Instalar as Dependências do Composer

Para instalar as dependências PHP do Laravel utilizando o Composer:

```bash
docker-compose run --rm app composer install
```

### 5. Buildar o Vite

Execute o comando para baixar os pacotes e buildar o front-end:

```bash
docker-compose run --rm app npm install
docker-compose run --rm app npm run build
```

### 6. Ajustar Permissões

Para ajustar as permissões dos diretórios necessários, execute os seguintes comandos:

```bash
docker-compose run --rm app chown -R www-data:www-data /var/www/storage
docker-compose run --rm app chown -R www-data:www-data /var/www/bootstrap/cache
```

### 6. Migrar e Popular o Banco de Dados

Após executar os testes, migre e popule o banco de dados conforme necessário, e gere a key do .env com os comandos a seguir:

```bash
docker-compose run --rm app php artisan migrate
docker-compose run --rm app php artisan key:generate
```

Estes comandos executam as migrações pendentes do banco de dados e adicionará uma key ao .env.

### 7. Acessar a Aplicação

Depois de seguir os passos acima, acesse a aplicação em seu navegador utilizando o endereço local configurado no seu ambiente Docker (http://localhost:8989).