<template>
    <div class="edit-profile-container">
        <h1>Edit Profile</h1>
        <div v-if="loading">
            Loading...
        </div>
        <div v-else>
            <form @submit.prevent="updateProfile">
                <div>
                    <label for="name">Username:</label>
                    <input type="text" id="name" v-model="user.name">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" v-model="user.email">
                </div>
                <!-- Add more fields as needed -->

                <button type="submit">Save Changes</button>
            </form>
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
    async mounted() {
        try {
            const response = await axios.get('/api/user')
            this.user = response.data
        } catch (error) {
            console.error(error)
        } finally {
            this.loading = false
        }
    },
    methods: {
        async updateProfile() {
            try {
                await axios.put(`/api/user/${this.user.id}`, this.user)
                this.$router.push({ name: 'Profile' })
            } catch (error) {
                console.error(error)
            }
        }
    }

}
</script>
  
<style scoped>
.edit-profile-container {
    min-height: 100vh;
    background: #fff;
}

.edit-profile-container h1 {
    font-weight: 300;
    padding: 50px 0 30px 0;
    text-align: center;
}

.edit-profile-container form {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 300px;
    margin: 0 auto;
}

.edit-profile-container form div {
    margin: 15px 0;
}

.edit-profile-container form label {
    display: block;
    margin-bottom: 5px;
}

.edit-profile-container form input {
    width: 100%;
    padding: 5px;
    font-size: 16px;
}

.edit-profile-container form button {
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 18px;
    cursor: pointer;
}
</style>
  