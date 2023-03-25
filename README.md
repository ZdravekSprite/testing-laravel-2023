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
cd vue && php artisan migrate:fresh --seed
```

```bash
cd vue && npm install && npm run dev
```

```bash
cd vue && php artisan serve
```

- to-do:
  - [x] [Breeze](vue00.md)
  - [x] [Role](vue01.md)
  - [x] [AdminAccess](vue02.md)
  - [x] [Users](vue03.md)
  - [x] [Impersonate](vue04.md)
  - [x] [Components](vue05.md)
    - [ ] [AddForm](vue06.md)
    - [x] [EditForm](vue07.md)
    - [x] [DeleteForm](vue08.md)

```bash
git add . && git commit -am "Laravel 2023 Vue v0.6.3" && git push
```
