<script setup>
import { createRouter, createWebHistory } from 'vue-router';
import Roles from './Pages/Roles.vue';

const routes = [
  { path: '/roles', component: Roles },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
</script>