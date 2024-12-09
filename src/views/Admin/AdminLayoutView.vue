<script setup>
import AdminNavComponent from '@/components/Admin/AdminNavComponent.vue'
import AdminSideComponent from '@/components/Admin/AdminSideComponent.vue'
import { RouterView } from 'vue-router'
</script>

<template>
    <!-- Header -->
    <AdminNavComponent />

    <div class="flex">
      <!-- Sidebar -->
      <AdminSideComponent />

      <!-- Content -->
        <router-view />
    </div>
</template>

