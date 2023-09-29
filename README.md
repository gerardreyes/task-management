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

### The Task:
------------
1. Build a Task Management web application. - Done
2. Build it using Laravel version 10. - Done
3. Use Laravel Sail for your local development setup. - Done
4. Use Laravel Sanctum for your API authentication system. - Done
5. Create the necessary API Resource and resource routes in the api.php file. - Done
6. Implement proper Form Request Validation to make sure that each http request is valid. - Done
7. Each API route must have a corresponding HTTP Test. - Done
8. Implement Event Broadcasting to produce a real-time user experience using Pusher Pusher as your driver. - Done
9. For your Frontend Implementation, you are expected to create a Single Page Application (SPA) using Vue 3, Vue Router, and Pinia, all written in TypeScript. - Done
10. Secure your SPA with the proper middleware with Laravel Sanctum as your authentication system. - Done
11. Implement Websocket on task management page with the task details seamlessly updating when a change is made. - Done
12. Finally, deploy your application on Heruko or any Cloud Platform. - Not Done. I do not have a paid account for Heruko or any Cloud Platform.
13. A task should have a title, description, due date, and status. - Done
14. Create the UI in kanban form where the user can sort the tasks and drag them from TODO to IN-PROGRESS to DONE columns. - I was not able to do this due to time constraint. What I did for this project is a CRUD variation for Task Management. No idea yet on what plugin will help me achieve the UI style to look like a Kanban Board where you can drag and drop but the Update Task is connecting properly to the update endpoint in Laravel. So, it is just a matter of re-using it.
15. A user should be able to edit, update and delete a task they have created. - Done

### Laravel Test
------------
`php artisan test`
<br>
<img width="376" alt="image" src="https://github.com/gerardreyes/task-management/assets/13266410/cafd9024-de75-4c16-9ea6-cdf9406c84d4">

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

### License
------------
Basically, feel free to use and re-use any way you want.
