<template>
  <AuthenticatedLayout>
    <div>
      <h1>Role Manager</h1>

      <!-- Search Input -->
      <input type="text" v-model="searchQuery" @input="fetchRoles" placeholder="Search by name" />

      <!-- Add Role Form -->
      <form @submit.prevent="addRole">
        <input type="text" v-model="newRole.name" placeholder="Role Name" required />
        <input type="text" v-model="newRole.slug" placeholder="Role Slug" required />
        <button type="submit">Add Role</button>
      </form>

      <!-- Role List -->
      <ul>
        <li v-for="role in roles" :key="role.id">
          {{ role.name }} - {{ role.slug }}
          <button @click="editRole(role)">Edit</button>
          <button @click="deleteRole(role.id)">Delete</button>
        </li>
      </ul>

      <!-- Edit Role Modal -->
      <div v-if="editingRole">
        <h2>Edit Role</h2>
        <form @submit.prevent="updateRole">
          <input type="text" v-model="editingRole.name" required />
          <input type="text" v-model="editingRole.slug" required />
          <button type="submit">Update Role</button>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// State Variables
const roles = ref([]);
const searchQuery = ref('');
const newRole = ref({ name: '', slug: '' });
const editingRole = ref(null);

// Fetch roles from the API
const fetchRoles = async () => {
  const response = await axios.get('/api/roles', { params: { search: searchQuery.value } });
  roles.value = response.data;
};

// Add a new role
const addRole = async () => {
  await axios.post('/api/roles', newRole.value);
  newRole.value = { name: '', slug: '' };
  fetchRoles();
};

// Edit role - fill form with current role data
const editRole = (role) => {
  editingRole.value = { ...role };
};

// Update role
const updateRole = async () => {
  await axios.put(`/api/roles/${editingRole.value.id}`, editingRole.value);
  editingRole.value = null;
  fetchRoles();
};

// Delete role
const deleteRole = async (roleId) => {
  await axios.delete(`/api/roles/${roleId}`);
  fetchRoles();
};

// Load roles when component is mounted
onMounted(fetchRoles);
</script>
