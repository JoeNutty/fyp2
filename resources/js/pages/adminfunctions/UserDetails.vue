<template>
    <div id="backend-view">
        <div class="user-details">
            <template v-if="user">
                <h1>User Details</h1>
                <dl>
                    <dt>Name</dt>
                    <dd>{{ user.name }}</dd>
                    <dt>Email</dt>
                    <dd>{{ user.email }}</dd>
                    <dt>Account Created At</dt>
                    <dd>{{ formattedDate(user.created_at) }}</dd>
                    <dt>Role</dt>
                    <dd>{{ user.role }}</dd>
                    <dt>Number of Posts</dt>
                    <dd>{{ user.posts_count }}</dd>
                </dl>
                <div class="button-container">
                    <button v-if="user.role !== 'admin'" class="delete-button" @click="deleteUser">
                        Delete User
                    </button>
                    <router-link to="/viewusers" tag="button" class="back-button">
                        Back to View Users
                    </router-link>
                </div>


            </template>
            <template v-else>
                <div class="loading">Loading...</div>
            </template>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios'

export default {
    props: {
        id: {
            type: Number,
            required: true,
        },
    },

    data() {
        return {
            user: null,
            success: false,
        };
    },

    computed: {
        formattedDate() {
            return function (dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString("en-US", {
                    day: 'numeric', month: 'long', year: 'numeric',
                    hour: '2-digit', minute: '2-digit', second: '2-digit'
                });
            };
        },
    },

    async mounted() {
        console.log(this.$route.params.id);

        try {
            const response = await axios.get(`/api/users/${this.$route.params.id}`)
            this.user = response.data
        } catch (error) {
            console.error(error)
        }
    },
    methods: {
        // ... other methods ...

        async deleteUser() {
            try {
                // Delete user's posts
                await axios.delete(`/api/users/${this.$route.params.id}/posts`);

                // Delete user
                await axios.delete(`/api/users/${this.$route.params.id}`);

                // Redirect to another page or show a success message
                this.$router.push('/viewusers');
                
            } catch (error) {
                console.error(error);
            }
        }

    },

};
</script>
  
<style scoped>
.user-details {
    margin-top: 30px;
    margin-left: auto;
    margin-right: auto;
    background: #ffffff;
    max-width: 500px;
    padding: 15px;
    border-radius: 15px;
}

h1 {
    font-size: 2.5rem;
    margin-bottom: 2rem;
}

dl {
    display: grid;
    grid-template-columns: 150px 1fr;
    grid-gap: 1rem;
}

dt {
    font-weight: bold;
    margin-top: 1rem;
    text-align: right;
}

dd {
    margin-top: 1rem;
    text-align: left;
}

.loading {
    font-size: 2rem;
    margin: 2rem;
}

.delete-button {
    background-color: red;
    color: white;
    border: none;
    padding: 1rem;
    margin-top: 2rem;
    cursor: pointer;
}

.delete-button:hover {
    background-color: darkred;
}

.back-button {
    background-color: #3490dc;
    color: white;
    border: none;
    padding: 1rem;
    margin-top: 2rem;
    cursor: pointer;
    margin-left: 1rem;
}

.back-button:hover {
    background-color: #2779bd;
}

.button-container {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    flex-wrap: wrap;
    gap: 1rem;
}

#backend-view {
    text-align: center;
    background-color: #f3f4f6;
    height: 100vh;
    padding-top: 15vh;
}
</style>
  