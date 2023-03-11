# testing-laravel-2023

Testing Laravel framework in 2023

-.editorconfig

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
cd blade
touch database/database.sqlite
```

- blade/.env

```edit
APP_NAME="Laravel 2023 Blade"
DB_CONNECTION=sqlite
```

- to-do:
  - [x] Breeze
  - [x] Role
  - [x] AdminAccess
  - [x] Impersonate

## Vue

```bash
composer create-project laravel/laravel vue
cd vue
touch database/database.sqlite
```

- vue/.env

```edit
APP_NAME="Laravel 2023 Vue"
DB_CONNECTION=sqlite
```

- to-do:
  - [x] Breeze
  - [] Breeze
  - [] AdminAccess
  - [] Impersonate

```bash
git add .
git commit -am "Laravel 2023 Vue v0.1.2"
git push
```
