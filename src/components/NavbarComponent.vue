<script setup>
import { defineProps } from 'vue'

// eslint-disable-next-line no-unused-vars
const props = defineProps({
  logo: String,
})
</script>

<template>
  <nav class="flex items-center justify-between flex-wrap p-6 mb-24">
    <router-link to="/" class="flex items-center flex-shrink-0 text-white mr-6">
      <span class="font-bold text-2xl tracking-tight text-black px-4 py-2"
        >SeeJTI</span
      >
      <img class="h-8" :src="logo" alt="" />
    </router-link>
    <!-- <div class="block lg:hidden">
      <button
        class="flex items-center px-3 py-2 border rounded text-blue-200 border-blue-400 hover:text-white hover:border-white"
      >
        <svg
          class="fill-current h-3 w-3"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <title>Menu</title>
          <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
        </svg>
      </button>
    </div> -->
    <div class="flex justify-end w-auto">
      <div class="flex justify-end">
        <img
          src="https://pbs.twimg.com/media/GLp9znnWMAAAsz_.jpg"
          alt="profile"
          class="w-10 h-10 rounded-full mt-1 object-cover"
        />
        <div class="grid ml-3 gap">
          <p class="text-black text-left rounded row-span-3 font-semibold">
            Tianlu
          </p>
        <p class="text-black/50 text-left rounded text-xs font-medium">9912803174 | TI-2C</p>
        </div>
      </div>
    </div>
  </nav>
</template>
