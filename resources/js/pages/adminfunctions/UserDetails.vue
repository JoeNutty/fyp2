<template>
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
            <button class="delete-button" @click="deleteUser">Delete User</button>
        </template>
        <template v-else>
            <div class="loading">Loading...</div>
        </template>
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

        deleteUser() {
            axios
                .delete(`/api/users/${this.$route.params.id}`)
                .then(() => {
                    this.$router.push('/viewusers');// Redirect to another page or show a success message
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },

};
</script>
  
<style scoped>
.user-details {
    max-width: 600px;
    margin: 0 auto;
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
</style>
  