# testing-laravel-2023

Testing Laravel framework in 2023

- .editorconfig

```ts
[*]
charset = utf-8
end_of_line = crlf
indent_size = 2
indent_style = space
insert_final_newline = true
trim_trailing_whitespace = true

[*.md]
trim_trailing_whitespace = false
```

## Blade

```bash
composer create-project laravel/laravel blade
touch blade/database/database.sqlite
```

- blade/.env

```edit
APP_NAME="Laravel 2023 Blade"
DB_CONNECTION=sqlite
```

```bash
cd blade
php artisan migrate:fresh --seed
npm install && npm run dev
php artisan serve
```

- to-do:
  - [x] [Breeze](blade00.md)
  - [x] Role
  - [x] AdminAccess
  - [x] Impersonate

## Vue

```bash
composer create-project laravel/laravel vue
touch vue/database/database.sqlite
```

- vue/.env

```edit
APP_NAME="Laravel 2023 Vue"
DB_CONNECTION=sqlite
```

```bash
cd vue && php artisan migrate:fresh --seed &&  cd ..
```

```bash
cd vue && npm install && npm run dev
```

```bash
cd vue && php artisan serve
```

- to-do:
  - [x] [Breeze](vue00.md)
  - [x] [Components](vue05.md)
    - [x] [NewForm](vue06.md)
    - [x] [EditForm](vue07.md)
    - [x] [DeleteForm](vue08.md)
    - [x] [Search](vue09.md)
    - [x] [Export](vue10.md)
    - [ ] [Import](vue11.md)
    - [ ] [Pagination](vue12.md)
  - [x] [Role](vue01.md)
  - [x] [AdminAccess](vue02.md)
  - [x] [Users](vue03.md)
  - [x] [Impersonate](vue04.md)
  - [ ] [Upgrade](vue13.md)
  - [x] [Type](vue14.md)
  - [x] [Warehouse](vue15.md)
  - [x] [Owner](vue16.md)
  - [x] [Device](vue17.md)
  - [x] [Config](vue18.md)
  - [ ] [Partner](vue19.md)

```bash
git add . && git commit -am "Laravel 2023 Vue v0.8.10" && git push
```

## Inertia

```bash
composer create-project laravel/laravel inertia
cd inertia
touch database/database.sqlite
composer require laravel/breeze --dev
php artisan breeze:install --dark
```

- inertia/.env

```edit
APP_NAME="Laravel 2023 Inertia"
DB_CONNECTION=sqlite
```

```bash
cd inertia && php artisan migrate:fresh --seed &&  cd ..
```

```bash
cd inertia && npm install && npm run dev
```

```bash
cd inertia && php artisan serve
```

```bash
git add . && git commit -am "Laravel 2023 Inertia v0.2.0" && git push
```

## Binance

```bash
composer create-project laravel/laravel binance
touch binance/database/database.sqlite
```

- binance/.env

```edit
APP_NAME="Laravel 2023 Binance"
DB_CONNECTION=sqlite
API_KEY=API_KEY
API_SECRET=API_SECRET
```

```bash
cd binance
php artisan migrate:fresh --seed
php artisan serve
```

## Breeze

```bash
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate:fresh
npm install && npm run dev
php artisan serve
```

## Binance model

```bash
php artisan make:model Binance -a
```

## Coin model

```bash
php artisan make:model Coin -a
```

## Network model

```bash
php artisan make:model Network -a
```

```bash
git add . && git commit -am "Laravel 2023 Binance v0.2.4" && git push
```
