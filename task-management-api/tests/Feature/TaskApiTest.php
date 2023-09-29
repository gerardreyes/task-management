<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    protected mixed $user;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user with Sanctum authentication and store it in the $user property
        $this->user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
    }

    public function test_create_task_with_authentication(): void
    {
        Sanctum::actingAs($this->user);

        // Send a POST request to create a task
        $response = $this->postJson('/api/tasks', [
            'title' => 'New Task TODO',
            'description' => 'Description for the new task',
            'due_date' => Carbon::now()->addDays(7)->toDateTimeString(),
            'status' => 'TODO',
            'user_id' => $this->user->id, // Associate the task with the user
        ]);
        $response->assertStatus(201); // Assert that the task was created successfully
        $this->assertDatabaseHas('tasks', ['title' => 'New Task TODO']);

        // Send a POST request to create a task
        $response = $this->postJson('/api/tasks', [
            'title' => 'New Task IN-PROGRESS',
            'description' => 'Description for the new task',
            'due_date' => Carbon::now()->addDays(7)->toDateTimeString(),
            'status' => 'IN-PROGRESS',
            'user_id' => $this->user->id, // Associate the task with the user
        ]);
        $response->assertStatus(201); // Assert that the task was created successfully
        $this->assertDatabaseHas('tasks', ['title' => 'New Task IN-PROGRESS']);

        // Send a POST request to create a task
        $response = $this->postJson('/api/tasks', [
            'title' => 'New Task DONE',
            'description' => 'Description for the new task',
            'due_date' => Carbon::now()->addDays(7)->toDateTimeString(),
            'status' => 'DONE',
            'user_id' => $this->user->id, // Associate the task with the user
        ]);
        $response->assertStatus(201); // Assert that the task was created successfully
        $this->assertDatabaseHas('tasks', ['title' => 'New Task DONE']);

        // Send an invalid POST request to create a task. This is expected to fail. Negative testing.
        $response = $this->postJson('/api/tasks', [
            'title' => 'New Task INVALID',
            'description' => 'Description for the new task',
            'due_date' => Carbon::now()->addDays(7)->toDateTimeString(),
            'status' => 'INVALID',
            'user_id' => $this->user->id, // Associate the task with the user
        ]);
        $response->assertStatus(422); // Assert that the task was NOT created successfully
        $this->assertDatabaseMissing('tasks', ['title' => 'New Task INVALID']);
    }

    public function test_create_task_without_authentication(): void
    {
        // Send a POST request to create a task. This is expected to fail because not authenticated. Negative testing.
        $response = $this->postJson('/api/tasks', [
            'title' => 'New Task TODO',
            'description' => 'Description for the new task',
            'due_date' => Carbon::now()->addDays(7)->toDateTimeString(),
            'status' => 'TODO',
            'user_id' => $this->user->id, // Associate the task with the user
        ]);
        $response->assertStatus(401); // Assert that the task was NOT created successfully
        $this->assertDatabaseMissing('tasks', ['title' => 'New Task TODO']);
    }

    public function test_get_list_of_tasks_with_authentication(): void
    {
        Sanctum::actingAs($this->user);

        Task::factory(5)->create(); // Create some tasks in the database

        $response = $this->getJson('/api/tasks'); // Send a GET request to retrieve the list of tasks

        $response->assertStatus(200); // Assert that the request was successful
        $response->assertJsonCount(5, 'tasks'); // Assert that there are 5 tasks in the response
    }

    public function test_get_list_of_tasks_without_authentication(): void
    {
        Task::factory(5)->create(); // Create some tasks in the database

        $response = $this->getJson('/api/tasks'); // Send a GET request to retrieve the list of tasks

        // Assert that the request was NOT successful because it does require authentication
        $response->assertStatus(401);
    }

    public function test_get_specific_task_with_authentication(): void
    {
        Sanctum::actingAs($this->user);

        $task = Task::factory()->create(); // Create a task in the database

        // Send a GET request to retrieve the specific task by ID
        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200); // Assert that the request was successful

        // Convert the expected due_date to a formatted string
        $expectedDueDate = $task->due_date->format('Y-m-d H:i:s');

        // Assert that the response matches the created task, including the formatted due_date
        $response->assertJson([
            'task' => [
                'title' => $task->title,
                'description' => $task->description,
                'due_date' => $expectedDueDate, // Format the due_date as a string
                'status' => $task->status,
                'user_id' => $task->user_id,
                'created_at' => $task->created_at->toISOString(),
                'updated_at' => $task->updated_at->toISOString(),
            ],
        ]);
    }

    public function test_get_specific_task_without_authentication(): void
    {
        $task = Task::factory()->create(); // Create a task in the database

        // Send a GET request to retrieve the specific task by ID
        $response = $this->getJson("/api/tasks/{$task->id}");

        // Assert that the request was NOT successful because it does require authentication
        $response->assertStatus(401);
    }

    public function test_update_task_with_authentication(): void
    {
        Sanctum::actingAs($this->user);

        $task = Task::factory()->create(); // Create a task in the database

        // Send a PUT request to update the specific task by ID
        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Task Title',
            'description' => 'Updated task description',
            'due_date' => now()->addDays(14)->toDateTimeString(),
            'status' => 'IN-PROGRESS',
            'user_id' => $task->user_id,
        ]);

        $response->assertStatus(200); // Assert that the request was successful
        $response->assertJson(['message' => 'Task updated successfully']); // Assert a success message

        $task->refresh(); // Refresh the task instance from the database

        // Assert that the task's attributes have been updated
        $this->assertEquals('Updated Task Title', $task->title);
        $this->assertEquals('Updated task description', $task->description);
        $this->assertEquals('IN-PROGRESS', $task->status);
    }

    public function test_update_task_without_authentication(): void
    {
        $task = Task::factory()->create(); // Create a task in the database

        // Send a PUT request to update the specific task by ID
        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Task Title Fail',
            'description' => 'Updated task description',
            'due_date' => now()->addDays(14)->toDateTimeString(),
            'status' => 'IN-PROGRESS',
            'user_id' => $task->user_id,
        ]);

        $response->assertStatus(401); // Assert that the task was NOT updated successfully
        $this->assertDatabaseMissing('tasks', ['title' => 'Updated Task Title Fail']);

        $task->refresh(); // Refresh the task instance from the database
    }

    public function test_delete_task_with_authentication(): void
    {
        Sanctum::actingAs($this->user);

        $task = Task::factory()->create(['user_id' => $this->user->id]); // Create a task in the database using user_id

        // Send a DELETE request to delete the specific task by ID
        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200); // Assert that the request was successful
        $response->assertJson(['message' => 'Task deleted successfully']); // Assert a success message

        // Assert that the task has been deleted from the database
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_delete_task_without_authentication(): void
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]); // Create a task in the database using user_id

        // Send a DELETE request to delete the specific task by ID
        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(401); // Assert that the request was successful
        $response->assertJson(['message' => 'Unauthenticated.']); // Assert a success message

        // Assert that the task has NOT been deleted from the database
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
