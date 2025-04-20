<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <RouterLink class="navbar-brand" to="/">COMP3385</RouterLink>
      
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <RouterLink class="nav-link" to="/">Home</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/about">About</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/movies">Movies</RouterLink>
          </li>
        </ul>

        <ul class="navbar-nav">
          <li v-if="!isAuthenticated" class="nav-item">
            <RouterLink class="nav-link" to="/login">Login</RouterLink>
          </li>
          <li v-else class="nav-item">
            <button @click="logout" class="btn btn-outline-light btn-sm">Logout</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const isAuthenticated = ref(false);

onMounted(() => {
  // Check if JWT is in storage
  isAuthenticated.value = !!localStorage.getItem('jwt');
});

function logout() {
  const token = localStorage.getItem('jwt');
  if (!token) return;

  axios.post('/api/v1/logout', {}, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  })
  .then(() => {
    localStorage.removeItem('jwt');
    isAuthenticated.value = false;
    router.push('/login');
  })
  .catch(error => {
    console.error('Logout failed:', error);
  });
}
</script>

<style scoped>
.navbar .btn {
  margin-left: 10px;
}
</style>

