<script setup>
import { RouterView } from 'vue-router'
</script>

<template>
  <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/material-icons@1.10.7/iconfont/material-icons.min.css">
  </head>
  <html>

  <keep-alive>
    <router-view/>
  </keep-alive>

  </html>
</template>

<style scoped>
html{
  height: 100%;
}
@import url('../src/assets/style.css');
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap');

</style>
