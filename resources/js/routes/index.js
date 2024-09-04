import { createWebHistory, createRouter } from 'vue-router'

import Login from '@/pages/List.vue'

const routes = [
  { 
    path: '/',
    name: 'list',
    component: List,
    meta: { checkAuth: true },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})


export default router;
