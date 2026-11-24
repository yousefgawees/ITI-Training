# ITI Training Tasks

Daily tasks and projects from my one-month ITI training.

| Folder | Content |
|---|---|
| `01-html-css/` | HTML and CSS tasks 1 and 2 (registration page, roadmap, home) |
| `02-javascript/` | JavaScript tasks 1 to 4 (task 4 is a calculator) |
| `03-laravel/posts-crud/` | Laravel posts CRUD app |
| `04-mini-websites/` | Shop website and a second small website |
| `docs/` | Day 2, Task 3 and MySQL Day 3 documents |

## Laravel app
```
cd 03-laravel/posts-crud
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate && php artisan serve
```
