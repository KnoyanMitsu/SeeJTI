import axios from '../api/api';
import LoginAdminView from '@/views/LoginAdminView.vue';
import NotFound from '@/views/Error/404Error.vue';
import { createRouter, createWebHistory } from 'vue-router';
import ScheduleView from '@/views/ScheduleView.vue';
import NoRoomView from '@/views/NoRoomView.vue';
import LoginUserView from '@/views/LoginUserView.vue';
import DasboardView from '@/views/DasboardView.vue';
// Middleware function to check authentication
async function checkAuth(to, from, next) {
  try {
    const response = await axios.get('http://localhost:8000/checkAuth.php');
    if (response.data === 'berhasil') {
      next();
    } else if (response.data === 'admin') {
      if (to.name === 'login') {
        next();
      } else {
        next({ name: 'login' });
      }
    } else {
      next({ name: 'loginuser' });
    }
  } catch (error) {
    next({ name: 'loginuser' });
  }
}

async function checkLogin(to, from, next) {
  try {
    const response = await axios.get('http://localhost:8000/checkAuth.php');
    if (response.data !== 'berhasil') {
      next();
    } else {
      next({ name: 'home' });
    }
  } catch (error) {
    next({ name: 'home' });
  }
}
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: DasboardView,
    },
    {
      path: '/admin',
      name: 'login',
      component: LoginAdminView,
      beforeEnter: checkAuth,
    },
    {
      path: '/login',
      name: 'loginuser',
      component: LoginUserView,
      beforeEnter: checkLogin,
    },
    {
      path: '/:pathMatch(.*)*',
      name: '404',
      component: NotFound,
    },
    {
      path: '/jadwal/kelas',
      name: 'kelas',
      component: ScheduleView,
      beforeEnter: checkAuth,
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
      beforeEnter: checkAuth,
    },
  ],
});

export default router;

