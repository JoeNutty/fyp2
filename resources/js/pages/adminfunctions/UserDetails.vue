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
#backend-view {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f3f4f6;
  height: 100vh;
}

.user-details {
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

.button-container {
  display: flex;
  justify-content: center;
  gap: 1rem;
}

.delete-button,
.back-button {
  color: white;
  border: none;
  padding: 1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.delete-button {
  background-color: red;
}

.delete-button:hover {
  background-color: darkred;
}

.back-button {
  background-color: #3490dc;
}

.back-button:hover {
  background-color: #2779bd;
}
</style>
  