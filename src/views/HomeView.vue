<script setup>
import ClockView from '@/components/ClockComponent.vue'
import Navbar from '@/components/NavbarComponent.vue'
import Clock from '@/controller/Date'
import LoadingWidget from '@/widget/LoadingWidget.vue'
import NavWidget from '@/widget/NavWidget.vue'
import ScheduleWidget from '@/widget/ScheduleWidget.vue'
</script>

<script>
import axios from '../api/api'
let cachedSchedules = null
export default {
  data() {
    return {
      schedules: [],
      selectedClass: '',
      classList: [],
      day: '',
      success: '',
    }
  },
  methods: {
    async fetchSchedules() {
      const maxRetries = 0
      let attempt = 0


      try {
        const response = await axios.get(
          'http://localhost:8000/classJSON.php',
          { withCredentials: true },
        )
        if (response.data && response.data.classes) {
          cachedSchedules = response.data.classes
          this.setScheduleData(cachedSchedules)
        } else {
          console.error('Invalid API Response:', response.data)
          throw new Error('Invalid response')
        }
      } catch (error) {
        console.error(`Error fetching schedules (attempt ${attempt}):`, error)
        if (attempt >= maxRetries) {
          console.error('Max retries reached. Unable to fetch schedules.')
        }
      }
    },

    setScheduleData(data) {
      this.schedules = data
      this.classList = data.map(c => c.name)
      if (this.classList.length > 0 && !this.selectedClass) {
        this.selectedClass = this.classList[0] // Set default ke kelas pertama jika belum ada selectedClass
      }
    },
    filteredSchedule() {
      const selectedClassSchedule = this.schedules.find(
        item => item.name === this.selectedClass,
      )
      return selectedClassSchedule ? selectedClassSchedule.schedule : {}
    },
    filteredDay() {
      return this.day ? this.filteredSchedule()[this.day] || [] : []
    },
  },
  mounted() {
    const clockInstance = new Clock()
    setInterval(() => {
      const currentDay = clockInstance.day
      if (this.day !== currentDay) {
        this.day = currentDay // Update hanya jika `day` berubah
      }
    }, 1000)
    setInterval(() => {
      this.fetchSchedules()
    },10000)

    const storedClass = localStorage.getItem('selectedClass')
    if (storedClass) {
      this.selectedClass = storedClass
    }

    this.fetchSchedules()
  }
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
      <div class="container mx-auto mt-24">
        <div class="grid gap-5 lg:grid-cols-2">
          <ClockView />
          <NavWidget />
        </div>
        <div class="mt-10 mx-4 lg:mx-20">
          <div class="">
            <div class="p-2 w-56 bg-white rounded-2xl shadow-md">
              <p class="font-bold inline-block">Jadwal Kelas</p>
              <select
                name="Kelas"
                v-model="selectedClass"
                class="bg-white w-24 inline-block"
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
          class="flex flex-row mt-6 gap-5 2xl:grid-cols-3 lg:mx-20 lg:grid-cols-2 md:grid-cols-1"
        >
          <LoadingWidget v-if="filteredDay().length === 0" />
          <ScheduleWidget
            v-for="(item, index) in filteredDay()"
            :key="`${selectedClass}-${index}`"
            :nama="item.subject"
            :jam="item.time"
            :kelas="selectedClass"
            :ruang="item.room"
            :dosen="item.dosen"
            :status="item.status"
            @refresh="fetchSchedules()"
          />
        </div>
      </div>
    </div>
  </div>
</template>
