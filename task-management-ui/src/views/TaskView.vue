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

    <!-- Edit Task Form -->
    <h2>Edit Task</h2>
    <form v-if="isEditing" @submit.prevent="updateTask">
      <div class="form-group">
        <label for="editTitle">Title: </label>
        <input v-model="editedTask.title" type="text" id="editTitle" required />
      </div>
      <div class="form-group">
        <label for="editDescription">Description: </label>
        <input v-model="editedTask.description" type="text" id="editDescription" required />
      </div>
      <div class="form-group">
        <label for="editDueDate">Due Date: </label>
        <input v-model="editedTask.due_date" type="datetime-local" id="editDueDate" required />
      </div>
      <div class="form-group">
        <label for="editStatus">Status: </label>
        <select v-model="editedTask.status" id="editStatus" required>
          <option value="TODO">TODO</option>
          <option value="IN-PROGRESS">IN-PROGRESS</option>
          <option value="DONE">DONE</option>
        </select>
      </div>
      <button type="submit">Update Task</button>
      <button @click="cancelEdit">Cancel</button>
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
          <!-- Conditionally render the Edit and Delete buttons -->
          <button @click="editTask(task)" v-if="isUserTask(task)" class="edit-button">Edit</button>
          <button @click="deleteTask(task.id)" v-if="isUserTask(task)">Delete</button>
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

// State to track whether we are editing a task or not
const isEditing = ref(false);

// State to store the edited task
const editedTask = ref({
  title: '',
  description: '',
  due_date: '',
  status: 'TODO',
});

// Function to initiate the editing of a task
const editTask = (task) => {
  // Populate the form fields with the task's data
  editedTask.value = { ...task };
  isEditing.value = true;
};

// Function to cancel the editing of a task
const cancelEdit = () => {
  editedTask.value = {
    title: '',
    description: '',
    due_date: '',
    status: 'TODO',
  };
  isEditing.value = false;
};

// Function to update a task
const updateTask = () => {
  const token = authStore.token;

  // Make an HTTP PUT request to update the task
  axios
      .put(`/tasks/${editedTask.value.id}`, editedTask.value, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
      .then((response) => {
        // Handle success and update the task in the store
        const updatedTask = response.data.task;

        // Find the index of the task in the array and update it
        const index = tasks.value.findIndex((task) => task.id === updatedTask.id);
        if (index !== -1) {
          tasks.value[index] = updatedTask;
        }

        // Clear the edited task and exit edit mode
        cancelEdit();
      })
      .catch((error) => {
        // Handle errors, e.g., display an error message
        console.error('Error updating task:', error);
      });
};

// Function to check if the task belongs to the logged-in user
const isUserTask = (task) => {
  const user = authStore.getUser();
  return task.user_id === user.user.id;
};

// Function to add a new task
const addTask = () => {
  const token = authStore.token;
  const user = authStore.getUser();

  // Create a task object that includes user_id
  const taskData = {
    title: newTask.value.title,
    description: newTask.value.description,
    due_date: newTask.value.due_date,
    status: newTask.value.status,
    user_id: user.user.id,
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
        taskStore.addTask(createdTask);
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

// Function to delete a task
const deleteTask = (taskId) => {
  taskStore.deleteTask(taskId);
};

onMounted(async () => {
  try {
    const token = authStore.token;

    const response = await axios.get('/tasks', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    taskStore.setTasks(response.data.tasks);
  } catch (error) {
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
  margin-right: 10px;
}
</style>
