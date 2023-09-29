<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Task;
use App\Http\Requests\CreateTaskRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    // Create a new task
    public function store(CreateTaskRequest $request): JsonResponse
    {
        // Validate the incoming request using the CreateTaskRequest form request
        $validatedData = $request->validated();

        $task = Task::create($validatedData); // Create a new task with the validated data

        event(new NewMessage('A new task has been created.'));

        // Return the created task as a JSON response
        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    // Get a list of all tasks
    public function index()
    {
        $tasks = Task::all(); // Retrieve all tasks

        return response()->json(['tasks' => $tasks]); // Return the list of tasks as a JSON response
    }

    // Get a specific task by ID
    public function show($id)
    {
        $task = Task::find($id); // Retrieve the task by ID

        if (!$task) {
            // Task not found, return a 404 response
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Return the task as a JSON response
        return response()->json(['task' => $task]);
    }

    // Update a task by ID
    public function update(CreateTaskRequest $request, $id)
    {
        // Validate the incoming request using the CreateTaskRequest form request
        $validatedData = $request->validated();

        $task = Task::find($id); // Retrieve the task by ID

        if (!$task) {
            // Task not found, return a 404 response
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Update the task with the validated data
        $task->update($validatedData);

        event(new NewMessage('Task ' . $id. ' has been updated.'));

        // Return a success message as a JSON response
        return response()->json(['message' => 'Task updated successfully', 'task' => $task]);
    }

    // Delete a task by ID
    public function destroy($id)
    {
        $task = Task::find($id); // Retrieve the task by ID

        if (!$task) {
            // Task not found, return a 404 response
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Use the 'delete-task' Gate to authorize the deletion
        if (Gate::allows('delete-task', $task)) {
            $task->delete(); // User is authorized to delete the task. Delete the task.

            event(new NewMessage('Task ' . $id. ' has been deleted.'));

            // Return a success message as a JSON response
            return response()->json(['message' => 'Task deleted successfully']);
        } else {
            // User is not authorized to delete the task
            return response()->json(['message' => 'Unauthorized to delete the task'], 403);
        }
    }
}
