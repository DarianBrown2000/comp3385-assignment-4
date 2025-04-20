<template>
  <div class="row">
    <div v-for="movie in movies" :key="movie.id" class="col-md-4 mb-4">
      <div class="card h-100">
        <img
          v-if="movie.poster"
          :src="'/storage/posters/' + movie.poster"
          class="card-img-top"
          alt="Movie Poster"
        />
        <div class="card-body">
          <h5 class="card-title">{{ movie.title }}</h5>
          <p class="card-text">{{ movie.description }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

let movies = ref([]);

function fetchMovies() {
  const token = localStorage.getItem('jwt'); 

  if (!token) {
    alert('You must log in first.');
    window.location.href = '/login'; // Redirect to login page if no token is found
    return;
  }

  fetch("/api/v1/movies", {
    method: "GET",
    headers: {
      "Accept": "application/json",
      "Authorization": `Bearer ${token}` 
    }
  })
    .then((response) => {
      if (!response.ok) throw new Error("Failed to fetch movies");
      return response.json();
    })
    .then((data) => {
      movies.value = data;
    })
    .catch((error) => {
      console.error("Error fetching movies:", error);
    });
}

onMounted(() => {
  fetchMovies();
});
</script>
