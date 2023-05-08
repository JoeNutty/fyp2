<template>
  <!-- header -->
  <header class="header">
    <div class="header-text">
      <div class="logo-container">
        <img src="images/logo.png" alt="Logo" class="brand-logo" />
      </div>
      <h1>Scam Awareness Blog</h1>
      <h4>A place to share your Experience getting scammed without being judged</h4>
    </div>
    <div class="overlay"></div>
  </header>
  <h2 class="header-title">Latest Blog Posts</h2>
  <section class="cards-blog latest-blog">
    <div class="card-blog-content" v-for="post in posts" :key="post.id">
      <img :src="post.imagePath" alt="" />
      <p>
        {{ post.created_at }}
        <span style="float: right">Written By {{ post.user }}</span>
      </p>
      <h4 style="font-weight: bolder">
        <a href="single-blog.html"></a>
        <router-link :to="{
          name: 'SingleBlog',
          params: { slug: post.slug },
        }">{{ post.title }}</router-link>
      </h4>
    </div>
  </section>
</template>
<script>
export default {
  emits: ["updateSidebar"],
  data() {
    return {
      posts: [],
    };
  },

  mounted() {
    axios
      .get("/api/home-posts")
      .then((response) => (this.posts = response.data.data))
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>
<style scoped>
.logo-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 1rem;
}

.brand-logo {
  max-width: 50%;
  margin-bottom: 1rem;
  margin-top: 3rem;
}
</style>