<template>
    <div class="admin-users">
        <h1>User List</h1>
        <table class="user-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Account Created At</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>
                        <router-link :to="{ name: 'UserDetails', params: { id: user.id } }">
                            {{ user.name }}
                        </router-link>
                    </td>
                    <td>{{ user.email }}</td>
                    <td>{{ formattedDate(user.created_at) }}</td>
                    <td>{{ user.role }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    data() {
        return {
            users: []
        }
    },
    computed: {
        formattedDate() {
            return function(dateString) {
                const date = new Date(dateString)
                return date.toLocaleDateString("en-US", {
                    day: 'numeric', month: 'long', year: 'numeric',
                    hour: '2-digit', minute: '2-digit', second: '2-digit'
                })
            }
        }
    },
    async mounted() {
        try {
            const response = await axios.get('/api/users')
            this.users = response.data
        } catch (error) {
            console.error(error)
        }
    }
}
</script>


<style scoped>
    .admin-users {
        padding: 20px;
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
    }

    .user-table th,
    .user-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .user-table th {
        background-color: #4CAF50;
        color: white;
    }
</style>
