<script setup>
import JTI from '@/assets/Logo/jti_polinema 3.png'
</script>

<template>
  <div class="relative justify-center items-center min-h-screen">
    <div
      class="fixed top-100 justify-center left-28 w-100 h-100 bg-gradient-to-r animate-move blur-3xl from-40% from-[#FEA127] via-[#F05529] via-10% to-[#244282] to-80% rounded-full"
    ></div>

    <div class="backdrop-blur-md h-full">
      <div class="grid place-items-center h-screen">
        <div class="grid grid-cols-2 gap-80">
          <div class="flex items-center justify-center h-full">
            <span
              class="font-bold text-8xl inline-block tracking-tight text-[#5B5B5B]"
              >SeeJTI <img class="h-20 inline-block" :src="JTI" alt=""
            /></span>
          </div>
          <div class="col-span-1">
            <h1 class="text-black text-6xl font-bold mb-5">Login</h1>
            <div>
              <div
                v-if="pesan"
                class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50"
                role="alert"
              >
                <svg
                  class="flex-shrink-0 inline w-4 h-4 me-3"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
                  />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                  {{ pesan }}
                </div>
              </div>
              <form @submit.prevent="login">
                <div class="mb-2">
                  <p class="font-bold mb-3 inline-block">Username</p>
                  <p class="text-red-500 inline-block">*</p>
                  <input
                    v-model="username"
                    type="text"
                    name="username"
                    id="username"
                    placeholder="Masukan Username"
                    class="w-full px-4 py-2 mb-4 border rounded-md border-black focus:outline-none focus:ring-2 focus:ring-[#F05529]"
                  />
                </div>

                <div class="mb-3">
                  <p class="font-bold mb-3 inline-block">Password</p>
                  <p class="text-red-500 inline-block">*</p>
                  <input
                    v-model="password"
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Masukan Password"
                    class="w-full px-4 py-2 mb-4 border rounded-md border-black focus:outline-none focus:ring-2 focus:ring-[#F05529]"
                  />
                </div>

                <button
                  type="submit"
                  class="w-full px-4 py-2 text-white bg-[#F05529] rounded-md hover:bg-[#FEA127]"
                >
                  Login
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from '../api/api'
import router from '../router'

export default {
  data() {
    return {
      username: '',
      password: '',
      pesan: '',
    }
  },
  methods: {
    async login() {
      try {
        const response = await axios.post(
          'http://localhost:8000/login.php',
          {
            username: this.username,
            password: this.password,
          },
          {
            withCredentials: true,
          },
        )

        const data = response.data
        console.log('Response Data:', data)
        if (data.status === 'berhasil') {
          this.pesan = 'Login berhasil'

          localStorage.setItem('selectedClass', data.kelas)
          const level = data.level.toLowerCase()

          if (level == 'mahasiswa' || level == 'ketua') {
            router.push({ path: '/' })
          } else if (level == 'admin') {
            router.push({ path: '/admin/dashboard' })
          } else {
            this.pesan = 'Level pengguna tidak dikenal.'
          }
        } else {
          this.pesan = 'Login gagal: password atau username salah '
        }
      } catch (error) {
        if (error.response && error.response.data) {
          this.pesan = 'Terjadi kesalahan saat login: ' + error.response.data
        } else {
          console.error('Error Details: ', error)
          this.pesan = 'Terjadi kesalahan saat login'
        }
      }
    },
  },
}
</script>
