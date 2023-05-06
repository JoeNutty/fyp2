<template>
  <div id="wrapper">
    <!-- sidebar -->
    <div class="sidebar" :class="{ showOverlay: overlayVisibility }">
      <span class="closeButton" @click="hideOverlay">&times;</span>
      <p class="brand-title"><strong>Scam Awareness Blog</strong></p>

      <div class="side-links">
        <ul>
          <li>
            <router-link @click="hideOverlay" :to="{ name: 'Home' }">Home</router-link>
          </li>
          <li>
            <router-link @click="hideOverlay" :to="{ name: 'Blog' }">Blog</router-link>
          </li>
          <li>
            <router-link @click="hideOverlay" :to="{ name: 'About' }">About</router-link>
          </li>

          <li v-if="!loggedIn">
            <router-link @click="hideOverlay" :to="{ name: 'Register' }">Register</router-link>
          </li>
          <li v-if="!loggedIn">
            <router-link @click="hideOverlay" :to="{ name: 'Login' }">Login</router-link>
          </li>
          <li v-if="loggedIn">
            <router-link @click="hideOverlay" :to="{ name: 'Dashboard' }">Dashboard</router-link>
          </li>
        </ul>
      </div>

      <!-- sidebar footer -->

    </div>
    <!-- Menu Button -->
    <div class="menuButton" @click="ShowOverlay">
      <div class="bar"></div>
      <div class="bar"></div>
      <div class="bar"></div>
    </div>
    <!-- main -->
    <main class="container">
      <!-- render components depending on the page visited -->

      <router-view @update-sidebar="updateSidebar" @show-edit-success="showEditSuccess" :editSuccess="editSuccess"
        :key="$route.path"></router-view>
    </main>

    <!-- Main footer -->
    <footer class="main-footer">


    </footer>
  </div>
</template>
<script>
export default {
  data() {
    return {
      overlayVisibility: false,
      loggedIn: false,
      editSuccess: false,
      deleteSuccess: false,
    };
  },
  methods: {
    ShowOverlay() {
      this.overlayVisibility = true;
    },

    hideOverlay() {
      this.overlayVisibility = false;
    },

    updateSidebar() {
      this.loggedIn = !this.loggedIn;
    },

    showEditSuccess() {
      this.editSuccess = true;
      setTimeout(() => {
        this.editSuccess = false;
      }, 2500);
    },
    

  },

  mounted() {
    if (localStorage.getItem("authenticated")) {
      this.loggedIn = true;
    } else {
      this.loggedIn = false;
    }
  },
};
</script>
<style scoped>
.showOverlay {
  width: 100%;
  z-index: 5;
}
</style>