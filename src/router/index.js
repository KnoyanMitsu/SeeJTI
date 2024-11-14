import HomeView from '@/views/HomeView.vue'
import LoginAdminView from '@/views/LoginAdminView.vue'
import NotFound from '@/views/Error/404Error.vue'
import { createRouter, createWebHistory } from 'vue-router'
import ScheduleView from '@/views/ScheduleView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: HomeView,
    },

    {
      path: '/admin',
      name: 'login',
      component: LoginAdminView,
    },
    {
      path: '/:pathMatch(.*)*',
      name: '404',
      component: NotFound
    },
    {
      path: '/jadwal',
      name: 'jadwal',
      component: ScheduleView,
    }
  ],
})

export default router
