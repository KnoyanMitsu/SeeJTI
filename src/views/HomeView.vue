<script setup>
import Clock from '@/components/ClockComponent.vue'
import Navbar from '@/components/NavbarComponent.vue'
import NavWidget from '@/widget/NavWidget.vue'
import ScheduleWidget from '@/widget/ScheduleWidget.vue'
import JTI from '@/assets/Logo/jti_polinema 3.png'
</script>

<style>
.top-100 {
  top: 50rem /* 320px */;
}

.w-100 {
  width: 80rem /* 384px */;
}
.h-100 {
  height: 80rem /* 384px */;
}
</style>

<template>
  <div class="relative justify-center items-center min-h-screen">
    <div
      class="fixed top-100 left-28 w-100 h-100 bg-gradient-to-r animate-move blur-3xl from-40% from-[#FEA127] via-[#F05529] via-10% to-[#244282] to-80% rounded-full "
    ></div>

    <div class="backdrop-blur-md h-full">
      <Navbar :logo="JTI" />
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
        <div class="grid mt-6 gap-2 lg:grid-cols-3 mx-auto md:grid-cols-2">
          <ScheduleWidget />
          <ScheduleWidget />
          <ScheduleWidget />
          <ScheduleWidget />
        </div>
      </div>
    </div>
  </div>
</template>
