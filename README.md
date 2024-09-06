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
git clone https://github.com/gabrieltva/desafio-effecti.git
cd desafio-effecti
```

### 2. Configuração do Ambiente

Renomeie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente conforme necessário para o seu projeto Laravel.

### 3. Buildar o Ambiente Docker

Para construir os contêineres Docker e iniciar o ambiente de desenvolvimento:

```bash
docker-compose up --build -d
```

Este comando irá construir e iniciar os contêineres especificados no `docker-compose.yml`.

### 4. Rodar os tests

Para executar os testes do Laravel:

```bash
docker-compose run --rm app php artisan test
```

### 5. Acessar a Aplicação

Depois de seguir os passos acima, acesse a aplicação em seu navegador utilizando o endereço local configurado no seu ambiente Docker (http://localhost:8989).