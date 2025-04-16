<template>

  <div v-if="successMessage" class="alert alert-success">
    {{ successMessage }}
  </div>
  <div v-if="errorMessage" class="alert alert-danger">
    {{ errorMessage }}
  </div>

  <form id="movieform" @submit.prevent="saveMovie">
    <div class="form-group mb-3">
      <label for="title" class="form-label">Movie Title</label>
      <input type="text" id="title" v-model="title" class="form-control" />
    </div>

    <div class="form-group mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea id="description" v-model="description" class="form-control"></textarea>
    </div>

    <div class="form-group mb-3">
      <label for="poster" class="form-label">Poster</label>
      <input type="file" id="poster" @change="handleFileUpload" class="form-control" />
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';

const title = ref('');
const description = ref('');
const poster = ref(null);
const successMessage = ref('');
const errorMessage = ref('');


function handleFileUpload(event) {
  poster.value = event.target.files[0];
}

function saveMovie() {
  const movieForm = document.getElementById('movieForm');
  const formData = new FormData(movieForm);

  fetch('/api/v1/movies', {
    method: 'POST',
    headers: {
      'Accept': 'application/json'
    },
    body: formData
  })
    .then(function (response) {
        if (!response.ok) throw new Error('Upload failed');
      return response.json();
    })
    .then(function (data) {
    successMessage.value = 'Movie saved successfully!';
      errorMessage.value = '';
    })
    .catch(function (error) {
      errorMessage.value = 'Something went wrong. Please try again.';
      successMessage.value = '';
      console.log(error);
    });
}
</script>