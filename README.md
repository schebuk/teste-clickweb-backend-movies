Um catálogo de filmes moderno que consome dados da API MoviesDatabase via RapidAPI, com paginação e design responsivo.

📋 Pré-requisitos
PHP 7.4 ou superior

Composer

Laragon, XAMPP, WAMP ou ambiente PHP similar

Conta no RapidAPI com acesso à MoviesDatabase API

🚀 Instalação
1. Clone o projeto
```bash
git clone [url-do-repositorio]
cd nome-do-projeto
```
2. Instale as dependências
```bash
composer install
```
3. Configure o ambiente
Copie o arquivo .env.example para .env:

```bash
cp .env.example .env
```
4. Configure a chave da API
No arquivo .env, adicione sua chave da RapidAPI:

```env
MOVIES_API_KEY=sua-chave-da-rapidapi-aqui
```
5. Gere a chave do Laravel
```bash
php artisan key:generate
```
6. Configure o cache (opcional)
```bash
php artisan config:cache
```
🔑 Obtenha sua Chave da API
Acesse RapidAPI - MoviesDatabase

Cadastre-se ou faça login

Inscreva-se no plano básico (gratuito)

Copie sua chave API do painel

Cole no arquivo .env

🏃‍♂️ Executando a Aplicação
Com Laragon:
Coloque a pasta do projeto em C:\laragon\www\

Inicie o Laragon

O projeto estará disponível em: http://nome-do-projeto.test

Com PHP Built-in Server:
```bash
php artisan serve
```
Acesse: http://localhost:8000

Com outros servidores:
Configure o document root para a pasta public/

Certifique-se que o mod_rewrite está habilitado

📁 Estrutura do Projeto
```text
app/
├── Http/
│   └── Controllers/
│       └── MovieController.php
├── Services/
│   └── MoviesApiService.php
resources/
├── views/
│   └── movies/
│       └── index.blade.php
routes/
└── web.php
```
🔧 Solução de Problemas
Erro de Certificado SSL (Windows/Laragon)
Se encontrar erro de certificado SSL, o serviço já está configurado com 'verify' => false.

API não retorna dados
Verifique se a chave da API está correta no .env

Confirme se sua conta RapidAPI tem créditos disponíveis

Teste a API diretamente:

```bash
php artisan tinker
>>> $service = new App\Services\MoviesApiService();
>>> $service->getMovies(1, 12);
```
Paginação não funciona
A API tem um bug onde retorna entries: 1, mas o sistema está configurado para mostrar ~200 filmes com paginação de 25 por página.

Imagens não carregam
Alguns filmes podem não ter imagens. O sistema exibe um placeholder nesses casos.

⚙️ Personalização
Alterar número de filmes por página
Edite MovieController.php:

```php
$limit = 25; // Altere este valor
```
Mudar lista de filmes
Edite MoviesApiService.php:

```php
'list' => 'top_boxoffice_200', // Pode ser 'most_pop_movies', 'top_rated_250', etc.
```
Modificar o design
Edite resources/views/movies/index.blade.php

📊 Listas Disponíveis na API
most_pop_movies - Filmes mais populares

most_pop_series - Séries mais populares

top_boxoffice_200 - Top 200 bilheterias

top_rated_250 - Top 250 melhores avaliados

top_rated_series_250 - Top 250 séries

titles - Todos os títulos

🔍 Testes
Para testar a conexão com a API:

```bash
php artisan tinker
>>> (new App\Services\MoviesApiService())->getMovies(1, 5);
```
📝 Notas
A API tem limite de requisições (100/dia no plano gratuito)

Cache é implementado por 1 hora para otimizar performance

O sistema usa fallback para dados mock se a API falhar

Design responsivo com Bootstrap 5

🛠 Tecnologias Utilizadas
Laravel 8/9/10

Bootstrap 5

GuzzleHTTP

MoviesDatabase API

📄 Licença
Este projeto é para fins educacionais.

🤝 Contribuindo
Faça um Fork do projeto

Crie uma branch para sua feature

Commit suas mudanças

Push para a branch

Abra um Pull Request

Desenvolvido com ❤️ usando Laravel e MoviesDatabase API