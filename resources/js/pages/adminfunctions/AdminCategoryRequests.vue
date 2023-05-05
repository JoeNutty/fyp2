<template>
    <div class="admin-category-requests">
        <h1>Category Requests</h1>
        <div v-if="message" :class="['message', messageType === 'success' ? 'message--success' : 'message--error']">
            {{ message }}
        </div>
        <div class="filter">
            <label for="status">Filter by status:</label>
            <select id="status" v-model="statusFilter" @change="filterByStatus">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="denied">Denied</option>
            </select>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>User ID</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="request in filteredRequests" :key="request.id">
                    <td>{{ request.id }}</td>
                    <td>{{ request.name }}</td>
                    <td>{{ request.user_id }}</td>
                    <td>{{ request.status }}</td>
                    <td>
                        <button v-if="request.status === 'pending'" @click="approveRequest(request.id)">
                            Approve
                        </button>
                        <button v-if="request.status === 'pending'" @click="denyRequest(request.id)">
                            Deny
                        </button>
                        <router-link v-if="request.status === 'approved'" to="/categories/create" tag="button"
                            class="blue-button">
                            Go to Create Category
                        </router-link>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
  
<script>
import axios from 'axios';

export default {

    data() {
        return {
            categoryRequests: [], // Fetch from API
            statusFilter: "",
            filteredRequests: [],
            message: '',
            messageType: '',
        };
    },
    methods: {
        filterByStatus() {
            if (this.statusFilter === "") {
                this.filteredRequests = this.categoryRequests;
            } else {
                this.filteredRequests = this.categoryRequests.filter(
                    (request) => request.status === this.statusFilter
                );
            }
        },
        async approveRequest(id) {
            try {
                const response = await axios.patch(`/api/category-requests/${id}/approve`);
                const updatedRequest = response.data;
                this.categoryRequests = this.categoryRequests.map((request) =>
                    request.id === updatedRequest.id ? updatedRequest : request
                );
                this.showMessage('Category request approved successfully!', 'success');
                this.filterByStatus();
                this.filteredRequests.find((req) => req.id === id).status = 'approved';
            } catch (error) {
                console.log(error.response.data);
                // Handle errors and display an error message
            }
        },
        async denyRequest(id) {
            try {
                const response = await axios.patch(`/api/category-requests/${id}/deny`);
                const updatedRequest = response.data;
                this.categoryRequests = this.categoryRequests.map((request) =>
                    request.id === updatedRequest.id ? updatedRequest : request
                );
                this.showMessage('Category request denied successfully!', 'error');
                this.filterByStatus();
                this.filteredRequests.find((req) => req.id === id).status = 'denied';
            } catch (error) {
                console.log(error.response.data);
                // Handle errors and display an error message
            }
        },
        showMessage(message, type) {
            this.message = message;
            this.messageType = type;
            setTimeout(() => {
                this.message = '';
            }, 3000);
        },
    },
    async mounted() {
        try {
            const response = await axios.get('/api/category-requests');
            this.categoryRequests = response.data;
            this.filteredRequests = this.categoryRequests;
            console.log(this.categoryRequests)
        } catch (error) {
            console.log(error.response.data);
            // Handle errors and display an error message
        }
    },

};
</script>
  
<style scoped>
.admin-category-requests {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.filter {
    margin-bottom: 1rem;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    padding: 0.5rem;
    border: 1px solid #ccc;
    text-align: left;
}

th {
    background-color: #f5f5f5;
}

button {
    background-color: #007bff;
    color: white;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    margin-right: 0.5rem;
}

button:hover {
    background-color: #0056b3;
}

button:last-child {
    background-color: #dc3545;
    margin-right: 0;


}

.message {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 4px;
    width: 100%;
    text-align: center;
}

.message--success {
    background-color: #28a745;
    color: #fff;
}

.message--error {
    background-color: #dc3545;
    color: #fff;
}
.blue-button {
    background-color: #007bff;
    color: white;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    margin-right: 0.5rem;
    text-decoration: none;
}

.blue-button:hover {
    background-color: #0056b3;
}

</style>
  