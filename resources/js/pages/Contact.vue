<template>
  <div class="request-category">
    <h1>Request a Category</h1>
    <div v-if="success" class="alert alert-success" v-on:click="success = false">
      {{ successMessage }}
    </div>
    <form @submit.prevent="submitRequest">
      <div class="form-group">
        <label for="categoryName">Category Name</label>
        <input type="text" id="categoryName" v-model="categoryName" placeholder="Enter category name" required />
      </div>
      <button type="submit">Request Category</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      categoryName: '',
      successMessage: '',
      success: false,
    };
  },
  methods: {
    async submitRequest() {
      try {
        const response = await axios.post('/api/category-requests', {
          name: this.categoryName
        });
        this.successMessage = 'Request successful!';
        this.success = true;
        this.categoryName = '';
        console.log(response.data);
        // Display a success message or handle errors
      } catch (error) {
        console.log(error.response.data);
        // Display an error message or handle errors
      }
    },
  },
};
</script>

<style scoped>
.request-category {
  max-width: 600px;
  margin: 0 auto;
  padding: 2rem;
}

.form-group {
  margin-bottom: 1rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
}

input {
  width: 100%;
  padding: 0.5rem;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  background-color: #007bff;
  color: white;
  padding: 0.5rem 1rem;
  font-size: 1rem;
  border-radius: 4px;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}
.alert {
  position: fixed;
  top: 1rem;
  right: 1rem;
  padding: 0.5rem;
  background-color: #28a745;
  color: #fff;
  border-radius: 4px;
  cursor: pointer;
}
</style>
