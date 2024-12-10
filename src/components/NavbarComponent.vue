<script setup>
import JTI from '@/assets/Logo/jti_polinema 3.png'

import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

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
      const maxRetries = 0
      let attempt = 0

      // Jika data sudah ada di cache, gunakan cache
      if (cachedUser) {
        this.setUserData(cachedUser)
        return
      }

      try {
        const response = await axios.get('http://localhost:8000/user.php', {
          withCredentials: true, // Kirim cookies
        })
        if (response.data && response.data.users) {
          cachedUser = response.data.users
          this.setUserData(cachedUser)
        } else {
          console.error('Invalid API Response:', response.data)
          throw new Error('Invalid response')
        }
      } catch (error) {
        console.error(`Error fetching user data (attempt ${attempt}):`, error)
        if (attempt >= maxRetries) {
          console.error('Max retries reached. Unable to fetch user data.')
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
      <span class="font-bold text-2xl tracking-tight text-black px-4 py-2">SeeJTI</span>
      <img class="h-8" :src="JTI" alt="" />
    </router-link>
    <Menu>
      <div>
        <MenuButton class="flex justify-end w-auto">
          <div class="flex justify-end">

            <div class="relative w-10 h-10 overflow-hidden bg-gray-600 rounded-full dark:bg-gray-200">
              <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                </path>
              </svg>
            </div>

            <div class="grid ml-3 gap">
              <p class="text-black text-left rounded row-span-3 font-semibold">
                {{ user.name }}
              </p>
              <p class="text-black/50 text-left rounded text-xs font-medium">
                {{ user.nim }} | {{ user.class }}
              </p>
            </div>
          </div>
          <ChevronDownIcon class="-mr-1 size-5 text-gray-400" aria-hidden="true" />
        </MenuButton>
      </div>
      <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95"
        enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
        leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
        <MenuItems
          class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
          <div class="py-1">
            <MenuItem v-slot="{ active }">
            <router-link to="/logout"
              :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block w-full px-4 py-2 text-left text-sm']">Sign
              out</router-link>
            </MenuItem>
          </div>
        </MenuItems>
      </transition>
    </Menu>
  </nav>
</template>
