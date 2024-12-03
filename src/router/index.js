import HomeView from '@/views/HomeView.vue'
import LoginAdminView from '@/views/LoginAdminView.vue'
import NotFound from '@/views/Error/404Error.vue'
import { createRouter, createWebHistory } from 'vue-router'
import ScheduleView from '@/views/ScheduleView.vue'
import NoRoomView from '@/views/NoRoomView.vue'
import LoginUserView from '@/views/LoginUserView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },

    {
      path: '/admin',
      name: 'login',
      component: LoginAdminView,
    },
    {
      path: '/login',
      name: 'loginuser',
      component: LoginUserView,
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
    // {
    //   path: '/jadwal/ruang',
    //   name: 'ruang',
    //   component: RoomView,
    // },
    {
      path: '/jadwal/kosong',
      name: 'kosong',
      component: NoRoomView,
    }
  ],
})

export default router
