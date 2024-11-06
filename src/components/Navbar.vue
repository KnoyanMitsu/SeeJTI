<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  logo: String,
})
</script>

<template>
  <nav class="flex items-center justify-between flex-wrap bg-white p-6">
    <div class="flex items-center flex-shrink-0 text-white mr-6">
      <span class="font-bold text-2xl tracking-tight text-black px-4 py-2"
        >SeeJTI</span
      >
      <img class="h-8" :src="logo" alt="" />
    </div>
    <div class="block lg:hidden">
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
    </div>
    <div class="w-full flex justify-end lg:w-auto">
      <div class="flex justify-end">
        <a href="/login" class="underline text-black px-4 py-2 rounded"
          >Masuk</a
        >
        <img
          src="https://www.figma.com/file/13npvNbNYNB0M9VNj6UsIe/image/2e43ed0c39ebb16fedfe083c2c6532de037dfe68"
          alt="profile"
          class="w-10 h-10 rounded-full mx-2 object-cover"
        />
      </div>
    </div>
  </nav>
</template>
