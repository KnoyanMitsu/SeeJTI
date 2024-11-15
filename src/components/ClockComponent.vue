<script lang="ts">
import Clock from '@/controller/Date'
import { defineComponent } from 'vue'
export default defineComponent({
  data() {
    return {
      date: '',
      currentTime: '',
    }
  },

  mounted() {
    const clockInstance = new Clock()

    setInterval(() => {
      this.date = clockInstance.date
      this.currentTime = clockInstance.currentTime
    }, 1)
  },
})
</script>

<template>
  <div class="text-center">
    <h1 class="text-xl font-bold text-black">{{ date }}</h1>
    <h1 class="text-9xl font-bold text-black">{{ currentTime }}</h1>
  </div>
</template>
