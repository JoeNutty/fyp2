<template>
    <div id="backend-view">
        <div class="profile-container">
            <h1>Profile</h1>
            <div v-if="loading">
                Loading...
            </div>
            <div class="item" v-else>
                <dl>
                    <dt>Username:</dt>
                    <dd>{{ user.name }}</dd>
                    <dt>Email:</dt>
                    <dd>{{ user.email }}</dd>
                    <dt>Role:</dt>
                    <dd>{{ user.role }}</dd>
                    <dt>Account Created:</dt>
                    <dd>{{ formattedCreatedAt }}</dd>
                </dl>
                <button class="edit-profile-btn" @click="goToEditProfile">Edit Profile</button>
                <!-- Other user details can be added here -->
            </div>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios';

export default {
    data() {
        return {
            loading: true,
            user: null,
        };
    },
    methods: {
        goToEditProfile() {
            this.$router.push({ name: 'EditAccount' });
        },
    },
    computed: {
        formattedCreatedAt() {
            const date = new Date(this.user.created_at);

            return date.toLocaleDateString('en-US', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });
        },
    },
    async mounted() {
        try {
            const response = await axios.get('/api/user');
            this.user = response.data;

            if (response.status === 401) {
                this.$emit('updateSidebar');
                localStorage.removeItem('authenticated');
                this.$router.push({ name: 'Login' });
            }
        } catch (error) {
            console.error(error);
        } finally {
            this.loading = false;
        }
    },
};
</script>
  
<style scoped>
#backend-view {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f3f4f6;
    height: 100vh;
}

.profile-container {
    background-color: #ffffff;
    max-width: 500px;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 2.5rem;
    margin-bottom: 2rem;
    text-align: center;
}

dl {
    display: grid;
    grid-template-columns: 150px 1fr;
    grid-gap: 1rem;
    margin-bottom: 2rem;
}

dt {
    font-weight: bold;
    text-align: right;
}

dd {
    text-align: left;
}

.loading {
    font-size: 2rem;
    text-align: center;
}

.edit-profile-btn {
    display: block;
    margin: 0 auto;
    color: white;
    border: none;
    padding: 1rem;
    cursor: pointer;
    background-color: #007BFF;
    transition: background-color 0.3s ease;
}

.edit-profile-btn:hover {
    background-color: #0056b3;
}
</style>
  