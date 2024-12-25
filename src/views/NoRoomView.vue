<script setup>
import NavbarComponent from '@/components/NavbarComponent.vue'
import Date from '@/controller/Date'
import ListRoomWidget from '@/widget/ListRoomWidget.vue'
import NavClassroom from '@/widget/NavClassroom.vue'
</script>

<script>
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { ref } from 'vue'
import axios from '../api/api'
let cachedSchedules = null
// import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

// Kontrol visibilitas dialog
const open = ref(false)
export default {
  methods: {

    async fetchRuang() {
      const maxRetries = 0
      let attempt = 0

      try {
        const response = await axios.get(
          'http://localhost:8000/ruangkosong.php',
          { withCredentials: true },
        )
        if (response.data) {
          cachedSchedules = response.data
          this.setRoomsData(cachedSchedules)
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
    async fetchMatkul() {
      const maxRetries = 0
      let attempt = 0

      try {
        const response = await axios.get(
          'http://localhost:8000/ListMatkul.php',
          { withCredentials: true },
        )
        if (response.data) {
          this.setMatkulData(response.data)
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
    setMatkulData(data) {
      this.matkul = data
    },
    setRoomsData(data) {
      this.rooms = data[this.day]
    },
    filteredDay() {
      return this.day ? this.filteredSchedule()[this.day] || [] : []
    },

  updateRooms() {
    this.selectedRoom = '';
    this.times = [];
    this.selectedMatkul = cachedSchedules[this.selectedDay];
  },
  updateTimes() {
    if (this.selectedRoom) {

      this.times = cachedSchedules[this.selectedDay]
        .filter((room) => room.room_name === this.selectedRoom)
        .map((room) => room.time);
    }
  },
  },

  mounted() {
    const clockInstance = new Date()

    setInterval(() => {
      this.year = clockInstance.year
      this.month = clockInstance.month
      this.day = clockInstance.day
      this.date = clockInstance.date
    }, 1)
  },
  data() {
    return {
      year: '',
      month: '',
      day: '',
      selectedDay: '',
      selectedRoom: '',
      class: '',
      rooms: [],
      matkul: [],
      selectedMatkul: [],
      times: [],
    }
  },
  created() {
    const storedClass = localStorage.getItem('selectedClass')
    if (storedClass) {
      this.class = storedClass
    }
    this.fetchRuang()
    this.fetchMatkul()
  },
}
</script>

<template>
  <NavbarComponent />
  <nav class="flex bg-[#0E1F43] item-center justify-between flex-warp p mb-10">
    <NavClassroom />
  </nav>
  <div
    class="xl:grid xl:grid-cols-2 md:grid-cols-1 container mx-auto grid-flow-col gap-x-32 md:gap-x-32"
  >

    <div class="col-span-1">
      <p class="font-semibold text-lg">{{ this.day }}, {{ this.month }}</p>
      <div class="grid mt-10">
        <div
          class="bg-[#FFD6CA] grid py-3 gap-3 grid-cols-2 border-2 rounded-t-2xl"
        >
          <div class="align-middle flex justify-center">
            <p>Ruang</p>
          </div>
          <div class="align-middle flex justify-center">
            <p>Jam</p>
          </div>
        </div>
        <div
          v-for="(item, index) in rooms"
          :key="index"
          class="grid py-3 gap-3 grid-cols-2 border-2 items-center"
        >
          <div class="align-middle flex justify-center">
            <p>{{ item.room_name }}</p>
          </div>
          <div class="align-middle flex justify-center">
            <p>{{ item.time }}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="md:mt-5">
      <div>
        <h1 class="font-semibold text-lg mb-2">Ruang Kosong</h1>
        <p class="text-[#7A7979]">{{ date }}</p>
      </div>
      <div class="flex justify-end">
        <button
          @click="open = true"
          type="submit"
          class="px-4 py-2 text-white bg-[#F05529] rounded-md hover:bg-[#FEA127]"
        >
          Request Pindah Ruang
        </button>
      </div>
    </div>
  </div>

  <!-- Dialog -->
  <TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="open = false">

      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div
          class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
        >
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel
              class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
            >
              <form action="a" method="post">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                  <p class="mb-3">Nama Matkul</p>
                  <select
                    name="matkul"
                    class="w-full px-4 py-2 mb-4 border rounded-md border-black focus:outline-none focus:ring-2 focus:ring-[#F05529]"
                  >
                    <option
                      :value="item.id"
                      v-for="(item, index) in matkul.mata_kuliah"
                      :key="index"
                    >
                      {{ item.name }}
                    </option>
                  </select>

                  <p class="mb-3">Kelas</p>
                  <input
                    name="class"
                    type="text"
                    class="w-full px-4 py-2 mb-4 border rounded-md border-black focus:outline-none focus:ring-2 focus:ring-[#F05529]"
                    :value="this.class"
                  >

                  <p class="mb-3">Hari</p>
                  <select
                    v-model="selectedDay"
                    name="day"
                    @change="updateRooms"
                    class="w-full px-4 py-2 mb-4 border rounded-md border-black focus:outline-none focus:ring-2 focus:ring-[#F05529]"
                    id="hari"
                  >
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                  </select>

                  <p v-if="selectedDay" class="mb-3">Nama Ruang</p>
                  <select
                  v-if="selectedDay"
                    v-model="selectedRoom"
                    @change="updateTimes"
                    name="room"
                    class="w-full px-4 py-2 mb-4 border rounded-md border-black focus:outline-none focus:ring-2 focus:ring-[#F05529]"
                  >
                    <option
                      v-for="(room, index) in selectedMatkul"
                      :key="index"
                      :value="room.room_name"
                    >
                      {{ room.room_name }}
                    </option>
                  </select>

                  <p v-if="selectedRoom" class="mb-3">Jam</p>
                  <div class="flex">
                    <select
                    v-if="selectedRoom"
                      v-model="selectedTime"
                      name="time"
                      class="w-full px-4 py-2 mb-4 border rounded-md border-black focus:outline-none focus:ring-2 focus:ring-[#F05529]"
                    >
                      <option
                        v-for="time in times"
                        :key="time"
                        :value="time"
                      >
                        {{ time }}
                      </option>
                    </select>
                  </div>
                </div>

                <div class="bg-white px-4 py-3 sm:flex justify-center sm:px-6">
                  <button
                    type="submit"
                    class="px-4 py-2 text-white bg-[#F05529] rounded-full mb-4 hover:bg-[#FEA127]"
                  >
                    Kirim Permintaan
                  </button>
                </div>
              </form>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<style></style>
