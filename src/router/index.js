import HomeView from '@/views/HomeView.vue'
import LoginAdminView from '@/views/LoginAdminView.vue'
import NotFound from '@/views/Error/404Error.vue'
import { createRouter, createWebHistory } from 'vue-router'
import ScheduleView from '@/views/ScheduleView.vue'
import RoomView from '@/views/RoomView.vue'

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
      path: '/jadwal/kelas',
      name: 'kelas',
      component: ScheduleView,
    },
    {
      path: '/jadwal/ruang',
      name: 'ruang',
      component: RoomView,
    }
  ],
})

export default router
