<script setup>
import JTI from '@/assets/Logo/jti_polinema 3.png'
import { RouterView } from 'vue-router'
import Navbar from './components/Navbar.vue'
</script>

<template>
  <html class="bg-white">
    <Navbar :logo="JTI" />

    <RouterView />
  </html>
</template>

<style scoped>
@import url('../src/assets/style.css');
</style>
