<script setup>
import ClockView from '@/components/ClockComponent.vue'
import Navbar from '@/components/NavbarComponent.vue'
import Clock from '@/controller/Date'
import AllSchWidget from '@/widget/AllSchWidget.vue'
import LoadingWidget from '@/widget/LoadingWidget.vue'
</script>

<script>
import axios from '../api/api'
let cachedSchedules = null
export default {
  data() {
    return {
      schedules: [], // Data jadwal
      selectedClass: '', // Kelas yang dipilih
      classList: [],
      day: '',
      success: '', // Hari saat ini
    }
  },
  methods: {
    async fetchSchedules() {
      const maxRetries = 0
      let attempt = 0
      // Jika data sudah ada di cache, gunakan cache
      if (cachedSchedules) {
        this.setScheduleData(cachedSchedules)
        return
      }

        try {
          const response = await axios.get(
            'http://localhost:8000/classJSON.php',{withCredentials: true,}
          )

          if (response.data && response.data.classes) {
            cachedSchedules = response.data.classes // Simpan data ke cache
            this.setScheduleData(cachedSchedules)
            this.success = true
          } else {
            console.error('Invalid API Response:', response.data)
            throw new Error('Invalid response')
          }
        } catch (error) {
          attempt++
          console.error(`Error fetching schedules (attempt ${attempt}):`, error)
          if (attempt >= maxRetries) {
            console.error('Max retries reached. Unable to fetch schedules.')
          }
        }
    },
    setScheduleData(data) {
      this.schedules = data
      this.classList = data.map(c => c.name) // Ambil nama kelas
      if (this.classList.length > 0) {
        this.selectedClass = this.classList[0] // Default pilih kelas pertama
      }
    },
    filteredSchedule() {
      const selectedClassSchedule = this.schedules.find(
        item => item.name === this.selectedClass,
      )
      return selectedClassSchedule ? selectedClassSchedule.schedule : {}
    },
  },
  mounted() {
    const clockInstance = new Clock()
    setInterval(() => {
      this.day = clockInstance.day
    }, 1000)
  },
  created() {
    this.fetchSchedules()
  },
}
</script>

<style>
.top-100 {
  top: 50rem; /* 320px */
}

.w-100 {
  width: 80rem; /* 384px */
}
.h-100 {
  height: 80rem; /* 384px */
}
</style>

<template>
  <div class="relative justify-center items-center min-h-screen">
    <div
      class="fixed top-100 justify-center left-28 w-100 h-100 bg-gradient-to-r animate-move blur-3xl from-40% from-[#FEA127] via-[#F05529] via-10% to-[#244282] to-80% rounded-full"
    ></div>

    <div class="backdrop-blur-md h-full">
      <Navbar />
      <div class="flex gap-20 container mx-auto grid-cols-2 mt-24">
        <div class="">
          <div class="grid sticky items-center justify-center">
            <ClockView class="mb-6" />
            <router-link
                  to="/login"
                  class="px-4 py-2 text-white text-center bg-[#F05529] rounded-md mb-4 hover:bg-[#FEA127]"
                >
                  Login
                </router-link>
          </div>

        </div>
        <div>
          <div class="mt-10 mb-6 ">
            <div class="">
              <div class="p-2 w-54 bg-white rounded-2xl shadow-md">
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
                    Tidak ada kelas tersedia.
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
            <div class="bg-white rounded-t-md w-20">
              <h1 class="text-lg font-bolt mx-3 font-bold text-center">
                {{ hari }}
              </h1>
            </div>
            <div
              class="grid lg:grid-cols-3 md:grid-cols-2 mb-2 rounded-b-md"
            >
              <LoadingWidget
                v-if="filteredSchedule().length === 0 && !success"
              />
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
    </div>
  </div>
</template>
