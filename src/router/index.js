import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import NotFound from '@/views/Error/404.vue'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: HomeView,
    },

    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/:pathMatch(.*)*',
      name: '404',
      component: NotFound
    }
  ],
})

export default router
