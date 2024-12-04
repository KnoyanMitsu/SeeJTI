<script setup>
import Navbar from '@/components/NavbarComponent.vue'
import AllSchWidget from '@/widget/AllSchWidget.vue';
import NavClassroom from '@/widget/NavClassroom.vue';
</script>

<script>
import axios from '../api/api';
let cachedSchedules = null;
export default {
  data() {
    return {
      schedules: [], // Data jadwal
      selectedClass: '', // Kelas yang dipilih
      classList: [],
      day: '', // Hari saat ini
    };
  },
  methods: {
    async fetchSchedules() {
      // Jika data sudah ada di cache, gunakan cache
      if (cachedSchedules) {
        this.setScheduleData(cachedSchedules);
        return;
      }

      // Jika tidak ada cache, fetch dari API
      try {
        const response = await axios.get('http://localhost:8000/classJSON.php');

        if (response.data && response.data.classes) {
          cachedSchedules = response.data.classes; // Simpan data ke cache
          this.setScheduleData(cachedSchedules);
        } else {
          console.error('Invalid API Response:', response.data);
        }
      } catch (error) {
        console.error('Error fetching schedules:', error);
      }f
    },
    setScheduleData(data) {
      this.schedules = data;
      this.classList = data.map((c) => c.name); // Ambil nama kelas
      if (this.classList.length > 0) {
        this.selectedClass = this.classList[0]; // Default pilih kelas pertama
      }
    },
    filteredSchedule() {
      const selectedClassSchedule = this.schedules.find(
        (item) => item.name === this.selectedClass
      );
      return selectedClassSchedule ? selectedClassSchedule.schedule : {};
    },
  },
  created() {
    this.fetchSchedules();
  },
};
</script>

<template>
  <div class="backdrop-blur-md h-full">
    <Navbar />
    <nav class="flex bg-[#0E1F43] item-center justify-between flex-warp p mb-10">
      <NavClassroom/>
    </nav>

    <div class="container mx-auto">
      <div class="mt-10 mx-4 lg:mx-20 ">
            <div class="">
              <div class="p-2 w-56 bg-white rounded-2xl shadow-md mb-10">
                <p class="font-bold inline-block">Jadwal Kelas</p>
                <select
                  name="Kelas"
                  v-model="selectedClass"
                  class="bg-white w-24 inline-block"
                  id=""
                >
                <option
                  v-for="classItem in classList"
                  :key="classItem"
                  :value="classItem"
                >
                  {{ classItem }}
                </option>
                <option v-if="classList.length === 0" disabled>
                  Data kelas tidak tersedia
                </option>
                </select>
              </div>
            </div>
          </div>
      <div
        v-for="(matkul, hari) in filteredSchedule()"
        :key="hari"
        class=""
      >
        <div class="bg-white lg:mx-20 rounded-t-md w-20">
          <h1 class="text-lg  font-bolt mx-3 font-bold text-center">{{ hari }}</h1>
        </div>
        <div class="grid lg:grid-cols-3 lg:mx-20 md:grid-cols-2 mb-2 rounded-b-md">
          <AllSchWidget
            v-for="item in matkul"
            :key="item"
            :nama="item.subject"
            :kelas="selectedClass"
            :jam="item.time"
            :ruang="item.room"
            :dosen="item.dosen"
            class="bg-white rounded-tr-md rounded-b-md"
          />
        </div>
      </div>
    </div>
  </div>
</template>
