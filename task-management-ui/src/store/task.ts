// store/task.ts
import { defineStore } from 'pinia';

interface Task {
    id: number;
    title: string;
    description: string;
    due_date: string;
    status: 'TODO' | 'IN-PROGRESS' | 'DONE';
}

export const useTaskStore = defineStore({
    id: 'task', // Store ID (you can use a different name if needed)
    state: () => ({
        tasks: [] as Task[],
    }),
    actions: {
        // Action to add a task
        addTask(task: Task) {
            // Add your logic here to add the task to the state
            this.tasks.push(task);
        },

        // Action to delete a task by ID
        deleteTask(taskId: number) {
            // Add your logic here to delete the task from the state
            this.tasks = this.tasks.filter((task) => task.id !== taskId);
        },

        // Mutation to set tasks
        setTasks(tasks: Task[]) {
            this.tasks = tasks;
        },

        // Add more actions as needed (e.g., editTask, etc.)
    },
});
