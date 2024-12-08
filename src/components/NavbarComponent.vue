<script setup>
import JTI from '@/assets/Logo/jti_polinema 3.png'
</script>

<script>
import axios from '../api/api'
let cachedUser = null
export default {
  data() {
    return {
      user: [],
      success: false,
    }
  },
  methods: {
    async fetchUser() {
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
          const response = await axios.get('http://localhost:8000/user.php', {
            withCredentials: true, // Kirim cookies
          })
          if (response.data && response.data.classes) {
            cachedUser = response.data.classes
            this.setScheduleData(cachedUser)
            this.success = true
            success = true
          } else {
            console.error('Invalid API Response:', response.data)
            throw new Error('Invalid response')
          }
        } catch (error) {
          attempt++
          console.error(`Error fetching user data (attempt ${attempt}):`, error)
          if (attempt >= maxRetries) {
            console.error('Max retries reached. Unable to fetch user data.')
          }
        }
      }
    },
    setUserData(data) {
      this.user = data[0]
    },
  },
  created() {
    this.fetchUser()
  },
}
</script>

<template>
  <nav class="flex items-center justify-between flex-wrap p-6">
    <router-link to="/" class="flex items-center flex-shrink-0 text-white mr-6">
      <span class="font-bold text-2xl tracking-tight text-black px-4 py-2"
        >SeeJTI</span
      >
      <img class="h-8" :src="JTI" alt="" />
    </router-link>
    <div v-if="success === true" class="flex justify-end w-auto">
      <div class="flex justify-end">
        <img
          src="https://pbs.twimg.com/media/GLp9znnWMAAAsz_.jpg"
          alt="profile"
          class="w-10 h-10 rounded-full mt-1 object-cover"
        />
        <div class="grid ml-3 gap">
          <p class="text-black text-left rounded row-span-3 font-semibold">
            {{ user.name }}
          </p>
          <p class="text-black/50 text-left rounded text-xs font-medium">
            {{ user.nim }} | {{ user.class }}
          </p>
        </div>
      </div>
    </div>
    <div class="flex justify-end items-center">
      <img
        src="https://pbs.twimg.com/media/GLp9znnWMAAAsz_.jpg"
        alt="profile"
        class="w-10 h-10 rounded-full object-cover"
      />
      <div class="ml-3">
        <router-link to="/login" class="text-black text-center underline">Masuk</router-link>
      </div>
    </div>
  </nav>
</template>
