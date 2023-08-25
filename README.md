<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

- Laravel Framework 10.20.0
- MySQL 8.1.0

## Setup

Necessário docker instalado no ambiente. Após instalar o docker, rodar o comando na linha de comando do projeto

`docker compose up --build -d`

Containers criados, entre no container e rode o comando de criação de migração e seeds.

a) Entrar no container da aplicação

`docker exec -it test_app bash`

b) Rode o comando artisan para criar as migrações e seeds

`php artisan migrate:fresh --seed`

c) Rodar link simbólico para salvar e mapear imagens inseridas

`php artisan storage:link`

Teste unitários

`php artisan test`

Acessar o mysql via container

`docker exec -it test_db bash`

Documentação para brincar no sistema

`www.google.com.br`

### Divirtam-se!

