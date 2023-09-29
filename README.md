# task-management
Task Management coding exam using **PHP**, **Laravel 10**, **MySQL**, **Vue.js 3**, **Vue Router**, and **Pinia**, all written in **TypeScript** for **GoTeam** by **Gerard Reyes**

### How to setup and run?
------------
- Clone this repository
- Edit `.env` file and change the DB configuration accordingly.
- Edit `config/sanctum.php` add your localhost and port.
- Migrate database: `php artisan migrate`
- Execute seeder: `php artisan db:seed`
- Install Vue node modules: `npm install`
- Run the Laravel application using Laravel Sail: `./vendor/bin/sail up`
- Run the Vue application: `npm run serve` or `npm run dev`
- Visit site: `http://localhost:8080/home`

### The Stack
------------
- PHP
- Laravel 10
- MySql
- Vue.js 3
- Vue Router
- Pinia
- Typescript

### The API
------------
It uses **Laravel Sanctum** to provides authentication system for **SPAs** (single page application). Sanctum allows each user of your application to generate multiple API tokens for their account. These tokens may be granted abilities / scopes which specify which actions the tokens are allowed to perform.

### Home Page
------------

### About Page
------------

### Registration Page
------------

### Login Page
------------

### Tasks Page - Task List
------------

### Tasks Page - Add Task
------------

### Tasks Page - Edit List
------------

### Tasks Page - Delete List
------------

### Laravel Test
------------
`php artisan test`

### License
------------
Basically, feel free to use and re-use any way you want.
