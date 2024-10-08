import { createWebHistory, createRouter } from 'vue-router'

import List from '@/pages/Users/List.vue'
import New from '@/pages/Users/New.vue'
import Edit from '@/pages/Users/Edit.vue'

const routes = [
  { 
    path: '/',
    name: 'list',
    component: List,
    meta: { },
  },
  { 
    path: '/new',
    name: 'new',
    component: New,
    meta: { },
  },
  {
    path: '/user/:id',
    name: 'edit',
    component: Edit,
    meta: { },
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})


export default router;
