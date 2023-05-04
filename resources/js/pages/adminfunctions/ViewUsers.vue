<template >
    <div id="backend-view">
        <div class="admin-users">
            <h1>User List</h1>
            <div class="success-msg" v-if="deleteSuccess">
                <i class="fa fa-check"></i>
                User deleted successfully
            </div>

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
                            <router-link :to="{ name: 'UserDetails', params: { id: user.id } }" class="clickable-link">
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
    </div>
</template>
<script>
import axios from 'axios'

export default {
    data() {
        return {
            users: [],
            
        }
    },
    computed: {
        formattedDate() {
            return function (dateString) {
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
    margin-top: 30px;
    margin-left: auto;
    margin-right: auto;
    background: #ffffff;
    max-width: 1000px;
    padding: 15px;
    border-radius: 15px;
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

#backend-view {
    text-align: center;
    background-color: #f3f4f6;
    height: 100vh;
    padding-top: 15vh;
}

.clickable-link {
    color: blue;
    text-decoration: underline;
    cursor: pointer;
}

.success-msg {
    color: green;
    font-weight: bold;
    margin-bottom: 1rem;
}
</style>
