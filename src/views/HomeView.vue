<script setup>
import Clock from '@/components/ClockComponent.vue'
import NavWidget from '@/widget/NavWidget.vue'
import ScheduleWidget from '@/widget/ScheduleWidget.vue'
</script>

<template>
  <div
    class="min-h-screen bg-gradient-to-t from-orange-100 via-orange-200 to-white"
  >
    <div class="container mx-auto">
      <div class="grid gap-5 lg:grid-cols-2">
        <Clock />
        <NavWidget />
      </div>
      <div class="mt-7">
        <div class="">
          <div class="p-2 w-44 bg-white rounded-full shadow-md">
            <p class="font-bold inline-block">Jadwal Kelas</p>
            <select name="Kelas" class="bg-white w-16 inline-block" id="">
              <option value="TI2C">TI-2C</option>
            </select>
          </div>
        </div>
      </div>
      <div class="grid mt-6 gap-2 grid-cols-3">
        <ScheduleWidget />
        <ScheduleWidget />
        <ScheduleWidget />
      </div>
    </div>
  </div>
</template>
