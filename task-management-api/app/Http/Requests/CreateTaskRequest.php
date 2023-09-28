<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Check if the authenticated user has the necessary permissions to create a task.
        return Gate::allows('create-task');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        // Define the validation rules for creating or updating a task
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|string|in:TODO,IN-PROGRESS,DONE', // Define valid status values
            'user_id' => 'required|exists:users,id', // Validate that user_id exists in the 'users' table
        ];
    }
}
