<template>
  <div id="backend-view">
    <div class="request-category">
      <h1>Request a Category</h1>
      <div v-if="success" class="alert alert-success" v-on:click="success = false">
        {{ successMessage }}
      </div>
      <form @submit.prevent="submitRequest">
        <div class="form-group">
          <label for="categoryName">Category Name</label>
          <input type="text" id="categoryName" v-model="categoryName" required />
        </div>
        <button type="submit">Request Category</button>
      </form>
      <router-link :to="{ name: 'ViewRequests' }">View requested categories <span>&#8594;</span></router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { RouterLink } from 'vue-router';

export default {
  data() {
    return {
      categoryName: "",
      successMessage: "",
      success: false,
    };
  },
  methods: {
    async submitRequest() {
      try {
        const response = await axios.post("/api/category-requests", {
          name: this.categoryName
        });
        this.successMessage = "Request successful!";
        this.success = true;
        this.categoryName = "";
        console.log(response.data);
        // Display a success message or handle errors
      }
      catch (error) {
        console.log(error.response.data);
        // Display an error message or handle errors
      }
    },
  },
  components: { RouterLink }
};
</script>

<style scoped>
#backend-view {
  text-align: center;
  background-color: #f3f4f6;
  height: 100vh;
  padding-top: 15vh;
}
.request-category {
  background-color: #ffffff;
  min-height: 50vh;
  padding: 50px;
  max-width: 600px;
  margin: 0 auto;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}

.request-category h1 {
  margin-bottom: 1.5rem;

  font-weight: 600;
  text-align: center;
}

.form-group {
  margin-bottom: 1rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

input {
  width: 100%;
  padding: 0.5rem;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #fff;
}

button {
  background-color: #6c757d;
  color: white;
  padding: 0.5rem 1rem;
  font-size: 1rem;
  border-radius: 4px;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #5a6268;
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

.router-link {
  display: block;
  margin-top: 1rem;
  text-decoration: none;
  font-size: 1.2rem;
  font-weight: 500;
  color: #333;
  text-align: center;
}

.router-link span {
  font-size: 22px;
  color: #007bff;
}
</style>
