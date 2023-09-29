<template>
  <div>
    <!-- Add Task Form -->
    <form @submit.prevent="addTask">
      <h2>Add Task</h2>
      <div class="form-group">
        <label for="title">Title: </label>
        <input v-model="newTask.title" type="text" id="title" required />
      </div>
      <div class="form-group">
        <label for="description">Description: </label>
        <input v-model="newTask.description" type="text" id="description" required />
      </div>
      <div class="form-group">
        <label for="due_date">Due Date: </label>
        <input v-model="newTask.due_date" type="datetime-local" id="due_date" required />
      </div>
      <div class="form-group">
        <label for="status">Status: </label>
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
    <table class="task-table">
      <thead>
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Due Date</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="task in tasks" :key="task.id">
        <td>{{ task.title }}</td>
        <td>{{ task.description }}</td>
        <td>{{ task.due_date }}</td>
        <td>{{ task.status }}</td>
        <td>
          <button @click="editTask(task)" class="edit-button">Edit</button>
          <button @click="deleteTask(task.id)">Delete</button>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
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

// Create a computed property to get the tasks from the task store
const tasks = computed(() => taskStore.tasks);

const addTask = () => {
  const token = authStore.token; // Get the authentication token from the store
  const user = authStore.getUser(); // Get the user_id from the store

  // Create a task object that includes user_id
  const taskData = {
    title: newTask.value.title,
    description: newTask.value.description,
    due_date: newTask.value.due_date,
    status: newTask.value.status,
    user_id: user.user.id, // Include the user_id in the task data
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
  router.push(`/tasks/edit/${task.id}`);
};

const deleteTask = (taskId) => {
  taskStore.deleteTask(taskId);
};

onMounted(async () => {
  try {
    // Make a GET request to fetch tasks from the /tasks endpoint
    // const response = await axios.get('/tasks');

    const token = authStore.token; // Get the authentication token from the store

    const response = await axios.get('/tasks', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    // Update the tasks in the task store with the fetched tasks
    taskStore.setTasks(response.data.tasks);
  } catch (error) {
    // Handle error, such as displaying an error message
    console.error('Error fetching tasks:', error);
  }
});
</script>

<style scoped>
/* Add your CSS styles for the form here */

.task-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.task-table th,
.task-table td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}

.task-table th {
  background-color: #f2f2f2;
}

/* Add your CSS styles for the list here */
button {
  cursor: pointer;
}

/* Add margin to the edit button for space */
.edit-button {
  margin-right: 10px; /* Adjust the margin as needed */
}
</style>
