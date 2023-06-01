<template>
  <div class="posts-list">
    <h1>Posts List</h1>
    <div class="search-box">
      <input type="text" v-model="searchQuery" placeholder="Search posts..." />
      <input type="text" v-model="searchAuthor" class="search-author" placeholder="Search authors..." />
    </div>
    <!-- success message -->
    <div class="success-msg" v-if="success">
      <i class="fa fa-check"></i>
      Post deleted successfully
    </div>
    <div class="success-msg" v-if="editSuccess">
      <i class="fa fa-check"></i>
      Post edited successfully
    </div>
    <div class="posts-container">
      <div class="post-item" v-for="(post, index) in filteredByAuthorPosts" :key="post.id">
        <div class="post-number">{{ index + 1 }}.</div>
        <div class="post-title">{{ post.title }} <span class="author-name">by: {{ post.user }}</span></div>
        <div class="post-actions">
          <router-link class="view-link" :to="{ name: 'SingleBlog', params: { slug: post.slug } }">
            View
          </router-link>
          <router-link v-if="isAuthor(post.user)" class="edit-link"
  :to="{ name: 'EditPosts', params: { slug: post.slug } }">
  Edit
</router-link>
          <button class="delete-btn" @click="destroy(post.slug)">
            Delete
          </button>
        </div>
      </div>
    </div>
    <div class="create-post">
      <router-link :to="{ name: 'CreatePosts' }">
        Create post<span>&#8594;</span>
      </router-link>
    </div>
  </div>
</template>
<script>
export default {
  props: ["editSuccess"],
  emits: ["updateSidebar"],
  data() {
    return {
      posts: [],
      success: false,
      searchQuery: '',
      searchAuthor: '',
      authenticatedUserName: '',
    };
  },
  computed: {
    filteredPosts() {
      if (!this.searchQuery) {
        return this.posts;
      }
      const query = this.searchQuery.toLowerCase();
      return this.posts.filter((post) =>
        post.title.toLowerCase().includes(query)
      );
    },
    filteredByAuthorPosts() { 
      return this.filteredPosts.filter((post) =>
        !this.searchAuthor || post.user.toLowerCase().includes(this.searchAuthor.toLowerCase())
      );
    },
  },
  methods: {
    destroy(slug) {
      axios
        .delete(`/api/posts/${slug}`)
        .then(() => {
          this.fetchPosts();
          this.success = true;
          setTimeout(() => {
            this.success = false;
          }, 2500);
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
    fetchPosts() {
      axios
        .get("/api/dashboard-posts")
        .then((response) => {this.posts = response.data.data})
        .catch((error) => {
          console.log(error);
        });
    },
    isAuthor(postUserName) {
    return this.authenticatedUserName === postUserName;
  },
  },
  mounted() {
    this.fetchPosts();
    axios
    .get("/api/user")
    .then((response) => (this.authenticatedUserName = response.data.name))
    .catch((error) => {
      console.log(error);
    });
  },
};
</script>
  
<style scoped >
.categories-list {
  min-height: 100vh;
  background: #fff;
}

.categories-list h1 {
  font-weight: 300;
  padding: 50px 0 30px 0;
  text-align: center;
}

.categories-list .item {
  display: flex;
  justify-content: right;
  align-items: center;
  max-width: 300px;
  margin: 0 auto !important;
}

.categories-list .item p {
  font-size: 16px;
}

.categories-list .item p,
.categories-list .item div,
.categories-list .item {
  margin: 15px 8px;
}

.categories ul li {
  list-style: none;
  background-color: #494949;
  margin: 20px 5px;

  border-radius: 15px;
}

.categories ul {
  display: flex;
  justify-content: center;
}

.categories a {
  color: white;
  padding: 10px 20px;
  display: inline-block;
}

.create-categories a,
.index-categories a {
  all: revert;
  margin: 20px 0;
  display: inline-block;
  text-decoration: none;
}

.create-categories a span,
.index-categories a span {
  font-size: 22px;
}

.index-categories {
  text-align: center;
}

.posts-list {
  min-height: 100vh;
  background: #fff;
  padding: 2rem;
}

.posts-list h1 {
  font-weight: 300;
  text-align: center;
  margin-bottom: 2rem;
}

.posts-container {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.post-item {
  display: flex;
  gap: 1rem;
  align-items: center;
  background-color: #f5f5f5;
  padding: 1rem;
  border-radius: 8px;
}

.post-number {
  font-size: 1rem;
  font-weight: bold;
}

.post-title {
  font-size: 1.2rem;
  flex-grow: 1;
  font-weight: bold;
}

.post-actions {
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

.create-post {
  margin-top: 2rem;
  text-align: center;
}

.create-post a {
  text-decoration: none;
  font-size: 1.2rem;
}
.search-box {
  margin-bottom: 1rem;
  text-align: center;
}
.search-author {
    margin-left: 1rem;
  }

.search-box input {
  padding: 0.5rem;
  width: 100%;
  max-width: 300px;
  font-size: 1rem;
  border-radius: 4px;
  border: 1px solid #ccc;
}
.author-name {
  font-size: 0.9rem;
  font-weight: normal;
  color: #888;
  margin-left: 0.5rem;
  
}
.view-link {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    background-color: #28a745;
    color: #fff;
  }
</style>