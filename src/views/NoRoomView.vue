<script setup>
import NavbarComponent from '@/components/NavbarComponent.vue'
import Date from '@/controller/Date'
import Calendar from '@/widget/CalendarWidget.vue'
import NavClassroom from '@/widget/NavClassroom.vue'
</script>

<script>
export default {
  mounted() {
    const clockInstance = new Date()

    setInterval(() => {
      this.year = clockInstance.year
      this.month = clockInstance.month
      this.day = clockInstance.date
    }, 1)
  },
  data() {
    return {
      year: '',
      month: '',
      day: '',
    }
  },
  components: {
    Calendar,
  },
}
</script>

<template>
  <NavbarComponent />
  <nav class="flex bg-[#0E1F43] item-center justify-between flex-warp p mb-10">
    <NavClassroom />
  </nav>

  <div class="grid grid-cols-2">
    <div class="">
      <p class="font-semibold text-lg mb-5">{{ month }}</p>

      <Calendar :year="year" :month="month" />
    </div>
    <div>
      <div>
        <h1 class="font-semibold text-lg mb-2">Ruang Kosong</h1>
        <p class="text-[#7A7979]">{{ day }}</p>
      </div>
      <div>Todo: this list room</div>
      <div>Todo: This Ruang yang di pilih and button Request Pindah Ruang</div>
    </div>
  </div>
</template>

<style></style>
