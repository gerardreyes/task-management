<template>
  <div>
    <h2>Tasks</h2>
    <!-- Display a list of tasks here -->
    <ul>
      <li v-for="task in tasks" :key="task.id">
        {{ task.title }}
      </li>
    </ul>
    <!-- Button to add a new task -->
    <button @click="addTask">Add Task</button>
  </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default defineComponent({
  setup() {
    const tasks = ref([]); // Store the list of tasks
    const router = useRouter();

    // Function to fetch tasks
    const fetchTasks = () => {
      axios
          .get('/api/tasks') // Assuming this endpoint exists in your Laravel API
          .then((response) => {
            tasks.value = response.data; // Assign the fetched tasks to the 'tasks' ref
          })
          .catch((error) => {
            console.error('Error fetching tasks:', error);
          });
    };

    // Function to add a new task
    const addTask = () => {
      // Redirect to the task creation page
      router.push('/create-task');
    };

    // Check if the user is logged in (you can replace this with your actual authentication check logic)
    const isLoggedIn = true; // Replace with your authentication logic

    // Fetch tasks when the component is mounted
    onMounted(() => {
      if (isLoggedIn) {
        fetchTasks(); // Fetch tasks only if the user is logged in
      } else {
        // Redirect to the login page if the user is not logged in
        router.push('/login');
      }
    });

    return { tasks, addTask };
  },
});
</script>
