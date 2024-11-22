<script setup>
import Navbar from '@/components/NavbarComponent.vue'
import schedule from '@/data/dummy/schedule.json'
import AllSchWidget from '@/widget/AllSchWidget.vue';
</script>

<script>
export default {
  data() {
    return {
      selectedClass: 'TI-2C',
    }
  },
  computed: {
    filteredSchedule() {
      return this.selectedClass
        ? schedule.classes.find(item => item.name === this.selectedClass)
            .schedule
        : []
    },
  }
}
</script>

<template>
  <div class="backdrop-blur-md h-full">
    <Navbar />
    <nav class="flex bg-[#0E1F43] item-center justify-between flex-warp p mb-10">
      This is Navbar
    </nav>

    <div class="container mx-auto">
      <div class="mt-10 mx-4 lg:mx-20 ">
            <div class="">
              <div class="p-2 w-48 bg-white rounded-2xl shadow-md mb-10">
                <p class="font-bold inline-block">Jadwal Kelas</p>
                <select
                  name="Kelas"
                  v-model="selectedClass"
                  class="bg-white w-16 inline-block"
                  id=""
                >
                  <option value="TI-2A">TI-2A</option>
                  <option value="TI-2B">TI-2B</option>
                  <option value="TI-2C">TI-2C</option>
                </select>
              </div>
            </div>
          </div>
      <div
        v-for="(matkul, hari) in filteredSchedule"
        :key="hari"
        class=""
      >
        <div class="bg-white lg:mx-20 rounded-t-md w-20">
          <h1 class="text-lg  font-bolt mx-3 font-bold text-center">{{ hari }}</h1>
        </div>
        <div class="grid lg:grid-cols-3 lg:mx-20 md:grid-cols-2 mb-10 rounded-b-md">
          <AllSchWidget
            v-for="item in matkul"
            :key="item"
            :nama="item.subject"
            :kelas="selectedClass"
            :jam="item.time"
            :ruang="item.room"
            class="bg-white rounded-tr-md rounded-b-md"
          />
        </div>
      </div>
    </div>
  </div>
</template>
