<template>
    <div class="profile-container">
        <h1>Profile</h1>
        <div v-if="loading">
            Loading...
        </div>
        <div class="item" v-else>
            <pre>
            <p><strong>Username:</strong>   {{ user.name }}</p>
            <p><strong>Email:</strong>      {{ user.email }}</p>
            <p><strong>Role:</strong>       {{ user.role }}</p>
            <p><strong>Account Created:</strong> {{ formattedCreatedAt }}</p>
            <button class="edit-profile-btn" @click="goToEditProfile">Edit Profile</button>
            </pre>
            <!-- Other user details can be added here -->
        </div>
    </div>
</template>
  
<script>
import axios from 'axios'

export default {
    data() {
        return {
            loading: true,
            user: null
        }
    },
    methods: {
        goToEditProfile() {
            this.$router.push({ name: 'EditAccount' }) // Replace 'EditProfile' with the actual name of the route
        }
    },
    computed: {
        formattedCreatedAt() {
            // Create a new Date object using the user's created_at value
            const date = new Date(this.user.created_at)

            // Format the date in a human-friendly format
            return date.toLocaleDateString("en-US", {
                day: 'numeric', month: 'long', year: 'numeric',
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            })
        }
    },
    async mounted() {
        try {
            const response = await axios.get('/api/user')
            this.user = response.data

            // If the server responds with a 401 status, the user is not authenticated
            if (response.status === 401) {
                this.$emit("updateSidebar");
                localStorage.removeItem("authenticated");
                this.$router.push({ name: "Login" });
            }
        } catch (error) {
            console.error(error)
        } finally {
            this.loading = false
        }
    }
}
</script>

  
<style scoped>
.profile-container {
    min-height: 100vh;
    background: #fff;
}

.profile-container h1 {
    font-weight: 300;
    padding: 50px 0 30px 0;
    text-align: center;
}

.profile-container .item {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 300px;
    margin: 0 auto;
}

.profile-container .item p {
    font-size: 16px;
    margin: 15px 8px;
}
.edit-profile-btn {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #007BFF; /* Change to desired color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.edit-profile-btn:hover {
    background-color: #0056b3; /* Change to desired hover color */
}
</style>
  