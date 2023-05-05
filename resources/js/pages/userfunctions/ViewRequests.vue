<template>
    <div class="user-category-requests">
      <h1>Your Category Requests</h1>
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
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="request in filteredRequests" :key="request.id">
            <td>{{ request.id }}</td>
            <td>{{ request.name }}</td>
            <td :class="statusClass(request.status)">{{ request.status }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        userRequests: [],
        statusFilter: "",
      };
    },
    mounted() {
      this.fetchRequests();
    },
    methods: {
      fetchRequests() {
        axios
          .get("/api/category-requests")
          .then((response) => {
            this.userRequests = response.data;
          })
          .catch((error) => {
            console.log(error);
          });
      },
      filterByStatus() {
        if (this.statusFilter === "") {
          this.filteredRequests = this.userRequests;
        } else {
          this.filteredRequests = this.userRequests.filter(
            (request) => request.status === this.statusFilter
          );
        }
      },
      statusClass(status) {
        switch (status) {
          case "pending":
            return "status--pending";
          case "approved":
            return "status--approved";
          case "denied":
            return "status--denied";
          default:
            return "";
        }
      },
    },
    computed: {
      filteredRequests() {
        if (this.statusFilter === "") {
          return this.userRequests;
        } else {
          return this.userRequests.filter(
            (request) => request.status === this.statusFilter
          );
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .user-category-requests {
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
  
  .status--pending {
    color: #ffc107;
  }
  
  .status--approved {
    color: #28a745;
  }
  
  .status--denied {
    color: #dc3545;
  }
  </style>
  