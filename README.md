# testing-laravel-2023

Testing Laravel framework in 2023

## Blade

## Vue

```bash
composer create-project laravel/laravel vue
cd vue
touch database/database.sqlite
```

### vue/.env

```edit
APP_NAME="Laravel 2023 Vue"
DB_CONNECTION=sqlite
```

```bash
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate:fresh
npm install && npm run dev
php artisan serve
```

```bash
git add .
git commit -am "Laravel 2023 Vue v0.1"
git push
```
