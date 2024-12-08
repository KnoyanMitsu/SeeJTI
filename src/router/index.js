import HomeView from '@/views/HomeView.vue'
import LoginAdminView from '@/views/LoginAdminView.vue'
import NotFound from '@/views/Error/404Error.vue'
import { createRouter, createWebHistory } from 'vue-router'
import ScheduleView from '@/views/ScheduleView.vue'
import NoRoomView from '@/views/NoRoomView.vue'
import LoginUserView from '@/views/LoginUserView.vue'
import axios from '../api/api'

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
let cachedUser = null
router.beforeEach(async (to, from, next) => {
  const maxRetries = 10
  let attempt = 0
  let success = false

  // Jika data sudah ada di cache, gunakan cache
  if (cachedUser) {
    this.setUserData(cachedUser)
    return
  }
  while (attempt < maxRetries && !success) {
  try {
    const response = await axios.get("http://localhost:8000/user.php", {
      withCredentials: true,
    });
    if (response.data && response.data.users) {
      cachedUser = response.data.users // Simpan data ke cache
      this.setUserData(cachedUser)

      success = true
    } else {
      console.error('Invalid API Response:', response.data)
      throw new Error('Invalid response')
    }

    if (cachedUser[0].level === "ketua" && cachedUser[0].level === "mahasiswa") {
      next({ name: "Home" }); // Redirect jika bukan user
    } else {
      next(); // Lanjutkan ke halaman yang diminta
    }
  } catch (error) {

    next({ name: "Home" }); // Redirect ke halaman Home
  }
}
});


export default router
