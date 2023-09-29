<template>
  <div>
    <!-- Add Task Form -->
    <form @submit.prevent="addTask">
      <h2>Add Task</h2>
      <div class="form-group">
        <label for="title">Title</label>
        <input v-model="newTask.title" type="text" id="title" required />
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <input v-model="newTask.description" type="text" id="description" required />
      </div>
      <div class="form-group">
        <label for="due_date">Due Date</label>
        <input v-model="newTask.due_date" type="datetime-local" id="due_date" required />
      </div>
      <div class="form-group">
        <label for="status">Status</label>
        <select v-model="newTask.status" id="status" required>
          <option value="TODO">TODO</option>
          <option value="IN-PROGRESS">IN-PROGRESS</option>
          <option value="DONE">DONE</option>
        </select>
      </div>
      <button type="submit">Add Task</button>
    </form>

    <!-- Task List -->
    <h2>Task List</h2>
    <ul>
      <li v-for="task in tasks" :key="task.id">
        <div>{{ task.title }}</div>
        <div>{{ task.description }}</div>
        <div>{{ task.due_date }}</div>
        <div>{{ task.status }}</div>
        <button @click="editTask(task)">Edit</button>
        <button @click="deleteTask(task.id)">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios'; // Import Axios for HTTP requests
import { useAuthStore } from '@/store/auth'; // Import the auth store
import { useTaskStore } from '@/store/task'; // Import the task store
import { useRouter } from 'vue-router';

const newTask = ref({
  title: '',
  description: '',
  due_date: '',
  status: 'TODO',
});

const authStore = useAuthStore(); // Use the auth store
const taskStore = useTaskStore(); // Use the task store
const router = useRouter();

const tasks = computed(() => taskStore.tasks);

const addTask = () => {
  const token = authStore.token; // Get the authentication token from the store
  // const userId = authStore.userId; // Get the user_id from the store

  // Create a task object that includes user_id
  const taskData = {
    title: newTask.value.title,
    description: newTask.value.description,
    due_date: newTask.value.due_date,
    status: newTask.value.status,
    user_id: 6, // Include the user_id in the task data
  };

  // Make a POST request to save the new task to Laravel with the token in the headers
  axios
      .post('/tasks', taskData, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
      .then((response) => {
        // Handle success and update your local state with the created task
        const createdTask = response.data.task;
        taskStore.addTask(createdTask); // Call the action in the task store to add a task
        newTask.value = {
          title: '',
          description: '',
          due_date: '',
          status: 'TODO',
        };
      })
      .catch((error) => {
        // Handle error, such as displaying an error message
        console.error('Error adding task:', error);
      });
};


const editTask = (task) => {
  // Navigate to the edit task view with the task ID as a parameter
  router.push(`/tasks/edit/${task.id}`);
};

const deleteTask = (taskId) => {
  taskStore.deleteTask(taskId); // Call the action in the task store to delete a task
};
</script>



<style scoped>
/* Add your CSS styles for the form here */
.form-group {
  margin-bottom: 15px;
}
/* Add your CSS styles for the list here */
ul {
  list-style: none;
  padding: 0;
}
li {
  border: 1px solid #ccc;
  padding: 10px;
  margin: 10px 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
button {
  cursor: pointer;
}
</style>
