# Crawler

Passo a passo para execução iniciar o Laravel
- Na pasta do projeto (aonde esta o arquivo docker-compose.yaml) execute: docker-compose up -d
- Depois execute: docker-compose exec php-fpm bash
- Depois entre na pasta do laravel através do comando: cd laravel
- Execute o comando: composer install
- Execute o comando: php artisan migrate
- Execute o comando: php artisan db:seed
- Execute o comando: php artisan crawler:start

Passo a passo para execução iniciar o Angular
- Descompacte o arquivo angular.zip
- Entre na pasta angular
- Execute: npm install -g @angular/cli
- Depois execute o comando: ng serve --open

	
