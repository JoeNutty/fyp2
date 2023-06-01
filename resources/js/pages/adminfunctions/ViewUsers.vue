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
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Account Created At</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td><span class="user-id">{{ user.id }}</span></td>
                        <td>
                            <router-link :to="{ name: 'UserDetails', params: { id: user.id } }" class="clickable-link">
                                <span class="user-name">{{ user.name }}</span>
                            </router-link>
                        </td>
                        <td><span class="user-email">{{ user.email }}</span></td>
                        <td><span class="user-created-at">{{ formattedDate(user.created_at) }}</span></td>
                        <td><span class="user-role" :class="{'rainbow-text': user.role === 'admin', 'blue-text': user.role === 'user'}">{{ user.role }}</span></td>
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

.admin-users h1 {
    font-weight: 300;
    text-align: center;
    margin-bottom: 2rem;
}

.user-email,
.user-created-at,
.user-role {
    font-size: 0.9rem;
    font-weight: normal;
    color: #888;
    margin-left: 0.5rem;

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
.rainbow-text {
  background-image: linear-gradient(to left, violet, indigo, blue, green, yellow, orange, red);
  -webkit-background-clip: text;
  color: transparent;
}

.blue-text {
  color: blue;
}

.rainbow-text,
.blue-text {
  text-transform: uppercase;
}

</style>
