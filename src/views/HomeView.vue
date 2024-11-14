<script setup>
import JTI from '@/assets/Logo/jti_polinema 3.png'
import Clock from '@/components/ClockComponent.vue'
import Navbar from '@/components/NavbarComponent.vue'
import NavWidget from '@/widget/NavWidget.vue'
import ScheduleWidget from '@/widget/ScheduleWidget.vue'
</script>

<script>
import schedule from '@/data/dummy/schedule.json'
export default {
  data() {
    return {
      selectedClass: 'TI-2C',
      day: '',
      days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
    };
  },
  mounted() {
    this.updateTime();
    setInterval(this.updateTime, 1000);
  },
  methods: {
    updateTime() {
      const now = new Date();
      const dayName = this.days[now.getDay()];
      this.day = dayName;
    },
  },
  computed: {
    filteredSchedule() {
      return this.selectedClass ? schedule.classes.find((item) => item.name === this.selectedClass).schedule : [];
    },
    filteredDay(){
      return this.day ? this.filteredSchedule[this.day] : [];
    }
  }
}
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
      class="fixed top-100 justify-center left-28 w-100 h-100 bg-gradient-to-r animate-move blur-3xl from-40% from-[#FEA127] via-[#F05529] via-10% to-[#244282] to-80% rounded-full"
    ></div>

    <div class="backdrop-blur-md h-full">
      <Navbar :logo="JTI" />
      <div class="container mx-auto">
        <div class="grid gap-5 lg:grid-cols-2">
          <Clock />
          <NavWidget />
        </div>
        <div class="mt-10 mx-4 lg:mx-20">
          <div class="">
            <div class="p-2 w-48 bg-white rounded-2xl shadow-md">
              <p class="font-bold inline-block">Jadwal Kelas</p>
              <select name="Kelas" v-model="selectedClass" class="bg-white w-16 inline-block" id="">
                <option value="TI-2A">TI-2A</option>
                <option value="TI-2B">TI-2B</option>
                <option value="TI-2C">TI-2C</option>
              </select>
            </div>
          </div>
        </div>
         <div class="grid mt-6 gap-5 lg:grid-cols-3 mx-20 md:grid-cols-2">
            <ScheduleWidget
              v-for="(item, index) in filteredDay"
              :key="index"
              :nama="item.subject"
              :jam="item.time"
              :kelas="selectedClass"
              :ruang="item.room"
            />
        </div>
      </div>
    </div>
  </div>
</template>
