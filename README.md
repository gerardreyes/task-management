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
<img width="1482" alt="image" src="https://github.com/gerardreyes/task-management/assets/13266410/b0aa7d35-d22b-40c0-86c9-4d7bfcdbc7a4">

### About Page
------------
<img width="1482" alt="image" src="https://github.com/gerardreyes/task-management/assets/13266410/66681bfb-41d6-4901-8633-751d92bba305">

### Registration Page
------------
<img width="1482" alt="image" src="https://github.com/gerardreyes/task-management/assets/13266410/46a224cf-bdd7-4243-bf94-cda6117b1f86">
<img width="1482" alt="image" src="https://github.com/gerardreyes/task-management/assets/13266410/fede7c5d-58e8-4d0b-85d0-ebfa67a8efd7">

### Login Page
------------
<img width="1482" alt="image" src="https://github.com/gerardreyes/task-management/assets/13266410/762293e8-cf0f-4ebd-a2a2-116b1a37377b">

### Tasks Page - Task List
------------
<img width="1506" alt="image" src="https://github.com/gerardreyes/task-management/assets/13266410/89198ae0-b233-4946-988e-724e62428fc0">

### Tasks Page - Add Task
------------
<img width="1506" alt="image" src="https://github.com/gerardreyes/task-management/assets/13266410/a21dab0f-7a6b-459d-a852-f13a2fde5f70">

### Tasks Page - Edit List - Can only edit Tasks you created
------------
<img width="1506" alt="image" src="https://github.com/gerardreyes/task-management/assets/13266410/6ae4d3a0-c9ba-4509-adbe-d64f82b02480">

### Tasks Page - Delete List - Can only delete Tasks you created
------------
<img width="1506" alt="image" src="https://github.com/gerardreyes/task-management/assets/13266410/13e5fff8-9850-45eb-acb5-059cc4342c27">

### Laravel Test
------------
`php artisan test`
<img width="376" alt="image" src="https://github.com/gerardreyes/task-management/assets/13266410/cafd9024-de75-4c16-9ea6-cdf9406c84d4">

### License
------------
Basically, feel free to use and re-use any way you want.
