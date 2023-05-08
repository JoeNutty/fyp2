<template>
  <div class="categories-list">
    <h1>Categories List</h1>
    <!-- success message -->
    <div class="success-msg" v-if="success">
      <i class="fa fa-check"></i>
      Deleted successfully
    </div>
    <div class="categories-container">
      <div
        class="category-item"
        v-for="(category, index) in categories"
        :key="category.id"
      >
        <div class="category-number">{{ index + 1 }}</div>
        <div class="category-name">{{ category.name }}</div>
        <div class="category-actions">
          <router-link
            class="edit-link"
            :to="{ name: 'EditCategories', params: { id: category.id } }"
          >
            Edit
          </router-link>
          <button class="delete-btn" @click="destroy(category.id)">
            Delete
          </button>
        </div>
      </div>
    </div>
    <div class="create-category">
      <router-link :to="{ name: 'CreateCategories' }">
        Create Categories<span>&#8594;</span>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      categories: [],
      success: false,
    };
  },

  methods: {
    destroy(id) {
      axios
        .delete("/api/categories/" + id)
        .then((response) => {
          this.success = true;
          setInterval(() => {
            this.success = false;
          }, 2500);
          this.fetchCategories();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchCategories() {
      axios
        .get("/api/categories")
        .then((response) => (this.categories = response.data))
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.fetchCategories();
  },
};
</script>

<style scoped>
.categories-list {
  min-height: 100vh;
  background: #fff;
  padding: 2rem;
}

.categories-list h1 {
  font-weight: 300;
  text-align: center;
  margin-bottom: 2rem;
}

.categories-container {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.category-item {
  display: flex;
  gap: 1rem;
  align-items: center;
  background-color: #f5f5f5;
  padding: 1rem;
  border-radius: 8px;
}

.category-number {
  font-size: 1rem;
  font-weight: bold;
}

.category-name {
  font-size: 1.2rem;
  flex-grow: 1;
}

.category-actions {
  display: flex;
  gap: 1rem;
}

.edit-link,
.delete-btn {
  font-size: 0.9rem;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  text-decoration: none;
}

.edit-link {
  background-color: #3498db;
  color: #fff;
}

.delete-btn {
  background-color: #e74c3c;
  color: #fff;
  border: none;
  outline: none;
}

.create-category {
  margin-top: 2rem;
  text-align: center;
}

.create-category a {
  text-decoration: none;
  font-size: 1.2rem;
}
</style>