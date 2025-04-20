<template>
  <div class="login-container">
    <form @submit.prevent="login" class="p-4 shadow rounded" style="max-width: 400px; margin: auto;">
      <h3 class="mb-3">Login</h3>
      
      <div class="mb-3">
        <input v-model="email" type="email" class="form-control" placeholder="Email" required />
      </div>

      <div class="mb-3">
        <input v-model="password" type="password" class="form-control" placeholder="Password" required />
      </div>

      <button type="submit" class="btn btn-primary w-100" :disabled="loading">
        {{ loading ? 'Logging in...' : 'Login' }}
      </button>

      <div v-if="errorMessage" class="alert alert-danger mt-3">
        {{ errorMessage }}
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      loading: false,
      errorMessage: ''
    };
  },
  methods: {
    async login() {
      this.loading = true;
      this.errorMessage = '';

      try {
        const response = await axios.post('http://localhost:8000/api/v1/login', {
          email: this.email,
          password: this.password,
        });

        const token = response.data.access_token || response.data.token;

        // Store the token
        localStorage.setItem('jwt', token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

        // Redirect to the movies page
        this.$router.push('/movies');
      } catch (error) {
        this.errorMessage = 'Login failed. Please check your credentials.';
        console.error(error);
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style scoped>
.login-container {
  padding-top: 100px;
}
</style>
