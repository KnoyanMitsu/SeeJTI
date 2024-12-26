<script setup>
import AllSchWidget from '@/widget/AllSchWidget.vue'
import LoadingWidget from '@/widget/LoadingWidget.vue'
import { Menu, MenuButton, MenuItems } from '@headlessui/vue'
</script>

<script>
import axios from '../../api/api'

let cachedSchedules = null
export default {
  data() {
    return {
      schedules: [], // Data jadwal
      selectedClass: '', // Kelas yang dipilih
      classList: [],
      day: '', // Hari saat ini
    }
  },
  methods: {
    async exportCSV() {
      try {
        const response = await axios.get("http://localhost:8000/exportJadwal.php", {
          responseType: "blob", // Respons file biner
        });

        const blob = new Blob([response.data], { type: "text/csv" });
        const url = window.URL.createObjectURL(blob);

        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "jadwal.csv");
        document.body.appendChild(link);
        link.click();
        link.remove();
      } catch (error) {
        console.error("Gagal mengekspor CSV:", error);
      }
    },
    async fetchSchedules() {
      const maxRetries = 0
      let attempt = 0
      // Jika data sudah ada di cache, gunakan cache
      if (cachedSchedules) {
        this.setScheduleData(cachedSchedules)
        return
      }

      try {
        const response = await axios.get('http://localhost:8000/classJSON.php')

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
  created() {
    this.fetchSchedules()
  },
}
</script>

<template>
  <div class="">
    <div class="mt-10 mx-4 lg:mx-20">
      <div class="flex justify-between">
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
              Tidak ada kelas tersedia.
            </option>
          </select>
        </div>
        <div class="flex gap-5">
          <Menu as="button" class="relative ">
            <MenuButton as="button" class="">
              <VsxIcon
                class="inline-block "
                iconName="HambergerMenu"
                :size="32"
                color="black"
                type="bulk"

              />
              <p class="inline-block ml-2 tracking-tight py-2 font-bold">Menu</p>
            </MenuButton>
            <transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <MenuItems
                class="absolute right-0 z-30 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
              >
                <div class="py-1">
                  <MenuItems>
                    <div class="">
                      <button
                        @click="exportCSV"
                        :class="[
                          'text-gray-700',
                          'block w-full px-4 py-2 text-left text-sm',
                        ]"
                      >
                        Export jadwal ke CSV
                      </button>
                      <hr />
                      <p
                        :class="[
                          'text-red-700',
                          'block w-full px-4 py-2 text-left text-sm',
                        ]"
                      >
                        Zona Berbahaya
                      </p>
                      <hr />
                      <button
                        :class="[
                          'text-red-700',
                          'block w-full px-4 py-2 text-left text-sm',
                        ]"
                      >
                        Import jadwal ke CSV (Hapus dan tambah semua jadwal)
                      </button>
                      <button
                        :class="[
                          'text-red-700',
                          'block w-full px-4 py-2 text-left text-sm',
                        ]"
                      >
                        Hapus semua jadwal
                      </button>
                    </div>
                  </MenuItems>
                </div>
              </MenuItems>
            </transition>
          </Menu>
        </div>
      </div>
    </div>
    <div v-for="(matkul, hari) in filteredSchedule()" :key="hari" class="">
      <div class="bg-white lg:mx-20 rounded-t-md w-20">
        <h1 class="text-lg font-bolt mx-3 font-bold text-center">
          {{ hari }}
        </h1>
      </div>
      <div
        class="grid lg:grid-cols-3 lg:mx-20 md:grid-cols-2 mb-2 rounded-b-md"
      >
        <LoadingWidget v-if="filteredSchedule().length === 0" />
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
</template>
