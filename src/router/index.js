import axios from '../api/api';
import LoginAdminView from '@/views/LoginAdminView.vue';
import NotFound from '@/views/Error/404Error.vue';
import { createRouter, createWebHistory } from 'vue-router';
import ScheduleView from '@/views/ScheduleView.vue';
import NoRoomView from '@/views/NoRoomView.vue';
import LoginUserView from '@/views/LoginUserView.vue';
import DasboardView from '@/views/DasboardView.vue';
import AdminLayoutView from '@/views/Admin/AdminLayoutView.vue';
import AdminScheduleView from '@/views/Admin/AdminScheduleView.vue';
import AdminDashView from '@/views/Admin/AdminDashView.vue';
import AdminRoomView from '@/views/Admin/AdminRoomView.vue';
import AdminUserView from '@/views/Admin/AdminUserView.vue';
import AdminCalView from '@/views/Admin/AdminCalView.vue';
import ComingSoon from '@/views/Error/ComingSoon.vue';
// Middleware function to check authentication
async function checkAuth(to, from, next) {
  try {
    const response = await axios.get('http://localhost:8000/checkAuth.php',{withCredentials: true,});
    if (response.data === 'ketua' || response.data === 'mahasiswa') {
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
    if (response.data !== 'ketua'  &&  response.data !== 'mahasiswa') {
      next();
      console.log(response.data);
    } else {
      next({ name: 'home' });
    }
  } catch (error) {
    next({ name: 'home' });
  }
}

async function checkAdmin(to, from, next) {
  try {
    const response = await axios.get('http://localhost:8000/checkAuth.php');
    if (response.data === 'admin') {
      next();
    } else {
      next({ name: 'home' });
    }
  } catch (error) {
    next({ name: 'home' });
  }
}

async function logout(to, from, next) {
  try {
    await axios.get('http://localhost:8000/logout.php');
    next({name: 'home', forceRefresh: true});
  } catch (error) {
    next({name: 'home', forceRefresh: true});
  }
}
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/logout',
      name: 'logout',
      beforeEnter: logout,
      meta: {
        reload: true,
      }
    },
    {
      path: '/',
      name: 'home',
      component: DasboardView,
    },
    {
      path: '/loginadmin',
      name: 'login',
      component: LoginAdminView,
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
      // beforeEnter: checkAuth,
    },
    {
      path: '/jadwal/ruang',
      name: 'ruang',
      component: NoRoomView,
      // beforeEnter: checkAuth,
    },
    {
      path: '/jadwal/kosong',
      name: 'kosong',
      component: ComingSoon,
      // beforeEnter: checkAuth,
    },
    // {
    //   path: '/jadwal/ruang',
    //   name: 'ruang',
    //   component: RoomView,
    // },
    {
      path: '/admin/',
      name: 'dashboard',
      component: AdminLayoutView,
      beforeEnter: checkAdmin,
      children: [
        {
          path: 'jadwal',
          name: 'adminjadwal',
          component: AdminScheduleView,
          beforeEnter: checkAdmin,
          // beforeEnter: checkAuth,
        },
        {
          path: 'dashboard',
          name: 'admindash',
          component: AdminDashView,
          beforeEnter: checkAdmin,
          // beforeEnter: checkAuth,
        },
        {
          path: 'ruang',
          name: 'adminroom',
          component: AdminRoomView,
          beforeEnter: checkAdmin,
          // beforeEnter: checkAuth,
        },
        {
          path: 'users',
          name: 'users',
          component: AdminUserView
        },
        {
          path: 'calendar',
          name: 'calendar',
          component: AdminCalView
        },
        
      ]
      // beforeEnter: checkAuth,
    },
  ],
});

export default router;

