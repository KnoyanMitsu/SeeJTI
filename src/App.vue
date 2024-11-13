<script setup>
import JTI from '@/assets/Logo/jti_polinema 3.png'
import { RouterView } from 'vue-router'
import Navbar from './components/NavbarComponent.vue'
</script>

<template>
  <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/material-icons@1.10.7/iconfont/material-icons.min.css">
  </head>
  <html class="bg-white">
    <Navbar :logo="JTI" />

    <router-view/>
  </html>
</template>

<style scoped>
@import url('../src/assets/style.css');
</style>
